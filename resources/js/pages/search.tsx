'use client';

import { SearchClient } from '@/clients/search.client';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { UserAvatar } from '@/components/user-avatar';
import UserLayout from '@/layouts/user-layout';
import { User } from '@/types';
import { Link } from '@inertiajs/react';
import { useQuery } from '@tanstack/react-query';
import { Search, Users, X } from 'lucide-react';
import { useState } from 'react';

export default function SearchPage() {
    const [searchQuery, setSearchQuery] = useState('');

    const { data, isLoading } = useQuery({
        queryKey: ['search', searchQuery],
        queryFn: async () => {
            return await SearchClient.search(searchQuery);
        },
    });

    const clearSearch = () => {
        setSearchQuery('');
    };

    const totalResults = data?.data.length ?? 0;

    return (
        <UserLayout title="Search">
            {/* Main content */}

            {/* Search input */}
            <div className="border-input relative mb-6 flex items-center rounded-md border px-4">
                <Search className="text-muted-foreground h-4 w-4" />
                <Input
                    type="search"
                    placeholder="Search people..."
                    className="h-auto appearance-none border-0 py-2 text-base !shadow-none !ring-0 !outline-none"
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                />
                {searchQuery && (
                    <Button variant="ghost" size="icon" className="h-4 w-4 hover:bg-transparent" onClick={clearSearch}>
                        <X className="h-4 w-4" />
                    </Button>
                )}
            </div>

            {/* Search results */}
            {searchQuery ? (
                <div>
                    {isLoading ? (
                        <div className="flex flex-col items-center justify-center py-12">
                            <div className="bg-muted mb-4 h-8 w-8 animate-pulse rounded-full"></div>
                            <p className="text-muted-foreground">Searching...</p>
                        </div>
                    ) : totalResults > 0 ? (
                        <div>
                            <div className="mb-4 flex items-center justify-between">
                                <p className="text-muted-foreground text-sm">
                                    {totalResults} {data!.data.length === 1 ? 'result' : 'results'} for "{searchQuery}"
                                </p>
                            </div>

                            <div className="flex flex-col gap-y-4">
                                {data!.data.map((person) => (
                                    <UserResult key={person.id} user={person} />
                                ))}
                            </div>
                            {data?.data.length === 0 && (
                                <div className="col-span-2 py-12 text-center">
                                    <Users className="text-muted-foreground mx-auto h-12 w-12" />
                                    <h3 className="mt-4 text-lg font-medium">No people found</h3>
                                    <p className="text-muted-foreground mt-1 text-sm">Try adjusting your search or filters</p>
                                </div>
                            )}
                        </div>
                    ) : (
                        <div className="py-12 text-center">
                            <Search className="text-muted-foreground mx-auto h-12 w-12" />
                            <h3 className="mt-4 text-lg font-medium">No results found</h3>
                            <p className="text-muted-foreground mt-1 text-sm">We couldn't find anything matching "{searchQuery}"</p>
                            <Button variant="outline" className="mt-4" onClick={clearSearch}>
                                Clear search
                            </Button>
                        </div>
                    )}
                </div>
            ) : (
                <div className="space-y-6">
                    <div className="py-12 text-center">
                        <Search className="text-muted-foreground mx-auto h-12 w-12" />
                        <h3 className="mt-4 text-lg font-medium">Search for people</h3>
                        <p className="text-muted-foreground mt-1 text-sm">Find and connect with people in your network</p>
                    </div>
                </div>
            )}
        </UserLayout>
    );
}

function UserResult({ user }: { user: User }) {
    return (
        <Card className="overflow-hidden">
            <CardContent className="p-4">
                <div className="flex items-center gap-3">
                    <UserAvatar user={user} />
                    <div className="flex-1">
                        <p className="font-medium">{user.name}</p>
                        <p className="text-muted-foreground text-xs">@{user.username}</p>
                        <p className="mt-1 text-sm">{user.bio ?? ''}</p>
                    </div>
                    <Link href={route('profile', user.username)}>
                        <Button size="sm">View profile</Button>
                    </Link>
                </div>
            </CardContent>
        </Card>
    );
}

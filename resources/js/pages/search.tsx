'use client';

import { SearchClient } from '@/clients/search.client';
import { EmptyResult } from '@/components/empty-result';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { UserCard } from '@/components/user/user-card';
import UserLayout from '@/layouts/user-layout';
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
                                {data!.data.map((user) => (
                                    <UserCard key={user.id} user={user} />
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
                        <EmptyResult
                            icon={<Search className="text-muted-foreground mx-auto h-12 w-12" />}
                            title="No results found"
                            description={`We couldn't find anything matching "${searchQuery}"`}
                            actions={
                                <Button variant="outline" className="mt-4" onClick={clearSearch}>
                                    Clear search
                                </Button>
                            }
                        />
                    )}
                </div>
            ) : (
                <EmptyResult
                    icon={<Search className="text-muted-foreground mx-auto h-12 w-12" />}
                    title="Search for people"
                    description="Find and connect with people in your network"
                />
            )}
        </UserLayout>
    );
}

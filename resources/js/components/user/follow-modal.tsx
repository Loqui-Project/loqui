import { User } from '@/types';
import { QueryFunction, useQuery } from '@tanstack/react-query';
import { AxiosResponse } from 'axios';
import { Search, Users, X } from 'lucide-react';
import { useState } from 'react';
import { Button } from '../ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '../ui/dialog';
import { Input } from '../ui/input';
import { UserCard } from './user-card';
import { UserSkeleton } from './user-skeleton';

export function UserFollowModal({
    user,
    open,
    onClose,
    triggerComponent,
    queryKey,
    queryFn,
}: {
    user: User;
    open: boolean;
    onClose: () => void;
    triggerComponent: React.ReactNode;
    queryKey: string;
    queryFn: QueryFunction<AxiosResponse<User[]>>;
}) {
    const [searchQuery, setSearchQuery] = useState('');

    const { data, isLoading, isFetched } = useQuery<AxiosResponse<User[]>>({
        queryKey: [queryKey, user.id, searchQuery],
        queryFn,
        enabled: open,
    });

    function clearSearch() {
        setSearchQuery('');
    }

    return (
        <Dialog
            open={open}
            onOpenChange={(open) => {
                if (!open) {
                    onClose();
                }
            }}
        >
            <DialogTrigger asChild>{triggerComponent}</DialogTrigger>
            <DialogContent className="max-w-full md:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>People You Follow</DialogTitle>
                    <DialogDescription>View and manage the people you're following.</DialogDescription>
                </DialogHeader>
                <div>
                    <div className="relative my-4">
                        <Search className="text-muted-foreground absolute top-2.5 left-3 h-4 w-4" />
                        <Input
                            type="search"
                            placeholder="Search people you follow..."
                            className="pr-10 pl-10"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                        {searchQuery && (
                            <Button variant="ghost" size="icon" className="absolute top-2 right-2 h-5 w-5 hover:bg-transparent" onClick={clearSearch}>
                                <X className="h-4 w-4" />
                            </Button>
                        )}
                    </div>
                    <div className="overflow-y-auto pr-2" style={{ maxHeight: 'calc(80vh - 220px)' }}>
                        {isLoading && <UserSkeleton />}
                        {isFetched && data && data?.data.length > 0 ? (
                            <div className="space-y-3">{data.data?.map((user) => <UserCard key={user.id} user={user} />)}</div>
                        ) : (
                            <div className="py-8 text-center">
                                <Users className="text-muted-foreground mx-auto h-12 w-12" />
                                <h3 className="mt-4 text-lg font-medium">No users found</h3>
                                <p className="text-muted-foreground mt-1 text-sm">
                                    {searchQuery ? `We couldn't find anyone matching "${searchQuery}"` : "You're not following anyone yet"}
                                </p>
                                {searchQuery && (
                                    <Button variant="outline" className="mt-4" onClick={clearSearch}>
                                        Clear search
                                    </Button>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
}

import { User } from '@/types';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@radix-ui/react-dropdown-menu';
import { QueryFunction, useQuery } from '@tanstack/react-query';
import { AxiosResponse } from 'axios';
import { MessageCircle, MoreHorizontal, Search, UserMinus, Users, X } from 'lucide-react';
import { useState } from 'react';
import { Button } from '../ui/button';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '../ui/dialog';
import { Input } from '../ui/input';
import { UserAvatar } from '../user-avatar';

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

    const { data, isLoading } = useQuery<AxiosResponse<User[]>>({
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
            <DialogContent className="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>People You Follow</DialogTitle>
                    <DialogDescription>View and manage the people you're following.</DialogDescription>
                </DialogHeader>
                {/* Search input */}
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
                {/* User list */}
                <div className="overflow-y-auto pr-2" style={{ maxHeight: 'calc(80vh - 220px)' }}>
                    {data && data?.data.length > 0 ? (
                        <div className="space-y-3">
                            {data.data?.map((user) => (
                                <div key={user.id} className="hover:bg-muted/50 flex items-start rounded-lg p-3 transition-colors">
                                    <div className="relative">
                                        <UserAvatar className="h-12 w-12" user={user} />
                                    </div>

                                    <div className="ml-3 flex-1">
                                        <div className="flex items-start justify-between">
                                            <div>
                                                <p className="font-medium">{user.name}</p>
                                                <p className="text-muted-foreground text-xs">{user.username}</p>
                                            </div>
                                            <DropdownMenu>
                                                <DropdownMenuTrigger asChild>
                                                    <Button variant="ghost" size="icon" className="h-8 w-8">
                                                        <MoreHorizontal className="h-4 w-4" />
                                                        <span className="sr-only">More options</span>
                                                    </Button>
                                                </DropdownMenuTrigger>
                                                <DropdownMenuContent align="end">
                                                    <DropdownMenuItem onClick={() => {}}>
                                                        <UserMinus className="mr-2 h-4 w-4" />
                                                        Unfollow
                                                    </DropdownMenuItem>
                                                    <DropdownMenuItem>
                                                        <MessageCircle className="mr-2 h-4 w-4" />
                                                        Message
                                                    </DropdownMenuItem>
                                                </DropdownMenuContent>
                                            </DropdownMenu>
                                        </div>

                                        <p className="mt-1 text-sm">{user.bio}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
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
                <DialogFooter>
                    <Button variant="outline" onClick={onClose}>
                        Cancel
                    </Button>
                    <Button>Follow</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    );
}

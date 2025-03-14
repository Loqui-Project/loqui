import { useFollowUser } from '@/hooks/use-follow';
import { useUnfollowUser } from '@/hooks/use-unfollow-user';
import { User } from '@/types';
import { Link } from '@inertiajs/react';
import { DropdownMenu, DropdownMenuTrigger } from '@radix-ui/react-dropdown-menu';
import { MessageCircle, MoreHorizontal, User as UserIcon, UserMinus, UserPlus } from 'lucide-react';
import { Button } from '../ui/button';
import { DropdownMenuContent, DropdownMenuItem } from '../ui/dropdown-menu';
import { UserAvatar } from '../user-avatar';

type UserCardProps = {
    user: User;
};
export function UserCard({ user }: UserCardProps) {
    const { unfollowUser, isUnfollowRequestPending } = useUnfollowUser(user);
    const { followUser, isFollowRequestPending } = useFollowUser(user);

    return (
        <div className="hover:bg-muted/50 flex items-start rounded-lg p-3 transition-colors">
            <div className="flex w-full items-start justify-between">
                <div className="flex flex-1 items-center gap-x-4">
                    <div className="relative">
                        <UserAvatar className="h-12 w-12" user={user} />
                    </div>
                    <div>
                        <p className="font-medium">{user.name}</p>
                        <p className="text-muted-foreground text-xs">@{user.username}</p>
                    </div>
                </div>
                <div className="flex flex-row gap-x-4">
                    <Link href={route('profile', user.username)}>
                        <Button variant="ghost">
                            <UserIcon className="h-4 w-4" />
                            <span>Visit Profile</span>
                        </Button>
                    </Link>
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="h-8 w-8">
                                <MoreHorizontal className="h-4 w-4" />
                                <span className="sr-only">More options</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            {user.is_following ? (
                                <DropdownMenuItem className="cursor-pointer" onClick={() => unfollowUser()} disabled={isUnfollowRequestPending}>
                                    <UserMinus className="mr-2 h-4 w-4" />
                                    Unfollow
                                </DropdownMenuItem>
                            ) : (
                                <DropdownMenuItem className="cursor-pointer" onClick={() => followUser()} disabled={isFollowRequestPending}>
                                    <UserPlus className="mr-2 h-4 w-4" />
                                    Follow
                                </DropdownMenuItem>
                            )}

                            <DropdownMenuItem>
                                <a href={route('profile', user.username) + '#message'} className="flex items-center">
                                    <MessageCircle className="mr-2 h-4 w-4" />
                                    Message
                                </a>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>
    );
}

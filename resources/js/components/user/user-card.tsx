import { useUnfollowUser } from '@/hooks/use-unfollow-user';
import { User } from '@/types';
import { DropdownMenu, DropdownMenuTrigger } from '@radix-ui/react-dropdown-menu';
import { MessageCircle, MoreHorizontal, UserMinus } from 'lucide-react';
import { Button } from '../ui/button';
import { DropdownMenuContent, DropdownMenuItem } from '../ui/dropdown-menu';
import { UserAvatar } from '../user-avatar';

type UserCardProps = {
    user: User;
};
export function UserCard({ user }: UserCardProps) {
    const { unfollowUser, isFollowing } = useUnfollowUser(user);

    return (
        <div className="hover:bg-muted/50 flex items-start rounded-lg p-3 transition-colors">
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
                            <DropdownMenuItem className="cursor-pointer" onClick={() => unfollowUser()} disabled={!isFollowing}>
                                <UserMinus className="mr-2 h-4 w-4" />
                                Unfollow
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <a href={route('profile', user.username) + '#message'} className="flex items-center">
                                    <MessageCircle className="mr-2 h-4 w-4" />
                                    Message
                                </a>
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>

                <p className="mt-1 text-sm">{user.bio}</p>
            </div>
        </div>
    );
}

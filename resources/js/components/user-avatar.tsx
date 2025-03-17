import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { User } from '@/types';

type UserAvatarProps = {
    user: User | null;
    className?: string;
};

export function UserAvatar({ user, className }: UserAvatarProps) {
    return (
        <Avatar className={className}>
            <AvatarImage src={user?.image_url} alt={user?.name ?? 'Anonymous'} loading="lazy" />
            <AvatarFallback>{user?.name[0] ?? 'Anonymous'}</AvatarFallback>
        </Avatar>
    );
}

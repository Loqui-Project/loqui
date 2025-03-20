import { cn } from '@/lib/utils';
import { User } from '@/types';

type UserAvatarProps = {
    user: User | null;
    className?: string;
};

export function UserAvatar({ user, className }: UserAvatarProps) {
    return (
        <div className="shrink-0">
            <img
                fetchPriority="auto"
                className={cn('rounded-full object-cover', className)}
                src={user?.image_url}
                alt={user?.name ?? 'Anonymous'}
                loading="lazy"
            />
        </div>
    );
}

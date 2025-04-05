import { cn } from '@/lib/utils';
import { User } from '@/types';
import { router } from '@inertiajs/react';

type UserAvatarProps = {
    user: User | null;
    className?: string;
    avatarClassname?: string;
    imageOnly?: boolean;
    withLink?: boolean;
};

export function UserAvatar({ user, className, avatarClassname, imageOnly = false, withLink = true }: UserAvatarProps) {
    return (
        <div
            {...(withLink
                ? {
                    onClick: () => {
                        if (user) {
                            router.visit(route('profile', user.username));
                        }
                    },
                }
                : {})}
            className={cn('flex items-center gap-2', className, {
                'cursor-pointer': withLink,
            })}
        >
            <div className="shrink-0">
                <img
                    fetchPriority="auto"
                    className={cn('rounded-full object-cover', avatarClassname)}
                    src={user && user.image_url != null ? user?.image_url : '/images/default-avatar.png'}
                    alt={user?.name ?? 'Anonymous'}
                    loading="lazy"
                />
            </div>
            {imageOnly ? null : (
                <div>
                    <h3 className="text-base">{user?.name ?? 'Anonymous'}</h3>
                    <p className="text-xs">{`@${user?.username ?? 'Anonymous'}`}</p>
                </div>
            )}
        </div>
    );
}

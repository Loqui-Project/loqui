import { BrowserNotification } from '@/types';
import { UserAvatar } from '../user-avatar';

type NewFollowerNotificationProps = {
    notification: BrowserNotification;
};

export function NewFollowerNotification({ notification }: NewFollowerNotificationProps) {
    return (
        <a href={notification.url} className="flex min-w-80 flex-row items-start gap-x-4 p-4">
            <UserAvatar user={notification.currentUser} className="mb-4 size-4" />
            <div className="flex flex-col gap-y-2">
                <div>
                    <h2 className="text-base font-bold">{notification.title}</h2>
                    {notification.currentUser.id && (
                        <p className="text-muted-foreground text-sm">
                            <span>@</span>
                            {notification.currentUser.username}
                        </p>
                    )}
                </div>
            </div>
        </a>
    );
}

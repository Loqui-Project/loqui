import { BrowserNotification } from '@/types';
import { UserAvatar } from '../user-avatar';

type NewMessageNotificationProps = {
    notification: BrowserNotification;
};

export function NewMessageNotification({ notification }: NewMessageNotificationProps) {
    return (
        <a
            href={route('message.show', {
                message: notification.message.id,
            })}
            className="flex-start flex min-w-52 flex-row gap-x-4 p-4"
        >
            <UserAvatar user={notification.currentUser} className="mb-4 size-5" />
            <div className="flex flex-col gap-y-2">
                <div>
                    <h2 className="text-xl font-bold">{notification.currentUser.name}</h2>
                    {notification.currentUser.id && (
                        <p className="text-muted-foreground text-sm">
                            <span>@</span>
                            {notification.currentUser.username}
                        </p>
                    )}
                </div>
                <p className="text-muted-foreground text-sm">{notification.message.message}</p>
            </div>
        </a>
    );
}

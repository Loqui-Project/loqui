import { NotificationsHeader } from '@/components/notifications/notification-header';
import { NotificationsList } from '@/components/notifications/notifications-list';
import UserLayout from '@/layouts/user-layout';
import { Notification } from '@/types';
import { Button } from '@headlessui/react';

type ListNotificationsPageProps = {
    notifications: {
        data: Notification[];
    };
    types: {
        label: string;
        value: string;
    }[];
};
export default function ListNotificationsPage({ notifications, types }: ListNotificationsPageProps) {
    function handleNotificationTypeFilter(type: string) {
        const url = new URL(window.location.href);
        url.searchParams.set('type', type);
        window.location.href = url.toString();
    }

    return (
        <UserLayout title="Notifications">
            <div className="container space-y-6 p-10">
                <NotificationsHeader />

                <div className="grid w-full grid-cols-5">
                    <Button className="col-span-1" onClick={() => handleNotificationTypeFilter('all')}>
                        All
                    </Button>

                    {types.map((type) => (
                        <Button className="col-span-1" key={type.value} onClick={() => handleNotificationTypeFilter(type.value)}>
                            {type.label}
                        </Button>
                    ))}
                </div>
                {notifications.data.length === 0 ? (
                    <div className="text-center text-gray-500">No notifications found.</div>
                ) : (
                    <NotificationsList notifications={notifications} />
                )}
            </div>
        </UserLayout>
    );
}

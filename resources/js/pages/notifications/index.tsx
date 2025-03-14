import { EmptyResult } from '@/components/empty-result';
import { NotificationsList } from '@/components/notifications/notifications-list';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import UserLayout from '@/layouts/user-layout';
import { Notification } from '@/types';
import clsx from 'clsx';
import { Bell, Filter } from 'lucide-react';
import { useMemo } from 'react';
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

    const isActiveTab = useMemo(() => {
        return (tab: string) => {
            const url = new URL(window.location.href);

            return {
                'bg-primary text-white dark:bg-white dark:text-black':
                    url.searchParams.get('type') === tab || (url.searchParams.get('type') === null && tab === 'all'),
                'border-transparent': url.searchParams.get('type') !== tab,
            };
        };
    }, []);

    return (
        <UserLayout
            title="Notifications"
            actions={
                <div className="flex items-center gap-x-2">
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild className="block md:hidden">
                            <Button variant="outline" size="sm">
                                <Filter />
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent>
                            {types.map((type) => (
                                <DropdownMenuItem key={type.value} onClick={() => handleNotificationTypeFilter(type.value)}>
                                    {type.label}
                                </DropdownMenuItem>
                            ))}
                        </DropdownMenuContent>
                    </DropdownMenu>
                    <Button variant="outline" size="sm">
                        Mark all as read
                    </Button>
                </div>
            }
        >
            <div className="container space-y-6">
                <div className="hidden w-full gap-x-2 md:flex">
                    <Button className={clsx(isActiveTab('all'), 'flex-1')} variant="ghost" onClick={() => handleNotificationTypeFilter('all')}>
                        All
                    </Button>

                    {types.map((type) => (
                        <Button
                            className={clsx(isActiveTab(type.value), 'flex-1')}
                            variant="ghost"
                            key={type.value}
                            onClick={() => handleNotificationTypeFilter(type.value)}
                        >
                            {type.label}
                        </Button>
                    ))}
                </div>
                {notifications.data.length === 0 ? (
                    <EmptyResult
                        icon={<Bell className="text-muted-foreground mx-auto h-12 w-12" />}
                        title="No notifications found"
                        description="Your notifications will appear here"
                    />
                ) : (
                    <NotificationsList notifications={notifications} />
                )}
            </div>
        </UserLayout>
    );
}

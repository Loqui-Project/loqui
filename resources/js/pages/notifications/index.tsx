import { NotificationClient } from '@/clients/notification.client';
import { EmptyResult } from '@/components/empty-result';
import { NotificationsList } from '@/components/notifications/notifications-list';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import UserLayout from '@/layouts/user-layout';
import { Notification } from '@/types';
import { useMutation } from '@tanstack/react-query';
import clsx from 'clsx';
import { Bell, Filter } from 'lucide-react';
import { useMemo } from 'react';
import { toast } from 'sonner';
type ListNotificationsPageProps = {
    notifications: Notification[];
    types: {
        label: string;
        value: string;
    }[];
};
export default function ListNotificationsPage({ notifications, types }: ListNotificationsPageProps) {
    const { mutate } = useMutation({
        mutationKey: ['notifications.markAsRead'],
        mutationFn: () => NotificationClient.markAllAsRead(),
        onSuccess: () => {
            toast.success('All notifications marked as read');
        },
    });
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
                            <DropdownMenuItem key={'all'} onClick={() => handleNotificationTypeFilter('all')}>
                                All
                            </DropdownMenuItem>
                            {types.map((type) => (
                                <DropdownMenuItem key={type.value} onClick={() => handleNotificationTypeFilter(type.value)}>
                                    {type.label}
                                </DropdownMenuItem>
                            ))}
                        </DropdownMenuContent>
                    </DropdownMenu>
                    <Button variant="outline" size="sm" onClick={() => mutate()}>
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
                {notifications.length === 0 ? (
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

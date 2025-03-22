'use client';

import { Card } from '@/components/ui/card';
import { Notification } from '@/types';
import { Bell } from 'lucide-react';
import { NotificationCard } from './notification-card';

type NotificationsListProps = {
    notifications: Notification[];
};
export function NotificationsList({ notifications }: NotificationsListProps) {
    if (notifications.length === 0) {
        return (
            <Card className="p-8 text-center">
                <Bell className="text-muted-foreground mx-auto mb-4 h-12 w-12" />
                <h3 className="text-lg font-medium">No notifications</h3>
                <p className="text-muted-foreground mt-2">You don't have any notifications at the moment.</p>
            </Card>
        );
    }

    return (
        <div className="space-y-4">
            {Array.isArray(notifications) &&
                notifications.map((notification) => <NotificationCard notification={notification} key={notification.id} />)}
        </div>
    );
}

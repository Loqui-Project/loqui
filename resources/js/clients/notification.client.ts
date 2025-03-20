import { client } from '@/lib/client';

export const NotificationClient = {
    async markAllAsRead() {
        return await client().post(route('notifications.markAllAsRead'));
    },
    async markAsRead(id: string) {
        return await client().post(route('notifications.markAsRead', { id }));
    },
};

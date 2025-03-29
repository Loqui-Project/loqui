import { NotificationClient } from '@/clients/notification.client';
import { Notification } from '@/types';
import { Link } from '@inertiajs/react';
import { useMutation } from '@tanstack/react-query';
import { formatDistance } from 'date-fns';
import { Check, Heart, MessageCircle, Reply, UserPlus } from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';
import { Badge } from '../ui/badge';
import { Button } from '../ui/button';
import { Card } from '../ui/card';
import { UserAvatar } from '../user-avatar';

function NotificationIcon({ type }: { type: Notification['type'] }) {
    switch (type) {
        case 'new-message':
            return <MessageCircle className="h-4 w-4 text-blue-500" />;
        case 'new-follower':
            return <UserPlus className="h-4 w-4 text-green-500" />;
        case 'like':
            return <Heart className="h-4 w-4 text-red-500" />;
        case 'replay':
            return <Reply className="h-4 w-4 text-purple-500" />;
        default:
            return <MessageCircle className="h-4 w-4" />;
    }
}
type NotificationCardProps = {
    notification: Notification;
};
export function NotificationCard({ notification }: NotificationCardProps) {
    const [isRead, setIsRead] = useState(!!notification.read_at);
    const { mutate } = useMutation({
        mutationKey: ['notifications.markAsRead'],
        mutationFn: () => NotificationClient.markAsRead(notification.id),
        onSuccess: () => {
            toast.success('Notifications marked as read');
            setIsRead(true);
        },
    });
    return (
        <Card key={notification.id} className={`p-4 transition-colors ${!isRead ? 'bg-muted/40 border-l-primary border-l-4' : ''}`}>
            <div className="flex items-start gap-4">
                <div className="flex-1 space-y-1">
                    <div className="flex items-start justify-between">
                        <div className="flex items-center gap-2">
                            <UserAvatar avatarClassname="h-12 w-12 border" user={notification.data.user} />
                            {!isRead && (
                                <Badge variant="default" className="ml-2">
                                    New
                                </Badge>
                            )}
                        </div>
                        <div className="flex items-center gap-2">
                            <NotificationIcon type={notification.type} />
                            <p className="text-muted-foreground text-xs">
                                {formatDistance(new Date(notification.created_at), new Date(), {
                                    addSuffix: true,
                                })}
                            </p>
                        </div>
                    </div>

                    <p className="text-sm">{notification.data.title}</p>

                    <div className="flex items-center justify-between pt-2">
                        <Link href={notification.data.url}>
                            <Button variant="link" size="sm" className="text-primary h-auto px-0">
                                View
                            </Button>
                        </Link>

                        {!isRead && (
                            <Button variant="ghost" size="sm" className="h-8 gap-1" onClick={() => mutate()}>
                                <Check className="h-3.5 w-3.5" />
                                Mark as read
                            </Button>
                        )}
                    </div>
                </div>
            </div>
        </Card>
    );
}

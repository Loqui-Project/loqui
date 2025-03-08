"use client"

import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Card } from "@/components/ui/card"
import {Heart, Bell, Check, MessageCircle, UserPlus, Reply} from "lucide-react"
import {Notification} from "@/types";
import {UserAvatar} from "@/components/user-avatar";
import { formatDistance } from 'date-fns';

// Icon component based on notification type
function NotificationIcon({ type }: { type: Notification["type"] }) {
    switch (type) {
        case "new-message":
            return <MessageCircle  className="h-4 w-4 text-blue-500" />
        case "new-follower":
            return <UserPlus className="h-4 w-4 text-green-500" />
        case "like":
            return <Heart className="h-4 w-4 text-red-500" />
        case "replay":
            return <Reply className="h-4 w-4 text-purple-500" />
        default:
            return <MessageCircle className="h-4 w-4" />
    }
}


type NotificationsListProps = {
    notifications: {
        data: Notification[]
    }
}
export function NotificationsList({ notifications }: NotificationsListProps) {

    if (notifications.data.length === 0) {
        return (
            <Card className="p-8 text-center">
                <Bell className="mx-auto h-12 w-12 text-muted-foreground mb-4" />
                <h3 className="text-lg font-medium">No notifications</h3>
                <p className="text-muted-foreground mt-2">
                    You don't have any notifications at the moment.
                </p>
            </Card>
        )
    }

    return (
        <div className="space-y-4">
            {Array.isArray(notifications.data) && notifications.data.map((notification) => (
                <Card
                    key={notification.id}
                    className={`p-4 transition-colors ${!notification.read_at ? "bg-muted/40 border-l-4 border-l-primary" : ""}`}
                >
                    <div className="flex items-start gap-4">
                        <UserAvatar className="h-12 w-12 border" user={notification.data.user} />

                        <div className="flex-1 space-y-1">
                            <div className="flex items-start justify-between">
                                <div className="flex items-center gap-2">
                                    <p className="font-medium">{notification.data.user.name}</p>
                                    <p className="text-xs text-muted-foreground">{notification.data.user.username}</p>
                                    {!notification.read_at && (
                                        <Badge variant="default" className="ml-2">
                                            New
                                        </Badge>
                                    )}
                                </div>
                                <div className="flex items-center gap-2">
                                    <NotificationIcon type={notification.type} />
                                    <p className="text-xs text-muted-foreground">{
                                        formatDistance(new Date(notification.created_at), new Date(), {
                                            addSuffix: true,
                                        })
                                    }</p>
                                </div>
                            </div>

                            <p className="text-sm">{notification.data.title}</p>

                            <div className="flex items-center justify-between pt-2">
                                <Button
                                    variant="link"
                                    size="sm"
                                    className="px-0 h-auto text-primary"
                                >
                                    View
                                </Button>

                                {!notification.read_at && (
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        className="h-8 gap-1"
                                    >
                                        <Check className="h-3.5 w-3.5" />
                                        Mark as read
                                    </Button>
                                )}
                            </div>
                        </div>
                    </div>
                </Card>
            ))}
        </div>
    )
}


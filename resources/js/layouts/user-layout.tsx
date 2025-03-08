import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Auth } from '@/types';
import { Head } from '@inertiajs/react';
import { Bell, House, MessageCircle, Settings, Star, User, Users, Inbox } from 'lucide-react';
import {toast} from "sonner";

interface AuthLayoutProps {
    children: React.ReactNode;
    name?: string;
    title?: string;
    description?: string;
    user: Auth['user'];
}

export default function UserLayout({ children, user, title }: AuthLayoutProps) {
    window.Echo.private(`user.${user.id}`)
        .notification((notification) => {
            console.log(notification)
            toast.custom(() => (
                <a href={route("message.show", {
                    message: notification.message.id
                })} className="flex flex-start p-4 flex-row min-w-52 gap-x-4">
                    <Avatar className="mb-4">
                        <AvatarImage width={50} height={50} src={`/storage/${notification.currentUser.image_url ?? ''}`} alt={notification.currentUser.name} />
                        <AvatarFallback>{notification.currentUser.username}</AvatarFallback>
                    </Avatar>
                    <div className="flex flex-col gap-y-2">
                        <div>
                            <h2 className="text-xl font-bold">{notification.currentUser.name}</h2>
                            <p className="text-muted-foreground text-sm"><span>@</span>{notification.currentUser.username}</p>
                        </div>
                        <p className="text-muted-foreground text-sm">{notification.message.message}</p>
                    </div>
                </a>
            ))
        });
    return (
        <>
            <Head title={title} />
            <div className="bg-background flex min-h-screen">
                {/* Sidebar with user info */}
                <div className="bg-muted/40 sticky top-0 hidden h-screen w-64 flex-col border-r md:flex">
                    <div className="flex flex-col items-center justify-center border-b p-6">
                        <Avatar className="mb-4 h-20 w-20">
                            <AvatarImage src={`/storage/${user.image_url ?? ''}`} alt={user.name} />
                            <AvatarFallback>{user.username}</AvatarFallback>
                        </Avatar>
                        <h2 className="text-xl font-bold">{user.name}</h2>
                        <p className="text-muted-foreground text-sm">{`@${user.username}`}</p>

                        <div className="mt-6 flex w-full justify-between">
                            <div className="text-center">
                                <p className="font-bold">245</p>
                                <p className="text-muted-foreground text-xs">Following</p>
                            </div>
                            <div className="text-center">
                                <p className="font-bold">1.2k</p>
                                <p className="text-muted-foreground text-xs">Followers</p>
                            </div>
                            <div className="text-center">
                                <p className="font-bold">48</p>
                                <p className="text-muted-foreground text-xs">Messages</p>
                            </div>
                        </div>
                    </div>

                    <nav className="flex-1 p-4">
                        <ul className="space-y-2">
                            <li>
                                <a href={route('home')}>
                                    <Button variant="ghost" className="w-full justify-start">
                                        <House className="mr-2 h-4 w-4" />
                                        Home
                                    </Button>
                                </a>
                            </li>
                            <li>
                                <Button variant="ghost" className="w-full justify-start">
                                    <Inbox className="mr-2 h-4 w-4" />
                                    Inbox
                                </Button>
                            </li>
                            <li>
                                <Button variant="ghost" className="w-full justify-start">
                                    <Star className="mr-2 h-4 w-4" />
                                    Starred
                                </Button>
                            </li>
                            <li>
                                <a href={route('notifications')}>

                                <Button variant="ghost" className="w-full justify-start">
                                    <Bell className="mr-2 h-4 w-4" />
                                    Notifications
                                </Button>
                                </a>
                            </li>
                            <li>
                                <a href={route('profile.edit')}>
                                    <Button variant="ghost" className="w-full justify-start">
                                        <Settings className="mr-2 h-4 w-4" />
                                        Settings
                                    </Button>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <div className="border-t p-4">
                        <a href={route("profile", {
                            username: user.username
                        })}>

                        <Button className="w-full">
                            <User className="mr-2 h-4 w-4" />
                            View Profile
                        </Button>
                        </a>

                    </div>
                </div>

                {/* Main content */}
                <div className="flex-1">
                    {/* Mobile header */}
                    {children}
                </div>
            </div>
        </>
    );
}

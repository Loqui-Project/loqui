import { Button } from '@/components/ui/button';
import { UserAvatar } from '@/components/user-avatar';
import { Auth, BrowserNotification } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { Bell, House, Inbox, Settings, Star, User } from 'lucide-react';
import { toast } from 'sonner';

interface AuthLayoutProps {
    children: React.ReactNode;
    name?: string;
    title?: string;
    description?: string;
}

export default function UserLayout({ children, title }: AuthLayoutProps) {
    const {
        props: {
            auth: { user },
            statistics,
        },
    } = usePage<{
        auth: Auth;
        statistics: {
            messages: number;
            followers: number;
            following: number;
        };
    }>();

    window.Echo.private(`user.${user?.id ?? 'anon'}`).notification((notification: BrowserNotification) => {
        toast.custom(() => (
            <a
                href={route('message.show', {
                    message: notification.message.id,
                })}
                className="flex-start flex min-w-52 flex-row gap-x-4 p-4"
            >
                <UserAvatar user={notification.currentUser} className="mb-4" />
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
        ));
    });

    return (
        <>
            <Head title={title} />
            <div className="bg-background min-h-screen md:flex">
                {user && (
                    <>
                        <div className="bg-muted md:bg-muted/40 sticky top-0 z-10 flex w-full flex-col border-r md:h-screen md:w-64">
                            <div className="flex flex-col items-start justify-start border-b p-6 md:items-center md:justify-center">
                                <div className="flex w-full flex-row items-center justify-between md:justify-center">
                                    <div className="flex flex-row items-center gap-x-4 md:flex-col">
                                        <UserAvatar user={user} className="mb-4 h-10 w-10 md:h-20 md:w-20" />
                                        <div className="flex flex-col">
                                            <h2 className="text-xl font-bold">{user.name}</h2>
                                            <p className="text-muted-foreground text-sm">{`@${user.username}`}</p>
                                        </div>
                                    </div>
                                    <Link
                                        href={route('profile', {
                                            username: user.username,
                                        })}
                                        className="block md:hidden"
                                    >
                                        <Button className="w-full">
                                            <User className="mr-2 h-4 w-4" />
                                            View Profile
                                        </Button>
                                    </Link>
                                </div>

                                <div className="mt-6 hidden w-full justify-between md:flex">
                                    <div className="text-center">
                                        <p className="font-bold">{statistics.following}</p>
                                        <p className="text-muted-foreground text-xs">Following</p>
                                    </div>
                                    <div className="text-center">
                                        <p className="font-bold">{statistics.followers}</p>
                                        <p className="text-muted-foreground text-xs">Followers</p>
                                    </div>
                                    <div className="text-center">
                                        <p className="font-bold">{statistics.messages}</p>
                                        <p className="text-muted-foreground text-xs">Messages</p>
                                    </div>
                                </div>
                            </div>

                            <nav className="fixed bottom-0 z-10 w-full flex-1 md:relative md:w-auto md:p-4">
                                <ul className="bg-accent flex flex-row justify-between space-y-2 p-4 md:flex-col md:justify-center md:bg-transparent md:p-0">
                                    <li>
                                        <Link href={route('home')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <House className="mr-2 h-4 w-4" />
                                                Home
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href={route('inbox')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Inbox className="mr-2 h-4 w-4" />
                                                Inbox
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Button
                                            variant="ghost"
                                            className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                        >
                                            <Star className="mr-2 h-4 w-4" />
                                            Starred
                                        </Button>
                                    </li>
                                    <li>
                                        <Link href={route('notifications')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Bell className="mr-2 h-4 w-4" />
                                                Notifications
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href={route('profile.edit')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Settings className="mr-2 h-4 w-4" />
                                                Settings
                                            </Button>
                                        </Link>
                                    </li>
                                </ul>
                            </nav>

                            <div className="hidden border-t p-4 md:block">
                                <Link
                                    href={route('profile', {
                                        username: user.username,
                                    })}
                                >
                                    <Button className="w-full">
                                        <User className="mr-2 h-4 w-4" />
                                        View Profile
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    </>
                )}
                {/* Main content */}
                <div className="flex-1">
                    {/* Mobile header */}
                    {children}
                </div>
            </div>
        </>
    );
}

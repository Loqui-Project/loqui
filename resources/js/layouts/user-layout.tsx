import { UserClient } from '@/clients/user.client';
import { Button } from '@/components/ui/button';
import { UserAvatar } from '@/components/user-avatar';
import { UserFollowModal } from '@/components/user/follow-modal';
import { Auth, BrowserNotification } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { Bell, ChevronLeft, House, Inbox, Search, Settings, Star, User } from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';

interface AuthLayoutProps {
    children: React.ReactNode;
    name?: string;
    title?: string;
    description?: string;
    actions?: React.ReactNode;
    pageTitle?: string;
}

export default function UserLayout({ children, title, actions, pageTitle = title }: AuthLayoutProps) {
    const [openFollowerModal, setOpenFollowerModal] = useState(false);
    const [openFollowingModal, setOpenFollowingModal] = useState(false);
    const {
        props: {
            auth: { user },
            statistics,
        },
        url,
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
            <Head>
                <meta charSet="utf-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0" />
                <meta name="theme-color" content="#FFFFFF" />
                <meta name="referrer" content="origin-when-cross-origin" />
                <meta name="twitter:site" content="@yanalshoubaki" />
                <meta name="twitter:domain" content="loqui.yanalshoubaki.com" />
                <meta property="og:url" content={url} />
                <meta name="twitter:url" content={url} />
                <meta name="twitter:creator" content={`@${user.username}`} />
                <meta property="fb:app_id" content={import.meta.env.FACEBOOK_CLIENT_ID} />
                <title>{pageTitle}</title>
                <meta name="description" content="Your page description" />
                <link rel="icon" type="image/svg+xml" href="/logo.svg" />
                <meta property="og:title" content={pageTitle} />
                <meta property="og:type" content="website" />
                <meta property="og:url" content={url} />
                <meta property="og:image" content={user.image_url ? `/storage/${user.image_url}` : '/images/default-avatar.png'} />
            </Head>
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
                                    <UserFollowModal
                                        onClose={() => setOpenFollowerModal(false)}
                                        user={user}
                                        open={openFollowerModal}
                                        queryKey={`followers-${user.id}`}
                                        queryFn={({ queryKey }) => {
                                            const [key, userId, query] = queryKey;
                                            return UserClient.getFollowers(user.username, query as string);
                                        }}
                                        triggerComponent={
                                            <div
                                                onClick={() => {
                                                    setOpenFollowerModal(true);
                                                    setOpenFollowingModal(false);
                                                }}
                                                className="cursor-pointer text-center"
                                            >
                                                <p className="font-bold">{statistics.following}</p>
                                                <p className="text-muted-foreground text-xs">Following</p>
                                            </div>
                                        }
                                    />
                                    <UserFollowModal
                                        onClose={() => setOpenFollowingModal(false)}
                                        user={user}
                                        open={openFollowingModal}
                                        queryKey={`followings-${user.id}`}
                                        queryFn={({ queryKey }) => {
                                            const [key, userId, query] = queryKey;
                                            return UserClient.getFollowing(user.username, query as string);
                                        }}
                                        triggerComponent={
                                            <div
                                                onClick={() => {
                                                    setOpenFollowingModal(true);
                                                    setOpenFollowerModal(false);
                                                }}
                                                className="cursor-pointer text-center"
                                            >
                                                <p className="font-bold">{statistics.followers}</p>
                                                <p className="text-muted-foreground text-xs">Followers</p>
                                            </div>
                                        }
                                    />

                                    <div className="text-center">
                                        <p className="font-bold">{statistics.messages}</p>
                                        <p className="text-muted-foreground text-xs">Messages</p>
                                    </div>
                                </div>
                            </div>

                            <nav className="fixed bottom-0 z-10 w-full flex-1 md:relative md:w-auto md:p-4">
                                <ul className="bg-accent flex flex-row justify-evenly space-y-2 p-4 md:flex-col md:justify-center md:bg-transparent md:p-0">
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
                                        <Link href={route('search.index')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Search className="mr-2 h-4 w-4" />
                                                Search
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
                                    <li className="hidden md:block">
                                        <Link href={route('message.favorites')}>
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Star className="mr-2 h-4 w-4" />
                                                Favorites
                                            </Button>
                                        </Link>
                                    </li>
                                    <li className="hidden md:block">
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
                    <main className="p-4 md:p-10">
                        <div className="mb-6">
                            <div className="mb-6 flex w-full items-center justify-between">
                                <div className="flex items-center">
                                    {url !== route('home', {}, false) ? (
                                        <Button variant="ghost" size="icon" asChild className="mr-2">
                                            <Link href={route('home')}>
                                                <ChevronLeft className="h-5 w-5" />
                                            </Link>
                                        </Button>
                                    ) : null}

                                    <h1 className="text-2xl font-bold">{title}</h1>
                                </div>
                                <div>{actions}</div>
                            </div>
                            {children}
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}

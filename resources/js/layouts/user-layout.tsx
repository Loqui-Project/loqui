import AppLogo from '@/components/app-logo';
import { NewFollowerNotification } from '@/components/notifications/new-follower.notification';
import { NewMessageNotification } from '@/components/notifications/new-message.notification';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { UserAvatar } from '@/components/user-avatar';
import { useAppearance } from '@/hooks/use-appearance';
import { BrowserNotification, InertiaPageProps } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { DropdownMenuGroup } from '@radix-ui/react-dropdown-menu';
import { Bell, ChevronLeft, House, Inbox, Menu, Search, Settings, Star } from 'lucide-react';
import { useMemo } from 'react';
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
    const { appearance, updateAppearance } = useAppearance();

    const {
        props: { auth },
        url,
    } = usePage<InertiaPageProps>();

    const isActiveLink = useMemo(
        () => (href: string) => {
            const pathname = new URL(href, window.location.origin).pathname;
            return url === pathname || url.includes(pathname);
        },
        [url],
    );
    if (auth) {
        window.Echo.private(`user.${auth?.id ?? 'anon'}`).notification((notification: BrowserNotification) => {
            if (notification.type == 'new-message') {
                toast.custom(() => <NewMessageNotification notification={notification} />);
            } else if (notification.type == 'new-follower') {
                toast.custom(() => <NewFollowerNotification notification={notification} />);
            }
        });
    }

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

                <meta name="twitter:creator" content={`@${auth?.username}`} />
                <meta property="og:image" content={auth?.image_url} />

                <meta property="fb:app_id" content={import.meta.env.FACEBOOK_CLIENT_ID} />
                <title>{pageTitle}</title>
                <meta name="description" content="Your page description" />
                <link rel="icon" type="image/svg+xml" href="/logo.svg" />
                <meta property="og:title" content={pageTitle} />
                <meta property="og:type" content="website" />
                <meta property="og:url" content={url} />
            </Head>
            <div className="w-full border-yellow-100 bg-yellow-50 px-4 py-6 text-center text-yellow-600 dark:border-yellow-200/10 dark:bg-yellow-700/10">
                This website is still in development, please report any issues you find to{' '}
                <a href="mailto:me@yanalshoubaki.com" className="underline">
                    me@yanalshoubaki.com
                </a>
            </div>

            <div className="bg-background min-h-screen md:flex">
                {auth && (
                    <>
                        <div className="bg-muted md:bg-muted/40 sticky top-0 z-10 flex w-full flex-col border-r md:h-screen md:w-64">
                            <div className="flex flex-col items-start justify-start p-4 md:p-6 md:py-10">
                                <AppLogo />
                            </div>

                            <nav className="fixed bottom-0 z-10 w-full flex-1 md:relative md:w-auto md:p-4">
                                <ul className="bg-accent flex flex-row justify-between p-4 md:flex-col md:justify-center md:space-y-6 md:bg-transparent md:p-0">
                                    <li>
                                        <Link href={route('home')} data-active={isActiveLink(route('home'))} className="group">
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <House className="size-6" />
                                                <span className="ml-2 hidden md:block md:text-base">Home</span>
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href={route('search.index')} data-active={isActiveLink(route('search.index'))} className="group">
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Search className="size-6" />
                                                <span className="ml-2 hidden md:block md:text-base">Search</span>
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link href={route('inbox')} data-active={isActiveLink(route('inbox'))} className="group">
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Inbox className="size-6" />
                                                <span className="ml-2 hidden md:block md:text-base">Inbox</span>
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            href={route('notifications.index')}
                                            data-active={isActiveLink(route('notifications.index'))}
                                            className="group"
                                        >
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <Bell className="size-6" />

                                                <span className="ml-2 hidden md:block md:text-base">Notifications</span>
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            href={route('profile', {
                                                username: auth.username,
                                            })}
                                        >
                                            <Button
                                                variant="ghost"
                                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                            >
                                                <UserAvatar user={auth} className="size-6" />
                                                <span className="ml-2 hidden md:block md:text-base">Profile</span>
                                            </Button>
                                        </Link>
                                    </li>
                                    <li>
                                        <DropdownMenu>
                                            <DropdownMenuTrigger asChild>
                                                <Button
                                                    variant="ghost"
                                                    className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                                                >
                                                    <Menu className="size-6" />
                                                    <span className="ml-2 hidden md:block md:text-base">More</span>
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent className="min-w-3xs flex-col gap-y-4">
                                                <DropdownMenuItem>
                                                    <Link
                                                        href={route('settings.profile.edit')}
                                                        data-active={isActiveLink(route('settings.profile.edit'))}
                                                        className="group flex items-center gap-x-2"
                                                    >
                                                        <Settings className="size-5" />
                                                        <span>Settings</span>
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuItem>
                                                    <Link
                                                        href={route('message.favorites')}
                                                        data-active={isActiveLink(route('message.favorites'))}
                                                        className="group flex items-center gap-x-2"
                                                    >
                                                        <Star className="size-5" />
                                                        <span>Favorites</span>
                                                    </Link>
                                                </DropdownMenuItem>
                                                <DropdownMenuSeparator />
                                                <DropdownMenuGroup className="flex items-center justify-between px-3 py-2">
                                                    <Label>Dark mode</Label>

                                                    <Switch
                                                        defaultChecked={appearance === 'dark'}
                                                        id="apperance-toggle"
                                                        onCheckedChange={(checked) => {
                                                            updateAppearance(checked ? 'dark' : 'light');
                                                        }}
                                                    />
                                                </DropdownMenuGroup>

                                                <DropdownMenuSeparator />
                                                <DropdownMenuItem
                                                    className="cursor-pointer"
                                                    onClick={() => {
                                                        router.post(route('logout'));
                                                    }}
                                                >
                                                    Logout
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </>
                )}
                {/* Main content */}
                <div className="flex-1">
                    <main className="p-4 md:p-10">
                        <div className="mb-6">
                            <div className="mb-6 flex w-full items-center justify-between">
                                {!!title && (
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
                                )}
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

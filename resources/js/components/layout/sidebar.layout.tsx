import { useAppearance } from '@/hooks/use-appearance';
import { InertiaPageProps } from '@/types';
import { router } from '@inertiajs/core';
import { Link, usePage } from '@inertiajs/react';
import { Bell, House, Inbox, Menu, Search, Settings, Shield, Star } from 'lucide-react';
import { useMemo } from 'react';
import AppLogo from '../app-logo';
import { Button } from '../ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '../ui/dropdown-menu';
import { Label } from '../ui/label';
import { Switch } from '../ui/switch';
import { UserAvatar } from '../user-avatar';

export function Sidebar() {
    const { appearance, updateAppearance } = useAppearance();

    const {
        props: { auth: user, is_admin, statistics },
        url,
    } = usePage<InertiaPageProps>();

    const isActiveLink = useMemo(
        () => (href: string) => {
            const pathname = new URL(href, window.location.origin).pathname;
            return url === pathname || url.includes(pathname);
        },
        [url],
    );

    if (user === null) {
        return null;
    }

    return (
        <aside className="bg-muted md:bg-muted/40 sticky top-0 z-10 flex w-full flex-col border-r md:h-screen md:w-64">
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
                                <span className="hidden md:block md:text-base">Home</span>
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
                                <span className="hidden md:block md:text-base">Search</span>
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
                                <span className="hidden md:block md:text-base">
                                    Inbox
                                    {statistics.inbox > 0 && (
                                        <span className="ml-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                                            {statistics.inbox}
                                        </span>
                                    )}
                                </span>
                            </Button>
                        </Link>
                    </li>
                    <li>
                        <Link href={route('notifications.index')} data-active={isActiveLink(route('notifications.index'))} className="group">
                            <Button
                                variant="ghost"
                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent w-full cursor-pointer justify-start transition"
                            >
                                <Bell className="size-6" />

                                <span className="hidden md:block md:text-base">
                                    Notifications
                                    {statistics.notifications > 0 && (
                                        <span className="ml-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">
                                            {statistics.notifications}
                                        </span>
                                    )}
                                </span>
                            </Button>
                        </Link>
                    </li>
                    <li>
                        <Link
                            href={route('profile', {
                                username: user.username,
                            })}
                        >
                            <Button
                                variant="ghost"
                                className="hover:bg-accent-foreground group-data-[active=true]:bg-accent-foreground group-data-[active=true]:text-accent hover:text-accent h-auto w-full cursor-pointer justify-start px-3 transition"
                            >
                                <UserAvatar user={user} imageOnly={true} avatarClassname="size-6" />
                                <span className="hidden md:block md:text-base">Profile</span>
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
                                    <span className="hidden md:block md:text-base">More</span>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent className="min-w-3xs flex-col gap-y-4">
                                {is_admin && (
                                    <DropdownMenuItem asChild>
                                        <a
                                            href={route('filament.admin.pages.dashboard')}
                                            className="group flex cursor-pointer items-center gap-x-2"
                                            target="_blank"
                                        >
                                            <Shield className="size-5" />
                                            <span>Admin</span>
                                        </a>
                                    </DropdownMenuItem>
                                )}
                                <DropdownMenuItem asChild>
                                    <Link
                                        href={route('settings.profile.edit')}
                                        data-active={isActiveLink(route('settings.profile.edit'))}
                                        className="group flex cursor-pointer items-center gap-x-2"
                                    >
                                        <Settings className="size-5" />
                                        <span>Settings</span>
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuItem asChild>
                                    <Link
                                        href={route('message.favorites')}
                                        data-active={isActiveLink(route('message.favorites'))}
                                        className="group flex cursor-pointer items-center gap-x-2"
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
        </aside>
    );
}

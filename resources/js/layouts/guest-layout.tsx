import AppLogo from '@/components/app-logo';
import { UserAvatar } from '@/components/user-avatar';
import { Auth } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface GuestLayoutProps {
    children: React.ReactNode;
    name?: string;
    title?: string;
    description?: string;
    actions?: React.ReactNode;
    pageTitle?: string;
}

export function GuestLayout({ children, title, pageTitle = title }: GuestLayoutProps) {
    const {
        props: { auth, url },
    } = usePage<{
        auth: Auth;
        url: string;
    }>();
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
                <meta name="twitter:creator" content={`@yanalshoubaki`} />
                <meta property="fb:app_id" content={import.meta.env.FACEBOOK_CLIENT_ID} />
                <title>{pageTitle}</title>
                <meta name="description" content="Your page description" />
                <link rel="icon" type="image/svg+xml" href="/logo.svg" />
                <meta property="og:title" content={pageTitle} />
                <meta property="og:type" content="website" />
                <meta property="og:url" content={url} />
                <meta property="og:image" content="/images/web-images/loqui-banner.png" />
            </Head>
            <div className="flex min-h-screen flex-col">
                {/* Header */}
                <header className="bg-background/95 supports-[backdrop-filter]:bg-background/60 sticky top-0 z-40 w-full border-b backdrop-blur">
                    <div className="container mx-auto flex h-16 items-center justify-between">
                        <div className="flex items-center gap-2">
                            <AppLogo />
                        </div>
                        <nav className="hidden gap-6 md:flex">
                            <Link href="#features" className="hover:text-primary text-sm font-medium">
                                Features
                            </Link>
                            <Link href="#how-it-works" className="hover:text-primary text-sm font-medium">
                                How It Works
                            </Link>
                        </nav>
                        <div className="flex items-center gap-4">
                            {auth.user?.data ? (
                                <Link href={route('home')} className="flex flex-row items-center gap-x-4">
                                    <UserAvatar user={auth.user.data} />
                                    <div>
                                        <h3 className="text-base font-bold">{auth.user.data.name}</h3>
                                        <p className="text-muted-foreground text-sm">@{auth.user.data.username}</p>
                                    </div>
                                </Link>
                            ) : (
                                <div className="flex flex-row items-center gap-x-4">
                                    <Link href={route('login')} className="text-sm font-medium underline-offset-4 hover:underline">
                                        Log In
                                    </Link>

                                    <Link
                                        href={route('register')}
                                        className="bg-primary text-primary-foreground rounded-md px-2 py-2 text-sm font-medium"
                                    >
                                        Sign up for free
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </header>

                <main className="flex-1">{children}</main>
                {/* Footer */}
                <footer className="w-full border-t py-6 md:py-0">
                    <div className="container mx-auto flex flex-col items-center justify-between gap-4 md:h-24 md:flex-row">
                        <div className="flex items-center gap-2">
                            <p className="text-sm font-medium">© 2025 Loqui. All rights reserved.</p>
                        </div>
                        <div className="flex gap-4">
                            <Link href="#" className="text-sm font-medium underline-offset-4 hover:underline">
                                Terms
                            </Link>
                            <Link href="#" className="text-sm font-medium underline-offset-4 hover:underline">
                                Privacy
                            </Link>
                            <Link href="#" className="text-sm font-medium underline-offset-4 hover:underline">
                                Cookies
                            </Link>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}

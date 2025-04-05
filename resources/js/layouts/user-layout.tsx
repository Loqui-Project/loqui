import { Sidebar } from '@/components/layout/sidebar.layout';
import { NewFollowerNotification } from '@/components/notifications/new-follower.notification';
import { NewMessageNotification } from '@/components/notifications/new-message.notification';
import { Button } from '@/components/ui/button';
import { BrowserNotification, InertiaPageProps } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { ChevronLeft } from 'lucide-react';
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
    const {
        url,
        props: { auth },
    } = usePage<InertiaPageProps>();

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

                <meta property="fb:app_id" content={import.meta.env.FACEBOOK_CLIENT_ID} />
                <title>{pageTitle}</title>
                <meta name="description" content="Your page description" />
                <link rel="icon" type="image/svg+xml" href="/logo.svg" />
                <meta property="og:title" content={pageTitle} />
                <meta property="og:type" content="website" />
            </Head>
            <div className="w-full border-yellow-100 bg-yellow-50 px-4 py-6 text-center text-yellow-600 dark:border-yellow-200/10 dark:bg-yellow-700/10">
                This website is still in development, please report any issues you find to{' '}
                <a href="mailto:me@yanalshoubaki.com" className="underline">
                    me@yanalshoubaki.com
                </a>
            </div>

            <div className="bg-background min-h-screen md:flex">
                <Sidebar />
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

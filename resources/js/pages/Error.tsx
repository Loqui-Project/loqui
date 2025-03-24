import { Button } from '@/components/ui/button';
import { Head, Link } from '@inertiajs/react';
import { Home, Search } from 'lucide-react';

export default function Error() {
    return (
        <>
            <Head>
                <title>Page not found</title>
                <meta name="description" content="Page not found" />
            </Head>
            <div className="bg-background flex min-h-[100dvh] flex-col items-center justify-center px-4">
                <div className="mx-auto flex max-w-[500px] flex-col items-center justify-center text-center">
                    <div className="bg-muted mb-4 flex h-24 w-24 items-center justify-center rounded-full">
                        <Search className="text-muted-foreground h-12 w-12" />
                    </div>
                    <h1 className="mb-2 text-4xl font-extrabold tracking-tight sm:text-5xl">Page not found</h1>
                    <p className="text-muted-foreground mb-8 max-w-md">
                        We couldn't find the page you were looking for. The page might have been removed, renamed, or is temporarily unavailable.
                    </p>
                    <div className="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3">
                        <Button asChild size="lg">
                            <Link href="/">
                                <Home className="mr-2 h-4 w-4" />
                                Back to home
                            </Link>
                        </Button>
                        <Button variant="outline" asChild size="lg">
                            <Link href="/contact">Contact support</Link>
                        </Button>
                    </div>
                </div>
            </div>
        </>
    );
}

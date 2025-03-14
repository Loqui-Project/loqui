import AppLogo from '@/components/app-logo';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Link } from '@inertiajs/react';
import { Bell, CheckCircle, Heart, ImageIcon, MessageCircle, Send, Shield, Star, Users } from 'lucide-react';

export default function LandingPage() {
    return (
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
                        <Link href="#testimonials" className="hover:text-primary text-sm font-medium">
                            Testimonials
                        </Link>
                        <Link href="#pricing" className="hover:text-primary text-sm font-medium">
                            Pricing
                        </Link>
                    </nav>
                    <div className="flex items-center gap-4">
                        <Link href={route('login')} className="text-sm font-medium underline-offset-4 hover:underline">
                            Log In
                        </Link>
                        <Button asChild>
                            <Link href={route('register')}>Sign Up Free</Link>
                        </Button>
                    </div>
                </div>
            </header>

            <main className="flex-1">
                {/* Hero Section */}
                <section className="relative w-full py-12 md:py-24 lg:py-32 xl:py-48">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="mx-auto flex max-w-8/12 flex-col items-center justify-center gap-y-12">
                            <div className="flex flex-col justify-center space-y-4 text-center">
                                <div className="flex flex-col gap-y-4 text-center">
                                    <h1 className="text-3xl font-bold tracking-tighter sm:text-5xl xl:text-6xl/none">
                                        Connect with friends in a more meaningful way
                                    </h1>
                                    <p className="text-muted-foreground mx-auto max-w-[600px] text-center md:text-xl">
                                        Share moments, exchange messages, and build relationships on a platform designed for genuine connections.
                                    </p>
                                </div>
                                <div className="flex flex-col justify-center gap-2 min-[400px]:flex-row">
                                    <Button size="lg" asChild>
                                        <Link href="/signup">Get Started</Link>
                                    </Button>
                                    <Button size="lg" variant="outline" asChild>
                                        <Link href="#how-it-works">Learn More</Link>
                                    </Button>
                                </div>
                            </div>
                            <div className="mx-auto flex items-center justify-center">
                                <div className="relative w-full">
                                    <img src="/images/web-images/loqui-banner.png" alt="Banner" className="object-cover" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="from-muted/40 absolute bottom-0 -z-10 block h-full w-full bg-gradient-to-t to-transparent"></div>
                </section>

                {/* Features Section */}
                <section id="features" className="bg-muted/40 w-full py-12 md:py-24 lg:py-32">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="flex flex-col items-center justify-center space-y-4 text-center">
                            <div className="space-y-2">
                                <h2 className="text-3xl font-bold tracking-tighter sm:text-5xl">Features you'll love</h2>
                                <p className="text-muted-foreground max-w-[900px] md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                    Our platform is designed to make connecting with others simple, meaningful, and enjoyable.
                                </p>
                            </div>
                        </div>
                        <div className="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <MessageCircle className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Real-time Messaging</h3>
                                    <p className="text-muted-foreground">
                                        Exchange messages instantly with friends and colleagues. Get notifications when someone responds.
                                    </p>
                                </CardContent>
                            </Card>
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <Users className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Social Feed</h3>
                                    <p className="text-muted-foreground">
                                        Stay updated with posts from people you follow. Like, comment, and share content that matters to you.
                                    </p>
                                </CardContent>
                            </Card>
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <ImageIcon className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Media Sharing</h3>
                                    <p className="text-muted-foreground">
                                        Share photos and images easily. Express yourself visually and make your conversations more engaging.
                                    </p>
                                </CardContent>
                            </Card>
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <Bell className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Smart Notifications</h3>
                                    <p className="text-muted-foreground">
                                        Get notified about what matters most. Customize your notification preferences for a distraction-free
                                        experience.
                                    </p>
                                </CardContent>
                            </Card>
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <Shield className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Privacy Controls</h3>
                                    <p className="text-muted-foreground">
                                        Take control of your privacy. Choose who can see your content and manage your personal information.
                                    </p>
                                </CardContent>
                            </Card>
                            <Card className="bg-background">
                                <CardContent className="flex flex-col items-center space-y-4 p-6 text-center">
                                    <div className="bg-primary/10 rounded-full p-3">
                                        <Star className="text-primary h-6 w-6" />
                                    </div>
                                    <h3 className="text-xl font-bold">Favorites</h3>
                                    <p className="text-muted-foreground">
                                        Save important messages and content. Organize your favorites for easy access later.
                                    </p>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </section>

                {/* How It Works Section */}
                <section id="how-it-works" className="w-full py-12 md:py-24 lg:py-32">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="flex flex-col items-center justify-center space-y-4 text-center">
                            <div className="space-y-2">
                                <h2 className="text-3xl font-bold tracking-tighter sm:text-5xl">How Loqui Works</h2>
                                <p className="text-muted-foreground max-w-[900px] md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                    See how our platform helps you connect with others in a few simple steps.
                                </p>
                            </div>
                        </div>

                        <Tabs defaultValue="messaging" className="mx-auto mt-12 w-full max-w-4xl">
                            <TabsList className="grid w-full grid-cols-3">
                                <TabsTrigger value="messaging">Messaging</TabsTrigger>
                                <TabsTrigger value="social">Social Feed</TabsTrigger>
                                <TabsTrigger value="profile">Profile</TabsTrigger>
                            </TabsList>
                            <TabsContent value="messaging" className="mt-6">
                                <div className="grid items-center gap-6 lg:grid-cols-2">
                                    <div className="space-y-4">
                                        <h3 className="text-2xl font-bold">Connect through conversations</h3>
                                        <ul className="space-y-3">
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Start conversations instantly</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Send messages to individuals or groups with just a few taps.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Share photos and media</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Enhance your conversations with images and other media.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Stay organized</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Find important messages quickly with our intuitive interface.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="bg-muted relative overflow-hidden rounded-lg border">
                                        <img src="/images/web-images/user-profile.png" alt="Messaging interface" className="object-cover" />
                                    </div>
                                </div>
                            </TabsContent>
                            <TabsContent value="social" className="mt-6">
                                <div className="grid items-center gap-6 lg:grid-cols-2">
                                    <div className="space-y-4">
                                        <h3 className="text-2xl font-bold">Stay connected with your network</h3>
                                        <ul className="space-y-3">
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Follow friends and colleagues</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Build your network and see updates from people who matter to you.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Engage with content</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Like, comment, and share posts to join the conversation.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Discover new connections</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Find people with similar interests and expand your network.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="bg-muted relative overflow-hidden rounded-lg border">
                                        <img src="/images/web-images/search.png" alt="Social feed interface" className="object-cover" />
                                    </div>
                                </div>
                            </TabsContent>
                            <TabsContent value="profile" className="mt-6">
                                <div className="grid items-center gap-6 lg:grid-cols-2">
                                    <div className="space-y-4">
                                        <h3 className="text-2xl font-bold">Express yourself</h3>
                                        <ul className="space-y-3">
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Customize your profile</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Show the world who you are with a personalized profile.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Share updates</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        Post messages, photos, and more directly from your profile.
                                                    </p>
                                                </div>
                                            </li>
                                            <li className="flex items-start gap-2">
                                                <CheckCircle className="text-primary mt-0.5 h-5 w-5" />
                                                <div>
                                                    <p className="font-medium">Track your activity</p>
                                                    <p className="text-muted-foreground text-sm">
                                                        See your message history, followers, and more in one place.
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div className="bg-muted relative aspect-video overflow-hidden rounded-lg border">
                                        <img src="/images/web-images/settings.png" alt="Profile interface" className="object-cover" />
                                    </div>
                                </div>
                            </TabsContent>
                        </Tabs>
                    </div>
                </section>

                {/* App Preview Section */}
                <section className="bg-muted/40 w-full py-12 md:py-24 lg:py-32">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="flex flex-col items-center justify-center space-y-4 text-center">
                            <div className="space-y-2">
                                <h2 className="text-3xl font-bold tracking-tighter sm:text-5xl">See Loqui in action</h2>
                                <p className="text-muted-foreground max-w-[900px] md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                    Take a look at our intuitive interface designed for seamless communication.
                                </p>
                            </div>
                        </div>

                        <div className="relative mx-auto mt-12 max-w-5xl">
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-12">
                                <div className="relative aspect-[4/2] overflow-hidden rounded-lg border shadow-lg md:col-span-9">
                                    <img src="/images/web-images/user-profile.png" alt="App desktop view" className="object-cover" />
                                </div>
                                <div className="flex flex-col gap-6 md:col-span-3">
                                    <div className="relative aspect-[8/13] overflow-hidden rounded-lg border shadow-lg">
                                        <img src="/images/web-images/mobile.png" alt="App mobile view" className="object-cover" />
                                    </div>
                                </div>
                            </div>

                            <div className="mt-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div className="bg-background rounded-lg border p-4 shadow-sm">
                                    <div className="mb-2 flex items-center gap-2">
                                        <MessageCircle className="text-primary h-5 w-5" />
                                        <h3 className="font-medium">Intuitive Messaging</h3>
                                    </div>
                                    <p className="text-muted-foreground text-sm">Our clean interface makes conversations flow naturally.</p>
                                </div>
                                <div className="bg-background rounded-lg border p-4 shadow-sm">
                                    <div className="mb-2 flex items-center gap-2">
                                        <Heart className="text-primary h-5 w-5" />
                                        <h3 className="font-medium">Engaging Social Features</h3>
                                    </div>
                                    <p className="text-muted-foreground text-sm">Like, comment, and interact with content that matters to you.</p>
                                </div>
                                <div className="bg-background rounded-lg border p-4 shadow-sm">
                                    <div className="mb-2 flex items-center gap-2">
                                        <Send className="text-primary h-5 w-5" />
                                        <h3 className="font-medium">Seamless Sharing</h3>
                                    </div>
                                    <p className="text-muted-foreground text-sm">Share thoughts and media with just a few taps.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Testimonials Section */}
                <section id="testimonials" className="w-full py-12 md:py-24 lg:py-32">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="flex flex-col items-center justify-center space-y-4 text-center">
                            <div className="space-y-2">
                                <h2 className="text-3xl font-bold tracking-tighter sm:text-5xl">What our users say</h2>
                                <p className="text-muted-foreground max-w-[900px] md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                    Don't just take our word for it. Here's what people love about loqui.
                                </p>
                            </div>
                        </div>

                        <div className="mt-12 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <Card>
                                <CardContent className="p-6">
                                    <div className="mb-4 flex items-start gap-4">
                                        <Avatar className="h-10 w-10 border">
                                            <AvatarImage src="/placeholder.svg?height=40&width=40" alt="Sarah J." />
                                            <AvatarFallback>SJ</AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <p className="font-medium">Sarah Johnson</p>
                                            <p className="text-muted-foreground text-sm">Marketing Director</p>
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <div className="flex text-amber-500">
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                        </div>
                                        <p className="text-muted-foreground">
                                            "Loqui has transformed how our team communicates. The interface is intuitive, and the social features make
                                            work conversations more engaging."
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent className="p-6">
                                    <div className="mb-4 flex items-start gap-4">
                                        <Avatar className="h-10 w-10 border">
                                            <AvatarImage src="/placeholder.svg?height=40&width=40" alt="Michael T." />
                                            <AvatarFallback>MT</AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <p className="font-medium">Michael Thompson</p>
                                            <p className="text-muted-foreground text-sm">Software Developer</p>
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <div className="flex text-amber-500">
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                        </div>
                                        <p className="text-muted-foreground">
                                            "I love how Loqui combines messaging and social features. It's like having the best parts of different
                                            apps all in one place."
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent className="p-6">
                                    <div className="mb-4 flex items-start gap-4">
                                        <Avatar className="h-10 w-10 border">
                                            <AvatarImage src="/placeholder.svg?height=40&width=40" alt="Emily R." />
                                            <AvatarFallback>ER</AvatarFallback>
                                        </Avatar>
                                        <div>
                                            <p className="font-medium">Emily Rodriguez</p>
                                            <p className="text-muted-foreground text-sm">Small Business Owner</p>
                                        </div>
                                    </div>
                                    <div className="space-y-2">
                                        <div className="flex text-amber-500">
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                            <Star className="h-5 w-5 fill-current" />
                                        </div>
                                        <p className="text-muted-foreground">
                                            "Loqui has helped me stay in touch with clients in a more personal way. The interface is beautiful and
                                            easy to use."
                                        </p>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="bg-primary text-primary-foreground w-full py-12 md:py-24 lg:py-32">
                    <div className="container mx-auto px-4 md:px-6">
                        <div className="flex flex-col items-center justify-center space-y-4 text-center">
                            <div className="space-y-2">
                                <h2 className="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">Ready to get started?</h2>
                                <p className="max-w-[600px] md:text-xl/relaxed lg:text-base/relaxed xl:text-xl/relaxed">
                                    Join thousands of users already connecting on our platform.
                                </p>
                            </div>
                            <div className="w-full max-w-sm space-y-2">
                                <form className="flex w-full max-w-sm items-center space-x-2">
                                    <Input type="email" placeholder="Enter your email" className="bg-primary-foreground text-foreground" />
                                    <Button type="submit" variant="secondary">
                                        Sign Up
                                    </Button>
                                </form>
                                <p className="text-xs">
                                    By signing up, you agree to our{' '}
                                    <Link href="#" className="underline underline-offset-2">
                                        Terms of Service
                                    </Link>{' '}
                                    and{' '}
                                    <Link href="#" className="underline underline-offset-2">
                                        Privacy Policy
                                    </Link>
                                    .
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

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
    );
}

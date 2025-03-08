'use client';

import { MessageCard } from '@/components/message-card';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';
import { Filter, MessageCircle, Search, Star } from 'lucide-react';
import { useState } from 'react';

type HomePageProps = {
    messages: {
        data: Message[];
    };
};

export default function HomePage({ messages }: HomePageProps) {
    const [filter, setFilter] = useState('all');
    const [searchQuery, setSearchQuery] = useState('');

    return (
        <UserLayout title="Home">
            {/* Messages section */}
            <main className="p-4">
                <div className="mb-6 flex flex-col items-center justify-between md:flex-row">
                    <h1 className="mb-4 text-2xl font-bold md:mb-0">Messages</h1>

                    {/* Filter and search */}
                    <div className="flex w-full space-x-2 md:w-auto">
                        <div className="relative flex-1 md:w-64">
                            <Search className="text-muted-foreground absolute top-2.5 left-2.5 h-4 w-4" />
                            <Input
                                type="search"
                                placeholder="Search messages..."
                                className="pl-8"
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                            />
                        </div>

                        <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                                <Button variant="outline" size="icon">
                                    <Filter className="h-4 w-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuItem onClick={() => setFilter('all')}>All Messages</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => setFilter('unread')}>Unread</DropdownMenuItem>
                                <DropdownMenuItem onClick={() => setFilter('starred')}>Starred</DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>
                </div>

                <Tabs defaultValue="all" className="w-full">
                    <TabsList className="mb-4 grid w-full grid-cols-3">
                        <TabsTrigger value="all" onClick={() => setFilter('all')}>
                            All
                        </TabsTrigger>
                        <TabsTrigger value="unread" onClick={() => setFilter('unread')}>
                            Unread
                        </TabsTrigger>
                        <TabsTrigger value="starred" onClick={() => setFilter('starred')}>
                            Starred
                        </TabsTrigger>
                    </TabsList>

                    <TabsContent value="all" className="space-y-4">
                        {messages.data.length > 0 ? (
                            messages.data.map((message) => <MessageCard key={message.id} message={message} />)
                        ) : (
                            <div className="py-10 text-center">
                                <MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />
                                <h3 className="mt-4 text-lg font-medium">No messages found</h3>
                                <p className="text-muted-foreground text-sm">
                                    {searchQuery ? 'Try a different search term' : 'Your messages will appear here'}
                                </p>
                            </div>
                        )}
                    </TabsContent>

                    <TabsContent value="unread" className="space-y-4">
                        {messages.data.length > 0 ? (
                            messages.data.map((message) => <MessageCard key={message.id} message={message} />)
                        ) : (
                            <div className="py-10 text-center">
                                <MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />
                                <h3 className="mt-4 text-lg font-medium">No unread messages</h3>
                                <p className="text-muted-foreground text-sm">You're all caught up!</p>
                            </div>
                        )}
                    </TabsContent>

                    <TabsContent value="starred" className="space-y-4">
                        {messages.data.length > 0 ? (
                            messages.data.map((message) => <MessageCard key={message.id} message={message} />)
                        ) : (
                            <div className="py-10 text-center">
                                <Star className="text-muted-foreground mx-auto h-12 w-12" />
                                <h3 className="mt-4 text-lg font-medium">No starred messages</h3>
                                <p className="text-muted-foreground text-sm">Star important messages to find them quickly</p>
                            </div>
                        )}
                    </TabsContent>
                </Tabs>
            </main>
        </UserLayout>
    );
}

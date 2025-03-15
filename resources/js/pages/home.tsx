'use client';

import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';
import { MessageCircle } from 'lucide-react';

type HomePageProps = {
    messages: {
        data: Message[];
    };
};

export default function HomePage({ messages }: HomePageProps) {
    return (
        <UserLayout title="Home">
            <main className="p-4">
                <section id="messages" className="space-y-4">
                    {messages.data.length > 0 ? (
                        messages.data.map((message) => <MessageCard key={message.id} message={message} />)
                    ) : (
                        <EmptyResult
                            icon={<MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />}
                            title="No messages found"
                            description="Your messages will appear here"
                        />
                    )}
                </section>
            </main>
        </UserLayout>
    );
}

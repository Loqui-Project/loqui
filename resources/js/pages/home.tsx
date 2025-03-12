'use client';

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
            {/* Messages section */}
            <main className="p-4">
                {messages.data.length > 0 ? (
                    messages.data.map((message) => <MessageCard key={message.id} message={message} />)
                ) : (
                    <div className="py-10 text-center">
                        <MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />
                        <h3 className="mt-4 text-lg font-medium">No messages found</h3>
                        <p className="text-muted-foreground text-sm">Your messages will appear here</p>
                    </div>
                )}
            </main>
        </UserLayout>
    );
}

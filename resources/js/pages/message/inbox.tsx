import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';
import { MessageCircle } from 'lucide-react';

type MessageShowProps = {
    messages: {
        data: Message[];
    };
};

export default function InboxPage({ messages }: MessageShowProps) {
    return (
        <UserLayout title="Inbox">
            {messages.data.length > 0 ? (
                messages.data.map((message) => <MessageCard key={message.id} message={message} />)
            ) : (
                <EmptyResult
                    icon={<MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />}
                    title="No messages yet"
                    description="When you receive messages, you'll see them here."
                />
            )}
        </UserLayout>
    );
}

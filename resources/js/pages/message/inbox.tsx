import { MessageCard } from '@/components/message-card';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';

type MessageShowProps = {
    messages: {
        data: Message[];
    };
};

export default function InboxPage({ messages }: MessageShowProps) {
    return (
        <UserLayout title="Inbox">
            <div className="space-y-6 p-10">
                <h2 className="text-xl font-semibold">Latest messages that you recived </h2>

                {messages.data.map((message) => (
                    <MessageCard key={message.id} message={message} />
                ))}
            </div>
        </UserLayout>
    );
}

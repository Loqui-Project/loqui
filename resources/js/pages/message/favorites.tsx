import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';
import { MessageCircle } from 'lucide-react';

type FavoritesMessagesProps = {
    messages: Message[];
};

export default function FavoritesMessages({ messages }: FavoritesMessagesProps) {
    return (
        <UserLayout title="Favorites">
            {messages.length > 0 ? (
                messages.map((message) => <MessageCard key={message.id} message={message} />)
            ) : (
                <EmptyResult
                    icon={<MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />}
                    title="No messages starred yet"
                    description="When you save message, you'll see it here."
                />
            )}
        </UserLayout>
    );
}

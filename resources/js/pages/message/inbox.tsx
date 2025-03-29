'use client';
import { MessagesList } from '@/components/messages/list.messages';
import UserLayout from '@/layouts/user-layout';
import { DataWithPagination, Message } from '@/types';

type MessageShowProps = {
    messages: DataWithPagination<Message>;
};

export default function InboxPage({ messages: initialMessages }: MessageShowProps) {
    return (
        <UserLayout title="Inbox">
            <main className="p-4">
                <MessagesList initialMessages={initialMessages} pageRoute={'inbox'} />
            </main>
        </UserLayout>
    );
}

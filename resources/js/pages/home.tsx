'use client';

import { MessagesList } from '@/components/messages/list.messages';
import UserLayout from '@/layouts/user-layout';
import { DataWithPagination, Message } from '@/types';

interface HomePageProps {
    messages: DataWithPagination<Message>;
}

export default function HomePage({ messages: initialMessages }: HomePageProps) {
    return (
        <UserLayout title="Home">
            <main className="p-4">
                <MessagesList initialMessages={initialMessages} pageRoute={'home'} />
            </main>
        </UserLayout>
    );
}

'use client';

import { MessagesClient } from '@/clients/messages.client';
import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import { Button } from '@/components/ui/button';
import UserLayout from '@/layouts/user-layout';
import { DataWithPagination, Message } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { Loader2, MessageCircle } from 'lucide-react';
import { useState } from 'react';

type HomePageProps = {
    messages: DataWithPagination<Message>;
};

export default function HomePage({ messages }: HomePageProps) {
    const [messagesData, setMessagesData] = useState<Message[]>(messages.data);
    const [pagination, setPagination] = useState(messages.meta);
    const [isLastPage, setIsLastPage] = useState(pagination.current_page === pagination.last_page);
    const { mutate: loadMore, isPending } = useMutation({
        mutationKey: ['inbox', 'messages', messages.meta.current_page + 1],
        mutationFn: () =>
            MessagesClient.getMessages({
                page: messages.meta.current_page + 1,
            }),
        onSuccess(data) {
            setMessagesData([...messagesData, ...data.data.data]);
            setPagination(data.data.meta);
            setIsLastPage(data.data.meta.current_page === data.data.meta.last_page);
        },
    });
    return (
        <UserLayout title="Home">
            <main className="p-4">
                <section id="messages" className="space-y-4">
                    {messages.data.length > 0 ? (
                        <div>
                            <div className="flex flex-col gap-y-4">
                                {messagesData.map((message) => (
                                    <MessageCard key={`message-${message.id}`} message={message} />
                                ))}
                            </div>
                            {!isLastPage && (
                                <div className="mt-4 flex items-center justify-center">
                                    <Button disabled={isPending} onClick={() => loadMore()}>
                                        {isPending ? (
                                            <>
                                                <Loader2 className="mr-2 animate-spin" />
                                                Loading...
                                            </>
                                        ) : (
                                            'Load More'
                                        )}
                                    </Button>
                                </div>
                            )}
                        </div>
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

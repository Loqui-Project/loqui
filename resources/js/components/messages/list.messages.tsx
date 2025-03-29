import { DataWithPagination, Message } from '@/types';
import { router } from '@inertiajs/react';
import { LoaderCircle, MessageCircle } from 'lucide-react';
import { useEffect, useState } from 'react';
import { EmptyResult } from '../empty-result';
import { MessageCard } from '../message-card';

type MessagesListProps = {
    initialMessages: DataWithPagination<Message>;
    pageRoute: string;
};
export function MessagesList({ initialMessages, pageRoute }: MessagesListProps) {
    const [messages, setMessages] = useState(initialMessages.data);
    const [currentPage, setCurrentPage] = useState(initialMessages.meta.current_page);
    const [lastPage, setLastPage] = useState(initialMessages.meta.last_page);
    const [loading, setLoading] = useState(false);

    const loadMore = async () => {
        if (currentPage >= lastPage || loading) return;

        setLoading(true);
        router.post(
            route(pageRoute),
            { page: currentPage + 1 },
            {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onStart: () => {
                    setLoading(true);
                },
                onSuccess: (page) => {
                    const newMessages = page.props.messages as DataWithPagination<Message>;
                    setMessages([...messages, ...newMessages.data]);
                    setCurrentPage(newMessages.meta.current_page);
                    setLastPage(newMessages.meta.last_page);
                    setLoading(false);
                },
            },
        );
    };

    useEffect(() => {
        const handleScroll = () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500 && !loading) {
                loadMore();
            }
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, [loading]);

    return (
        <section id="messages" className="space-y-4">
            {messages.length > 0 ? (
                <div>
                    <div className="flex flex-col gap-y-4">
                        {messages.map((message) => (
                            <MessageCard key={`message-${message.id}`} message={message} />
                        ))}
                    </div>
                    {currentPage < lastPage && loading && (
                        <p className="flex justify-center py-10">
                            <LoaderCircle className="h-5 w-5 animate-spin" />
                        </p>
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
    );
}

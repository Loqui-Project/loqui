'use client';

import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import { SendMessage } from '@/components/send-message';
import { Separator } from '@/components/ui/separator';
import { UserProfileCard } from '@/components/user/profile-card.user';
import UserLayout from '@/layouts/user-layout';
import { InertiaPageProps, Message, User } from '@/types';
import { MessageCircle } from 'lucide-react';

type PublicProfilePageProps = {
    user: User;
    is_me: boolean;
    messages: Message[];
    is_following_me: boolean;
    is_following: boolean;
} & InertiaPageProps;

export default function PublicProfilePage({ user, is_me, messages, auth, statistics, is_following_me, is_following }: PublicProfilePageProps) {
    return (
        <UserLayout pageTitle={`${user.name} (@${user.username})`}>
            <section className="mb-20 md:mb-6">
                <UserProfileCard
                    isAuthenticated={!!auth}
                    statistics={statistics}
                    user={user}
                    is_me={is_me}
                    is_following_me={is_following_me}
                    is_following={is_following}
                />
                <Separator className="my-10" />
                {!is_me && <SendMessage userId={user.id} />}
                {/* Feed from followed users */}
                <section id="messages" className="mt-4 space-y-6">
                    {messages.length > 0 ? (
                        messages.map((message) => <MessageCard key={message.id} message={message} />)
                    ) : (
                        <EmptyResult
                            icon={<MessageCircle className="text-muted-foreground mx-auto h-12 w-12" />}
                            title="No messages found"
                            description="There is no message to show here"
                        />
                    )}
                </section>
            </section>
        </UserLayout>
    );
}

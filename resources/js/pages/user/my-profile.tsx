'use client';

import { MessagesList } from '@/components/messages/list.messages';
import { SendMessage } from '@/components/send-message';
import { Separator } from '@/components/ui/separator';
import { UserProfileCard } from '@/components/user/profile-card.user';
import UserLayout from '@/layouts/user-layout';
import { DataWithPagination, InertiaPageProps, Message, User } from '@/types';

type MyProfilePageProps = {
    user: User;
    is_me: boolean;
    messages: DataWithPagination<Message>;
    is_following_me?: boolean;
    is_following?: boolean;
} & InertiaPageProps;

export default function MyProfilePage({ user, is_me, messages: initialMessages, statistics, auth, is_following }: MyProfilePageProps) {
    return (
        <UserLayout pageTitle={`${user.name} (@${user.username})`}>
            <section className="mb-20 md:mb-6">
                <UserProfileCard isAuthenticated={!!auth} statistics={statistics} is_following={is_following} user={user} is_me={is_me} />
                <Separator className="my-10" />
                {!is_me && <SendMessage userId={user.id} />}
                {/* Feed from followed users */}
                <MessagesList initialMessages={initialMessages} pageRoute={'profile'} routeParams={{
                    username: user.username,
                }} />
            </section>
        </UserLayout>
    );
}

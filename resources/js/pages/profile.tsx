'use client';

import { UserClient } from '@/clients/user.client';
import { MessageCard } from '@/components/message-card';
import { SendMessage } from '@/components/send-message';
import { Button } from '@/components/ui/button';
import { UserAvatar } from '@/components/user-avatar';
import { useUnfollowUser } from '@/hooks/use-unfollow-user';
import UserLayout from '@/layouts/user-layout';
import { Message, User } from '@/types';
import { useMutation } from '@tanstack/react-query';
import clsx from 'clsx';
import { useState } from 'react';
import { toast } from 'sonner';

type ProfilePageProps = {
    user: User;
    is_me: boolean;
    messages: {
        data: Message[];
    };
    is_following: boolean;
};

export default function ProfilePage({ user, is_me, messages, is_following }: ProfilePageProps) {
    const [isFollowing, setIsFollowing] = useState(is_following);
    const { mutate: followUser } = useMutation({
        mutationKey: ['followUser', user.id],
        mutationFn: async () => {
            return await UserClient.followUser(user.id);
        },
        onSuccess: () => {
            setIsFollowing(true);
            toast.success(`You are now following ${user.name}`);
        },
    });

    const { unfollowUser, isUnfollowRequestPending } = useUnfollowUser(user);

    return (
        <UserLayout title={`${user.name} Profile`} pageTitle={`${user.name} (@${user.username})`}>
            <section className="mb-20 md:mb-6">
                {!is_me && (
                    <div className="my-10 flex w-full items-start justify-between">
                        <div className="flex items-center gap-4">
                            <UserAvatar user={user} className="h-16 w-16" />
                            <div>
                                <h1 className="text-2xl font-semibold">{user.name}</h1>
                                <p className="text-muted-foreground text-sm">
                                    <span>@</span>
                                    {user.username}
                                </p>
                            </div>
                        </div>
                        <Button
                            onClick={() => (isFollowing ? unfollowUser() : followUser())}
                            variant="secondary"
                            disabled={isUnfollowRequestPending}
                            className={clsx('mt-4 transition data-[unfollow=true]:bg-red-500 data-[unfollow=true]:text-white', {
                                'bg-primary': isFollowing,
                                'hover:bg-primary-dark': isFollowing,
                                'text-accent': isFollowing,
                                'text-primary': !isFollowing,
                                'hover:text-primary-dark': !isFollowing,
                            })}
                            onMouseEnter={(e) => {
                                e.currentTarget.innerText = isFollowing ? 'Unfollow' : 'Follow';
                                e.currentTarget.dataset.unfollow = isFollowing ? 'true' : 'false';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.innerText = isFollowing ? 'Following' : 'Follow';
                                e.currentTarget.dataset.unfollow = 'false';
                            }}
                        >
                            {isFollowing ? 'Following' : 'Follow'}
                        </Button>
                    </div>
                )}
                {!is_me && <SendMessage userId={user.id} />}
                {/* Feed from followed users */}
                <section id="messages" className="mt-4 space-y-6">
                    {messages.data.map((message) => (
                        <MessageCard key={message.id} message={message} />
                    ))}
                </section>
            </section>
        </UserLayout>
    );
}

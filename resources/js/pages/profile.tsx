'use client';

import { UserClient } from '@/clients/user.client';
import { EmptyResult } from '@/components/empty-result';
import { MessageCard } from '@/components/message-card';
import { SendMessage } from '@/components/send-message';
import { Button } from '@/components/ui/button';
import { Separator } from '@/components/ui/separator';
import { UserAvatar } from '@/components/user-avatar';
import { UserFollowModal } from '@/components/user/follow-modal';
import { useUnfollowUser } from '@/hooks/use-unfollow-user';
import UserLayout from '@/layouts/user-layout';
import { Message, User } from '@/types';
import { Link } from '@inertiajs/react';
import { useMutation } from '@tanstack/react-query';
import clsx from 'clsx';
import { MessageCircle } from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';

type ProfilePageProps = {
    user: {
        data: User;
    };
    is_me: boolean;
    messages: {
        data: Message[];
    };
    is_following: boolean;
    statistics: {
        followers: number;
        following: number;
        messages: number;
    };
};

export default function ProfilePage({ user: { data: user }, is_me, messages, is_following, statistics }: ProfilePageProps) {
    const [isFollowing, setIsFollowing] = useState(is_following);
    const [openFollowingModal, setOpenFollowingModal] = useState(false);
    const [openFollowerModal, setOpenFollowerModal] = useState(false);
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
                <section id="user-information">
                    <div className="grid grid-cols-12">
                        <div className="col-span-2">
                            <UserAvatar user={user} className="size-40" />
                        </div>
                        <div className="col-span-10 flex flex-col gap-y-4">
                            <div className="flex items-start gap-x-4">
                                <h2 className="text-xl font-semibold">{user.username}</h2>
                                {is_me ? (
                                    <div>
                                        <Link href={route('profile.edit')} className="text-accent">
                                            <Button className="text-sm">Edit Profile</Button>
                                        </Link>
                                    </div>
                                ) : (
                                    <Button
                                        onClick={() => (isFollowing ? unfollowUser() : followUser())}
                                        variant="secondary"
                                        disabled={isUnfollowRequestPending}
                                        className={clsx('test-sm transition data-[unfollow=true]:bg-red-500 data-[unfollow=true]:text-white', {
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
                                )}
                            </div>
                            <div className="flex items-center gap-4">
                                <div className="flex cursor-pointer flex-row items-center gap-x-2 text-center">
                                    <p className="text-base font-bold">{statistics.messages ?? 0}</p>
                                    <p className="text-muted-foreground text-base">Messages</p>
                                </div>

                                <UserFollowModal
                                    user={user}
                                    queryKey={`followers-${user.id}`}
                                    queryFn={({ queryKey }) => {
                                        return UserClient.getFollowers(user.username, queryKey[2] as string);
                                    }}
                                    open={openFollowerModal}
                                    onClose={() => setOpenFollowerModal(false)}
                                    triggerComponent={
                                        <div
                                            onClick={() => {
                                                setOpenFollowerModal(true);
                                                setOpenFollowingModal(false);
                                            }}
                                            className="flex cursor-pointer flex-row items-center gap-x-2 text-center"
                                        >
                                            <p className="text-base font-bold">{statistics.followers ?? 0}</p>
                                            <p className="text-muted-foreground text-base">Followers</p>
                                        </div>
                                    }
                                />
                                <UserFollowModal
                                    user={user}
                                    queryKey={`followings-${user.id}`}
                                    queryFn={({ queryKey }) => {
                                        return UserClient.getFollowing(user.username, queryKey[2] as string);
                                    }}
                                    open={openFollowingModal}
                                    onClose={() => setOpenFollowingModal(false)}
                                    triggerComponent={
                                        <div
                                            onClick={() => {
                                                setOpenFollowingModal(true);
                                                setOpenFollowerModal(false);
                                            }}
                                            className="flex cursor-pointer flex-row items-center gap-x-2 text-center"
                                        >
                                            <p className="text-base font-bold">{statistics.following ?? 0}</p>
                                            <p className="text-muted-foreground text-base">Following</p>
                                        </div>
                                    }
                                />
                            </div>
                            <div>
                                <h3 className="text-sm font-bold">{user.name}</h3>
                                <p className="prose" dangerouslySetInnerHTML={{ __html: user.bio }} />
                            </div>
                        </div>
                    </div>
                </section>
                <Separator className="my-10" />
                {!is_me && <SendMessage userId={user.id} />}
                {/* Feed from followed users */}
                <section id="messages" className="mt-4 space-y-6">
                    {messages.data.length > 0 ? (
                        messages.data.map((message) => <MessageCard key={message.id} message={message} />)
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

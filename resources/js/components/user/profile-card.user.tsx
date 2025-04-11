import { UserClient } from '@/clients/user.client';
import { useFollowUser } from '@/hooks/use-follow';
import { useUnfollowUser } from '@/hooks/use-unfollow-user';
import { User } from '@/types';
import { Link } from '@inertiajs/react';
import clsx from 'clsx';
import { useState } from 'react';
import { Button } from '../ui/button';
import { UserAvatar } from '../user-avatar';
import { UserFollowModal } from './follow-modal';

type UserProfileCardProps = {
    user: User;
    isAuthenticated: boolean;
    statistics: {
        messages?: number;
        followers?: number;
        following?: number;
    };
    is_following_me?: boolean;
    is_following?: boolean;
    is_me: boolean;
};

export function UserProfileCard(props: UserProfileCardProps) {
    const { user, isAuthenticated, statistics, is_me, is_following_me, is_following } = props;
    if (isAuthenticated) {
        if (is_me) {
            return <SelfUserProfileCard user={user} statistics={statistics} is_following={is_following} is_following_me={is_following_me} />;
        }
        return <AuthUserProfileCard user={user} statistics={statistics} is_following={is_following} is_following_me={is_following_me} />;
    }

    return <GuestUserProfileCard user={user} statistics={statistics} is_following={is_following} is_following_me={is_following_me} />;
}

type AuthUserProfileCardProps = {
    user: User;
    is_following_me?: boolean;
    is_following?: boolean;
    statistics: {
        messages?: number;
        followers?: number;
        following?: number;
    };
};

function AuthUserProfileCard({ statistics, user, is_following_me, is_following }: AuthUserProfileCardProps) {
    const [openFollowingModal, setOpenFollowingModal] = useState(false);
    const [openFollowerModal, setOpenFollowerModal] = useState(false);
    const { followUser, isFollowRequestPending } = useFollowUser(user);

    const { unfollowUser, isUnfollowRequestPending } = useUnfollowUser(user);
    return (
        <section id="user-information">
            <div className="grid grid-cols-12 gap-y-4">
                <div className="col-span-12 lg:col-span-2">
                    <UserAvatar user={user} imageOnly avatarClassname="size-20 md:size-40" />
                </div>
                <div className="col-span-10 flex flex-col gap-y-4">
                    <div className="flex flex-wrap items-start gap-4">
                        <h2 className="text-xl font-semibold">{user.username}</h2>
                        {is_following_me && !is_following ? (
                            <Button
                                onClick={() => followUser()}
                                variant="secondary"
                                disabled={isFollowRequestPending}
                                className={clsx('test-sm transition')}
                            >
                                Follow back
                            </Button>
                        ) : (
                            <Button
                                onClick={() => (is_following ? unfollowUser() : followUser())}
                                variant="secondary"
                                disabled={isFollowRequestPending || isUnfollowRequestPending}
                                className={clsx('test-sm transition data-[unfollow=true]:bg-red-500 data-[unfollow=true]:text-white', {
                                    'bg-primary': is_following,
                                    'hover:bg-primary-dark': is_following,
                                    'text-accent': is_following,
                                    'text-primary': !is_following,
                                    'hover:text-primary-dark': !is_following,
                                })}
                                onMouseEnter={(e) => {
                                    e.currentTarget.innerText = is_following ? 'Unfollow' : 'Follow';
                                    e.currentTarget.dataset.unfollow = is_following ? 'true' : 'false';
                                }}
                                onMouseLeave={(e) => {
                                    e.currentTarget.innerText = is_following ? 'Following' : 'Follow';
                                    e.currentTarget.dataset.unfollow = 'false';
                                }}
                            >
                                {is_following ? 'Following' : 'Follow'}
                            </Button>
                        )}
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="#messages" className="flex cursor-pointer flex-row items-center gap-x-2 text-center">
                            <p className="text-base font-bold">{statistics.messages ?? 0}</p>
                            <p className="text-muted-foreground text-base">Messages</p>
                        </a>

                        <UserFollowModal
                            user={user}
                            queryKey={'followers'}
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
                            queryKey={'followings'}
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
    );
}

type GuestUserProfileCardProps = {
    user: User;
    statistics: {
        messages?: number;
        followers?: number;
        following?: number;
    };
    is_following_me?: boolean;
    is_following?: boolean;
};

function GuestUserProfileCard({ user, statistics }: GuestUserProfileCardProps) {
    const [openFollowingModal, setOpenFollowingModal] = useState(false);
    const [openFollowerModal, setOpenFollowerModal] = useState(false);
    return (
        <section id="user-information">
            <div className="grid grid-cols-12 gap-y-4">
                <div className="col-span-12 lg:col-span-2">
                    <UserAvatar user={user} imageOnly avatarClassname="size-20 md:size-40" />
                </div>
                <div className="col-span-10 flex flex-col gap-y-4">
                    <div className="flex flex-wrap items-start gap-4">
                        <h2 className="text-xl font-semibold">{user.username}</h2>
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="#messages" className="flex cursor-pointer flex-row items-center gap-x-2 text-center">
                            <p className="text-base font-bold">{statistics.messages ?? 0}</p>
                            <p className="text-muted-foreground text-base">Messages</p>
                        </a>

                        <UserFollowModal
                            user={user}
                            queryKey={`followers`}
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
                            queryKey={`followings`}
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
    );
}

type SelfUserProfileCardProps = {
    user: User;
    statistics: {
        messages?: number;
        followers?: number;
        following?: number;
    };
    is_following_me?: boolean;
    is_following?: boolean;
};

function SelfUserProfileCard({ user, statistics }: SelfUserProfileCardProps) {
    const [openFollowingModal, setOpenFollowingModal] = useState(false);
    const [openFollowerModal, setOpenFollowerModal] = useState(false);
    return (
        <section id="user-information">
            <div className="grid grid-cols-12 gap-y-4">
                <div className="col-span-12 lg:col-span-2">
                    <UserAvatar user={user} imageOnly avatarClassname="size-20 md:size-40" />
                </div>
                <div className="col-span-10 flex flex-col gap-y-4">
                    <div className="flex flex-wrap items-start gap-4">
                        <h2 className="text-xl font-semibold">{user.username}</h2>
                        <div>
                            <Link href={route('settings.profile.edit')} className="text-accent">
                                <Button className="text-sm">Edit Profile</Button>
                            </Link>
                        </div>
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="#messages" className="flex cursor-pointer flex-row items-center gap-x-2 text-center">
                            <p className="text-base font-bold">{statistics.messages ?? 0}</p>
                            <p className="text-muted-foreground text-base">Messages</p>
                        </a>

                        <UserFollowModal
                            user={user}
                            queryKey={`followers`}
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
                            queryKey={`followings`}
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
    );
}

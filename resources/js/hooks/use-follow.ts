import { UserClient } from '@/clients/user.client';
import { User } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { useState } from 'react';
import { toast } from 'sonner';

export const useFollowUser = (user: User) => {
    const [isFollowing, setIsFollowing] = useState(user.is_following_me);
    const { mutate: followUser, isPending: isFollowRequestPending } = useMutation({
        mutationKey: ['followUser', user?.id],
        mutationFn: async () => {
            return await UserClient.followUser(user.id);
        },
        onSuccess: () => {
            toast.success(`You are now following ${user.name}`);
            setIsFollowing(true);
        },
    });
    if (!user) {
        return {
            followUser: () => {
                toast.error('You must be logged in to follow a user');
            },
            isFollowRequestPending: false,
        };
    }
    return {
        followUser,
        isFollowRequestPending,
        isFollowing,
    };
};

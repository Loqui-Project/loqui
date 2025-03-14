import { UserClient } from '@/clients/user.client';
import { User } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { useState } from 'react';
import { toast } from 'sonner';

export const useUnfollowUser = (user: User) => {
    const [isFollowing, setIsFollowing] = useState(true);

    const { mutate: unfollowUser, isPending: isUnfollowRequestPending } = useMutation({
        mutationKey: ['unFollowUser', user.id],
        mutationFn: async () => {
            return await UserClient.unfollowUser(user.id);
        },
        onSuccess: () => {
            setIsFollowing(false);
            toast.success(`You are now not following ${user.name}`);
        },
    });
    return {
        isFollowing,
        unfollowUser,
        isUnfollowRequestPending,
    };
};

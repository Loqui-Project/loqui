import { UserClient } from '@/clients/user.client';
import { User } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { toast } from 'sonner';

export const useUnfollowUser = (user: User) => {
    const { mutate: unfollowUser, isPending: isUnfollowRequestPending } = useMutation({
        mutationKey: ['unFollowUser', user?.id],
        mutationFn: async () => {
            return await UserClient.unfollowUser(user.id);
        },
        onSuccess: () => {
            toast.success(`You are now not following ${user.name}`);
        },
    });
    if (!user) {
        return {
            unfollowUser: () => {
                toast.error('You must be logged in to unfollow a user');
            },
            isUnfollowRequestPending: false,
        };
    }
    return {
        unfollowUser,
        isUnfollowRequestPending,
    };
};

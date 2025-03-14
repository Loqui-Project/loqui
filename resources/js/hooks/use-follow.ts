import { UserClient } from '@/clients/user.client';
import { User } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { toast } from 'sonner';

export const useFollowUser = (user: User) => {
    const { mutate: followUser, isPending: isFollowRequestPending } = useMutation({
        mutationKey: ['followUser', user.id],
        mutationFn: async () => {
            return await UserClient.followUser(user.id);
        },
        onSuccess: () => {
            toast.success(`You are now following ${user.name}`);
        },
    });
    return {
        followUser,
        isFollowRequestPending,
    };
};

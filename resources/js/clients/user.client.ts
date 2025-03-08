import { client } from '@/lib/client';

export const UserClient = {
    async followUser(userId: number) {
        return await client().post(route('user.follow'), {
            user_id: userId,
        });
    },
    async unfollowUser(userId: number) {
        return await client().post(route('user.unfollow'), {
            user_id: userId,
        });
    },
};

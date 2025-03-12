import { client } from '@/lib/client';
import { User } from '@/types';

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
    async getFollowers(username: string, query: string) {
        return await client().get<User[]>(route('user.followers', { username }), {
            params: {
                query,
            },
        });
    },
    async getFollowing(username: string, query: string) {
        return await client().get<User[]>(route('user.followings', { username }), {
            params: {
                query,
            },
        });
    },
};

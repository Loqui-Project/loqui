import { client } from '@/lib/client';
import { User } from '@/types';

export const SearchClient = {
    async search(query: string) {
        return await client().get<User[]>(route('search.data'), {
            params: {
                query: query,
            },
        });
    },
};

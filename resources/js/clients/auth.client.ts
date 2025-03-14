import { client } from '@/lib/client';

export const AuthClient = {
    async disconnectProvider(provider: string) {
        return await client().post(route('social.disconnect', provider), {
            provider,
        });
    },
};

import { client } from '@/lib/client';
import { DataWithPagination, Message } from '@/types';

export const MessagesClient = {
    async getMessages(params: Record<string, unknown>, route: string) {
        return await client().get<DataWithPagination<Message>>(route, {
            params,
        });
    },
    async likeMessage(messageId: number, like: boolean) {
        return await client().post(route('message.like'), {
            message_id: messageId,
            like: Boolean(like),
        });
    },

    async replyMessage(messageId: number, replay: string) {
        return await client().post(route('message.add-reply'), {
            message_id: messageId,
            replay,
        });
    },

    async sendMessage(message: string, receiverId: number, isAnon: boolean) {
        return await client().post(route('message.send'), {
            message,
            receiver_id: receiverId,
            isAnon,
        });
    },
    async addToFavorite(messageId: number) {
        return await client().post(route('message.addToFavorite'), {
            message_id: messageId,
        });
    },
};

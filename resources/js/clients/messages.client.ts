import {client} from "@/lib/client";

export const MessagesClient = {
    async likeMessage(messageId: number, like: boolean) {
        return await client().post(route('message.like'), {
            message_id: messageId,
                like: Boolean(like)
        });
    },

    async replyMessage(messageId: number, replay: string) {
        return await client().post(route('message.add-reply'), {
            message_id: messageId,
            replay
        });
    },

    async sendMessage(message: string, receiverId: number, isAnon: boolean) {
        return await client().post(route('message.send'), {
            message,
            receiver_id: receiverId,
            isAnon
        });
    }
}

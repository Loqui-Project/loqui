import { MessagesClient } from '@/clients/messages.client';
import { Message } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { useState } from 'react';
import { toast } from 'sonner';

export const useAddToFavorite = (message: Message) => {
    const [isFavorite, setIsFavorite] = useState(message.is_favorite);

    const { mutate: addToFavorite, isPending: isFavoriteRequestPending } = useMutation({
        mutationKey: ['add-to-favorite', message.id],
        mutationFn: async () => {
            return await MessagesClient.addToFavorite(message.id);
        },
        onSuccess: () => {
            setIsFavorite(false);
            toast.success(`Message added to favorites`);
        },
    });
    return {
        isFavorite,
        addToFavorite,
        isFavoriteRequestPending,
    };
};

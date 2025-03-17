import { MessagesClient } from '@/clients/messages.client';
import { Textarea } from '@/components/ui/textarea';
import { UserAvatar } from '@/components/user-avatar';
import { useAddToFavorite } from '@/hooks/use-add-to-favorite';
import { Message } from '@/types';
import { useMutation } from '@tanstack/react-query';
import { AxiosError, AxiosResponse } from 'axios';
import { clsx } from 'clsx';
import { formatDistance } from 'date-fns';
import { Calendar, Heart, MessageCircle, MoreHorizontal, Send, Star, Trash2 } from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';
import { Button } from './ui/button';
import { Card, CardContent, CardFooter, CardHeader } from './ui/card';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from './ui/dropdown-menu';

type MessageCardProps = {
    message: Message;
};

export function MessageCard({ message }: MessageCardProps) {
    const [likes, setLikes] = useState(message.likes_count);
    const [isLiked, setIsLiked] = useState(message.liked);
    const [replyText, setReplyText] = useState('');

    const [replaysCount, setReplaysCount] = useState(message.replays_count);

    const { mutate: likeMessage } = useMutation({
        mutationKey: ['like', message.id],
        mutationFn: async () => {
            return MessagesClient.likeMessage(message.id, !isLiked);
        },
        onSuccess: (
            data: AxiosResponse<{
                message: string;
            }>,
        ) => {
            setLikes(isLiked ? likes - 1 : likes + 1);
            setIsLiked(!isLiked);
            toast.success(data.data.message);
        },
        onError: (error) => {
            if (error instanceof AxiosError) {
                toast.error(error.response?.data.message);
            }
        },
    });

    const { mutate: replyMessage } = useMutation({
        mutationKey: ['reply', message.id],
        mutationFn: async () => {
            return MessagesClient.replyMessage(message.id, replyText);
        },
        onSuccess: (
            data: AxiosResponse<{
                message: string;
            }>,
        ) => {
            setReplyText('');
            setReplaysCount(replaysCount + 1);
            toast.success(data.data.message);
        },
        onError: (error) => {
            if (error instanceof AxiosError) {
                toast.error(error.response?.data.message);
            }
        },
    });

    const { addToFavorite, isFavorite, isFavoriteRequestPending } = useAddToFavorite(message);

    return (
        <Card key={message.id} className="gap-y-2 overflow-hidden p-0">
            <CardHeader className="flex w-full flex-row flex-wrap items-start justify-between gap-3 space-y-0 p-4">
                <div className="flex items-center gap-2">
                    <UserAvatar className="h-10 w-10" user={message.sender} />
                    <div>
                        <h3 className="text-base">{message.sender?.name ?? 'Anonymous'}</h3>
                        <p className="text-xs">{`@${message.sender?.username ?? 'Anonymous'}`}</p>
                    </div>
                </div>
                <div className="flex items-center gap-2">
                    <div className="flex-1 flex-wrap">
                        <div className="flex items-center justify-between">
                            <div className="text-muted-foreground flex items-center text-xs">
                                <Calendar className="mr-1 h-3 w-3" />
                                {formatDistance(new Date(message.created_at), new Date(), { addSuffix: true })}
                            </div>
                        </div>
                    </div>
                    <DropdownMenu>
                        <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="h-8 w-8">
                                <MoreHorizontal className="h-4 w-4" />
                                <span className="sr-only">More options</span>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end">
                            <DropdownMenuItem onClick={() => addToFavorite()} disabled={isFavoriteRequestPending}>
                                <Star className={clsx('mr-2 h-4 w-4', isFavorite ? 'text-yellow-500' : 'text-muted-foreground')} />
                                Save
                            </DropdownMenuItem>
                            <DropdownMenuItem>
                                <MessageCircle className="mr-2 h-4 w-4" />
                                Reply
                            </DropdownMenuItem>
                            <DropdownMenuItem className="text-destructive">
                                <Trash2 className="mr-2 h-4 w-4" />
                                Hide
                            </DropdownMenuItem>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </CardHeader>
            <CardContent className="p-4">
                <p className="mb-3 text-sm">{message.message}</p>
            </CardContent>
            <CardFooter className="flex justify-between p-4">
                <div className="flex space-x-4">
                    <Button
                        onClick={() => {
                            likeMessage();
                        }}
                        variant="ghost"
                        size="sm"
                        className={clsx('h-8 px-2', isLiked && 'text-red-500')}
                    >
                        <Heart className="mr-1 h-4 w-4" />
                        <span>{likes}</span>
                    </Button>
                    <Button variant="ghost" size="sm" className="h-8 px-2">
                        <MessageCircle className="mr-1 h-4 w-4" />
                        <span>{replaysCount}</span>
                    </Button>
                </div>
            </CardFooter>

            <div className="border-t px-4 pt-3 pb-4">
                <div className="flex items-start space-x-3">
                    <UserAvatar user={message.sender} className="h-8 w-8" />
                    <div className="flex-1 space-y-2">
                        <Textarea
                            placeholder={`Reply to ${message.sender?.username ?? 'Anonymous'}...`}
                            className="min-h-[80px] w-full"
                            value={replyText}
                            onChange={(e) => setReplyText(e.target.value)}
                        />
                        <div className="flex justify-end space-x-2">
                            <Button size="sm" onClick={() => replyMessage()} disabled={!replyText.trim()}>
                                <Send className="mr-2 h-4 w-4" />
                                Send Reply
                            </Button>
                        </div>
                    </div>
                </div>
                {message.replays.length > 0 && (
                    <div className="bg-muted/5 px-4 pt-0 pb-2">
                        <div className="space-y-4 pl-8">
                            {message.replays.map((reply) => (
                                <div key={reply.id} className="mt-4 space-y-2 border-t pt-4">
                                    <div className="flex items-start gap-2">
                                        <UserAvatar user={reply.user} className="h-7 w-7" />
                                        <div className="flex-1">
                                            <div className="flex items-center gap-1">
                                                <span className="text-sm font-medium">{reply.user.name}</span>
                                                <span className="text-muted-foreground text-xs">{reply.user.username}</span>
                                            </div>
                                            <p className="mt-1 text-sm">{reply.text}</p>
                                            <div className="mt-1 flex items-center gap-4">
                                                <span className="text-muted-foreground text-xs">
                                                    {formatDistance(new Date(reply.created_at), new Date(), { addSuffix: true })}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </Card>
    );
}

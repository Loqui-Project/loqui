import { MessageCard } from '@/components/message-card';
import UserLayout from '@/layouts/user-layout';
import { Message } from '@/types';

type MessageShowProps = {
    message: Message;
};

export default function MessageShow({ message }: MessageShowProps) {
    return (
        <UserLayout title={`Message From ${message.sender?.name ?? 'Unknown'}`}>
            <div className="p-10">
                <MessageCard message={message} />
            </div>
        </UserLayout>
    );
}

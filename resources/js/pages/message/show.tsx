import UserLayout from "@/layouts/user-layout";
import {Auth, Message} from "@/types";
import {MessageCard} from "@/components/message-card";


type MessageShowProps = {
    auth: Auth;
   message: {
       data:Message
   }
};

export default function MessageShow({auth, message}: MessageShowProps) {
    return (
        <UserLayout user={auth.user}>
            <div className="p-10">

            <MessageCard message={message.data}/>
            </div>

        </UserLayout>
    )
}

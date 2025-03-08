"use client"

import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"
import { Button } from "@/components/ui/button"
import {

    Settings,
} from "lucide-react"
import UserLayout from "@/layouts/user-layout";
import {Message, User} from "@/types";
import {SendMessage} from "@/components/send-message";
import {MessageCard} from "@/components/message-card";



type ProfilePageProps = {
    user: User
    is_me: boolean
    messages: {
        data: Message[]
    }
}

export default function ProfilePage({user, is_me, messages}: ProfilePageProps) {

    return (

        <UserLayout title="Home" user={user}>
            {/* Mobile header */}
            <header className="flex items-center justify-between p-4 border-b md:hidden">
                <div className="flex items-center">
                    <Avatar className="h-8 w-8 mr-2">
                        <AvatarImage src="/placeholder.svg?height=32&width=32" alt="User" />
                        <AvatarFallback>JD</AvatarFallback>
                    </Avatar>
                    <h2 className="font-bold">John Doe</h2>
                </div>
                <Button variant="ghost" size="icon">
                    <Settings className="h-5 w-5" />
                </Button>
            </header>

            {/* Profile content */}
            <main className="p-4">
                <div className="mb-6">
                    {
                        !is_me && (
                            <SendMessage userId={user.id}/>
                        )
                    }
                    {/* Feed from followed users */}
                    <div className="space-y-6">
                        <h2 className="text-xl font-semibold">Latest from people you follow</h2>

                        {messages.data.map((message) => (
                            <MessageCard key={message.id} message={message}/>
                        ))}
                    </div>
                </div>
            </main>
        </UserLayout>

    )
}


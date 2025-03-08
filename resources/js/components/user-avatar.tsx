

import React from 'react';
import {User} from "@/types";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";

type UserAvatarProps = {
    user: User | null;
    className?: string;
}

export function UserAvatar({ user, className }: UserAvatarProps) {
    return (
        <Avatar className={className}>
            <AvatarImage src={user?.image_url ?? "/images/default-avatar.png"} alt={user?.name ?? "Anonymous"} />
            <AvatarFallback>{user?.name[0] ?? "Anonymous"}</AvatarFallback>
        </Avatar>
    );
}

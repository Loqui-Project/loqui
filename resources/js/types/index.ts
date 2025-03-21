import { LucideIcon } from 'lucide-react';

export interface Auth {
    user: {
        data: User;
    };
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}
type PagerLinks = {
    first: string;
    last: string;
    prev: any;
    next: string;
};
type PagerDataLinks = {
    url?: string;
    label: string;
    active: boolean;
};
type PagerData = {
    current_page: number;
    from: number;
    last_page: number;
    links: PagerDataLinks[];
    path: string;
    per_page: number;
    to: number;
    total: number;
};

export interface DataWithPagination<T> {
    links: PagerLinks;
    data: T[];
    meta: PagerData;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    [key: string]: unknown;
}

export interface User {
    id: number;
    username: string;
    name: string;
    email: string;
    bio: string;
    image_url: string;
    is_following: boolean;
    email_verified_at: string | null;
}

export interface Message {
    id: number;
    user: User;
    sender: User | null;
    message: string;
    is_anon: boolean;
    likes_count: number;
    liked: boolean;
    replays_count: number;
    is_favorite: boolean;
    replays: MessageReplay[];
    created_at: string;
    updated_at: string;
}

export interface MessageReplay {
    id: number;
    user: User;
    text: string | null;
    created_at: string;
    updated_at: string;
}

export interface Notification {
    id: string;
    type: string;
    notifiable_type: string;
    notifiable_id: number;
    data: {
        user: User;
        message?: Message;
        title: string;
        url: string;
    };
    read_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface BrowserNotification {
    type: string;
    user: User;
    currentUser: User;
    message: Message;
    title: string;
    url: string;
}

export interface UserSocialAuth {
    provider: string;
    provider_name: string;
    connected: boolean;
}

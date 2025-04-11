import { PageProps } from '@inertiajs/core';
import { LucideIcon } from 'lucide-react';

export interface InertiaPageProps extends PageProps {
    auth: User | null;
    url: string;
    errors: string[];
    statistics: {
        messages: number;
        followers: number;
        following: number;
        inbox: number;
        notifications: number;
    };
    is_admin: boolean;
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
    prev: string;
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

export interface User {
    id: number;
    username: string;
    name: string;
    email: string;
    bio: string;
    image_url: string;
    is_following_me: boolean;
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
    image_url: string | null;
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

export interface Session {
    id: number;
    agent: {
        platform: string;
        browser: string;
        device: string;
    };
    ip_address: string;
    is_current_device: boolean;
    last_activity: number;
}

export type NotificationTypes = 'new-message' | 'new-like' | 'new-reply' | 'new-follower';
export type NotifiactionChannels = 'email' | 'browser' | 'database';

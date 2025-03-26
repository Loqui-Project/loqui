'use client';

import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from '@/layouts/user-layout';

import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { NotifiactionChannels, NotificationTypes } from '@/types';
import { Transition } from '@headlessui/react';
import { useForm } from '@inertiajs/react';
import { toast } from 'sonner';

type NotificationsPageProps = {
    types: {
        label: string;
        value: NotificationTypes;
        description: string;
    }[];
    channels: {
        label: string;
        value: NotifiactionChannels;
    }[];
    userNotificationSettings: Record<NotifiactionChannels, Record<NotificationTypes, boolean>>;
};
export default function NotificationsPage({ channels, types, userNotificationSettings }: NotificationsPageProps) {
    const { data, setData, post, processing, recentlySuccessful } = useForm(userNotificationSettings);
    const handleToggle = (channel: NotifiactionChannels, type: NotificationTypes) => {
        setData((prev) => ({
            ...prev,
            [channel]: {
                ...prev[channel],
                [type]: !prev[channel][type],
            },
        }));
    };

    // Save preferences
    const savePreferences = () => {
        post(route('settings.notifications.update'));
        // Here you would typically save to a database
        console.log('Saving preferences:', data);
        toast.success('Settings saved', {
            description: 'Your notification preferences have been updated.',
        });
    };
    return (
        <UserLayout title="Notification" pageTitle="Notification / Settings">
            <SettingsLayout title="Notification" description="Manage how you receive notifications across different channels">
                <div className="container mx-auto">
                    <div className="mb-10 grid gap-6">
                        {/* Channel Headers */}
                        <div className="grid grid-cols-3 gap-4 border-b pb-2">
                            <div className="col-span-1">
                                <span className="text-muted-foreground text-sm font-medium">Notification Type</span>
                            </div>
                            {channels
                                .filter((channel) => channel.value !== 'database')
                                .map((channel) => (
                                    <div key={channel.value} className="flex items-center justify-center">
                                        <span className="text-muted-foreground text-sm font-medium">{channel.label}</span>
                                    </div>
                                ))}
                        </div>

                        {/* Notification Types */}
                        {types.map((type) => (
                            <div key={type.value} className="grid grid-cols-3 items-center gap-4">
                                <div className="col-span-1">
                                    <div className="space-y-0.5">
                                        <h4 className="text-sm font-medium">{type.label}</h4>
                                        <p className="text-muted-foreground text-xs">{type.description}</p>
                                    </div>
                                </div>
                                {channels
                                    .filter((channel) => channel.value !== 'database')
                                    .map((channel) => {
                                        return (
                                            <div key={channel.value} className="flex justify-center">
                                                <Switch
                                                    defaultChecked={data[channel.value][type.value]}
                                                    onCheckedChange={() => handleToggle(channel.value, type.value)}
                                                    aria-label={`${channel.label} notifications for ${type.label}`}
                                                />
                                            </div>
                                        );
                                    })}
                            </div>
                        ))}
                    </div>

                    <div className="flex items-center gap-4">
                        <Button disabled={processing} onClick={savePreferences}>
                            Save
                        </Button>

                        <Transition
                            show={recentlySuccessful}
                            enter="transition ease-in-out"
                            enterFrom="opacity-0"
                            leave="transition ease-in-out"
                            leaveTo="opacity-0"
                        >
                            <p className="text-sm text-neutral-600">Saved</p>
                        </Transition>
                    </div>
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

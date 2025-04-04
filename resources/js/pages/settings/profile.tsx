import { Transition } from '@headlessui/react';
import { Link, router, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler, useState } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { UserAvatar } from '@/components/user-avatar';
import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from '@/layouts/user-layout';
import { InertiaPageProps } from '@/types';
import { Camera, Loader2 } from 'lucide-react';

export default function Profile({ mustVerifyEmail, status }: { mustVerifyEmail: boolean; status?: string }) {
    const { auth } = usePage<InertiaPageProps>().props;

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm<{
        name: string;
        email: string;
        username: string | null;
        image: File | null;
    }>({
        name: auth?.name ?? '',
        email: auth?.email ?? '',
        username: auth?.username ?? '',
        image: null,
    });
    const [avatar, setAvatar] = useState<string | null>(null);
    const [uploading, setUploading] = useState(false);

    const handleAvatarChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        if (e.target.files && e.target.files[0]) {
            setUploading(true);
            const file = e.target.files[0];
            const reader = new FileReader();
            setData('image', file);
            reader.onload = (event) => {
                setAvatar(event.target?.result as string);
                setUploading(false);
            };

            reader.readAsDataURL(file);
        }
    };

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        console.log(data, 'data');
        post(route('settings.profile.update'), {
            preserveScroll: true,
        });
    };
    if (!auth) {
        router.visit(route('login'));
        return null;
    }

    return (
        <UserLayout title="Profile Settings">
            <SettingsLayout title="Profile information" description="Update your name and email address">
                <div className="space-y-6">
                    <form onSubmit={submit} className="space-y-6" encType="multipart/form-data">
                        <div className="mb-8 flex flex-col items-center">
                            <div className="relative mb-4">
                                {avatar ? (
                                    <img src={avatar} alt="avatar" className="size-36 rounded-full object-cover" />
                                ) : (
                                    <UserAvatar user={auth} imageOnly avatarClassname="size-36" />
                                )}
                                <div className="absolute right-0 bottom-0">
                                    <Label htmlFor="avatar-upload" className="cursor-pointer">
                                        <div className="bg-primary text-primary-foreground hover:bg-primary/90 rounded-full p-2 transition-colors">
                                            {uploading ? <Loader2 className="h-5 w-5 animate-spin" /> : <Camera className="h-5 w-5" />}
                                        </div>
                                    </Label>
                                    <Input
                                        id="avatar-upload"
                                        type="file"
                                        accept="image/*"
                                        className="hidden"
                                        onChange={handleAvatarChange}
                                        disabled={uploading}
                                    />
                                </div>
                            </div>
                            <p className="text-muted-foreground text-sm">Click the camera icon to upload a new profile picture</p>
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="name">Name</Label>

                            <Input
                                id="name"
                                className="mt-1 block w-full"
                                value={data.name}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                                autoComplete="name"
                                placeholder="Full name"
                            />

                            <InputError className="mt-2" message={errors.name} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="username">Username</Label>

                            <Input
                                id="username"
                                className="mt-1 block w-full"
                                value={data.username!}
                                onChange={(e) => setData('username', e.target.value)}
                                required
                                autoComplete="username"
                                placeholder="Username"
                            />

                            <InputError className="mt-2" message={errors.username} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="email">Email address</Label>

                            <Input
                                id="email"
                                type="email"
                                className="mt-1 block w-full"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                                autoComplete="username"
                                placeholder="Email address"
                            />

                            <InputError className="mt-2" message={errors.email} />
                        </div>

                        {mustVerifyEmail && auth.email_verified_at === null && (
                            <div>
                                <p className="text-muted-foreground -mt-4 text-sm">
                                    Your email address is unverified.{' '}
                                    <Link
                                        href={route('verification.send')}
                                        method="post"
                                        as="button"
                                        className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
                                    >
                                        Click here to resend the verification email.
                                    </Link>
                                </p>

                                {status === 'verification-link-sent' && (
                                    <div className="mt-2 text-sm font-medium text-green-600">
                                        A new verification link has been sent to your email address.
                                    </div>
                                )}
                            </div>
                        )}

                        <div className="flex items-center gap-4">
                            <Button disabled={processing}>Save</Button>

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
                    </form>
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

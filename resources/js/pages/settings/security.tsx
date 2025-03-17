import { AuthClient } from '@/clients/auth.client';
import { FacebookIcon } from '@/components/icons/facebook.icon';
import { GoogleIcon } from '@/components/icons/google.icon';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { UserActions } from '@/components/user/actions.user';
import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from '@/layouts/user-layout';
import { UserSocialAuth } from '@/types';
import { router } from '@inertiajs/react';
import { useMutation } from '@tanstack/react-query';
import { toast } from 'sonner';

type SecurityPageProps = {
    socialConnections: Record<string, UserSocialAuth>;
};

function SocialProviderIcon({ provider }: { provider: string }) {
    switch (provider) {
        case 'facebook':
            return <FacebookIcon className="h-4 w-4 text-blue-500" />;
        case 'google':
            return <GoogleIcon className="h-4 w-4 text-red-500" />;
        default:
            return <FacebookIcon className="h-4 w-4" />;
    }
}

export default function SecurityPage({ socialConnections }: SecurityPageProps) {
    const { mutate: disconnectProvider } = useMutation({
        mutationKey: ['disconnect-social'],
        mutationFn: async (provider: string) => {
            return AuthClient.disconnectProvider(provider);
        },
        onError: (error) => {
            toast.error(error.message);
        },
        onSuccess: () => {
            toast.success('Provider disconnected successfully');
            router.reload();
        },
    });

    return (
        <UserLayout title="Security">
            <SettingsLayout>
                <div className="space-y-6">
                    <Card>
                        <CardHeader>
                            <CardTitle>Social Login</CardTitle>
                            <CardDescription>Manage social media accounts used for login</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {Object.entries(socialConnections).map(([provider, connection]) => (
                                <div key={provider} className="flex items-center justify-between">
                                    <div className="flex items-center space-x-3">
                                        <div className="flex h-10 w-10 items-center justify-center rounded-full">
                                            <SocialProviderIcon provider={provider} />
                                        </div>
                                        <div>
                                            <p className="font-medium">{connection.provider_name}</p>
                                        </div>
                                    </div>
                                    <Button
                                        onClick={() => {
                                            connection.connected
                                                ? disconnectProvider(provider)
                                                : (window.location.href = route('social.redirect', { provider }));
                                        }}
                                        size="sm"
                                    >
                                        {connection.connected ? 'Disconnect' : 'Connect'}
                                    </Button>
                                </div>
                            ))}
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader>
                            <CardTitle>Account Actions</CardTitle>
                            <CardDescription>Manage your account actions such as deactivating or deleting your account</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <UserActions />
                        </CardContent>
                    </Card>
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

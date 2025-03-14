import { AuthClient } from '@/clients/auth.client';
import { FacebookIcon } from '@/components/icons/facebook.icon';
import { GoogleIcon } from '@/components/icons/google.icon';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { Switch } from '@/components/ui/switch';
import { UserActions } from '@/components/user/actions.user';
import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from '@/layouts/user-layout';
import { UserSocialAuth } from '@/types';
import { Link, router } from '@inertiajs/react';
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
                            <CardTitle>Account Security</CardTitle>
                            <CardDescription>Manage your password and authentication methods</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="font-medium">Change Password</p>
                                    <p className="text-muted-foreground text-sm">Last changed 3 months ago</p>
                                </div>
                                <Link href={route('password.edit')}>
                                    <Button variant="outline">Update</Button>
                                </Link>
                            </div>
                            <Separator />
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="font-medium">Two-Factor Authentication</p>
                                    <p className="text-muted-foreground text-sm">Add an extra layer of security to your account</p>
                                </div>
                                <Switch defaultChecked={true} />
                            </div>
                            <Separator />
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="font-medium">Login History</p>
                                    <p className="text-muted-foreground text-sm">View your recent login activity</p>
                                </div>
                                <Button variant="outline">View</Button>
                            </div>
                            <Separator />
                            <div className="flex items-center justify-between">
                                <div>
                                    <p className="font-medium">Connected Devices</p>
                                    <p className="text-muted-foreground text-sm">Manage devices that are logged into your account</p>
                                </div>
                                <Button variant="outline">Manage</Button>
                            </div>
                        </CardContent>
                    </Card>

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

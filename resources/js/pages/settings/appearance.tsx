import AppearanceTabs from '@/components/appearance-tabs';
import HeadingSmall from '@/components/heading-small';

import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from '@/layouts/user-layout';

export default function Appearance() {
    return (
        <UserLayout title="Appearance Settings">
            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                    <AppearanceTabs />
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

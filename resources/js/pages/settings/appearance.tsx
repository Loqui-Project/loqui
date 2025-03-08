import {Head, usePage} from '@inertiajs/react';

import AppearanceTabs from '@/components/appearance-tabs';
import HeadingSmall from '@/components/heading-small';
import {type SharedData} from '@/types';

import SettingsLayout from '@/layouts/settings/layout';
import UserLayout from "@/layouts/user-layout";



export default function Appearance() {
    const { auth } = usePage<SharedData>().props;

    return (
        <UserLayout user={auth.user}>
            <Head title="Appearance settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />
                    <AppearanceTabs />
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

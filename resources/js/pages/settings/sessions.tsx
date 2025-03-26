import { Button } from '@/components/ui/button';
import SettingsLayout from '@/layouts/settings/layout';

import UserLayout from '@/layouts/user-layout';
import { cn } from '@/lib/utils';
import { Session } from '@/types';
import { router } from '@inertiajs/react';
import { format } from 'date-fns';

type SessionPageProps = {
    sessions: Session[];
};

export default function SessionPage({ sessions }: SessionPageProps) {
    return (
        <UserLayout title="Sessions">
            <SettingsLayout title="Sessions" description="Manage your sessions">
                <div className="space-y-6">
                    {sessions.map((session, i) => (
                        <div
                            key={session.id}
                            className={cn('flex items-center justify-between py-4', i !== sessions.length - 1 ? 'border-b border-gray-200' : '')}
                        >
                            <div>
                                <div className="text-sm font-bold">{session.ip_address}</div>
                                <div>
                                    <span>
                                        {session.agent.browser} on <i>{session.agent.device}</i>
                                    </span>
                                </div>
                                <div className="text-sm">{format(session.last_activity * 1000, 'MMM dd, yyyy')}</div>
                            </div>
                            <div>
                                {session.is_current_device ? (
                                    <span className="text-sm font-light italic">Current Session</span>
                                ) : (
                                    <span className="text-sm font-medium">
                                        <Button
                                            size="sm"
                                            variant="outline"
                                            onClick={() => {
                                                router.delete(route('sessions.destroy', session.id));
                                            }}
                                        >
                                            Revoke
                                        </Button>
                                    </span>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            </SettingsLayout>
        </UserLayout>
    );
}

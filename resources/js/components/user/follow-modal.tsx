import { User } from '@/types';
import { QueryFunction, useQuery } from '@tanstack/react-query';
import { AxiosResponse } from 'axios';
import { Users } from 'lucide-react';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '../ui/dialog';
import { UserCard } from './user-card';
import { UserSkeleton } from './user-skeleton';

export function UserFollowModal({
    user,
    open,
    onClose,
    triggerComponent,
    queryKey,
    queryFn,
}: {
    user: User;
    open: boolean;
    onClose: () => void;
    triggerComponent: React.ReactNode;
    queryKey: string;
    queryFn: QueryFunction<AxiosResponse<User[]>>;
}) {
    const { data, isLoading, isFetched } = useQuery<AxiosResponse<User[]>>({
        queryKey: [queryKey, user.id],
        queryFn,
        enabled: open,
    });

    return (
        <Dialog
            open={open}
            onOpenChange={(open) => {
                if (!open) {
                    onClose();
                }
            }}
        >
            <DialogTrigger asChild>{triggerComponent}</DialogTrigger>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>People You Follow</DialogTitle>
                    <DialogDescription>View and manage the people you're following.</DialogDescription>
                </DialogHeader>
                <div>
                    <div className="overflow-y-auto pr-2" style={{ maxHeight: 'calc(80vh - 220px)' }}>
                        {isLoading && <UserSkeleton />}
                        {isFetched && data && data?.data.length > 0 ? (
                            <div className="space-y-3">{data.data?.map((user) => <UserCard key={user.id} user={user} />)}</div>
                        ) : (
                            <div className="py-8 text-center">
                                <Users className="text-muted-foreground mx-auto h-12 w-12" />
                                <h3 className="mt-4 text-lg font-medium">No users found</h3>
                            </div>
                        )}
                    </div>
                </div>
            </DialogContent>
        </Dialog>
    );
}

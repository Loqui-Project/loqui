import { Skeleton } from '../ui/skeleton';

export function UserSkeleton() {
    return (
        <div className="hover:bg-muted/50 flex items-start rounded-lg p-3 transition-colors">
            <div className="relative">
                <Skeleton className="h-12 w-12 rounded-full" />
            </div>
            <div className="ml-3 flex-1">
                <div className="flex items-start justify-between">
                    <div className="flex flex-col gap-y-2">
                        <p className="font-medium">
                            <Skeleton className="h-4 w-24 rounded-full" />
                        </p>
                        <p className="text-muted-foreground text-xs">
                            <Skeleton className="h-4 w-10 rounded-full" />
                        </p>
                    </div>
                    <div>
                        <Skeleton className="h-8 w-8" />
                    </div>
                </div>
            </div>
        </div>
    );
}

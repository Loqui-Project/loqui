import { cn } from '@/lib/utils';
import AppLogoIcon from './app-logo-icon';

type AppLogoProps = {
    flexDir?: 'row' | 'col';
    full?: boolean;
    className?: string;
};

export default function AppLogo({ flexDir, full, className }: AppLogoProps) {
    return (
        <div className={cn('flex items-center justify-start gap-4', flexDir === 'col' ? 'flex-col' : 'flex-row', full ? 'w-full' : '', className)}>
            <AppLogoIcon className="size-11 object-cover text-white dark:text-black" />
            <h1 className="mb-0.5 truncate text-xl leading-none font-semibold">Loqui</h1>
        </div>
    );
}

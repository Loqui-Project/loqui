import { HTMLAttributes } from 'react';

export default function AppLogoIcon(props: HTMLAttributes<HTMLImageElement>) {
    return <img src="/images/logo.svg" alt="Logo" {...props} />;
}

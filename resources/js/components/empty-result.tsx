type EmptyResultProps = {
    icon: React.ReactNode;
    title: string;
    description: string;
    actions?: React.ReactNode;
};
export function EmptyResult({ icon, title, description, actions }: EmptyResultProps) {
    return (
        <div className="mt-4 flex flex-col items-center justify-center gap-y-2">
            <div className="text-center">
                {icon}
                <h3 className="mt-4 text-lg font-medium">{title}</h3>
                <p className="text-muted-foreground mt-1 text-sm">{description}</p>
            </div>
            <div>{actions}</div>
        </div>
    );
}

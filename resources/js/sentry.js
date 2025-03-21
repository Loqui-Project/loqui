window.Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN,
    integrations: [
        window.Sentry.linkedErrorsIntegration({
            limit: 7,
        }),
    ],
});

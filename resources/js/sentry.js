window.Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN,
    integrations: [
        window.Sentry.linkedErrorsIntegration({
            limit: 7,
        }),
        window.Sentry.replayIntegration(),
    ],
    // Session Replay
    replaysSessionSampleRate: 0.1, // This sets the sample rate at 10%. You may want to change it to 100% while in development and then sample at a lower rate in production.
    replaysOnErrorSampleRate: 1.0, // If you're not already sampling the entire session, change the sample rate to 100% when sampling sessions where errors occur.
});

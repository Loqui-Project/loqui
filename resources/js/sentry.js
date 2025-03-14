Sentry.init({
    dsn: process.env.SENTRY_LARAVEL_DSN,
    integrations: [
      Sentry.linkedErrorsIntegration({
        limit: 7,
      }),
    ],
  });

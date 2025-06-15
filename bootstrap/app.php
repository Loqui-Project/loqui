<?php

declare(strict_types=1);

use App\Services\ResponseFormatter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))->withRouting(web: __DIR__.'/../routes/web.php', api: __DIR__.'/../routes/api.php', commands: __DIR__.'/../routes/console.php', channels: __DIR__.'/../routes/channels.php', health: '/up')->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(['*']);
})->withEvents(discover: [__DIR__.'/../app/Listeners'])->withExceptions(function (Exceptions $exceptions): void {
    Integration::handles($exceptions);
    $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
        if (in_array($response->getStatusCode(), [500, 503, 404, 403])) {
            return app(ResponseFormatter::class)->responseError('An error occurred, please try again later.', $response->getStatusCode());
        }
        if ($response->getStatusCode() === 419) {
            return app(ResponseFormatter::class)->responseError('The page expired, please try again.', 419);
        }

        return $response;
    });
})->create();

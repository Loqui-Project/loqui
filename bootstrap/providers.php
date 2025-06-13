<?php

declare(strict_types=1);

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\PulseServiceProvider::class,
    App\Providers\TelescopeServiceProvider::class,
    Torann\GeoIP\GeoIPServiceProvider::class,
    Jenssegers\Agent\AgentServiceProvider::class,
];

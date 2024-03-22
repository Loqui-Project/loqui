<?php

use App\Providers\RepositoryServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
    RepositoryServiceProvider::class,
];

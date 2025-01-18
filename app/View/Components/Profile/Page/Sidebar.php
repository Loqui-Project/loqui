<?php

namespace App\View\Components\Profile\Page;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Sidebar extends Component
{

    public $menuLinks;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $routeCollection = Route::getRoutes();
        $routes = $routeCollection->getRoutesByName();
        $this->menuLinks = collect($routes)->filter(function ($route) {
            return Str::startsWith($route->getName(), 'profile.settings');
        })->map(function ($route) {
            return [
                'name' => __($route->getName()),
                'url' => route($route->getName()),
                'active' => Route::currentRouteName() === $route->getName(),
            ];
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.page.sidebar');
    }
}

<?php

namespace Jezzdk\Laravel;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class LaravelRouteGuardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This looks for an option on the route call 'guard', which we can use to set different guards on different routes.
        // This is specifically useful for tenant routes, where the guard is different.
        $this->app['router']->matched(function (RouteMatched $event) {
            $route = $event->route;

            if (!Arr::has($route->getAction(), 'guard')) {
                return;
            }

            $routeGuard = Arr::last(Arr::wrap(Arr::get($route->getAction(), 'guard')));

            $this->app['auth']->resolveUsersUsing(function ($guard = null) use ($routeGuard) {
                return $this->app['auth']->guard($routeGuard)->user();
            });

            $this->app['auth']->setDefaultDriver($routeGuard);
        });
    }
}

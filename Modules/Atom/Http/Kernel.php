<?php namespace Modules\Atom\Http ; class Kernel extends \Illuminate\Foundation\Http\Kernel {
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ] ;

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ] ,

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ] ,
    ] ;

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders      :: class ,
        'signed'        => \Illuminate\Routing\Middleware\ValidateSignature :: class ,
        'throttle'      => \Illuminate\Routing\Middleware\ThrottleRequests  :: class ,
    ] ;
}
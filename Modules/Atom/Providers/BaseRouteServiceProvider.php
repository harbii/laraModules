<?php namespace Modules\Atom\Providers;

use Nwidart\Modules\Module;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

Abstract class BaseRouteServiceProvider extends ServiceProvider {

    public function boot( ) : void {
        RateLimiter::for( 'api' , fn ( Request $request ) => Limit::perMinute( 60 ) -> by( $request -> user( ) ?-> id ?: $request -> ip ( ) ) );
        $this -> routes( fn ( ) => [
            Route::middleware ( 'web'  )
                -> name       ( 'Web.' . $this -> getModuleName( ) . '.' )
                -> namespace  ( $this -> getNameSpace( ) )
                -> group      ( $this -> getPath( 'web' ) )
            ,
            Route::middleware ( 'api'  )
                -> prefix     ( 'Api/' . $this -> getModuleName( ) )
                -> name       ( 'Api.' . $this -> getModuleName( ) . '.' )
                -> namespace ( $this -> getNameSpace ( ) )
                -> group     ( $this -> getPath      ( ) )
        ] ) ;
    }

    public function getModuleName( ) : string {
        return Str::of( Str::afterLast( static::class , 'Modules' )  ) -> match('/\w+/') -> toString( ) ;
        return Module::byClassName( static::class ) ;
    }

    public function getNameSpace( ) : string {
        return 'Modules\\' . $this -> getModuleName( ) . '\\Http\\Controllers' ;
    }

    public function getPath( string $path = 'api' ) : string {
        return module_path( $this -> getModuleName( ) , 'Routes/' . $path . '.php' ) ;
    }

}

<?php namespace Modules\Atom\Http\Middleware; class Localization {
    public function handle( \Illuminate\Http\Request $request , \Closure $next ) {
        \Illuminate\Support\Facades\App::setLocale( $request -> header( 'localization' , 'en' ) );
        return $next( $request );
    }
}
<?php namespace Modules\Atom\Http\Middleware; class ForceJsonResponse {
    public function handle( \Illuminate\Http\Request $request , \Closure $next ) {
        $request -> headers -> set( 'Accept' , 'application/json' ) ;
        return $next( $request ) ;
    }
}
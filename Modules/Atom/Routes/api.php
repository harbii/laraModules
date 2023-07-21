<?php

use Illuminate\Support\Facades\Route;

Route::name( 'v1.') -> prefix( 'v1' ) -> group( fn ( ) => [
    Route::get( 'Route' , fn ( ) => response( ) -> json(
        collect( Route::getRoutes( ) -> get( ) ) -> transform( fn( $Route ) => [
            'uri'        => $Route -> uri              ( ) ,
            'name'       => $Route -> getName          ( ) ,
            'methods'    => $Route -> methods          ( ) ,
            'middleware' => $Route -> gatherMiddleware ( ) ,
        ] )
    ) ) ,
]);
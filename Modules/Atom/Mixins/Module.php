<?php namespace Modules\Atom\Mixins;

use Illuminate\Support\{Str,Collection};
use Nwidart\Modules\Module as Base ;
use Illuminate\Support\Facades\Config;

class Module {

    public function byClassName( ) {
        return function( string $className ) : string {
            return Str::of( Str::afterLast( $className , 'Modules' )  ) -> match('/\w+/') -> toString( ) ;
        } ;
    }

    public function byFilePath( ) {
        return function( string $FilePath ) : string {
            return Str::of( Str::replace( Config::get( 'modules.paths.modules' ) , '' , $FilePath ) ) -> match('/\w+/') -> toString( ) ;
        } ;
    }

    public function config( ) {
        return function( string $by = '' ) : Collection {
            return Collection::wrap( Config::get( strtolower( match( true ) {
                class_exists ( $by ) => Base::byClassName ( $by ) ,
                is_file      ( $by ) => Base::byFilePath  ( $by ) ,
                default              => Base::byFilePath( debug_backtrace( ) [ 1 ][ 'file' ] ) ,
            } ) ) ) ;
        } ;
    }

}
<?php namespace Modules\Atom\Mixins;

use Illuminate\Support\{Str,Facades\DB};

class Blueprint {

    public function foreignFor( ) {
        return function( string $className , bool $nullable = true ) : void {
            $table = with( new $className ) ;
            $tableName = $table -> getTable( ) ;
            $foreignName = implode( '_' , array_map( fn( $word ) => Str::substr( $word , 0 , 2 ) , explode( '_' , $this -> table . '_' . $tableName . '_' . $table -> getForeignKey( ) ) ) ) . '_foreign' ;
            $unsignedBigInteger = $this -> unsignedBigInteger( $table -> getForeignKey( ) ) ;
            if ( $nullable ) $unsignedBigInteger -> nullable ( ) ;
            $this
                -> foreign           ( $table -> getForeignKey( ) , $foreignName )
                -> on                ( DB::raw( $tableName ) )
                -> references        ( 'id' )
                -> cascadeOnUpdate   ( )
                -> cascadeOnDelete   ( )
            ;
        } ;
    }

}
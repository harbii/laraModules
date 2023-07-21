<?php namespace Modules\Atom\Mixins;

use Illuminate\Support\{Str,Arr};
use Illuminate\Database\Eloquent\Builder as base;

class Builder {
    
    public function orWhereByString( ) {
        return function( array | string $attributes , string $searchTerm ) : base {
            /** @var base $this */
            return $this -> orWhere( function( $query ) use ( $attributes , $searchTerm ) {
                foreach( Arr::wrap( $attributes ) as $attribute ) $query -> orWhere( $attribute , 'REGEXP' , $searchTerm );
            } )  ;
        } ;
    }

    public function whereByString( ) {
        return function( array | string $attributes , string $searchTerm ) : base {
            /** @var base $this */
            return $this -> Where( function( $query ) use ( $attributes , $searchTerm ) {
                foreach( Arr::wrap( $attributes ) as $attribute ) $query -> orWhere( $attribute , 'REGEXP' , $searchTerm );
            } )  ;
        } ;
    }

    public function whereInStrs( ) {
        return function( array | string $attributes , array | string $searchTerm = [ ] ) : base {
            /** @var base $this */
            return $this -> whereByString  ( $attributes , is_array( $searchTerm ) ? implode( '|' , $searchTerm ) : $searchTerm ) ;
        } ;
    }

    public function orWhereInStrs( ) {
        return function( array | string $attributes , array | string $searchTerm = [ ] ) : base {
            /** @var base $this */
            return $this -> orWhereByString  ( $attributes , is_array( $searchTerm ) ? implode( '|' , $searchTerm ) : $searchTerm ) ;
        } ;
    }

}
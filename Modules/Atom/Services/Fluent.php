<?php namespace Modules\Atom\Services; class Fluent extends \Illuminate\Support\Fluent {

    public function __construct( array|object $Array = [ ] ) {
        parent::__construct( $Array ) ;
        foreach ( $Array as $key => $value ) $this -> $key = $value ;
        foreach ( ( new \ReflectionClass( static::class ) ) -> getProperties( ) as $Propertie ) if ( $Propertie -> name !== 'attributes' ) $this -> KeyNotExists( $Propertie -> name , $Propertie -> getType( ) ?-> getName( ) ) ;
        foreach ( $this -> Rules( ) as $key => $type ) $this -> KeyNotExists( $key , $type );
    }

    public function throwNewInvalidArgumentException( mixed $key , string $type ) : void {
        throw new \InvalidArgumentException( $key . ' must be exists , not empty and ' . $type );
    }

    public function Rules( ) : array {
        return [ ] ;
    }

    public function KeyNotExists( string $key , string $type ) : void {
        if ( ! $this -> offsetExists( $key )                                                                                    ) $this -> throwNewInvalidArgumentException( $key , $type ) ;
        if ( function_exists( 'is_' . strtolower( $type ) ) and ! ( 'is_' . strtolower( $type ) )( $this -> offsetGet( $key ) ) ) $this -> throwNewInvalidArgumentException( $key , $type ) ;
        else if ( is_subclass_of( $this -> offsetGet( $key ) , $type )                                                          ) $this -> throwNewInvalidArgumentException( $key , $type ) ;
        if ( ! function_exists( 'is_' . strtolower( $type ) ) and is_subclass_of( $this -> offsetGet( $key ) , $type )          ) $this -> throwNewInvalidArgumentException( $key , $type ) ;
    }

}
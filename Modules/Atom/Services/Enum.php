<?php namespace Modules\Atom\Services; Trait Enum {

    public function toArray( ) : Array {
        return [ $this -> name => $this -> value ] ;
    }

    static public function All( ) : Array {
        return array_merge_recursive( ... array_map( fn( $item ) => [ $item -> name => $item -> value ] , Self::cases ( ) ) ) ;
    }

    public static function is( String $String ) : Bool {
        return ! is_null( Self::tryby( $String ) ) or ! is_null( Self::tryFrom( $String ) ) ;
    }

    public static function by( String $Name ) : Self {
        foreach ( self::cases( ) as $Status ) if ( $Name === $Status -> name ) return $Status ;
        throw new \ValueError( $Name . ' is not a valid backing value for enum ' . self::class );
    }

    public static function tryby( String $Name ) :? Self {
        try { return Self::by( $Name ); } catch ( \ValueError $Error ) { return null ; }
    }

}
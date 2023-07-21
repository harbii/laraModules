<?php namespace Modules\Atom\Tests; trait initializedSupports {

    public static $initializedSupports = false;

    public function setUp( ) : void {
        parent::setUp( );
        if ( ! self::$initializedSupports ) {
            static :: bootTraits       ( ) ;
            $this  -> initializeTraits ( ) ;
            self::$initializedSupports = true;
        }
    }

    /**
     * The Array of trait initializers that will be called on each new instance.
     *
     * @var Array
     */
    protected static $traitInitializers = [ ];

    /**
     * Boot all of the bootable traits .
     *
     * @return void
     */
    public static function bootTraits( ) : void {
        $class = static::class;
        $booted = [ ];
        static::$traitInitializers[ $class ] = [ ];
        foreach ( class_uses_recursive( $class ) as $trait ) {
            $method = 'boot' . class_basename( $trait );
            if ( method_exists( $class , $method ) && ! in_array( $method , $booted ) ) {
                forward_static_call( [ $class , $method ] );
                $booted[ ] = $method;
            }
            if ( method_exists( $class , $method = 'initialize' . class_basename( $trait ) ) ) {
                static::$traitInitializers[ $class ][ ] = $method;
                static::$traitInitializers[ $class ] = array_unique( static::$traitInitializers[ $class ] );
            }
        }
    }

    /**
     * Initialize any initializable traits .
     *
     * @return void
     */
    public function initializeTraits( ) : void {
        foreach ( static::$traitInitializers[ static::class ] as $method ) $this -> { $method } ( ) ;
    }

}
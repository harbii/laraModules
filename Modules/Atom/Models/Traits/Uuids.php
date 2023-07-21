<?php namespace Modules\Atom\Models\Traits; trait Uuids {

    /**
     * Boot function from Laravel.
     */
    protected static function bootUuids( ) : void {
        static::creating( fn ( $model ) => ( empty( $model -> { $model -> getKeyName( ) } ) ) ? $model -> { $model -> getKeyName( ) } = \Illuminate\Support\Str::uuid( ) -> toString( ) : null );
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     */
    public function getIncrementing( ) : bool {
        return false ;
    }

    /**
     * Get the auto-incrementing key type.
     */
    public function getKeyType( ) : string {
        return 'string' ;
    }

}
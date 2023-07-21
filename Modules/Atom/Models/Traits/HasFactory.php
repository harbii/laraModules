<?php namespace Modules\Atom\Models\Traits;

use Nwidart\Modules\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory as base ;

trait HasFactory {

    use base ;

    protected static function newFactory( ) {
        return ( 'Modules\\' . Module::byClassName( static::class ) . '\\Database\\Factories\\' . class_basename( static::class ) )::new( ) ;
    }

    protected static function forFactory( ) : self {
        return static::inRandomOrder( ) -> first( ) ?? static::factory( ) -> create( ) ;
    }

}
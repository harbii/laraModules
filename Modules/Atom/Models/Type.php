<?php namespace Modules\Atom\Models;

use Illuminate\Database\Eloquent\Builder;

Abstract class Type extends Model {

    public $fillable = [
        'key'          ,
        'sort'         ,
        'is_const'     ,
        'is_available' ,
        'is_active'    ,
        'created_at'   ,
        'updated_at'   ,
        'deleted_at'   ,
    ] ;

    public function scopePublic( Builder $Builder ) : Builder {
        return $Builder
            -> where( 'is_available' , 1 )
            -> where( 'is_active'    , 1 )
        ;
    }

    public function scopeByKey( Builder $Builder , string $key ) : self {
        return $Builder -> firstOrCreate( [ 'key' => $key ] ) ;
    }

    public function scopeGetIdByKey( Builder $Builder , string $key ) : int {
        return $Builder -> ByKey( $key ) -> id ;
    }

}
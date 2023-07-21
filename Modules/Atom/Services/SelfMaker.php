<?php namespace Modules\Atom\Services; trait SelfMaker {
    static function instance( ) : static {
        return \Illuminate\Support\Facades\App::make( static::class ) ;
    }
}
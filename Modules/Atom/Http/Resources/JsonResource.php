<?php namespace Modules\Atom\Http\Resources;

use Illuminate\Support\{Str,Carbon};

use Illuminate\Http\Resources\Json\JsonResource        as Resources    ;

use Modules\Media\Models\Media as Model  ;

Abstract class JsonResource extends Resources{
    use Resource ;

    public function id( $request ) { return[
        'id' => $this -> id ,
    ] ; }

    public function AvailableAndActive( $request ) { return[
        'is_available' => ( bool ) $this -> is_available ,
        'is_active'    => ( bool ) $this -> is_active    ,
    ] ; }

    public function timestamps( $request ) { return[
        'created_at' => $this -> date( $this -> created_at ) ,
        'updated_at' => $this -> date( $this -> updated_at ) ,
    ] ; }

    public function dates( $request ) { return[
        ... $this -> timestamps ( $request ) ,
        'deleted_at' => $this -> date( $this -> deleted_at  ) ,
    ] ; }

    public function date( Carbon|null $attr ) :? string {
        return $attr ?-> __toString( );
    }

    public function base( $request ) { return[
        ... $this -> id                         ( $request ) ,
        ... $this -> DatesAndAvailableAndActive ( $request ) ,
    ] ; }

    public function DatesAndAvailableAndActive( $request ) { return[
        ... $this -> dates              ( $request ) ,
        ... $this -> AvailableAndActive ( $request ) ,
    ] ; }

    public function class_type( ) {
        return Str::singular( class_basename( $this -> resource ) );
    }

}
<?php namespace Modules\Atom\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Container\Container;

class ModelNotFoundException extends \Illuminate\Database\Eloquent\ModelNotFoundException {

    /**
     * Render the exception into an HTTP response.
     */
    public function render( $request ) {
        if( Container::getInstance( ) -> has ( $this  -> model . 'NotFoundException' ) ) return Container::getInstance( ) -> make ( $this  -> model . 'NotFoundException' , [
            'message' => $this  -> getMessage( ) ,
            'request' => $request ,
            'model'   => $this  -> model ,
            'ids'     => $this  -> ids ,
        ] ) ;
        else return new JsonResponse ( [
            'message' => $this  -> getMessage( ) ,
            'errors'  => [ 'ids' => $this -> ids ] ,
            'check'   => false ,
        ] , 404 ) ;
    }
}
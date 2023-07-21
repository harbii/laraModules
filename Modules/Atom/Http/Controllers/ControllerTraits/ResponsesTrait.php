<?php namespace Modules\Atom\Http\Controllers\ControllerTraits;

use Illuminate\Support\MessageBag ;
use Illuminate\Http\JsonResponse ;
use Illuminate\Http\Resources\Json\JsonResource;

trait ResponsesTrait {

    /**
     * Make Response In All Controllers
     * @param string                                        $message = 'Successful.'
     * @param bool                                          $check   = true
     * @param int                                           $code    = JsonResponse::HTTP_OK
     * @param JsonResource|Array|String|Int|Bool            $data    = [ ]
     * @param MessageBag|JsonResource|Array|String|Int|Bool $errors  = [ ]
     * @param JsonResource|Array|String|Int|Bool            $Array   = [ ]
     * @return JsonResponse
     */
    public function MakeResponse( string $message = 'Successful.' , bool $check = true , int $code = JsonResponse::HTTP_OK , JsonResource|Array|String|Int|Bool $data = [ ] , MessageBag|JsonResource|Array|String|Int|Bool $errors = [ ] , JsonResource|Array|String|Int|Bool $Array = [ ] ) : JsonResponse {
        if( ! empty( $data   ) ) $Array [ 'data'   ] = $data   ;
        if( ! empty( $errors ) ) $Array [ 'errors' ] = $errors ;
        return new JsonResponse( [
            'message' => $message ,
            'check'   => $check   ,
        ] + $Array , $code );
    }

    /**
     * Make Successful Response
     *
     * @param JsonResource|Array|String|Int|Bool $data    = [ ]
     * @param string                             $message = 'Successful.'
     * @param int                                $code    = JsonResponse::HTTP_OK
     *
     * @return JsonResponse
     */
    public function MakeResponseSuccessful( JsonResource|Array|String|Int|Bool $data = [ ] , string $message = 'Successful.'        , int $code = JsonResponse::HTTP_OK                   ) : JsonResponse {
        return $this -> MakeResponse( message : $message , check : true , code : $code , data : $data );
    }

    /**
     * Make Errors Response
     * @param MessageBag|JsonResource|Array|String|Int|Bool $Errors  = [ ]
     * @param string                                        $message = 'Errors.'
     * @param int                                           $code    = JsonResponse::HTTP_UNPROCESSABLE_ENTITY
     * @return JsonResponse
     */
    public function MakeResponseErrors    ( MessageBag|JsonResource|Array|String|Int|Bool $Errors = [ ] , string $Error = 'Errors.' , int $code = JsonResponse::HTTP_UNPROCESSABLE_ENTITY ) : JsonResponse {
        return $this -> MakeResponse( $Error , check : False , code : $code , errors : $Errors );
    }

}
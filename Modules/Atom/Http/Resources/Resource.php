<?php namespace Modules\Atom\Http\Resources;

use Illuminate\Http\JsonResponse ;

trait Resource{

    public function __construct( $resource ,
        public string $message = 'Successful.' ,
        public bool   $check   = true          ,
        public int    $code    = JsonResponse::HTTP_OK
    ) {
        parent::__construct( $resource );
        $this -> message = $message ;
        $this -> check   = $check   ;
        $this -> code    = $code    ;
    }

    public function with( $request ) : array { return [
        'message' => $this -> message ,
        'check'   => $this -> check   ,
    ] ; }

}
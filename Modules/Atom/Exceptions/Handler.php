<?php namespace Modules\Atom\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException as NotFoundException;

class Handler extends ExceptionHandler {
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected function prepareException( Throwable $exception ) {
        return match ( true ) {
            $exception instanceof NotFoundException => $this -> NotFoundException( $exception ) ,
            default => parent::prepareException( $exception ),
        } ;
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register( ) : void {
        $this -> reportable( function ( Throwable $e ) { } );
        $this -> renderable( fn ( ModelNotFoundException $exception , $request ) => $exception -> render( $request ) );
    }

    public function NotFoundException( NotFoundException $exception ) {
        return ( new ModelNotFoundException( $exception -> getMessage( ) ) ) -> setModel( $exception -> getModel( ) , $exception -> getIds( ) ) ;
    }

    protected function unauthenticated( $request , AuthenticationException $exception) {
        return new JsonResponse( [
            'message' => $exception -> getMessage( ) ,
            'errors'  => [ 'Authentication' => [ $exception -> getMessage( ) ] ],
            'check'   => false ,
        ] , 401 ) ;
    }

}
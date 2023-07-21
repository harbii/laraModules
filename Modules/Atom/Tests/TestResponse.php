<?php namespace Modules\Atom\Tests;

use Illuminate\Http\Response ;

class TestResponse extends \Illuminate\Testing\TestResponse {

    public function AssertOkSuccessful( string $mutation , string $Message = 'Successful.' , bool $Check = true , int $StatusResponse = Response::HTTP_OK ) : TestResponse {
        return $this
            -> AssertJson  ( [ 'data' => [ $mutation => [ 'status' => [
                'message' => $Message ,
                'check'   => $Check ,
                'code'    => $StatusResponse
            ] ] ] ] )
        ;
    }

    public function AssertOkData( string $mutation , array $data = [ ] , ...$Arguments ) : TestResponse {
        return $this
            -> AssertOkSuccessful( $mutation , ...$Arguments )
            -> AssertJson        ( [ 'data' => [ $mutation => $data ] ] )
        ;
    }

    public function FromFirstErrorsResponse( Array $Errors = [ ] ) : TestResponse {
        return $this -> AssertJson ( [ 'errors' => [ $Errors ] ] ) ;
    }

    public function AssertErrors( string $path , string $debugMessage = 'Internal server error' , Array $Errors = [ ] , string $message = 'Internal server error' , int $code = Response::HTTP_UNPROCESSABLE_ENTITY , bool $isClientSafe = false ) : TestResponse {
        return $this
            -> AssertErrorMmessage     ( $message )
            -> FromFirstErrorsResponse ( [ 'path'         => [ $path           ] ] )
            -> AssertExtensions        ( [ 'debugMessage' =>   $debugMessage     ] )
            -> AssertExtensions        ( [ 'code'         =>   $code             ] )
            -> AssertExtensions        ( [ 'errors'       =>   $Errors           ] )
            -> AssertExtensions        ( [ 'isClientSafe' =>   $isClientSafe     ] ) 
        ;
    }

    public function AssertErrorMmessage( string $message = 'Internal server error' ) : TestResponse {
        return $this -> FromFirstErrorsResponse ( [ 'message' => $message ] ) ;
    }

    public function AssertExtensions( Array $Errors ) : TestResponse {
        return $this -> FromFirstErrorsResponse ( [ 'extensions' => $Errors ] ) ;
    }

    public function AssertValidation( string $path , Array $Validation ) : TestResponse {
        return $this
            -> FromFirstErrorsResponse ( [ 'path'       => [ $path ]                                  ] )
            -> FromFirstErrorsResponse ( [ 'message'    => "Validation failed for the field [$path]." ] )
            -> AssertExtensions        ( [ 'validation' => $Validation                                ] )
        ;
    }

    public function AssertResponseUnAuthorized( ) : TestResponse {
        return $this -> AssertExtensions ( [ 'debugMessage' => 'Unauthenticated.' ] ) ;
    }

    public function AssertJsonStructureToken( string $path ) : TestResponse {
        return $this -> AssertJsonStructure ( [ 'data' => [ $path => [ 'token' => [
            'token_type'    ,
            'expires_in'    ,
            'refresh_token' ,
            'access_token'  ,
        ] ] ] ] ) ;
    }

    public function AssertFileuploudExists( string $path , string $type = 'public' ) : TestResponse {
        \Illuminate\Support\Facades\Storage::disk( $type ) -> assertExists( $path ) ;
        return $this ;
    }

}
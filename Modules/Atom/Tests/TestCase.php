<?php namespace Modules\Atom\Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Testing\LoggedExceptionCollection;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{DB};

use Illuminate\Http\UploadedFile;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication;
    use initializedSupports;
    use \Illuminate\Foundation\Testing\WithFaker;

    public function route( string $Route_Name , Array | int $Route_Parameters = [ ] ) : string {
        return \Illuminate\Support\Facades\URL::route( 'Api.' . $Route_Name , $Route_Parameters ) ;
    }

    public function actingAs( Authenticatable $Authentication , $guard = '' ) : self {
        $provider = class_basename( get_class( $Authentication ) ) ;
        // \Laravel\Passport\Passport::actingAs( $Authentication , [ $provider ] , $provider );
        return $this ;
    }

    protected function createTestResponse( $response ) {
        return tap( TestResponse::fromBaseResponse( $response ) , function ( $response ) {
            $response -> withExceptions(
                $this -> app -> bound( LoggedExceptionCollection::class ) ? $this -> app -> make( LoggedExceptionCollection::class ) : new LoggedExceptionCollection
            ) ;
        } ) ;
    }

    public static function WithOutForeignKey( ? \Closure $Closure ) : void {
        \Illuminate\Support\Facades\Schema::withoutForeignKeyConstraints( $Closure ) ;
    }

    public static function QueryLog( ? \Closure $Closure ) : void {
        DB::enableQueryLog( );
        if( is_callable( $Closure ) ) $Closure( ) ;
        dd(
            DB::getQueryLog( )
        );
    }

    public function makeFile( ) : UploadedFile {
        return UploadedFile::fake( ) -> image( 'test.png' , 100 , 100 ) -> size( 100 ) ;
    }

    public function AssertFileuploudExists( string $path , string $type = 'public' ) : self {
        \Illuminate\Support\Facades\Storage::disk( $type ) -> assertExists( $path ) ;
        return $this ;
    }

}
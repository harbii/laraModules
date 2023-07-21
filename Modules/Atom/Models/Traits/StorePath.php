<?php namespace Modules\Atom\Models\Traits;

use Illuminate\Support\{Str,Arr};
use Illuminate\Http\UploadedFile;

trait StorePath {

    public $StorgePath = '' ;

    public function StorgePathPartes( ... $args ) : String {
        return Arr::join( Arr::whereNotNull( [ $this -> StorgePath , $this -> id , ... $args ] ) , '/' ) ;
    }

    public function generatePathToTest( String $type , UploadedFile $fileName ) : String {
        return $this -> StorgePathPartes( Str::plural( $type ) , $fileName -> hashName( ) ) ;
    }

    public function generateUrlToTest( String $type , UploadedFile $fileName ) : String {
        return url( 'public/' . $this -> generatePathToTest( $type , $fileName ) ) ;
    }

    public function generatePathToSave( String $type ) : String {
        return 'public/' . $this -> StorgePathPartes( Str::plural( $type ) ) ;
    }

    public function generatePathToShow( ? String $path ) : String {
        return url( $path ?? '/' ) ;
    }

    public function ConvertFileToString( string $attrbute , UploadedFile|string|null $file ) : self {
        $this -> $attrbute = match ( true ) {
            is_null   ( $file ) => $file ,
            is_string ( $file ) => $file ,
            is_a      ( $file , UploadedFile::class ) => $file -> store( $this -> generatePathToSave( $attrbute ) )
        } ;
        return $this ;
    }

    public function updateImageToAttribute( string $attrbute , UploadedFile|string|null $value ) {
        if ( $this -> exists ) static::saving ( fn( self $self ) => $self -> ConvertFileToString( $attrbute , $value ) ) ;
        else static::created ( function( self $self ) use( $attrbute , $value ) {
            $self -> ConvertFileToString( $attrbute , $value ) ;
            $self -> save( ) ;
        } ) ;
        return $value ;
    }

}
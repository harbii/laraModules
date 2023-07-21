<?php namespace Modules\Atom\Database\Factories;

use Illuminate\Http\UploadedFile;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory {

    public function makeFile( ) : UploadedFile {
        return UploadedFile::fake( ) -> image( 'test.png' , 100 , 100 ) -> size( 100 ) ;
    }

    public function nameTranslated( ) : Array {
        return [ \Illuminate\Support\Facades\App::getLocale( ) => $this -> faker -> unique( ) -> name ( ) ];
    }

}
<?php namespace Modules\Atom\Database;

use Illuminate\Support\{
    Str,
    Facades\Schema ,
};
use Illuminate\Database\{
    Schema\Blueprint,
    Schema\Builder,
    Migrations\Migration as base
};

Abstract Class Migration extends base {

    public String  $method    ;
    public String  $modelName ;
    public Builder $schema    ;

    function setup( Blueprint $table ) : void { }

    public function getConnection( ) : string | null {
        return env( 'DB_CONNECTION' , 'mysql' ) ;
    }

    public function __construct( ) {
        $FileName = pathinfo( ( new \ReflectionClass( $this ) ) -> getFileName( ) ) ;
        $parts = Str::of( Str::remove( '_table' , $FileName[ 'filename' ] ) ) -> explode( '_' ) -> slice( 4 ) -> values( ) ;
        $this -> method    = $parts -> shift( );
        $this -> modelName = Str::plural( $parts -> implode( '_' ) ) ;
        $this -> schema    = Schema::connection( $this -> getConnection( ) );
    }

    Public function up( ) {
        $this -> schema -> { $this -> method }( $this -> modelName , function ( Blueprint $table ) {
            $table -> id          (        ) ;
            $this -> setup        ( $table ) ;
            $table -> boolean     ( 'is_available' ) -> default ( True ) ;
            $table -> boolean     ( 'is_active'    ) -> default ( True ) ;
            $table -> softDeletes ( ) ;
            $table -> timestamps  ( ) ;
        });
    }
    public function down( ) : void {
        $this -> schema -> dropIfExists( $this -> modelName );
    }
}
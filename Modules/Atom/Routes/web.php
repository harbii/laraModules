<?php use Illuminate\Support\Facades\{Route,DB};
Route:: view ( '/' , 'welcome' );
Route:: get  ( '/' , fn ( ) => response( ) -> json( [
    'Mysql_Version   ' => collect( DB::select( 'SELECT VERSION ( ) as mysql_version' ) ) -> first( ) -> mysql_version ,
    'Database_Name   ' => DB::connection( ) -> getDatabaseName ( ) ,
    'Zend_Version    ' => zend_version                         ( ) ,
    'php_uname       ' => php_uname                            ( ) ,
    'Php_Version     ' => phpversion                           ( ) ,
    'Laravel_Version ' => app( ) -> version                    ( ) ,
    'Php_Extensions  ' => get_loaded_extensions                ( ) ,
] ) );
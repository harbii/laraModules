<?php namespace Modules\Atom\Database\Seeders; abstract class type extends \Illuminate\Database\Seeder{
    public string $typeModel ;
    public array  $types     ;
    public function run( ) {
        collect( $this -> types ) -> map( fn( array $Status , int $id ) => $this -> typeModel::updateOrCreate( [ 'id' => $id + 1 ] , $Status ) ) ;
    }
}
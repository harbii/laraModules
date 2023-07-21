<?php namespace Modules\Atom\Database\Seeders;

use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run( ) : void {
        Module::toCollection (            )
            -> sortBy        ( 'priority' )
            // -> reverse       (            )
            -> keys          (            )
            -> filter        ( fn( string $Module_Name ) => 'Atom' !== $Module_Name )
            -> map           ( fn( string $Module_Name ) => 'Modules\\' . $Module_Name . '\\Database\\Seeders\\' . $Module_Name . 'DatabaseSeeder' )
            -> filter        ( fn( string $Seeder      ) => class_exists( $Seeder ) )
            -> map           ( fn( string $Seeder      ) => $this -> call( $Seeder ) )
        ;
    }
}
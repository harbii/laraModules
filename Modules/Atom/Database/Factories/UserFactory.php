<?php namespace Modules\Atom\Database\Factories; class UserFactory extends Factory {
    public function definition( ) : array { return [
        'email'        => $this -> faker -> unique( ) -> safeEmail( ) ,
        'active'       => 1 ,
        'password'     => '$2y$04$HHcKsdqZWS6rPEwjNjAvPuiTjm7euqWhBJ2pB98Y0QaRVd4.OMgx6', // password1A
        // 'name'         => $this -> nameTranslated( ) ,
    ] ; }
}
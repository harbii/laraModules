<?php namespace Modules\Atom\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;

Abstract class BaseUser extends \Modules\Atom\Models\Model {

    use
        \Modules\Atom\Models\Traits\HasFactory ,
        \Illuminate\Notifications\Notifiable
    ;

    public $fillable = [
        'email'    ,
        'password' ,
        'active'   ,
    ] ;

    protected $casts = [
        'active' => 'boolean' ,
    ];

    protected $hidden = [ 'password' ];

    public string $AuthenticationModel ;

    public function getAuthenticationModel( ) {
        return $this -> AuthenticationModel::find( $this -> id ) ;
    }

    public function password( ) : Attribute {
        return new Attribute(
            set : function( String $password ) {
                static::saving( function( self $self ) use( $password ) {
                    $self -> attributes [ 'password' ] = ( $password !== '$2y$04$HHcKsdqZWS6rPEwjNjAvPuiTjm7euqWhBJ2pB98Y0QaRVd4.OMgx6' ) ? \Illuminate\Support\Facades\Hash::make ( $password ) : $password ;
                } ) ;
            } ,
            get : fn ( ) => $this -> attributes [ 'password' ]
        ) ;
    }

}
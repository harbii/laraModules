<?php namespace Modules\Atom\Models\Traits;
use Illuminate\Support\Collection;

trait UpdateByArray {

    public Collection $updatedArray ;

    public function initializeUpdateByArray( ) : void {
        $this -> updatedArray = Collection::wrap( [ ] ) ;
    }

    public function hasAttributeUpdateAble( $key ) : bool {
        return method_exists( $this , $key . 'update' ) ;
    }

    public function addInAttributeUpdateAble( $key , $value ) : self {
        $this -> unsetAttributeUpdateAble( $key ) ;
        $this -> updatedArray -> put( $key , $value ) ;
        return $this ;
    }

    public function unsetAttributeUpdateAble( $key ) : self {
        unset(
            $this -> attributes         [ $key ] ,
            $this -> original           [ $key ] ,
            $this -> attributeCastCache [ $key ] ,
            $this -> classCastCache     [ $key ] ,
        ) ;
        return $this ;
    }

    protected function setAttributeUpdateAble( $key , $value ) : self {
        $this -> updatedArray -> forget( $key ) ;
        return $this -> { $key . 'update' }( $value ) ;
    }

    public function setAttribute( $key , $value ) {
        parent::setAttribute( $key , $value ) ;
        if ( $this -> isTranslatableAttribute( $key ) ) {
            if ( is_array( $value ) ) return $this -> setTranslations( $key , $value ) ;
            $this -> unsetAttributeUpdateAble( $key ) ;
            return $this -> setTranslation( $key , $this -> getLocale( ) , $value ) ;
        }
        if ( $this -> hasAttributeUpdateAble( $key ) ) return $this -> addInAttributeUpdateAble( $key , $value ) ;
        return $this ;
    }

    protected function finishSave( array $options ) {
        $this -> fireModelEvent( 'saved', false );
        if ( $this -> isDirty( ) && ( $options[ 'touch' ] ?? true ) ) $this -> touchOwners( ) ;
        $this -> updatedArray -> map( fn( $value , $key ) => $this -> setAttributeUpdateAble( $key , $value ) ) ;
        $this -> syncOriginal( ) ;
    }

}
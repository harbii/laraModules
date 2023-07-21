<?php namespace Modules\Atom\Services;

use Modules\Atom\Models\Model;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

Abstract class Repository {

    use SelfMaker ;

    public array $relations = [ ] ;
    public array $counters  = [ ] ;

    public function relations ( ) : array { return $this -> relations ; }
    public function counters  ( ) : array { return $this -> counters  ; }

    public function filters   ( Builder $Query , Array $Array = [ ] ) : Builder {
        $this -> WhenArrayExists ( 'id'         , $Array , fn ( $items ) => $Query -> whereIn      ( 'id'         , $items ) ) ;
        $this -> WhenExistsFT    ( 'created_at' , $Array , fn ( $dates ) => $Query -> whereBetween ( 'created_at' , $dates ) ) ;
        $this -> WhenExists      ( 'active'     , $Array , fn ( $item  ) => $Query -> where        ( 'active'     , $item  ) ) ;
        return $Query ;
    }

    public function Query     ( Array $Array = [ ] , bool $with = false ) : Builder {
        $Query = $this -> filters ( $this -> BaseQuery ( ) , $Array ) ;
        if ( $with ) $Query = $Query
            -> with      ( $this -> relations ( ) )
            -> withCount ( $this -> counters  ( ) )
        ;
        return $Query ;
    }

    public function loudData( Model $Model ) : Model {
        return $Model
            -> loadMissing ( $this -> relations( ) )
            -> loadCount   ( $this -> Counters ( ) )
        ;
    }

    Abstract public function BaseQuery ( ) : Builder ;

    public function WhenArrayExists( string | int $key , Array $Array = [ ] , \Closure $Closure = null , $default = null ) {
        if ( array_key_exists( $key , $Array ) ) return value( $Closure , Arr::wrap( $Array[ $key ] ) ) ;
        return func_num_args( ) === 4 ? value( $Closure , Arr::wrap( $default ) ) : null ;
    }

    public function WhenExists( string | int $key , Array $Array = [ ] , \Closure $Closure = null , $default = null ) {
        if ( array_key_exists( $key , $Array ) ) return value( $Closure , $Array[ $key ] ) ;
        return func_num_args( ) === 4 ? value( $Closure , $default ) : null ;
    }

    public function WhenExistsFT( string $key , Array $Array = [ ] , \Closure $Closure = null , $default = null ) {
        if ( array_key_exists( $key . '_from' , $Array ) and array_key_exists( $key . '_to' , $Array ) ) return value( $Closure , Arr::wrap( [ ( int ) $Array[ $key . '_from' ] , ( int ) $Array[ $key . '_to' ] ] ) ) ;
        return func_num_args( ) === 4 ? value( $Closure , Arr::wrap( $default ) ) : null ;
    }

    public static function Relation( string $Relation , Builder $Query , Array $Array = [ ] ) : Builder {
        return $Query -> whereRelation ( $Relation , fn ( Builder $Query ) => self::instance( ) -> filters( $Query , $Array ) ) ;
    }

}

/**
    namespace App\Interfaces; interface RepositoryInterface {
        public function All           ( ) ;
        public function AllTrashed    ( ) ;
        public function find          ( int $Id , array $columns = [ '*' ] , array $relations = [ ] , array $append = [ ] ) :? model ;
        public function findTrashed   ( int $Id , array $columns = [ '*' ] , array $relations = [ ] , array $append = [ ] ) :? model ;
        public function create        ( array $payloud ) : model ;
        public function update        ( model $model , array $newDetails ) : model ;
        public function delete        ( int $Id ) : bool ;
        public function restore       ( int $Id ) :? model ;
    }
*/
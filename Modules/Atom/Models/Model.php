<?php namespace Modules\Atom\Models; Abstract Class Model extends \Illuminate\Database\Eloquent\Model {

    use
        Traits\HasFactory      ,
        Traits\StorePath       ,
        Traits\UpdateByArray
    ;


    protected $casts = [
        'is_available' => 'boolean'  ,
        'is_active'    => 'boolean'  ,
        'created_at'   => 'datetime' ,
        'updated_at'   => 'datetime' ,
        'deleted_at'   => 'datetime' ,
    ] ;

    public function edit( Array $Attributes = [ ] ) : Self {
        $this -> update ( $Attributes ) ;
        return $this -> refresh( );
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate( \DateTimeInterface $date ) : string {
        return $date -> format( \Illuminate\Support\Carbon::DEFAULT_TO_STRING_FORMAT );
    }

    public function guardName( ) : string {
        return class_basename( static::class ) ;
    }

}
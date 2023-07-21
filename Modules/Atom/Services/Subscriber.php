<?php namespace Modules\Atom\Services; Abstract class Subscriber {

    public Array $Subscribes = [ ] ;

    public function subscribe( \Illuminate\Events\Dispatcher $events ) : Array {
        return ( $this -> onSubscribe( $events ) ?? [ ] ) + $this -> Subscribes ;
    }

    public function onSubscribe( \Illuminate\Events\Dispatcher $events ) : Array | null {
        return [ ] ;
    }

    public function EventName( string $Event ) : Array {
        $Event = explode( '.' , $Event ) ;
        return [
            'Prefix'  => $Event[ 0 ] ,
            'Webhook' => $Event[ 1 ] ,
            'Verble'  => $Event[ 2 ] ,
            'Type'    => $Event[ 3 ] ,
            'Event'   => $Event[ 4 ] ,
            'All'     => $Event
        ] ;
    }

}
<?php namespace Modules\Atom\Providers; class BroadcastServiceProvider extends \Illuminate\Support\ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot( ) {
        \Illuminate\Support\Facades\Broadcast::routes( ) ;
        require base_path( 'Routes/channels.php' ) ;
    }
}

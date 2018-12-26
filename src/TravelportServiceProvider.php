<?php

namespace Thedevlogs\Travelport;


use Illuminate\Support\ServiceProvider;

class TravelportServiceProvider extends ServiceProvider
{

    public function boot()
    {
		$logs_path = __DIR__.'/../logs/travelport.log';
		$this->publishes([
			$logs_path => storage_path('logs/travelport.log'),
		], 'travelport-logs');
		
		$dist = __DIR__.'/../config/travelport.php';
        $this->publishes([
            $dist => config_path('travelport.php'),
        ],'travelport-config');

        $this->mergeConfigFrom($dist, 'travelport');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
		
        $this->app->singleton(Travelport::class, function($app){
			
            $config = $app['config']->get('travelport');

            if(!$config){
                throw new \RuntimeException('missing travelport configuration section');
            }

            if(!isset($config['TARGETBRANCH'])){
                throw new \RuntimeException('missing travelport configuration: `TARGETBRANCH`');
            }

            if(!isset($config['CREDENTIALS'])){
                throw new \RuntimeException('missing travelport configuration: `CREDENTIALS`');
            }

            if(!isset($config['PROVIDER'])){
                throw new \RuntimeException('missing travelport configuration: `PROVIDER`');
            }

            return new Travelport($config);
        });

		
        $this->app->alias(Travelport::class, 'travelport-api');
    }

}
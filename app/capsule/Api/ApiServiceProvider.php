<?php namespace Capsule\Api;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['exception'] = $this->app->share(function($app)
        {
            return new ExceptionHandler($app, $app['exception.plain'], $app['exception.debug']);
        });
    	include app_path() . "/routes.api.php";
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
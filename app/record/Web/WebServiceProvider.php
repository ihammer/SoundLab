<?php namespace Record\Web;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Foundation\AssetPublisher;
// use Artisan;

class WebServiceProvider extends ServiceProvider {
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
		// 
	}
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// $this->app['capsule.web.assetManager'] = $this->app->share(function($app)
		// {
		// 	return new AssetManager($app['files'], $app['path.public']);
		// });
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
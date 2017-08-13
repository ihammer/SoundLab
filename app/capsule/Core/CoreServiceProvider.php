<?php namespace Capsule\Core;

use Event, Config, Queue;
use Capsule\Core\Task;
use Capsule\Core\Support\JobStatus;
use Capsule\Core\Support\Tagged;
use Capsule\Core\Support\SMS;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {
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
        // $this->app->make('validator')->extend('username', 'Capsule\Core\Users\UsernameValidator@validate');
        $this->registerEventHandler();
    }
    
    /**
	 * Register the service provider.
	 *
	 * @return void
	 */
    public function register()
    {
        // tags
        $this->app->bind('capsule.core.tag', function($app) {
            return new Tagged;
        });

        // sms
        $this->app->bindShared('sms', function($app) {
            return new SMS("d39d533f9b57524a9bfe8ce67d8d9e01");
        });
    }
    // 注册事件监听器
    public function registerEventHandler()
    {
        Event::listen('Capsule.Core.*', 'Capsule\Core\Listeners\WorkMetaDataUpdater');
        Event::listen('Capsule.Core.*', 'Capsule\Core\Listeners\UserMetaDataUpdater');
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
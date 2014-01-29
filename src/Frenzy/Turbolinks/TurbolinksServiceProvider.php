<?php namespace Frenzy\Turbolinks;

use Illuminate\Support\ServiceProvider;

class TurbolinksServiceProvider extends ServiceProvider {

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
		$this->package('frenzy/turbolinks');

        /** @var Turbolinks $turbolinks */
        $turbolinks = $this->app['turbolinks'];
        $turbolinks->boot();
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;
        $this->app['turbolinks'] = $this->app->share(function ($app){
            $turbolinks = new Turbolinks($app);

            return $turbolinks;
        });

        if(version_compare($app::VERSION, '4.1', '>=')){
            $app->middleware('Frenzy\Turbolinks\Middleware', array($app));
        }

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('turbolinks');
	}

}
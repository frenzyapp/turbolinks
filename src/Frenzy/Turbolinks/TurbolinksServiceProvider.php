<?php namespace Frenzy\Turbolinks;

use Helthe\Component\Turbolinks\Turbolinks;
use Illuminate\Support\ServiceProvider;
use File;

class TurbolinksServiceProvider extends ServiceProvider
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
        $this->package('frenzy/turbolinks');
        // Add turbolinks and jquery.turbolinks assets path to the search paths of Larasset package
        $packageAssetsPath = base_path()."/vendor/helthe/turbolinks/Resources/public/js";
        if (File::exists($packageAssetsPath)) {
            $this->app['config']->set('larasset::paths', array_merge(array($packageAssetsPath), $this->app['config']->get('larasset::paths', array())));
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['turbolinks'] = $this->app->share(function ($app) {
            return new Turbolinks();
        });

        $this->app->middleware('Helthe\Component\Turbolinks\StackTurbolinks', array($this->app['turbolinks']));
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

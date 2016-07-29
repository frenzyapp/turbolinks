<?php namespace Frenzy\Turbolinks;

use File;
use Barryvdh\StackMiddleware\StackMiddleware;
use Helthe\Component\Turbolinks\Turbolinks;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

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
    public function boot(StackMiddleware $stack, ResponseFactory $factory)
    {
        // Add turbolink assets path to the search paths of Larasset package
        $packageAssetsPath = base_path()."/vendor/helthe/turbolinks/Resources/public/js";
        if (File::exists($packageAssetsPath)) {
            $this->app['config']->set(
                'larasset.paths',
                array_merge([$packageAssetsPath], config('larasset.paths', []))
            );
        }

        // Publish assets
        $this->publishes([
            base_path().'/vendor/helthe/turbolinks/Resources/public/js' => base_path('resources/js'),
        ], 'assets');

        $stack->bind(
            'Frenzy\Turbolinks\Middleware\StackTurbolinks',
            'Helthe\Component\Turbolinks\StackTurbolinks',
            [$this->app['turbolinks']]
        );

        $this->registerTurbolinksMacros($factory);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['turbolinks'] = $this->app->share(function ($app) {
            return new Turbolinks;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['turbolinks'];
    }

    /**
     * @param ResponseFactory $factory
     */
    protected function registerTurbolinksMacros($factory)
    {
        $factory->macro('makeWithTurbolinks', function ($content, $options = []) use ($factory) {
            $status =  array_pull($options, 'status', 200);
            $headers = array_pull($options, 'headers', []);

            $turbolinksHeaders = app('turbolinks')->convertTurbolinksOptions($options);
            $headers = array_merge($headers, $turbolinksHeaders);

            return $factory->make($content, $status, $headers);
        });

        $factory->macro('redirectToWithTurbolinks', function ($path, $options = []) use ($factory) {
            $status =  array_pull($options, 'status', 302);
            $headers = array_pull($options, 'headers', []);
            $secure =  array_pull($options, 'secure');

            $turbolinksHeaders = app('turbolinks')->convertTurbolinksOptions($options);
            $headers = array_merge($headers, $turbolinksHeaders);

            return $factory->redirectTo($path, $status, $headers, $secure);
        });
    }
}

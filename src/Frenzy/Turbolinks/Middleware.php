<?php namespace Frenzy\Turbolinks;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Illuminate\Foundation\Application;


class Middleware implements HttpKernelInterface {

    /** @var \Symfony\Component\HttpKernel\HttpKernelInterface $kernel */
    protected $kernel;
    /** @var \Illuminate\Foundation\Application $app */
    protected $app;

    /**
     * Create a new turbolinks middleware instance
     * @param \Symfony\Component\HttpKernel\HttpKernelInterface $kernel
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(HttpKernelInterface $kernel, Application $app)
    {
        $this->kernel = $kernel;
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        /** @var Turbolinks $turbolinks */
        $turbolinks = $this->app['turbolinks'];

        $response = $this->kernel->handle($request, $type, $catch);

        return $turbolinks->modifyResponse($request, $response, $type);
    }
}

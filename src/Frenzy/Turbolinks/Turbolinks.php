<?php namespace Frenzy\Turbolinks;

use Symfony\Component\HttpFoundation\Cookie;

use Symfony\Component\HttpKernel\HttpKernelInterface;

class Turbolinks {
    /**
     * The Laravel application instance.
     *
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * True when booted.
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * Header to verify on the request.
     *
     * @var string
     */
    const REQUEST_HEADER_REFERER = 'X-XHR-Referer';

    /**
     * Header to verify on the response.
     *
     * @var string
     */
    const RESPONSE_HEADER_LOCATION = 'Location';
    /**
     * Header inserted in the response.
     *
     * @var string
     */
    const RESPONSE_HEADER_REDIRECTED = 'X-XHR-Redirected-To';

    /**
     * Cookie attribute name for the request method.
     *
     * @var string
     */
    const COOKIE_ATTR_NAME = 'request_method';

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct($app=null){
        if(!$app){
            $app = app();   //Fallback when $app is not given
        }
        $this->app = $app;
    }

    /**
     * Boot turbolinks
     */
    public function boot(){
        if($this->booted){
            return;
        }

        $turbolinks = $this;

        $app = $this->app;

        $this->booted = true;

    }

    public function modifyResponse($request, $response, $type){
        $app = $this->app;

        if ($type != HttpKernelInterface::MASTER_REQUEST) {
            return $response;
        }

        $response->headers->setCookie(
            new Cookie(
                self::COOKIE_ATTR_NAME,
                $request->getMethod()
            )
        );

        // Crossdomain : has X-XHR-Referer and Location
        if ($request->headers->has(self::REQUEST_HEADER_REFERER) && $response->headers->has(self::RESPONSE_HEADER_LOCATION)) {
            if (!$this->hasSameOrigin($request, $response)) {
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
            }
        }
        
        // Redirected : is redirect and has Location
        if ($response->isRedirect() && $response->headers->has(self::RESPONSE_HEADER_LOCATION)) {
            $response->headers->add(array(self::RESPONSE_HEADER => $response->headers->get(self::RESPONSE_HEADER_LOCATION)));
        }

        return $response;
    }

    /**
     * Parse the given url into an origin array with the scheme, host and port.
     *
     * @param string $url
     *
     * @return array
     */
    private function getUrlOrigin($url)
    {
        return array(
            parse_url($url, PHP_URL_SCHEME),
            parse_url($url, PHP_URL_HOST),
            parse_url($url, PHP_URL_PORT),
        );
    }

    /**
     * Checks if the request and the response have the same origin.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Boolean
     */
    private function hasSameOrigin(Request $request, Response $response)
    {
        $requestOrigin = $this->getUrlOrigin($request->headers->get(self::REQUEST_HEADER));

        $responseOrigin = $this->getUrlOrigin($response->headers->get(self::RESPONSE_HEADER_LOCATION));

        return $requestOrigin == $responseOrigin;
    }


}
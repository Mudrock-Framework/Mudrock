<?php
namespace system\core;

class BaseRouter {

    /**
     * @var string|array
     */
    private $uri;

    /**
     * @var array
     */
    private $method;

    /**
     * @var array
     */
    private $array_get = [];

    /**
     * @var array
     */
    private $array_post = [];

    /**
     * @return void
     */
    public function run(): void
    {
        session_start();
        $this->init();
        require_once('.././app/config/routes.php');
        $this->exec();
    }

    /**
     * @return void
     */
    private function init(): void
    {
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $explode_uri   = explode('/', $_SERVER['REQUEST_URI']);
        $normalize_uri = array_values(array_filter($explode_uri));

        $uri_imploded = implode('/', array_values($normalize_uri));
        $normalize_uri_params = explode('?', $uri_imploded);

        $this->uri = $normalize_uri_params[0];

        if (@$_GET['debug_uri'] == 'true') {
            $uri = str_replace('?debug_uri=true', '', $this->uri);
            dd($uri, false);
        }
    }

    /**
     * @return void
     */
    private function exec(): void
    {
        switch ($this->method) {
            case 'GET':
                if (!$this->searchRoute($this->array_get)) {
                    $this->validateRouteMethod();
                }
                break;
            case 'POST':
                if (!$this->searchRoute($this->array_post)) {
                    $this->validateRouteMethod();
                }
                break;
            default:
                $exception = new Exceptions();
                $exception->error('request_method_not_allowed', $this->method);
        }
    }

    /**
     * @param string $router
     * @param string $callback
     * @return void
     */
    private function get(string $router, string $callback): void
    {
        $this->array_get[] = [
            'router' => $router,
            'callback' => $callback
        ];
    }

    /**
     * @param string $router
     * @param string $callback
     * @return void
     */
    private function post(string $router, string $callback): void
    {
        $this->array_post[] = [
            'router' => $router,
            'callback' => $callback
        ];
    }

    /**
     * @param string $call
     * @return void
     */
    private function callControllerFunction(string $call): void
    {
        $callback = explode('@', $call);
        $exception = new Exceptions();

        if (!isset($callback[0]) || !isset($callback[1])) {
            $exception->error('undefined_route');
            return;
        }

        $controller = 'app\\controllers\\' . $callback[0];
        $method = $callback[1];

        if (!class_exists($controller)) {
            $exception->error('controller_not_found', $callback[0]);
            return;
        }

        if (!method_exists($controller, $method)) {
            $exception->error('method_not_found', $method);
            return;
        }

        call_user_func_array([
            new $controller,
            $method
        ], []);
    }

    /**
     * @return bool
     */
    private function validateRouteMethod(): bool
    {
        $router = substr_replace($this->uri, '/', 0, 0);
        $exists_another_method = false;

        foreach ($this->array_get as $index => $array) {
            if (substr($array['router'], 0, 1) != '/') {
                $array_router = substr_replace($array['router'], '/', 0, 0);
            } else {
                $array_router = $array['router'];
            }                
            if ($array_router == $router) {
                $exists_another_method = true;
            }
        }

        foreach ($this->array_post as $index => $array) {
            $array_router = $array['router'];

            if (substr($array['router'], 0, 1) != '/') {
                $array_router = substr_replace($array['router'], '/', 0, 0);
            }

            if ($array_router == $router) {
                $exists_another_method = true;
            }
        }

        if ($exists_another_method) {
            $exception = new Exceptions();
            $exception->error('request_not_allowed', $this->uri);

            return true;
        }

        $exception = new Exceptions();
        $exception->error('route_not_found', $router);

        return false;
    }

    /**
     * @param array $method_array
     * @return bool
     */
    private function searchRoute(array $method_array): bool
    {
        $router_exists = false;

        foreach ($method_array as $request) {
            $router = $request['router'];

            if (substr($request['router'], 0, 1) == '/') {
                $router = substr($request['router'], 1);
            }

            if ($router == $this->uri) {
                $router_exists = true;
                if (is_callable($request['callback'])) {
                    $request['callback']();
                } else {
                    $this->callControllerFunction($request['callback']);
                }
            }
        }

        return $router_exists;
    }

    /**
     * @return array|string
     */
    public function getUri(): array
    {
        return $this->uri;
    }

}

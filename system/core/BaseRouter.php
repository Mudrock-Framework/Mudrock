<?php
namespace system\core;

use Exception;
use system\core\Exceptions;

class BaseRouter {

    private $uri;
    private $method;
    private $array_get = [];
    private $array_post = [];

    public function run() {
        session_start();
        $this->init();
        require_once('.././app/config/routes.php');
        $this->exec();
    }

    private function init() {

        $this->method  = $_SERVER['REQUEST_METHOD'];
        $explode_uri   = explode('/', $_SERVER['REQUEST_URI']);
        $normalize_uri = array_values(array_filter($explode_uri));

        for ($i=0; $i < URI_COUNT; $i++) { 
            unset($normalize_uri[$i]);
        }

        $uri_imploded = implode('/', array_values($normalize_uri));
        $normalize_uri_params = explode('?', $uri_imploded);

        $this->uri = $normalize_uri_params[0];

        if (@$_GET['debug_uri'] == 'true') {
            $uri = str_replace('?debug_uri=true', '', $this->uri);
            dd($uri, false);
        }
    }

    private function exec() {
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

    private function get($router, $callback) {
        $this->array_get[] = [
            'router' => $router,
            'callback' => $callback
        ];
    }

    private function post($router, $callback) {
        $this->array_post[] = [
            'router' => $router,
            'callback' => $callback
        ];
    }

    private function callControllerFunction(String $call) {
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

    private function validateRouteMethod() {

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
            if (substr($array['router'], 0, 1) != '/') {
                $array_router = substr_replace($array['router'], '/', 0, 0);
            } else {
                $array_router = $array['router'];
            }                
            if ($array_router == $router) {
                $exists_another_method = true;
            }
        }

        if ($exists_another_method) {
            $exception = new Exceptions();
            $exception->error('request_not_allowed', $this->uri);
        } else {
            $exception = new Exceptions();
            $exception->error('route_not_found', $router);
        }
    }

    private function searchRoute(Array $method_array) {
        $router_exists = false;
        foreach ($method_array as $request) {
            if (substr($request['router'], 0, 1) == '/') {
                $router = substr($request['router'], 1);
            } else {
                $router = $request['router'];
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

    public function getUri()
    {
        return $this->uri;
    }

}
<?php

namespace Eshchukina\TodoApi\Http;

class Router {
    private $routes;

    public function __construct() {
        $this->routes = [];
    }

    public function register($method, $url, $handlers) {
        $this->routes[$method][$url] = $handlers;
    }

    public function exec() {

        $data = json_decode(file_get_contents('php://input'), true);
        $request = new Request($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], $_SERVER, $data);
        $response = new Response();
        $handler = $this->getHandler($request);
        if (!$handler) {
            $handler = [$this, 'notFoundHandler'];
        }
        call_user_func($handler, $request, $response);
        $this->respoond($response);
    }

    private function getHandler(Request $request) {
        if (empty($this->routes[$request->getMethod()])) {
            return null;
        } 

        if (!empty($this->routes[$request->getMethod()][$request->getUrl()])) {
            return $this->routes[$request->getMethod()][$request->getUrl()];
        }

        foreach ($this->routes[$request->getMethod()] as $pattern => $funcName) {
            if (@preg_match($pattern, $request->getUrl(), $matches)) {
                return $funcName;
            }
        }
        
        return null;
    }

    private function notFoundHandler(Request $request, Response $response) {
        $response->setStatus(404);
        $response->setBody([
            'error' => 'not found',
            'server' => $_SERVER,
        ]);
    }

    public function respoond(Response $response) {
        
        foreach ($response->getHeaders() as $key => $value) {
            header($key . ': ' . $value);
        }

        http_response_code($response->getStatus());
        echo json_encode($response->getBody());
    }

}



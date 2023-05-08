<?php
namespace Eshchukina\TodoApi\Http;

class Request {
    private $method;
    private $url;
    private $headers;
    private $body;

    public function __construct($method, $url, $headers, $body) {

        $this->method = $method;
        $this->url = $url;
        $this->body = $body;
        $this->headers = $headers;
    }

    public function getMethod() {
        
        return $this->method;

    }

    public function getUrl() {

        return $this->url;

    }

    public function getHeaders() {

        return $this->headers;

    }

    public function getBody() {

        return $this->body;
        
    }
}

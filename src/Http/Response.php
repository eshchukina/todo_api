<?php
namespace Http;

class Response {
    private $status;
    private $body;
    private $headers;

    public function __construct() {

        $this->headers = [];
        $this->addHeader('X-Router', 'Http\Router');
    }

    public function addHeader($key, $value) {

        $this->headers[$key] = $value;
    }

    public function getStatus() {

        return $this->status;

    }

    public function setStatus($status) {

        $this->status = $status;

    }

    public function getBody() {

        return $this->body;

    }

    public function setBody($body) {

        $this->body = $body;

    }

    public function getHeaders() {

        return $this->headers;

    }

    public function setHeaders($headers) {

        $this->headers = $headers;

    }

}
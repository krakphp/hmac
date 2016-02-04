<?php

namespace Krak\Hmac;

class MockHmacRequest implements HmacRequest
{
    private $public_key;
    private $hash;
    private $timestamp;
    private $content;
    private $uri;
    private $method;
    private $headers;

    public function __construct($content, $uri, $method, $headers = [])
    {
        $this->content = $content;
        $this->uri = $uri;
        $this->method = $method;
        $this->headers = $headers;
    }

    public function setPublicKey($key)
    {
        $this->public_key = $key;
    }
    public function getPublicKey()
    {
        return $this->public_key;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }
    public function getHash()
    {
        return $this->hash;
    }

    public function setTimestamp($stamp)
    {
        $this->timestamp = $stamp;
    }
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHeader($key) {
        if (array_key_exists($key, $this->headers)) {
            return $this->headers[$key];
        }

        return null;
    }
    public function setHeader($key, $val) {
        $this->headers[$key] = $val;
    }
}

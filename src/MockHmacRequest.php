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

    public function __construct($content, $uri, $method)
    {
        $this->content = $content;
        $this->uri = $uri;
        $this->method = $method;
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
}

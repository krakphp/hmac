<?php

namespace Krak\Hmac;

use Psr\Http\Message\RequestInterface;

class Psr7HmacRequest implements HmacRequest
{
    private $request;
    private $public_key_header;
    private $hash_header;
    private $timestamp_header;

    public function __construct(
        RequestInterface $request,
        $public_key_header = 'X-Public-Key',
        $hash_header = 'X-Hash',
        $timestamp_header = 'X-Timestamp'
    ) {
        $this->request = $request;
        $this->public_key_header = $public_key_header;
        $this->hash_header = $hash_header;
        $this->timestamp_header = $timestamp_header;
    }

    public function getPublicKey()
    {
        return $this->request->getHeader($this->public_key_header)[0];
    }
    public function setPublicKey($key)
    {
        $this->request = $this->request->withHeader($this->public_key_header, $key);
    }

    public function getHash()
    {
        return $this->request->getHeader($this->hash_header)[0];
    }
    public function setHash($hash)
    {
        $this->request = $this->request->withHeader($this->hash_header, $hash);
    }
    public function getTimestamp()
    {
        return $this->request->getHeader($this->timestamp_header)[0];
    }
    public function setTimestamp($timestamp)
    {
        $this->request = $this->request->withHeader($this->timestamp_header, $timestamp);
    }
    public function getContent()
    {
        return (string) $this->request->getBody();
    }
    public function getUri()
    {
        return (string) $this->request->getUri();
    }
    public function getMethod()
    {
        return $this->request->getMethod();
    }

    public function getHeader($key) {
        return $this->request->getHeader($key);
    }
    public function setHeader($key, $val) {
        $this->request = $this->request->withHeader($key, $val);
    }
    public function getPsr7Request() {
        return $this->request;
    }
}

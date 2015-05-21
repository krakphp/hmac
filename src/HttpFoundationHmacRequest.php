<?php

namespace Krak\Hmac;

use Symfony\Component\HttpFoundation\Request;

class HttpFoundationHmacRequest implements HmacRequest
{
    private $request;
    private $public_key_header;
    private $hash_header;
    private $timestamp_header;

    public function __construct(
        Request $request,
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
        return $this->request->headers->get($this->public_key_header);
    }
    public function setPublicKey($key)
    {
        $this->request->headers->set($this->public_key_header, $key);
    }
    public function getHash()
    {
        return $this->request->headers->get($this->hash_header);
    }
    public function setHash($hash)
    {
        $this->request->headers->set($this->hash_header, $hash);
    }
    public function getTimestamp()
    {
        return $this->request->headers->get($this->timestamp_header);
    }
    public function setTimestamp($timestamp)
    {
        $this->request->headers->set($this->timestamp_header, $timestamp);
    }
    public function getContent()
    {
        return $this->request->getContent();
    }
    public function getHttpRequest()
    {
        return $this->request;
    }
}

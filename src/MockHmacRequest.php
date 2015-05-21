<?php

namespace Krak\Hmac;

class MockHmacRequest implements HmacRequest
{
    private $public_key;
    private $hash;
    private $timestamp;
    private $content;

    public function __construct($content)
    {
        $this->content = $content;
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
}

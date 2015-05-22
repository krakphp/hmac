<?php

namespace Krak\Hmac;

interface HmacRequest
{
    public function getPublicKey();
    public function setPublicKey($key);
    public function getHash();
    public function setHash($hash);
    public function getTimestamp();
    public function setTimestamp($timestamp);
    public function getUri();
    public function getMethod();
    public function getContent();
}

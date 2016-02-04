<?php

namespace Krak\Hmac;

interface HmacRequest
{
    /** @deprecated */
    public function getPublicKey();
    /** @deprecated */
    public function setPublicKey($key);
    /** @deprecated */
    public function getHash();
    /** @deprecated */
    public function setHash($hash);
    /** @deprecated */
    public function getTimestamp();
    /** @deprecated */
    public function setTimestamp($timestamp);


    public function getUri();
    public function getMethod();
    public function getContent();
    
    public function getHeader($key);
    public function setHeader($key, $value);
}

<?php

namespace Krak\Hmac;

class Base64HmacHasher implements HmacHasher
{
    private $hasher;

    public function __construct(HmacHasher $hasher) {
        $this->hasher = $hasher;
    }

    public function hashContent($content, HmacKeyPair $pair) {
        return base64_encode($this->hasher->hashContent($content, $pair));
    }
}

<?php

namespace Krak\Hmac;

class ClosureHmacHasher implements HmacHasher
{
    private $hasher;

    public function __construct(\Closure $hasher) {
        $this->hasher = $hasher;
    }

    public function hashContent($content, HmacKeyPair $pair) {
        $hasher = $this->hasher;
        return $hasher($content, $pair);
    }
}

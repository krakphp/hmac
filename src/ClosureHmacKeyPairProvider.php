<?php

namespace Krak\Hmac;

class ClosureHmacKeyPairProvider implements HmacKeyPairProvider
{
    private $provider;

    public function __construct(\Closure $provider) {
        $this->provider = $provider;
    }

    public function getKeyPairFromPublicKey($key)
    {
        $provider = $this->provider;
        return $provider($key);
    }
}

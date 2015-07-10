<?php

namespace Krak\Hmac;

class NullHmacKeyPairProvider implements HmacKeyPairProvider
{
    public function getKeyPairFromPublicKey($key)
    {
        return null;
    }
}

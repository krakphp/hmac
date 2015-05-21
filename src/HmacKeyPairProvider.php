<?php

namespace Krak\Hmac;

interface HmacKeyPairProvider
{
    /**
     * @param $key string
     * @return HmacKeyPair
     */
    public function getKeyPairFromPublicKey($key);
}

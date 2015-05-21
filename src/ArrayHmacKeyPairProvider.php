<?php

namespace Krak\Hmac;

class ArrayHmacKeyPairProvider implements HmacKeyPairProvider
{
    private $key_pair_map;

    public function __construct($key_pairs)
    {
        $this->key_pair_map = [];
        foreach ($key_pairs as $pair) {
            $this->key_pair_map[$pair->public_key] = $pair;
        }
    }

    public function getKeyPairFromPublicKey($key)
    {
        if (!array_key_exists($key, $this->key_pair_map)) {
            return null;
        }

        return $this->key_pair_map[$key];
    }
}

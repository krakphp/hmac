<?php

namespace Krak\Hmac;

class StdHmacHasher implements HmacHasher
{
    private $alg;

    public function __construct($alg = 'sha256')
    {
        $this->alg = $alg;
    }

    public function hashContent($content, HmacKeyPair $pair)
    {
        return hash_hmac($this->alg, $content, $pair->private_key);
    }
}

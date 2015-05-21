<?php

namespace Krak\Hmac;

class HmacKeyPair
{
    public $public_key;
    public $private_key;

    public function __construct($public_key, $private_key)
    {
        $this->public_key = $public_key;
        $this->private_key = $private_key;
    }
}

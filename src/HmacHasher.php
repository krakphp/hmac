<?php

namespace Krak\Hmac;

interface HmacHasher
{
    public function hashContent($content, HmacKeyPair $pair);
}

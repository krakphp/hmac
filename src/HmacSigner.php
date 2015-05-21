<?php

namespace Krak\Hmac;

interface HmacSigner
{
    public function signRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher);
    /**
     * @return bool
     */
    public function validateRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher);
}

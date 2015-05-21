<?php

namespace Krak\Hmac;

class ContentHmacSigner implements HmacSigner
{
    public function signRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher)
    {
        $hash = $hasher->hashContent($request->getContent(), $pair);
        $request->setPublicKey($pair->public_key);
        $request->setHash($hash);
    }

    public function validateRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher)
    {
        $expected_hash = $request->getHash();
        $hash = $hasher->hashContent($request->getContent(), $pair);
        return hash_equals($hash, $expected_hash);
    }
}

<?php

namespace Krak\Hmac;

class RequestHmacSigner implements HmacSigner
{
    private function getHashString(HmacRequest $req)
    {
        return $req->getMethod() . $req->getUri() . $req->getTimestamp() . $req->getContent();
    }

    public function signRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher)
    {
        $request->setTimestamp(time());

        $hash = $hasher->hashContent(
            $this->getHashString($request),
            $pair
        );

        $request->setPublicKey($pair->public_key);
        $request->setHash($hash);
    }

    public function validateRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher)
    {
        $expected_hash = $request->getHash();

        $hash = $hasher->hashContent(
            $this->getHashString($request),
            $pair
        );

        if (!hash_equals($hash, $expected_hash)) {
            return false;
        }

        /* verify the timestamp */
        $diff = time() - (int) $request->getTimestamp();

        if (abs($diff) > 10) {
            return false;
        }

        return true;
    }
}

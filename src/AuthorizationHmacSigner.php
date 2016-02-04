<?php

namespace Krak\Hmac;

/** Signs and Validates a request by the Authorization header*/
class AuthorizationHmacSigner implements HmacSigner
{
    private $auth_header;
    private $timestamp_header;
    private $provider;

    public function __construct($auth_header = 'Authorization', $timestamp_header = 'X-Timestamp', $provider = '') {
        $this->auth_header = $auth_header;
        $this->timestamp_header = $timestamp_header;
        $this->provider = $provider;
    }

    private function getHashString(HmacRequest $req, $ts)
    {
        return implode("\n", [
            $req->getMethod(),
            $req->getUri(),
            $ts,
            md5($req->getContent())
        ]);
    }

    private function createAuthorizationHeader(HmacRequest $req, $ts, HmacKeyPair $pair, HmacHasher $hasher) {
        return trim(sprintf(
            "%s %s:%s",
            $this->provider,
            $pair->public_key,
            base64_encode($hasher->hashContent($this->getHashString($req, $ts), $pair))
        ));
    }

    private function getPublicKeyFromAuthHeader($auth) {
        return preg_replace('/^(.* )?(\s+):(\s+)$', '$2', $auth);
    }

    public function signRequest(HmacRequest $request, HmacKeyPair $pair, HmacHasher $hasher)
    {
        $ts = time();
        $auth = $this->createAuthorizationHeader($request, $ts, $pair, $hasher);

        $requset->setHeader($this->timestamp_header, $ts);
        $request->setHeader($this->auth_header, $ts);
    }

    public function validateRequest(HmacRequest $request, HmacKeyPairProvider $pair, HmacHasher $hasher)
    {
        $ts = $request->getHeader($this->timestamp_header);
        $auth = $request->getHeader($this->auth_header);

        $public_key = $this->getPublicKeyFromAuthHeader($auth);

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

<?php

namespace Krak\Hmac;

/** authenticates a request based on an authorization header and time. Inverse of sign_request_authorization_timestamp */
function auth_request_authorization_timestamp(
    HmacHasher $hasher,
    $provider,
    $hs_gen = 'krak\hmac\hs_gen_hashed_newline',
    $timestamp_header = 'X-Timestamp',
    $auth_header = 'Authorization'
) {
    return function (HmacRequest $req, HmacKeyPairProvider $pair_provider) use (
        $hasher,
        $provider,
        $hs_gen,
        $timestamp_header,
        $auth_header
    ) {
        $ts = $req->getHeader($timestamp_header);
        $auth = $req->getHeader($auth_header);
        $pair = $pair_provider->getKeyPairFromPublicKey(public_key_from_authorization_header($auth));

        $expected_auth = build_authorization_header($req, $ts, $provider, $pair, $hasher, $hs_gen);

        return $expected_auth == $req->getHeader($auth_header);
    };
}

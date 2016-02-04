<?php

/** Krak Hmac Signing
    All request signing and related funcs are here.

    HmacSigner - any function that takes a HmacRequest, HmacKeyPair, and HmacHasher and signs the request
    HsGen - any function that generates a string to be hashed
*/

namespace Krak\Hmac;

/** signs a request into the Authorization header and uses a timestamp for the time component */
function sign_request_authorization_timestamp(
    HmacHasher $hasher,
    $provider,
    $hs_gen = 'krak\hmac\hs_gen_hashed_newline',
    $timestamp_header = 'X-Timestamp',
    $auth_header = 'Authorization'
) {
    return function (HmacRequest $req, HmacKeyPair $pair) use (
        $hasher,
        $provider,
        $hs_gen,
        $timestamp_header,
        $auth_header
    ) {
        $ts = time();
        $auth = build_authorization_header($req, $ts, $provider, $pair, $hasher, $hs_gen);

        $req->setHeader($timestamp_header, $ts);
        $req->setHeader($auth_header, $auth);
    };
}

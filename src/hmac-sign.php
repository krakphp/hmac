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

function hmac_sign_request(HmacConfig $config = null) {
    $conf = $config ?: HmacConfig::create();

    return function(HmacRequest $req, HmacKeyPair $pair) use ($conf) {
        $time = call_user_func($conf->time_gen);
        $auth = build_authorization_header(
            $req,
            $time,
            $conf->scheme,
            $pair,
            $conf->hasher,
            $conf->hs_gen
        );

        $req->setHeader($conf->time_header, $time);
        $req->setHeader($conf->auth_header, $auth);

        return $req;
    };
}

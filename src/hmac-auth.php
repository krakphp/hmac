<?php

namespace Krak\Hmac;

/** authenticates a request based on an authorization header and time. Inverse of sign_request_authorization_timestamp */
function auth_request_authorization_timestamp(
    HmacHasher $hasher,
    HmacKeyPairProvider $provider,
    $type,
    $hs_gen = 'krak\hmac\hs_gen_hashed_newline',
    $timestamp_header = 'X-Timestamp',
    $auth_header = 'Authorization'
) {
    return function (HmacRequest $req) use (
        $hasher,
        $provider,
        $type,
        $hs_gen,
        $timestamp_header,
        $auth_header
    ) {
        $ts = $req->getHeader($timestamp_header);
        $auth = $req->getHeader($auth_header);

        if (!$auth || !$ts) {
            return false;
        }

        $pair = $provider->getKeyPairFromPublicKey(public_key_from_authorization_header($auth));

        if (!$pair) {
            return false;
        }

        $expected_auth = build_authorization_header($req, $ts, $type, $pair, $hasher, $hs_gen);

        return $expected_auth == $req->getHeader($auth_header);
    };
}

function hmac_auth_request(HmacKeyPairProvider $provider, HmacConfig $config = null) {
    $conf = $config ?: HmacConfig::create();

    return function(HmacRequest $req) use ($provider, $conf) {
        $time = $req->getHeader($conf->time_header);
        $auth = $req->getHeader($conf->auth_header);

        if (!$auth || !$time) {
            return false;
        }

        $pair = $provider->getKeyPairFromPublicKey(public_key_from_authorization_header($auth));

        if (!$pair) {
            return false;
        }

        $expected_auth = build_authorization_header(
            $req,
            $time,
            $conf->scheme,
            $pair,
            $conf->hasher,
            $conf->hs_gen
        );

        return $expected_auth == $auth;
    };
}

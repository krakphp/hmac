<?php

namespace Krak\Hmac\Provider;

use GuzzleHttp\Middleware,
    Krak\Hmac\HmacKeyPair,
    Psr\Http\Message\RequestInterface;

function guzzle_hmac_middleware($psr7_sign, HmacKeyPair $pair) {
    return Middleware::mapRequest(function(RequestInterface $req) use ($psr7_sign, $pair) {
        return $psr7_sign($req, $pair);
    });
}

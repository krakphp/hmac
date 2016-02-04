<?php

namespace Krak\Hmac;

/** returns a hash string with hashed content and split by new line */
function hs_gen_hashed_newline(HmacRequest $req, $time) {
    return implode("\n", [
        $req->getMethod(),
        $req->getUri(),
        $time,
        md5($req->getContent())
    ]);
}

function build_authorization_header(HmacRequest $req, $time, $provider, HmacKeyPair $pair, HmacHasher $hasher, $hs_gen) {
    return trim(sprintf(
        "%s %s:%s",
        $provider,
        $pair->public_key,
        $hasher->hashContent($hs_gen($req, $time), $pair)
    ));
}

function public_key_from_authorization_header($header) {
    $res = preg_replace('/(.* )?(\S+):(\S+)/', '$2', $header);
    if ($res == $header) {
        return '';
    }

    return $res;
}

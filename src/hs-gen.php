<?php

namespace Krak\Hmac;

/** Hash String generators take the request and time info and generate the
    string content to be hashed.
*/

/** seperated hash string generator with md5 hashed content */
function hmac_hashed_hs_gen($sep = "\n") {
    return function(HmacRequest $req, $time) use ($sep) {
        return implode($sep, [
            $req->getMethod(),
            $req->getUri(),
            $time,
            md5($req->getContent())
        ]);
    };
}

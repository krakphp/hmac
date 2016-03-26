<?php

namespace Krak\Hmac;

/** generates timestamps for hmac signing */

/** generate a timestamp */
function hmac_ts_time_gen() {
    return 'time';
}

/** generate an http header date string */
function hmac_date_time_gen() {
    return function() {
        return date('r');
    };
}

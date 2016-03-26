<?php

namespace Krak\Hmac;

class HmacConfig
{
    public $scheme;
    public $hasher;
    public $hs_gen;
    public $time_gen;
    public $time_header;
    public $auth_header;

    public function __construct(
        $scheme,
        HmacHasher $hasher,
        $hs_gen,
        $time_gen,
        $time_header,
        $auth_header
    ) {
        $this->scheme = $scheme;
        $this->hasher = $hasher;
        $this->hs_gen = $hs_gen;
        $this->time_gen = $time_gen;
        $this->time_header = $time_header;
        $this->auth_header = $auth_header;
    }

    public static function create(array $conf = []) {
        $conf = $conf + [
            'scheme' => 'Krak',
            'hasher' => null,
            'hs_gen' => null,
            'time_gen' => null,
            'time_header' => 'Date',
            'auth_header' => 'Authorization',
        ];
        $conf['hasher'] = $conf['hasher'] ?: new Base64HmacHasher(new StdHmacHasher());
        $conf['hs_gen'] = $conf['hs_gen'] ?: hmac_hashed_hs_gen();
        $conf['time_gen'] = $conf['time_gen'] ?: hmac_date_time_gen();

        return new self(
            $conf['scheme'],
            $conf['hasher'],
            $conf['hs_gen'],
            $conf['time_gen'],
            $conf['time_header'],
            $conf['auth_header']
        );
    }
}

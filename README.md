# Hmac

Hmac is a library for handling hmac authentication. Look at the source code for documentation.

## Usage

```php
<?php

use Krak\Hmac\Psr7HmacRequest,
    Krak\Hmac\HmacKeyPair,
    Krak\Hmac\ArrayHmacKeyPairProvider;

use function Krak\Hmac\hmac_sign_request,
    Krak\Hmac\hmac_auth_request;

// create the key pair of public and private keys
$keypair = new HmacKeyPair('public-key', 'private-key');

// wrap your request with the appropriate HmacRequest wrapper
$request = new Psr7HmacRequest($psr7_request);

// create the signer with default configuration
$sign = hmac_sign_request();

// sign the request
$request = $sign($request, $keypair);

// create a key pair provider for looking up the key pair used for the request
$provider = new ArrayHmacKeyPairProvider([$keypair]);

// we can authenticate a request now, by creating the authenticator with the
// same config as the signer (they need to match exactly)
$auth = hmac_auth_request($provider);

// authenticate the request
var_dump($auth($request));
// output: bool(true)
```

### HmacConfig

The `HmacConfig` is passed at creation to the signer and authenticator to allow total configuration of how the request is authed or signed. The same config needs to be provided to the sign and the auth for them to inverse each other.

Here are the options:

```php
<?php

use Krak\Hmac;

$config = Hmac\HmacConfig::create([
    'scheme' => 'CustomHmac', // authentication scheme. Authorization: <scheme> <public_key>:<hash>
    'hasher' => new Hmac\StdHmacHasher(), // any HmacHasher instance, defaults to Base64HmacHasher(StdHmacHasher)
    'hs_gen' => hmac\hmac_hashed_hs_gen(), // any hash string generator function
    'time_gen' => hmac\hmac_date_time_gen() // any time_gen function for generating a unit of time
    'time_header' => 'Date',
    'auth_header' => 'Authorization',
]);

$sign = hmac\hmac_sign_request($config);
$auth = hmac\hmac_auth_request($provider, $config);
```

### Hash String Generator

The hash string generators are functions that take the request and time value and generate the string that will end up being hashed.

provided `hs_gen` funcs:

    // returns a hs_gen that will md5 hash the content and join everything by the given separator
    hmac_hashed_hs_gen($sep = "\n");

example:

```php
<?php

function concat_hs_gen() {
    return function(Krak\Hmac\HmacRequest $req, $time) {
        return $req->getUri() . $time;
    };
}
```

### Time Generator

A time generator is just used to generate a time unit like a timestamp or date stamp.

provided `time_gen` funcs:

    // returns the `time` function which creates a unix timestamp
    hmac_ts_time_gen();

    // returns a time_gen which creates an RFC 2822  formatted date
    hmac_date_time_gen();

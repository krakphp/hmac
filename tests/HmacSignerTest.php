<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac,
    Symfony\Component\HttpFoundation\Request;

class HmacSignerTest extends TestCase
{
    /**
     * @dataProvider hmacSignerProvider
     */
    public function testSigner(Hmac\HmacSigner $signer)
    {
        $req = new Hmac\MockHmacRequest('content', 'uri', 'method');
        $key_pair = new Hmac\HmacKeyPair('pub', 'priv');
        $hasher = new Hmac\StdHmacHasher();

        $signer->signRequest($req, $key_pair, $hasher);
        $this->assertTrue($signer->validateRequest($req, $key_pair, $hasher));
    }

    public function hmacSignerProvider()
    {
        return [
            [new Hmac\ContentHmacSigner()],
            [new Hmac\RequestHmacSigner()],
        ];
    }
}

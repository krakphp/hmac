<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac;

class HmacManagerTest extends TestCase
{
    public function testManager()
    {
        $provider = new Hmac\ArrayHmacKeyPairProvider([
            new Hmac\HmacKeyPair('pub', 'priv')
        ]);
        $manager = new Hmac\HmacManager(
            new Hmac\ContentHmacSigner(),
            new Hmac\StdHmacHasher(),
            $provider
        );
        $req = new Hmac\MockHmacRequest('content', 'uri', 'method');
        $manager->signRequest($req, $provider->getKeyPairFromPublicKey('pub'));
        $this->assertTrue(
            $manager->validateRequest($req)
        );
    }
}

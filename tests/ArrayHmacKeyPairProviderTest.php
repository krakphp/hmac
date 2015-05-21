<?php

namespace Krak\Tests;

use Krak\Hmac\ArrayHmacKeyPairProvider,
    Krak\Hmac\HmacKeyPair,
    Krak\Tests\TestCase;

class ArrayHmacKeyPairProviderTest extends TestCase
{
    public function testConstruct()
    {
        $provider = new ArrayHmacKeyPairProvider([new HmacKeyPair('a', 'b')]);
        $this->assertNull($provider->getKeyPairFromPublicKey('b'));
    }

    /**
     * @depends testConstruct
     * @dataProvider keyPairProviderProvider
     */
    public function testGetKeyPairFromPublicKey(
        HmacKeyPair $a,
        ArrayHmacKeyPairProvider $provider
    ) {
        $this->assertSame($a, $provider->getKeyPairFromPublicKey('a-pub'));
    }

    /**
     * @depends testConstruct
     * @dataProvider keyPairProviderProvider
     */
    public function testGetKeyPairFromPublicKeyNull(
        HmacKeyPair $a,
        ArrayHmacKeyPairProvider $provider
    ) {
        $this->assertNull($provider->getKeyPairFromPublicKey('bad-key'));
    }

    public function keyPairProviderProvider()
    {
        $a = new HmacKeyPair('a-pub', 'a-priv');
        $provider = new ArrayHmacKeyPairProvider([
            $a,
            new HmacKeyPair('b-pub', 'b-priv'),
        ]);

        return [
            [$a, $provider]
        ];
    }
}

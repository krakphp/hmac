<?php

namespace Krak\Tests;

use Krak\Hmac\StdHmacHasher,
    Krak\Hmac\HmacKeyPair,
    Krak\Tests\TestCase;

class HmacHasherTest extends TestCase
{

    /**
     * @dataProvider keyPairProvider
     */
    public function testStdHmacHasher($content, HmacKeyPair $pair, $hash)
    {
        $hasher = new StdHmacHasher();

        $this->assertEquals($hash, $hasher->hashContent($content, $pair));
    }

    public function keyPairProvider()
    {
        return [
            [
                'content',
                new HmacKeyPair('public', 'private'),
                '45e61c977acc20329800c8f5be63e8a4bb128a8ecc0da15e270315b3c3915c7c'
            ]
        ];
    }
}

<?php

namespace Krak\Tests;

use Krak\Hmac\HmacKeyPair,
    Krak\Tests\TestCase;

class HmacKeyPairTest extends TestCase
{
    public function testKeyPair() {
        $pair = new HmacKeyPair('pub', 'priv');
        $equals = $pair->public_key == 'pub' && $pair->private_key == 'priv';
        $this->assertTrue($equals);
    }
}

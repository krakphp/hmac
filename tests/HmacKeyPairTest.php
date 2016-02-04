<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac\HmacKeyPair;

class HmacKeyPairTest extends TestCase
{
    public function testKeyPair() {
        $pair = new HmacKeyPair('pub', 'priv');
        $equals = $pair->public_key == 'pub' && $pair->private_key == 'priv';
        $this->assertTrue($equals);
    }
}

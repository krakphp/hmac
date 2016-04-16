<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function keyPair($pub = 'pub', $priv = 'priv') {
        return new Hmac\HmacKeyPair($pub, $priv);
    }
    protected function psr7Request() {
        return \Phake::mock('Psr\Http\Message\RequestInterface');
    }
}

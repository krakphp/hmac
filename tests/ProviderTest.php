<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac,
    Pimple\Container,
    RuntimeException;

class ProviderTest extends TestCase
{
    public function testRegister()
    {
        $c = new Container();
        $c->register(new Hmac\Provider\HmacServiceProvider(), [
            'krak.hmac.array_key_pair_provider.key_pairs' => []
        ]);

        $this->assertTrue(isset($c['krak.hmac.manager']));
    }

    /**
     * @dataProvider servicesProvider
     */
    public function testServices($container, $key, $classname)
    {
        $this->assertInstanceOf($classname, $container[$key]);
    }

    public function testRuntimeException()
    {
        $c = new Container();
        $c->register(new Hmac\Provider\HmacServiceProvider());

        try {
            $p = $c['krak.hmac.array_key_pair_provider'];
            $this->assertTrue(false);
        } catch (RuntimeException $e) {
            $this->assertTrue(true);
        }
    }

    public function servicesProvider()
    {
        $c = new Container();
        $c->register(new Hmac\Provider\HmacServiceProvider(), [
            'krak.hmac.array_key_pair_provider.key_pairs' => []
        ]);

        return [
            [$c, 'krak.hmac.manager', Hmac\HmacManager::class]
        ];
    }
}

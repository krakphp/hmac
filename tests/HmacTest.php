<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac;

use function Krak\Hmac\hmac_sign_request,
    Krak\Hmac\hmac_auth_request,
    Krak\Hmac\hmac_hashed_hs_gen,
    Krak\Hmac\hmac_ts_time_gen;

class HmacTest extends TestCase
{
    /**
     * @dataProvider publicKeyFromAuthHeaderProvider
     */
    public function testPublicKeyFromAuthHeader($header, $expected) {
        $this->assertEquals($expected, hmac\public_key_from_authorization_header($header));
    }

    public function publicKeyFromAuthHeaderProvider() {
        return [
            ['Basic PublicKey:somehash', 'PublicKey'],
            ['PublicKey:somehash', ''],
            ['Basic :somehash', ''],
            ['Test public:GET uri', 'public'],
            ['', ''],
        ];
    }

    public function testSignRequestAuthorizationTimestamp() {
        $hasher = new Hmac\ClosureHmacHasher(function() {
            return 'hash';
        });

        $sign = hmac\sign_request_authorization_timestamp($hasher, 'Basic');

        $req = new Hmac\MockHmacRequest('content', 'uri', 'GET', []);
        $pair = new Hmac\HmacKeyPair('public', 'private');

        $sign($req, $pair);

        $this->assertEquals('Basic public:hash', $req->getHeader('Authorization'));
    }

    public function testHmacSignRequest() {
        $config = Hmac\HmacConfig::create([
            'scheme' => 'Test',
            'hasher' => new Hmac\ClosureHmacHasher(function($content) { return $content; }),
            'time_gen' => function() { return 'time'; },
            'hs_gen' => function($req) { return $req->getMethod() . ' '. $req->getUri(); },
        ]);
        $sign = hmac_sign_request($config);

        $req = new Hmac\MockHmacRequest('content', 'uri', 'GET', []);
        $pair = new Hmac\HmacKeyPair('public', 'private');
        $req = $sign($req, $pair);

        $valid = 'Test public:GET uri' == $req->getHeader('Authorization') &&
            'time' == $req->getHeader('Date');

        $this->assertTrue($valid);

        return [$req, $config, $pair];
    }

    /** @depends testHmacSignRequest */
    public function testHmacAuthRequest($tup) {
        list($req, $config, $pair) = $tup;
        $provider = new Hmac\ArrayHmacKeyPairProvider([$pair]);
        $auth = hmac_auth_request($provider, $config);
        $this->assertTrue($auth($req));
    }

    public function testAuthRequestAuthorizationTimestamp() {
        $hasher = new Hmac\ClosureHmacHasher(function() {
            return 'hash';
        });
        $provider = new Hmac\ClosureHmacKeyPairProvider(function($pub) {
            return new Hmac\HmacKeyPair($pub, 'private');
        });

        $auth = hmac\auth_request_authorization_timestamp($hasher, $provider, 'Basic');

        $req = new Hmac\MockHmacRequest('content', 'uri', 'GET', [
            'Authorization' => 'Basic public:hash',
            'X-Timestamp' => '123',
        ]);

        $this->assertTrue($auth($req));
    }

    public function testHmacHashedHsGen() {
        $hs_gen = hmac_hashed_hs_gen('-');
        $req = new Hmac\MockHmacRequest('content', 'uri', 'GET');
        $hs = $hs_gen($req, 'time');

        $this->assertEquals('GET-uri-time-'.md5('content'), $hs);
    }

    public function testHmacTsTimeGen() {
        $time_gen = hmac_ts_time_gen();

        $this->assertEquals(time(), $time_gen());
    }

    public function testSignAuthTest() {
        $keypair = new Hmac\HmacKeyPair('public-key', 'private-key');
        $request = new Hmac\MockHmacRequest('content', 'uri', 'GET');
        $sign = hmac_sign_request();
        $request = $sign($request, $keypair);
        $provider = new Hmac\ArrayHmacKeyPairProvider([$keypair]);
        $auth = hmac_auth_request($provider);

        $this->assertTrue($auth($request));
    }
}

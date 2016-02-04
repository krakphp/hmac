<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac;

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
            ['PublicKey:somehash', 'PublicKey'],
            ['Basic :somehash', ''],
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
}

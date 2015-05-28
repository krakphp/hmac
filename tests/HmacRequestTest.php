<?php

namespace Krak\Tests;

use Krak\Hmac\HttpFoundationHmacRequest,
    Krak\Hmac\HmacRequest,
    Krak\Hmac\MockHmacRequest,
    Krak\Tests\TestCase,
    Symfony\Component\HttpFoundation\Request;

class HmacRequestTest extends TestCase
{
    public function testHttpFoundationConstruct()
    {
        $req = new HttpFoundationHmacRequest(new Request());
        $this->assertInstanceOf(HttpFoundationHmacRequest::class, $req);

        return $req;
    }

    /**
     * @depends testHttpFoundationConstruct
     */
    public function testHttpFoundationGetRequest(HttpFoundationHmacRequest $req)
    {
        $this->assertInstanceOf(Request::class, $req->getHttpRequest());
    }

    public function testMockConstruct()
    {
        $req = new MockHmacRequest('', '', '');
        $this->assertEquals('', $req->getContent());
    }

    /**
     * @dataProvider hmacRequestProvider
     */
    public function testRequest(HmacRequest $request) {
        $request->setPublicKey('pub-key');
        $request->setHash('hash');
        $request->setTimestamp('timestamp');

        $equals = $request->getPublicKey() == 'pub-key' &&
            $request->getHash() == 'hash' &&
            $request->getTimestamp() == 'timestamp' &&
            $request->getContent() == '';

        $this->assertTrue($equals);
    }

    public function hmacRequestProvider()
    {
        return [
            [new HttpFoundationHmacRequest(new Request())],
            [new MockHmacRequest('')],
        ];
    }
}

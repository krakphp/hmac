<?php

namespace Krak\Hmac\Tests;

use Krak\Hmac\HttpFoundationHmacRequest,
    Krak\Hmac\Psr7HmacRequest,
    Krak\Hmac\HmacRequest,
    Krak\Hmac\MockHmacRequest,
    Symfony\Component\HttpFoundation\Request,
    GuzzleHttp\Psr7;

class HmacRequestTest extends TestCase
{
    const URI = 'http://domain/part';

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

        $request->setHeader('key', 'value');

        $equals = $request->getPublicKey() == 'pub-key' &&
            $request->getHash() == 'hash' &&
            $request->getTimestamp() == 'timestamp' &&
            $request->getUri() == self::URI &&
            $request->getContent() == 'content' &&
            $request->getMethod() == 'GET' &&
            $request->getHeader('key') == 'value';

        $this->assertTrue($equals);
    }

    public function hmacRequestProvider()
    {
        $uri = self::URI;
        return [
            [new HttpFoundationHmacRequest(Request::create($uri, 'GET', [], [], [], [], 'content'))],
            [new MockHmacRequest('content', $uri, 'GET')],
            [new Psr7HmacRequest(new Psr7\Request('GET', $uri, [], 'content'))],
        ];
    }
}

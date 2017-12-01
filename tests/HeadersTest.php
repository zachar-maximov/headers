<?php

namespace Ivoba\Headers;

class HeadersTest extends \PHPUnit_Framework_TestCase
{
    public function testFromRequestHeaders()
    {
        $string  = file_get_contents(__DIR__ . '/Fixtures/Mail/request_headers.txt');

        $headers = Headers::fromString($string);

        $this->assertInstanceOf(Headers::class, $headers);
        $this->assertInstanceOf(StatusLine::class, $headers->getStatusLine());
        $this->assertInstanceOf(HeaderCollection::class, $headers->getHeaders());
        $this->assertEquals('POST', $headers->getStatusLine()->get(StatusLine::METHOD));
        $this->assertEquals('/Bang', $headers->getStatusLine()->get(StatusLine::REQUEST_URI));
        $this->assertEquals('HTTP/1.1', $headers->getStatusLine()->get(StatusLine::HTTP_VERSION));

        $this->assertNull($headers->getHeaders()->get('asdasd'));
        $this->assertEquals('www.url.com:3111', $headers->getHeaders()->get('host'));
        $this->assertEquals('Keep-Alive', $headers->getHeaders()->get('connection'));
    }

    public function testFromResponseHeaders()
    {
        $string  = file_get_contents(__DIR__ . '/Fixtures/Mail/response_headers.txt');

        $headers = Headers::fromString($string);

        $this->assertInstanceOf(Headers::class, $headers);
        $this->assertInstanceOf(StatusLine::class, $headers->getStatusLine());
        $this->assertInstanceOf(HeaderCollection::class, $headers->getHeaders());
        $this->assertEquals('HTTP/1.1', $headers->getStatusLine()->get(StatusLine::HTTP_VERSION));
        $this->assertEquals('200', $headers->getStatusLine()->get(StatusLine::STATUS_CODE));
        $this->assertEquals('OK', $headers->getStatusLine()->get(StatusLine::REASON_PHRASE));

        $this->assertNull($headers->getHeaders()->get('asdasd'));
        $this->assertEquals('782420', $headers->getHeaders()->get('content-length'));
        $this->assertEquals('Microsoft-HTTPAPI/2.0', $headers->getHeaders()->get('server'));
    }
}
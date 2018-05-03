<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     03/05/2018
// Time:     11:39
// Project:  FaviconMiddleware
//
declare(strict_types=1);
namespace CodeInc\FaviconMiddleware\Tests;
use CodeInc\FaviconMiddleware\Assets\FaviconProxyResponse;
use CodeInc\FaviconMiddleware\FaviconProxyMiddleware;
use CodeInc\MiddlewareTestKit\FakeRequestHandler;
use CodeInc\MiddlewareTestKit\FakeServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


/**
 * Class FaviconProxyMiddlewareTest
 *
 * @uses FaviconProxyMiddleware
 * @package CodeInc\FaviconMiddleware\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class FaviconProxyMiddlewareTest extends TestCase
{
    private const REMOTE_FAVICON = 'https://static.codeinc.fr/logo/v1/favicon/favicon.ico';

    /**
     * @throws \CodeInc\FaviconMiddleware\FaviconMiddlewareException
     */
    public function testMiddleware():void
    {
        $middleware = new FaviconProxyMiddleware(self::REMOTE_FAVICON);

        $response = $middleware->process(
            FakeServerRequest::getUnsecureServerRequestWithPath('/favicon.ico'),
            new FakeRequestHandler()
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(FaviconProxyResponse::class, $response);

        $bodyStream = $response->getBody()->detach();
        self::assertInternalType('resource', $bodyStream);

        self::assertNotFalse($body = stream_get_contents($bodyStream));
        self::assertNotEmpty($body);
        self::assertEquals(strlen($body), $response->getHeaderLine('Content-Length'));
        self::assertTrue(fclose($bodyStream));
    }

    /**
     * @throws \CodeInc\FaviconMiddleware\FaviconMiddlewareException
     */
    public function testNotFaviconRequest():void
    {
        $middleware = new FaviconProxyMiddleware(self::REMOTE_FAVICON);
        $response = $middleware->process(
            FakeServerRequest::getUnsecureServerRequestWithPath('/page1.html'),
            new FakeRequestHandler()
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertNotInstanceOf(FaviconProxyResponse::class, $response);
    }

    /**
     * @expectedException \CodeInc\FaviconMiddleware\FaviconMiddlewareException
     */
    public function testFakeUrl():void
    {
        new FaviconProxyMiddleware('a-fake-url');
    }
}
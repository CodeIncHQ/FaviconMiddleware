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
// Date:     02/05/2018
// Time:     17:35
// Project:  RobotsTxtMiddleware
//
declare(strict_types=1);
namespace CodeInc\RobotsTxtMiddleware\Tests;
use CodeInc\FaviconMiddleware\Assets\FaviconResponse;
use CodeInc\FaviconMiddleware\FaviconMiddleware;
use CodeInc\FaviconMiddleware\FaviconMiddlewareException;
use CodeInc\MiddlewareTestKit\FakeRequestHandler;
use CodeInc\MiddlewareTestKit\FakeServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


/**
 * Class FaviconMiddlewareTest
 *
 * @uses FaviconMiddleware
 * @package CodeInc\RobotsTxtMiddleware\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class FaviconMiddlewareTest extends TestCase
{
    private const LOCAL_FAVICON = __DIR__.'/assets/favicon.ico';

    /**
     * @throws FaviconMiddlewareException
     */
    public function testLocalFavicon():void
    {
        self::assertFileExists(self::LOCAL_FAVICON);
        self::assertFileIsReadable(self::LOCAL_FAVICON);

        $faviconMiddleware = new FaviconMiddleware(self::LOCAL_FAVICON);
        $response = $faviconMiddleware->process(
            FakeServerRequest::getUnsecureServerRequestWithPath(FaviconMiddleware::DEFAULT_URI_PATH),
            new FakeRequestHandler()
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(FaviconResponse::class, $response);
        self::assertEquals($response->getHeaderLine('Content-Type'), 'image/x-icon');
        self::assertEquals($response->getHeaderLine('Content-Length'), filesize(self::LOCAL_FAVICON));
        self::assertEquals($response->getBody()->__toString(), file_get_contents(self::LOCAL_FAVICON));
    }

    /**
     * @throws FaviconMiddlewareException
     */
    public function testNotFaviconRequest():void
    {
        self::assertFileExists(self::LOCAL_FAVICON);
        self::assertFileIsReadable(self::LOCAL_FAVICON);

        $faviconMiddleware = new FaviconMiddleware(self::LOCAL_FAVICON);
        $response = $faviconMiddleware->process(
            FakeServerRequest::getUnsecureServerRequestWithPath('/page1.html'),
            new FakeRequestHandler()
        );

        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertNotInstanceOf(FaviconResponse::class, $response);
    }

    /**
     * @expectedException \CodeInc\FaviconMiddleware\FaviconMiddlewareException
     * @throws FaviconMiddlewareException
     */
    public function testConstructorFilePathError():void
    {
        new FaviconMiddleware('/a/fake/favicon.ico');
    }

    /**
     * @throws FaviconMiddlewareException
     */
    public function testHtmlMetaTag():void
    {
        $faviconMiddleware = new FaviconMiddleware(self::LOCAL_FAVICON);
        self::assertEquals($faviconMiddleware->getHtmlMetaTag(),
            '<link rel="shortcut icon" href="/favicon.ico">');
    }

    /**
     * @expectedException \CodeInc\FaviconMiddleware\FaviconMiddlewareException
     * @throws FaviconMiddlewareException
     */
    public function testMethodFilePathError():void
    {
        $faviconMiddleware = new FaviconMiddleware(self::LOCAL_FAVICON);
        $faviconMiddleware->setFaviconFilePath('/a/fake/favicon.ico');
    }
}
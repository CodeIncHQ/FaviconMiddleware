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
// Time:     10:53
// Project:  FaviconMiddleware
//
declare(strict_types=1);
namespace CodeInc\FaviconMiddleware;
use CodeInc\RobotsTxtMiddleware\Tests\FaviconMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class AbstractFaviconMiddleware
 *
 * @see FaviconMiddlewareTest
 * @package CodeInc\FaviconMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
abstract class AbstractFaviconMiddleware implements MiddlewareInterface
{
    public const DEFAULT_URI_PATH = '/favicon.ico';

    /**
     * @var string
     */
    protected $uriPath;

    /**
     * AbstractFaviconMiddleware constructor.
     *
     * @param string $uriPath
     */
    public function __construct(string $uriPath = self::DEFAULT_URI_PATH)
    {
        $this->uriPath = $uriPath;
    }

    /**
     * Returns the favicon URI path.
     *
     * @return string
     */
    public function getUriPath():string
    {
        return $this->uriPath;
    }

    /**
     * Returns the response for a favicon request.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    abstract protected function getFavicon(ServerRequestInterface $request):ResponseInterface;

    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        if ($this->isFaviconRequest($request)) {
            return $this->getFavicon($request);
        }
        else {
            return $handler->handle($request);
        }
    }

    /**
     * Checks if the request is targeting the favicon (/favicon.ico or on of the URI paths listed in
     * the $faviconUriPaths property).
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isFaviconRequest(ServerRequestInterface $request):bool
    {
        return $request->getUri()->getPath() == $this->uriPath;
    }

    /**
     * Returns the HTML meta tag.
     *
     * @return string
     */
    public function getHtmlMetaTag():string
    {
        return '<link rel="shortcut icon" href="'.htmlspecialchars($this->uriPath).'">';
    }
}
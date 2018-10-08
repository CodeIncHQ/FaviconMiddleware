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
use CodeInc\FaviconMiddleware\Assets\FaviconProxyResponse;
use CodeInc\FaviconMiddleware\Tests\FaviconProxyMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class FaviconProxyMiddleware
 *
 * @see FaviconProxyMiddlewareTest
 * @package CodeInc\FaviconMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
class FaviconProxyMiddleware extends AbstractFaviconMiddleware
{
    /**
     * @var string
     */
    private $remoteFaviconUrl;

    /**
     * FaviconProxyMiddleware constructor.
     *
     * @param string $remoteFaviconUrl
     * @param string $uriPath
     * @throws FaviconMiddlewareException
     */
    public function __construct(string $remoteFaviconUrl, string $uriPath = self::DEFAULT_URI_PATH)
    {
        parent::__construct($uriPath);
        $this->setRemoteFaviconUrl($remoteFaviconUrl);
    }

    /**
     * Sets the remote favicon
     *
     * @param string $remoteFaviconUrl
     * @throws FaviconMiddlewareException
     */
    public function setRemoteFaviconUrl(string $remoteFaviconUrl):void
    {
        if (!filter_var($remoteFaviconUrl, FILTER_VALIDATE_URL)) {
            throw new FaviconMiddlewareException(
                sprintf("%s is not a valid URL", $remoteFaviconUrl),
                $this
            );
        }
        $this->remoteFaviconUrl = $remoteFaviconUrl;
    }

    /**
     * @return string
     */
    public function getRemoteFaviconUrl():string
    {
        return $this->remoteFaviconUrl;
    }

    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getFavicon(ServerRequestInterface $request):ResponseInterface
    {
        return new FaviconProxyResponse($this->remoteFaviconUrl);
    }
}
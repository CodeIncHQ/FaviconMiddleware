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
use CodeInc\FaviconMiddleware\Assets\FaviconResponse;
use CodeInc\RobotsTxtMiddleware\Tests\FaviconMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class FaviconMiddleware
 *
 * @see FaviconMiddlewareTest
 * @package CodeInc\FaviconMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
class FaviconMiddleware extends AbstractFaviconMiddleware
{
    /**
     * @var string
     */
    private $faviconFilePath;

    /**
     * FaviconMiddleware constructor.
     *
     * @param string      $faviconFilePath
     * @param string $uriPath
     * @throws FaviconMiddlewareException
     */
    public function __construct(string $faviconFilePath, string $uriPath = self::DEFAULT_URI_PATH)
    {
        parent::__construct($uriPath);
        $this->setFaviconFilePath($faviconFilePath);
    }

    /**
     * Sets the favicon file path. The path must be valid and readable.
     *
     * @param string $faviconFilePath
     * @throws FaviconMiddlewareException
     */
    public function setFaviconFilePath(string $faviconFilePath):void
    {
        if (!file_exists($faviconFilePath)) {
            throw new FaviconMiddlewareException(
                sprintf("The file %s does not exist", $faviconFilePath),
                $this
            );
        }
        if (!is_readable($faviconFilePath)) {
            throw new FaviconMiddlewareException(
                sprintf("The file %s is not readable", $faviconFilePath),
                $this
            );
        }
        $this->faviconFilePath = $faviconFilePath;
    }

    /**
     * Returns the favicon file path.
     *
     * @return string
     */
    public function getFaviconFilePath():string
    {
        return $this->faviconFilePath;
    }

    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     * @throws \CodeInc\Psr7Responses\ResponseException
     */
    protected function getFavicon(ServerRequestInterface $request):ResponseInterface
    {
        return new FaviconResponse($this->faviconFilePath);
    }
}
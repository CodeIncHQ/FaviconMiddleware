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
// Time:     10:55
// Project:  FaviconMiddleware
//
declare(strict_types=1);
namespace CodeInc\FaviconMiddleware\Assets;
use CodeInc\Psr7Responses\LocalFileResponse;


/**
 * Class FaviconResponse
 *
 * @package CodeInc\FaviconMiddleware\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
class FaviconResponse extends LocalFileResponse
{
    /**
     * FaviconResponse constructor.
     *
     * @param string $filePath
     * @param int $code
     * @param string $reasonPhrase
     * @param string $fileName
     * @param null|string $contentType
     * @param int|null $contentLength
     * @param bool $asAttachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
    public function __construct(string $filePath, int $code = 200, string $reasonPhrase = '',
        string $fileName = 'favicon.ico', ?string $contentType = null, ?int $contentLength = null,
        bool $asAttachment = true, array $headers = [], string $version = '1.1')
    {
        parent::__construct($filePath, $code, $reasonPhrase, $fileName, $contentType, $contentLength, $asAttachment,
            $headers, $version);
    }
}
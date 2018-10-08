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
use CodeInc\Psr7Responses\FileResponse;


/**
 * Class FaviconResponse
 *
 * @package CodeInc\FaviconMiddleware\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
class FaviconResponse extends FileResponse
{
    /**
     * FaviconResponse constructor.
     *
     * @param $file
     * @param string $fileName
     * @param int $code
     * @param string $reasonPhrase
     * @param null|string $contentType
     * @param bool $asAttachment
     * @param array $headers
     * @param string $version
     * @throws \CodeInc\MediaTypes\Exceptions\MediaTypesException
     */
    public function __construct($file, string $fileName = 'favicon.ico', int $code = 200, string $reasonPhrase = '',
        ?string $contentType = null, bool $asAttachment = true, array $headers = [], string $version = '1.1')
    {
        parent::__construct($file, $fileName, $code, $reasonPhrase, $contentType, $asAttachment, $headers, $version);
    }
}
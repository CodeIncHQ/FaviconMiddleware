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
// Time:     10:56
// Project:  FaviconMiddleware
//
declare(strict_types=1);
namespace CodeInc\FaviconMiddleware;
use Throwable;


/**
 * Class FaviconMiddlewareException
 *
 * @package CodeInc\FaviconMiddleware
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @link https://github.com/CodeIncHQ/FaviconMiddleware
 * @license MIT <https://github.com/CodeIncHQ/FaviconMiddleware/blob/master/LICENSE>
 */
class FaviconMiddlewareException extends \Exception
{
    /**
     * @var AbstractFaviconMiddleware
     */
    private $faviconMiddleware;

    /**
     * FaviconMiddlewareException constructor.
     *
     * @param string                    $message
     * @param AbstractFaviconMiddleware $faviconMiddleware
     * @param int                       $code
     * @param Throwable|null            $previous
     */
    public function __construct(string $message, AbstractFaviconMiddleware $faviconMiddleware,
        int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->faviconMiddleware = $faviconMiddleware;
    }

    /**
     * @return AbstractFaviconMiddleware
     */
    public function getFaviconMiddleware():AbstractFaviconMiddleware
    {
        return $this->faviconMiddleware;
    }
}
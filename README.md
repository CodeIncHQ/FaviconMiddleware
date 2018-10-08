# Favicon PSR-15 middleware 

This PHP 7.1 library is a [PSR-15](https://www.php-fig.org/psr/psr-15/) middleware didecated to answers `/favicon.ico` requests. Two middleware classes are included: 
* [`FaviconMiddleware`](src/FaviconMiddleware.php) anwsers sending a local favicon file
* [`FaviconProxyMiddleware`](src/FaviconProxyMiddleware.php) anwsers sending a remote favicon file downloadable via HTTP(S)


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/favicon-middleware) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/favicon-middleware
```


## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).
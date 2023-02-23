# Zonda PHP API

[![StyleCi](https://github.styleci.io/repos/594166518/shield)](https://github.styleci.io/repos/594166518)
[![Tests](https://github.com/lukaszoramus/zonda-php-api/actions/workflows/tests.yml/badge.svg)](https://github.com/lukaszoramus/zonda-php-api/actions/workflows/tests.yml)

## Installation

This version supports PHP 8.1. To get started require the project using Composer. 
You will probably also need install one of packages that provide "psr/http-client-implementation" e.g. `guzzlehttp/guzzle`

```bash
$ composer require "lukaszoramus/zonda-php-api:^0.2" "guzzlehttp/guzzle:^7.5"
```

## How to use

```php
use ZondaPhpApi\Client;

$client = new Client();
$client->authenticate('yourPublicApiKey', 'yourPrivateApiKey'); // Not required if you use only public endpoints

// Example call
$client->trading()->ticker('BTC-PLN');
```

## License

Zonda PHP API is licensed under [The MIT License (MIT)](LICENSE).

journify-php-sdk
================
[![CI](https://github.com/journifyio/journify-php-sdk/actions/workflows/ci.yml/badge.svg)](https://github.com/journifyio/journify-php-sdk/actions/workflows/ci.yml)

## Installation

The package can be installed via composer.

```sh
composer require journify/journify-php
```

## Documentation

The links bellow should provide all the documentation needed to make the best use of the library:

- [Docs](https://docs.journify.io/sources/php)
- [Specs](https://docs.journify.io/tracking)

## Usage

```php
use Journify\Journify;

Journify::init('WRITE_KEY');

Journify::track([
  'event' => 'add_to_cart',
  'userId' => 'user123',
  'properties' => [
    'currency' => 'USD',
    'value' => 29.99,
    'items' => [
      [
        'item_id' => 'SKU12345',
        'item_name' => 'T-shirt',
        'price' => 29.99,
        'quantity' => 1,
      ],
    ],
  ],
]);
```

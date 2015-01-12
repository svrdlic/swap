# Swap [![Build status][travis-image]][travis-url] [![Version][version-image]][version-url]

> Exchange rates library for PHP 5.4+

## Installation

```bash
$ composer require florianv/swap
```

## Usage

First, you need to create an HTTP adapter provided by the [egeloen/ivory-http-adapter](https://github.com/egeloen/ivory-http-adapter)
library.

```php
$httpAdapter = new \Ivory\HttpAdapter\FileGetContentsHttpAdapter();
```

Then, you can create a provider and add it to Swap:

```php
// Create the Yahoo Finance provider
$yahooProvider = new \Swap\Provider\YahooFinanceProvider($httpAdapter);

// Create Swap with the provider
$swap = new \Swap\Swap($yahooProvider);
```

### Quoting

To retrieve the latest exchange rate for a currency pair, you need to use the `quote()` method.

```php
$rate = $swap->quote('EUR/USD');
// or $swap->quote(new \Swap\Model\CurrencyPair('EUR', 'USD')));

// 1.187220
echo $rate;

// 1.187220
echo $rate->getValue();

// 15-01-11 21:30:00
echo $rate->getDate()->format('Y-m-d H:i:s');
```

> Currencies are expressed as their [ISO 4217](http://en.wikipedia.org/wiki/ISO_4217) code.

### Chaining providers

It is possible to chain providers in order to use fallbacks in case the main providers don't support the currency or are unavailable.
Simply create a `ChainProvider` wrapping the providers you want to chain.

```php
$chainProvider = new \Swap\Provider\ChainProvider([
    new \Swap\Provider\YahooFinanceProvider($httpAdapter),
    new \Swap\Provider\GoogleFinanceProvider($httpAdapter)
]);
```

The rates will be first fetched using the Yahoo Finance provider and will fallback to Google Finance.

### Caching

For performance reasons you might want to cache the rates during a given time. Currently Swap allows you to use the 
[doctrine/cache](https://github.com/doctrine/cache) library as caching provider.

```php
// Create the cache adapter
$cache = new \Swap\Cache\DoctrineCache(new \Doctrine\Common\Cache\ApcCache(), 3600);

// Pass the cache to Swap
$swap = new \Swap\Swap($provider, $cache);
```

All rates will now be cached in APC during 3600 seconds.

### Currency Codes

Swap provides an enumeration of currency codes so you can use autocompletion to avoid typos.

```php
use \Swap\Util\CurrencyCodes;

// Retrieving the EUR/USD rate
$rate = $swap->quote(new \Swap\Model\CurrencyPair(
    CurrencyCodes::ISO_EUR,
    CurrencyCodes::ISO_USD
));
```

## Integrations

- A Symfony2 bundle [FlorianvSwapBundle](https://github.com/florianv/FlorianvSwapBundle).

## Providers

- [European Central Bank](http://www.ecb.europa.eu/home/html/index.en.html)
Supports only EUR as base currency.
- [Google Finance](http://www.google.com/finance)
Supports multiple currencies as base and quote currencies.
- [Open Exchange Rates](https://openexchangerates.org)
Supports only USD as base currency for the free version and multiple ones for the enterprise version.
- [Xignite](https://www.xignite.com)
You must have access to the `XigniteGlobalCurrencies` API.
Supports multiple currencies as base and quote currencies.
- [Yahoo Finance](https://finance.yahoo.com/)
Supports multiple currencies as base and quote currencies.
- [WebserviceX](http://www.webservicex.net/ws/default.aspx)
Supports multiple currencies as base and quote currencies.
- [NationalBankOfRomania](http://www.bnr.ro)
Supports only RON as base currency.

## License

[MIT](https://github.com/florianv/swap/blob/master/LICENSE)

[travis-url]: https://travis-ci.org/florianv/swap
[travis-image]: http://img.shields.io/travis/florianv/swap.svg?style=flat

[version-url]: https://packagist.org/packages/florianv/swap
[version-image]: http://img.shields.io/packagist/v/florianv/swap.svg?style=flat

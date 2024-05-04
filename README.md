## Installation

You can install the package via composer:

```bash
composer require ismaelillodev/filament-scraper-plugin:dev-main
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-scraper-plugin-migrations"
php artisan migrate
```

## Usage

Create your WebScrapperResource that extends from WebScrapperResource of the package to register it in you filament.

Make sure that the models you want to scrape implements the IsScrapable interface.

## Credits

- [ismaelilloDev](https://github.com/ismaelilloDev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

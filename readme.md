# magadanuhak/laravel-provably-fair
Laravel ProvablyFair is a package that permits to generate random numbers using clientSeed - a string from frontend and serverSeed - a string from backend.

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


If you know clientSeed, serverSeed and nonce you can generate the same random number.
Nonce is a countable number that is used to count how much times the same clientSeed and serverSeed was used.

## Installation

Use the composer package manager [composer](https://getcomposer.org/download/) to install package.

```bash
composer require magadanuhak/laravel-provably-fair
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)






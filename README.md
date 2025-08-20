# Laravel Actor is Online

[![Latest Version on Packagist](https://img.shields.io/packagist/v/djl997/laravel-actor-is-active.svg?style=flat-square)](https://packagist.org/packages/djl997/laravel-actor-is-active)
[![Total Downloads](https://img.shields.io/packagist/dt/djl997/laravel-actor-is-active.svg?style=flat-square)](https://packagist.org/packages/djl997/laravel-actor-is-active)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This package provides a simple and easy way to check if an _Actor_ in your application is active or was active recently. In most cases _Actor_ will be your app user, but in some cases it can be some logic like a bot, variable Cronjob, Queue or another external proces you want to monitor.

The package doesn't require any database migrations because it's built on the [Laravel Cache Driver](https://laravel.com/docs/cache).


## Requirements
Laravel Actor is Online requires PHP 8.2 or higher and Laravel 11+.

## Installation
1. You can install the package via composer:

    ```sh
    composer require djl997/laravel-actor-is-active
    ```

2. Prepare your actor model:
    ```php
    namespace App\Models;

    use Djl997\LaravelActorIsActive\Traits\IsOnlineTrait;

    class Actor {

        use IsOnlineTrait;

        // ..

    }
    ```

3. Set online status
    - [Route Middleware (recommended for Auth)](#route-middleware-recommended-for-authenticables)
    - [Manually](#manually)


### Route Middleware (recommended for Authenticables)

Activate the middleware to automatically update the online status of Users in your application, add the following to your `app/Http/Kernel.php` file:

```php
protected $middlewareGroups = [
    'web' => [
        // ..
        \Djl997\LaravelActorIsActive\Http\Middleware\IsOnline::class,
    ]
];
```

### Manually

If you want to update the status manually or if middleware is not applicable in your case:

```php
$model = Model::find(1);

$model->touchOnline();
```

## Advanced Usage

```php
$user = User::find(1);

$user->isOnline(); // returns true if user is online
$user->wasOnlineRecently(); // returns true if user was inline x minutes ago (by default 5-30 minutes, customizable via config)
$user->lastOnlineAt(); // returns Carbon object of last online timestamp
$user->getCacheActorOnlineKey(); // get the online cache key

```

## Contributing

Contributions are welcome.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
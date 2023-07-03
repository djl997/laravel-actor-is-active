# Laravel Actor is Online
This package provides a simple and easy way to check if an _Actor_ in your application is active or was active recently. In most cases _Actor_ will be an user, but in some cases it can be some logic like a variable Cronjob, Queue or external proces you want to monitor.
The package doesn't require any database migrations because it's built on the [Laravel Cache Driver](https://laravel.com/docs/cache).


## Requirements
Laravel Actor is Online requires PHP 8+ and Laravel x+.

## Installation
You can install the package via composer:

```bash
composer require djl997/...
```

Prepare your actor model:
```php
use Djl997\LaravelActorIsActive\Traits\IsOnlineTrait;

class Actor {

    use IsOnlineTrait;

    //..

}
```


## Usage

- [Route Middleware (recommended for Auth)](#route-middleware-recommended-for-authenticables)
- [Manually]()


### Route Middleware (recommended for Authenticables)
...

```php
protected $middlewareGroups = [
    'web' => [
        // ..
        \Djl997\LaravelActorIsActive\Http\Middleware\IsOnline::class,
    ]
];
```

### Manually

```php



```
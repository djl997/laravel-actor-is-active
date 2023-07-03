# Laravel Actor is Online
This package provides a simple and easy way to check if an _Actor_ in your application is active or was active recently. In most cases _Actor_ will be an user, but in some cases it can be some logic like a variable Cronjob, Queue or external proces you want to monitor.
The package doesn't require any database migrations because it's built on the [Laravel Cache Driver](https://laravel.com/docs/cache).


## Requirements
Laravel Actor is Online requires PHP 8+ and Laravel 6+.

## Installation
You can install the package via composer:

```bash
composer require djl997/laravel-actor-is-active
```

Prepare your actor model:
```php
namespace App\Models;

use Djl997\LaravelActorIsActive\Traits\IsOnlineTrait;

class Actor {

    use IsOnlineTrait;

    // ..

}
```


## Usage
Set online status
- [Route Middleware (recommended for Auth)](#route-middleware-recommended-for-authenticables)
- [Manually](#manually)
- [Available methods]()



### Route Middleware (recommended for Authenticables)


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
$user = User::find(1);

$user->touchOnline();
```

### Available Methods
```php
$user = User::find(1);

$user->isOnline(); // returns true if user is online
$user->wasOnlineRecently(); // returns true if user was inline x minutes ago (by default 5-30 minutes, customizable via config)
$user->lastOnlineAt(); // returns Carbon object of last online timestamp
$user->getCacheActorOnlineKey(); // get the online cache key

```
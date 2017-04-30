# FoxTail
Simple server and website for "Where is the Fox data aggregator", based on [Frameworkless](https://github.com/mmeyer724/Frameworkless) micro-framework

#### What's included?
* **[nikic/fast-route](https://github.com/nikic/FastRoute)**
  * Popular routing library used by frameworks like [Slim](http://www.slimframework.com).  
* **[filp/whoops](https://github.com/filp/whoops)**
  * Stunning error handler, it makes errors sting a bit less.  
* **[symfony/http-foundation](https://github.com/symfony/http-foundation)**
  * Simplifies request & reponse handling.
* **[league/container](https://github.com/thephpleague/container)**
  * Dependency injection container, for sharing common resources (like a database connection).
* **[twig/twig](https://github.com/twigphp/Twig)**
  * The rock solid templating engine used by Symfony and many others.
* **[vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)**
  * Please don't push your database credentials to GitHub.
* **[cloudinary/cloudinary_php](https://github.com/cloudinary/cloudinary_php)**
  * PHP extension for Cloudinary cloud service.
* **[cmfcmf/openweathermap-php-api](https://github.com/cmfcmf/openweathermap-php-api)**
  * A PHP API to parse weather data and weather history from OpenWeatherMap.org.

## Developer setup

#### Prerequisites
* [Vagrant](https://www.vagrantup.com)
* [VirtualBox](https://www.virtualbox.org)
* [composer](https://getcomposer.org)

#### Steps
1. `git clone` this repository
2. `cd` into the cloned repository
3. `composer install`
4. `cp misc/.env.example .env`
6. `vagrant up`

From here, you should be able to access http://localhost:8080/. This website is served using NGINX & PHP 7.

<!-- ## Batteries not included
I've intentionally made this project as simplistic as possible. A lot of things are left up to you to design and implement. On the plus side, you won't have to remove much boilerplate.

Below you will find instructions on how to implement a few things, feel free to contribute more examples :).

### PDO (database)
Edit `bootstrap/app.php` and add the following:
```php
$container
    ->add('PDO')
    ->withArgument(getenv('DB_CONN'))
    ->withArgument(getenv('DB_USER'))
    ->withArgument(getenv('DB_PASS'));
```

You will also need to add some values to your `.env`
```
# Database access
DB_CONN=mysql:host=127.0.0.1;dbname=frameworkless;charset=utf8
DB_USER=fwl_user
DB_PASS=hopefullysecure
```

Now, from a controller:
```php
private $pdo;

public function __construct(PDO $pdo)
{
    $this->pdo = $pdo;
}

public function get()
{
    $handle = $this->pdo->prepare('SELECT * FROM `todos`');
    $handle->execute();
    return new JsonResponse($handle->fetchAll(PDO::FETCH_ASSOC));
}
```

### Spot (database, ORM)
```
composer require vlucas/spot2
```

from here, edit `bootstrap/app.php` and add the following:
```php
$db = new \Spot\Config();
$db->addConnection('mysql', [
    'dbname'   => getenv('DB_NAME'),
    'user'     => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'host'     => getenv('DB_HOST')
]);

$container
    ->add('\Spot\Locator')
    ->withArgument($db);
```

You will also need to add some values to your `.env`
```
# Database access
DB_CONN=mysql:host=127.0.0.1;dbname=frameworkless;charset=utf8
DB_USER=fwl_user
DB_PASS=hopefullysecure
```

Now you can create models! I recommend adding them under a src/Models directory for separation. For example, `src/Models/Posts.php`:
```php
namespace Frameworkless\Models;

use Spot\Entity;

class Posts extends Entity
{
    protected static $table = 'posts';
    // etc.
}
```

And finally from your controller:
```php
private $spot;

public function __construct(\Spot\Locator $spot)
{
    $this->spot = $spot;
}

public function get()
{
    $posts = $this->spot->mapper('Frameworkless\Models\Posts')->all();
    return new Response('Here are your posts ' . print_r($posts, true));
}
```
-->

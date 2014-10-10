# Language Middleware

Language Middleware for the Slim framework.

This middleware parses the HTTP Accept-Language header and converts it into an array ordered by language preference.

## How to install

Update your `composer.json` manifest to require the `mnlg/language-middleware` package (see below).
Run `composer install` or `composer update` to update your local vendor folder.

    {
        "require": {
            "mnlg/language-middleware": "*"
        }
    }

## How to use

Add the middleware to your Slim application, and access the languages array from within your routes through `$app->acceptLanguages`.

    <?php
    require 'vendor/autoload.php';

    $app = new \Slim\Slim();
    $app->add(new \Mnlg\Middleware\Language());

    $app->get('/', function() use ($app) {
        var_dump($app->acceptLanguages);
    });

    $app->run();

## License

All code in this repository is released under the MIT public license.

<http://opensource.org/licenses/MIT>
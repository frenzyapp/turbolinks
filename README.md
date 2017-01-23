Frenzy Turbolinks for Laravel 5.*
=================================

Frenzy Turbolinks is a port of the Rails [turbolinks](https://github.com/turbolinks/turbolinks-rails) gem
for projects using the PHP [Laravel](http://laravel.com) 5 framework.

## Versions

Current versions of the following JavaScript libraries are used:

 * turbolinks: v5.0.0

For [**Laravel 4.1 or 4.2**](http://laravel.com/docs/4.2) supports see [Frenzy Turbolinks `1.0` tag](https://github.com/frenzyapp/turbolinks/tree/1.0)

## Performance

Turbolinks makes following links in your web application faster. Instead of letting
the browser recompile the JavaScript and CSS between each page change, it keeps
the current page instance alive and replaces only the body and the title in the head.

Performance improvements will vary depending on the amount of CSS and Javascript
you are using. You can get up to a 2X increase when using a lot of Javascript and
CSS. You can find the Rails benchmarks [here](https://stevelabnik/turbolinks_test).

## Installation

### Using [Composer](https://getcomposer.org)

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "frenzy/turbolinks": "dev-master"
    }
}
```

Run this command in a terminal:
```bash
composer update frenzy/turbolinks
```

Add `'Frenzy\Turbolinks\TurbolinksServiceProvider', ` to the `providers` array in `config/app.php`.

Add the Turbolinks middleware, to the `$middleware` array in `app/Http/Kernel.php`:
```php
        'Frenzy\Turbolinks\Middleware\StackTurbolinks',
```

Add these scripts for automatic publication of assets, in your `composer.json` file:

```json
{
   "scripts": {
       "post-install-cmd": [
           "php artisan vendor:publish --provider=\"Frenzy\\Turbolinks\\TurbolinksServiceProvider\" --force"
       ],
       "post-update-cmd": [
           "php artisan vendor:publish --provider=\"Frenzy\\Turbolinks\\TurbolinksServiceProvider\" --force"
       ]
   }
}
```

Add Javascript files into your project

## Usage

Using turbolinks requires both the usage of the javascript library and the event listeners included with the component.

### Javascripts

Both the original coffeescript version and compiled version of each script are available for use.

#### Using turbolinks.js

To enable turbolinks, all you need to do is add the compiled turbolinks javascript to your layout in the `<head>`section.

## Installation with the Larasset package

Click [here](README_LARASSET.md) to publish the assets automatically.

## Compatibility

The turbolinks javascript is designed to work with any browser that fully supports
pushState and all the related APIs. This includes Safari 6.0+ (but not Safari 5.1.x!),
IE10+, and latest Chrome and Firefox.

Do note that existing JavaScript libraries may not all be compatible with
Turbolinks out of the box due to the change in instantiation cycle. You might
very well have to modify them to work with Turbolinks' new set of events. For
help with this, check out the [Turbolinks Compatibility project](http://reed.github.io/turbolinks-compatibility).

## Additional Resources

Please refer to the [turbolinks](https://github.com/turbolinks/turbolinks-rails) project
if you require additional information on the javascript libraries and their usage.

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/frenzyapp/turbolinks/issues/new).

## Credits

This package is based on the Symfony middleware package [Helthe Turbolinks](https://github.com/helthe/Turbolinks).

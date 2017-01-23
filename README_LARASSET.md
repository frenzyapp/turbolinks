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

Add `'Frenzy\Turbolinks\TurbolinksServiceProvider', ` to the `providers` array in `config/app.php`
**after** [Larasset](https://github.com/efficiently/larasset/tree/1.0) one.

Add the Turbolinks middleware, to the `$middleware` array in `app/Http/Kernel.php`:
```php
        'Frenzy\Turbolinks\Middleware\StackTurbolinks',
```

## Usage with the [Larasset](https://github.com/efficiently/larasset/tree/1.0) package

If you have installed the [Larasset](https://github.com/efficiently/larasset/tree/1.0) package:

The `turbolinks.js` file will be added to the asset pipeline and available for you to use.

Add these lines in your `resource/assets/js/app.js` file, in this order:

```js
//= require jquery
//= require jquery_ujs
//
// ... your other scripts here ...
//
//= require turbolinks
```

Then if the `<head>`section of your main layout.

```html
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- ... -->
        {!! stylesheet_link_tag('app', ['data-turbolinks-track' => true]) !!}
        {!! javascript_include_tag('app', ['data-turbolinks-track' => true]) !!}
    </head>
    <!-- ... -->
</html>
```

And it just works!

**Checkout "[Faster page loads with Turbolinks](https://coderwall.com/p/ypzfdw)" for deeper explanation how to use Turbolink in real world**.

## Usage without the Larasset package

Click [here](README.md) to publish the assets manually.

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

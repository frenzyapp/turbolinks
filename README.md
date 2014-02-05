Frenzy Turbolinks for Laravel 4.1.*
==========

Frenzy Turbolinks is a port of the rails [turbolinks](https://github.com/rails/turbolinks) gem and the [jquery.turbolinks](https://github.com/kossnocorp/jquery.turbolinks) gem for projects using the Laravel 4.1.*.

## Versions

Current versions of the following gems are used:

 * turbolinks: v2.2.0
 * jquery.turbolinks: v2.0.1

## Performance

Turbolinks makes following links in your web application faster. Instead of letting
the browser recompile the JavaScript and CSS between each page change, it keeps
the current page instance alive and replaces only the body and the title in the head.

Performance improvements will vary depending on the amount of CSS and Javascript
you are using. You can get up to a 2X increase when using a lot of Javascript and
CSS. You can find the rails benchmarks [here](https://stevelabnik/turbolinks_test).

## Installation

### Using Composer

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "frenzy/turbolinks": "dev-master"
    }
}
```

Add `'Frenzy\Turbolinks\TurbolinksServiceProvider', ` to the `providers` array in `app/config/app.php`

Add Composer scripts for automatic publication of assets

```json
{
   "scripts": {
       "post-install-cmd": [
           "php artisan asset:publish --path=\"vendor/helthe/turbolinks/Resources/public/js\" frenzy/turbolinks"
       ],
       "post-update-cmd": [
           "php artisan asset:publish --path=\"vendor/helthe/turbolinks/Resources/public/js\" frenzy/turbolinks"
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

#### Using jquery.turbolinks

If you need to use jquery.turbolinks, you need to add it before `turbolinks.js`

## Compatibility

The turbolinks javascript is designed to work with any browser that fully supports
pushState and all the related APIs. This includes Safari 6.0+ (but not Safari 5.1.x!),
IE10, and latest Chromes and Firefoxes.

Do note that existing JavaScript libraries may not all be compatible with
Turbolinks out of the box due to the change in instantiation cycle. You might
very well have to modify them to work with Turbolinks' new set of events. For
help with this, check out the [Turbolinks Compatibility project](http://reed.github.io/turbolinks-compatibility).

## Additional Resources

Please refer to the [turbolinks](https://github.com/rails/turbolinks) and
[jquery.turbolinks](https://github.com/kossnocorp/jquery.turbolinks) projects
if you require additional information on the javascript libraries and their usage.

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/frenzyapp/turbolinks/issues/new).
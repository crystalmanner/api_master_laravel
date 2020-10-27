# Activity Api

[![Total Downloads][ico-downloads]][link-downloads]

**Activity Api** provides an HTTP API to manage Activty.

To use this package in an existing laravel project, choose either _Option 1_ or _Option 2_.

## Installation on a Client Project

#### Option 1: pull from repository

Add to `composer.json` in the following respective sections 
```
"require": [
  "freshinup/activity-api": "master",
],
"repositories": {
    "activity-api": {
        "type": "vcs",
        "url": "git@github.com:FreshinUp/activity-api.git"
    }
}
```
Then, run `composer update freshinup/activity-api`

#### Option 2: symlink from local directory

This will allow you to test modifications in real time.

Clone this project in a sibling directory along the **Client Project** that will make use of this package,
then add to `composer.json` of the Client project

```
"require": [
  "freshinup/activity-api": "master",
],
"repositories": {
    "activity-api": {
        "type": "path",
        "url": "../activity-api",
        "options": {
            "symlink": true
        }
    }
}
```
Then, run `composer update freshinup/activity-api` from the Client Project

## Usage

Run `php artisan activity-api:install` to publish this package's config and dependencies migrations.

Run `php artisan migrate`.

Edit the `fresh-activity-api.php` config file to your needs.

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email john@freshinup.com instead of using the issue tracker.

## Credits

- [FreshinUp][link-author]
- [All Contributors][link-contributors]

## License

private. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/freshinup/activity-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/freshinup/activity-api.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/freshinup/activity-api/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/freshinup/activity-api
[link-downloads]: https://packagist.org/packages/freshinup/activity-api
[link-travis]: https://travis-ci.org/freshinup/activity-api
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/freshinup
[link-contributors]: ../../contributors

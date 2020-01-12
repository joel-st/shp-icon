# Megafilter by Say Hello

## Description

This plugin modifies the WordPress archive view according to specific query parameters, in order to provide filtered results.

It does NOT provide the form which will be used to request the page using the supported parameters. The form
should be provided with the Theme. (Usually a `form` using `action="GET"`.)

The parameters are passed as `GET` parameters. The parameters work together and modify the WordPress query via the
`pre_get_posts` hook using `AND` logic. If all are passed to the page, then the resulting set of posts are those which
match ALL parameters.

## Parameters

* `megafilter_year` - parsed into an integer. Single entry only.
* `megafilter_month` - parsed into an integer. Single entry only.
* `megafilter_category` - single ID or a comma-separated string of IDs. All entries are converted to an integer and passed on to the `WP_Query` parameter `category__in`.

## Usage

Install and activate the plugin.

## Changelog

### 0.1.0

* Initial working version with year, month and category parameters.

### 0.0.1

* Initial development version.

## Contributors

* Mark Howells-Mead (mark@sayhello.ch)

## License
Use this code freely, widely and for free. Provision of this code provides and implies no guarantee.

Please respect the GPL v3 licence, which is available via http://www.gnu.org/licenses/gpl-3.0.html

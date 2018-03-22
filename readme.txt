=== Yoast SEO for WordPress PWA ===
Contributors: Pablo Postigo, Niels Garve, Tedy Warsitha, Charlie Francis
Tags: yoast, wp-api, wp-pwa, seo
Requires at least: 4.4
Tested up to: 4.9.1
Stable tag: 1.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Returns Yoast post or page metadata in a normal post or page request.

== Description ==

Makes Yoast SEO settings available to WordPress PWA using the REST API.
Returns Yoast post or page metadata in a normal post or page REST API request. Stores the metadata in the `yoast_meta` field of the returned data.

```
{
  id: 123,
  ...
  yoast_meta: {
    title: "Testy Test | My WordPress site",
  }
}
```

Supports pages, posts, categories, tags and any *public* custom post types and custom taxonomies.


Thanks to Pablo Postigo, Tedy Warsitha and Charlie Francis for amazing contributions!

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/yoast-to-rest-api` directory, or install the plugin through the 'Plugins' menu in WordPress
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.6.0=
- Big refactoring. Avoid using `the_post` and make it work with custom taxonomies and `latest`.

= 1.5.1=
- Main file renamed to plugin.php

= 1.5.0 =
- Merged contributions from Niels Garve fork (https://github.com/niels-garve/yoast-to-rest-api)
- Changed name to "Yoast SEO for WordPress PWA"

= 1.4.1 =

- Documentation

= 1.4.0 =

- Fixed broken meta descriptions in REST collections
- PHP Coding Standards (https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/#php)

= 1.4.0-alpha =

- Fixed retrieval of the meta description
- Generalized Worona PWA dependencies

= 1.3 =

- Adapted to the needs of Worona PWA

= 1.2 =

- Changed `register_api_field` to `register_rest_field` as it's depracated
- Changed the metadata name to `yoast` rather than `yoast_meta`
- Removed the `yoast_wpseo_` prefix from the returned meta as it seems undeed

= 1.1 =

- Using Class instead of plain function
- Added output to public custom post types

= 1.0 =

- Launched!

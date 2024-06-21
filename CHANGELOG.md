# Changelog

## 2.0.0 - 2024-06-21

⚠ Please read the [documentation](./Documentation.md) if you're using a custom
theme and wish to update to version 2 - several functions have changed places.

### Added

* Support for plain-text and HTML blog posts and pages.
* `Config::Description` option
* `$Blog->get_description()` and `$Blog->get_canonical_url()` functions

### Changed

* URL parsing method - no need for a complicated `.htaccess` file, and is more
  compatible with nginx.
* Refactored nearly all of the backend. As such, **all existing themes on v1 are
  not compatible with v2** (hence the major version bump). All global
  functions should now belong in `$Blog`.
* Renamed `Config::UseParsedown` to `Config::UseMarkdown` to make the option's
  change more obvious.

### Removed

* Removed prism.js from default theme

## 1.5.0 - 2024-06-20

It's been almost 7 years since the last update, but I have *actually* been using
Hyperlight for my main website this whole time! As such, some new changes will
eventually be coming.

### Added

* Featured post images to RSS feed items
* Redirections, part of `config.php`
* Optionally determine a post's timestamp based on the filename (ISO date)
* `/rss.xml` and `/sitemap.xml` endpoints to `.htaccess`
* CHANGELOG.md (that's this file!)

### Changed

* Upgraded Parsedown to v1.7.4
* Print whole post content in RSS feed, rather than just summary.
* Return HTTP 404 when visiting `/includes` and `/themes`

## 1.4.1 - 2017-07-02

Outputs a sitemap of your blog when `/sitemap` is visited. This is for search
engine optimisation, so Google and other search engines can see an entire list
of all the pages on your website.

Known Issues:

* Only reports the latest number of posts as specified in the config.php file,
  rather than every single post made.

## 1.4.0 - 2017-06-24

This release adds support for RSS feeds by going to `example.com/rss`. You can
also request a JSON version of the data by visiting `example.com/rss/json`.

## 1.3.0 - 2017-06-20

* Moved PHP classes and config file to restricted `includes/` directory
* Added initialisation definition to `index.php` that other files must check for

## 1.2.2 - 2017-05-14

* Improved parsedown checking
* Improved a couple of comments

## 1.2.1 - 2017-04-30

Adds page support, using the same format as blog posts.

## 1.1.0 - 2017-04-29

Add tag support.

## 1.0.0 - 2017-04-29

Initial release.

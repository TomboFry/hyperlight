# Hyperlight

Hyperlight is (yet another) PHP flat-file blog engine, which is light on code
and easily extensible.

## Features

* **17.4 kB** installed size (disclaimer: with the smallest packaged theme
  (uberlight) and no markdown support. Full download size: 84 kB)
* Markdown parsing, thanks to [Parsedown](https://github.com/erusev/parsedown)
  (optional, adds 37kb to installation)
* Theme support
* Pagination
* RSS Feed (`/rss.xml`) & Sitemap (`/sitemap.xml`)
* Post tags
* No database required

## Requirements

* Apache `mod_rewrite` engine
* PHP (tested on 8.3, but should work from 8.1 onwards)

## Demo

A demo of the initial installation state can be found here:
<https://tombofry.co.uk/hyperlight/>

## Documentation/Manual

Please read the [documentation/set-up guide](./Documentation.md), as it
contains:

* Super simple installation steps
* Configuring your installation
* Writing posts/pages
* How to write custom themes

## No Admin Panel

As there's no admin panel, compared to other popular blogs/CMSes, to change your
site config and write posts/pages you'll need to manually edit files. As a
result, this means you will have to upload images manually and link to them
yourself, too.

# Hyperlight

Hyperlight is yet another PHP flat-file blog engine with the intent of being incredibly small and fast.

## Features

* **14.7KB** installed size (disclaimer: with the smallest packaged theme (uberlight) and no markdown support. Full download size: 76KB)
* Markdown parsing, thanks to [Parsedown](https://github.com/erusev/parsedown) (optional, adds 37kb to installation)
* Theme support
* Pagination
* RSS Feed (`/rss.xml`) & Sitemap (`/sitemap.xml`)
* Post tags
* No database required

## Requirements

* Apache mod_rewrite engine
* PHP (tested on 5.5 and 7.1)

## Demo

A demo of the initial installation state can be found here: [https://tombofry.co.uk/hyperlight](https://tombofry.co.uk/hyperlight)

## Documentation/Manual

To get the most out of Hyperlight, it is imperative that you [read the manual](https://tombofry.co.uk/hyperlight/docs/). It contains:

* Super simple installation steps
* Configuring your installation
* Writing posts/pages
* How to write custom themes

## No Admin Panel

Hey, every piece of software has its problems, this has one that you could consider intentional. There's no admin panel to write posts and change settings - all configuration must be done manually. However, all this requires is changing one file (`config.php`) with the values you want.

As a result, this means you will have to upload images manually and link to them yourself, too.

I do plan on adding this feature at some point.

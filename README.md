# Hyperlight

Hyperlight is (yet another) PHP flat-file blog engine, which is light on code
and easily extensible.

## Features

* **14.7KB** installed size (disclaimer: with the smallest packaged theme
  (uberlight) and no markdown support. Full download size: 76KB)
* Markdown parsing, thanks to [Parsedown](https://github.com/erusev/parsedown)
  (optional, adds 37kb to installation)
* Theme support
* Pagination
* RSS Feed (`/rss.xml`) & Sitemap (`/sitemap.xml`)
* Post tags
* No database required

## Requirements

* Apache `mod_rewrite` engine
* PHP (tested on 8.3, but should work all the way back to 5.5 if you're a
  maniac!)

## Demo

A demo of the initial installation state can be found here:
<https://tombofry.co.uk/hyperlight/>

## Documentation/Manual

> [!NOTE]
> The docs have been unavailable for a while. I'll write up a new version soon
> that's directly available within the repo.

~~To get the most out of Hyperlight, it is imperative that you [read the manual](https://tombofry.co.uk/hyperlight/docs/)~~. It contains:

* Super simple installation steps
* Configuring your installation
* Writing posts/pages
* How to write custom themes

## No Admin Panel

As there's no admin panel, compared to other popular blogs/CMSes, to change your
site config and write posts/pages you'll need to manually edit files. As a
result, this means you will have to upload images manually and link to them
yourself, too.

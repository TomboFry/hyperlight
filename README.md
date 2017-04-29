# Hyperlight

Hyperlight is yet another PHP flat-file blog engine with the intent of being incredibly small and fast.

## Features

* **8.0KB** installed size (with the smallest packaged theme (uberlight) and no markdown support, full download size: 70KB)
* Markdown parsing, thanks to [Parsedown](https://github.com/erusev/parsedown) (optional, adds 37kb to installation)
* Theme support (see `themes/uberlight/index.php` for a quick guide)
* Pagination
* No database required

## Requirements

* PHP (tested on 5.6)
* Apache mod_rewrite engine

## No Admin Panel

Hey, every piece of software has its problems, this has one that you could consider intentional. There's no admin panel to write posts and change settings - all configuration must be done manually. However, all this requires is changing one file (`config.php`) with the values you want.

As a result, this means you will have to upload images manually and link to them yourself, too.

I do plan on adding this feature at some point.

-----

## Blog Post Format

The first four lines of every blog post must contain the following:

* Line 1: Post Title
* Line 2: Short summary of the post
* Line 3: Featured Image URL
* Line 4: Anything, just for separation between metadata and content

Lines 3 and 4 are optional but if omitted must still be an empty line.

Everything else below that will be parsed as markdown (or plain text, your choice).

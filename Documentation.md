# Hyperlight Docs

## Table of Contents

- [Hyperlight Docs](#hyperlight-docs)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
    - [Using Nginx?](#using-nginx)
  - [Configuring Hyperlight](#configuring-hyperlight)
  - [Writing posts/pages](#writing-postspages)
  - [Writing custom themes](#writing-custom-themes)
    - [Config variables](#config-variables)
    - [Blog functions](#blog-functions)
    - [Blog properties](#blog-properties)
    - [Posts](#posts)
    - [Pages](#pages)

## Installation

> [!IMPORTANT]
> To use hyperlight, you need a PHP server running on either Apache or Nginx, or
> something that can rewrite URLs. Make sure that's set up first.

1. Download the latest version from
   [Releases](https://github.com/TomboFry/hyperlight/releases/latest)
2. Extract the contents of the ZIP into the folder you want to run Hyperlight
   from.
3. That's it! Now you can [make changes to the config](#configuring-hyperlight)
   (unless you're using Nginx, see below).

### Using Nginx?

Because nginx doesn't use `.htaccess` files to make directory-specific config
changes, you'll need to set up your server block to do the rewriting for you.

Luckily, this is pretty simple. In your server block, add the snippet below.

If you're installing to a sub-directory, rather than the root, you will need to
make sure both the `location` and `try_files` refer to the name of the
sub-directory, like the example below.

If you're installing to the root of your server, you can replace `/demo/` with
`/`.

```nginx
location /demo/ {
  try_files $uri /demo/index.php;
}
location ~ /demo/(includes|posts|pages)(\/.*)? {
  return 404;
}
```

Also, if you choose to move your posts or pages directories in the Config file, you can change the nginx config above to return a 404 correctly.

## Configuring Hyperlight

All the config you'll need to change is in `includes/config.php`. Edit the
options as you see fit. Each option has a comment above explaining what it's
used for and how you should change it.

It's really that simple!

## Writing posts/pages

By default, posts and pages are in the `posts/` and `pages/` directory by default, unless you've changed the config.

To write a post or a page:

* Create a markdown (`.md`), `txt`, or `html` file inside the folder.
* The filename is the URL used by hyperlight (eg. `my-post.md` would be
  `https://example.com/post/my-post`)
* If your filename starts with an ISO date (eg. `YYYY-MM-DD`), that will set the
  published date for that post.

The first 5 lines of the file are important, so make sure word-wrapping is
turned off for them!

1. The first line is the title of the page or post.
2. The second line is a short summary or description, used for
   archive/indexing/previewing.
3. Third is a URL to a featured image - you will have to make sure this is
   uploaded somewhere first.
4. Fourth is a comma-separated list of tags (eg. `news, programming`), but make
   sure there's a space between each tag.
5. Finally, the last line is just used to separate the metadata from the post
   itself, you can set this to whatever you like - I personally use hyphens, but
   it doesn't matter what's there.

Everything below the fifth line contains the page/post's content. Depending on whether you've enabled Markdown, you'll be able to write posts either as Markdown or plain-text.

A full post may look something like this:

```
💡 How to write posts using Hyperlight
We'll look at the metadata structure, and write some content!
/uploads/featured-image.avif
programming, guide, hyperlight
-----
This is a short guide on writing [hyperlight](https://github.com/tombofry/hyperlight) posts.

etc.
```

## Writing custom themes

Your theme is responsible for outputting all content to the page. You'll have
access to the `$Blog` variable, which contains all the posts and pages loaded
from your file system. There are a couple of other, special variables that can
help with organising your theme.

Please refer to the uberlight theme in `themes/uberlight/index.php` for a good
starting point in creating your own themes. It's all commented, uses all the
basic functions and properties in a single file, and so can be split up and
modified as you required.

Otherwise, the full documentation for each function is below:

### Config variables

You can use the Config variables you set up earlier inside your theme. Here are
the options relevant to theming:

* `Config::Root`  
  This is, essentially, a URL to your homepage. It's what all other URLs are
  based off.
* `Config::Title`  
  Your blog's title
* `Config::Description`  
  Your blog's description
* `Config::Footer`  
  The text to be displayed at the bottom of your blog. Of course, this can be
  ignored if you want your theme to display more intricate contents on the
  footer, but is good to use a default theme straight out of the box.

### Blog functions

* `$Blog->get_title()`
  * This returns the full title of the page you're visiting, whether it's the
    index or an individual page/post.
* `$Blog->get_description()` - depending on the page, it'll return either:
  * the description set in your config
  * the summary of the post/page being viewed
  * or if you're viewing a tag archive, "Posts tagged with 'tag-name'".
* `$Blog->get_canonical_url()`
  * returns the true URL for the page being viewed
  * for example, `/tag/news/p/1` is identical to `/tag/news` in terms of
    content, so we can use the latter.)
* `$Blog->get_tag_link($tag_slug)`
  * Returns a link to the archive of a specific tag.
* `$Blog->has_pagination()`
  * returns `false` on individual pages/posts, otherwise it may return `true` if
    you have more posts than are currently displayed on one page.
* `$Blog->get_page_num()`
  * returns the currently viewed page.
* `$Blog->get_page_total()`
  * returns the number of pages available.
* `$Blog->has_page_next()` and `$Blog->has_page_prev()`
  * returns `true`/`false` if there are more pages.
* `$Blog->get_page_next()` and `$Blog->get_page_prev()`
  * return the URL for the next and previous pages.
* `Blog::get_base_url()` (static function)
  * Returns an absolute URL to the root of your blog
* `Blog::get_theme_css_dir()` (static function)
  * Returns the directory containing CSS files - this assumes your theme has a
    directory inside called `css`.
* `Blog::get_theme_js_dir()` (static function)
  * Returns the directory containing JS files - this assumes your theme has a
    directory inside called `js`.


### Blog properties

* `$Blog->url`
  * Determines what page you're looking at. It can be checked by comparing to:
    * `Url::Archive` The main post archive/index.
    * `Url::Post` Viewing a single post
    * `Url::Page` Viewing a single page
    * `Url::Error404` The post or page you're trying to view doesn't exist.
* `$Blog->posts`
  * An array of [posts](#posts).
  * If you're viewing a single post, this array will contain only that post.
  * If you're viewing a single page, this array will contain only that page.
* `$Blog->pages`
  * An array of [pages](#pages). Always contains the full list of pages,
    regardless of the URL.

### Posts

There are several properties posts have which can be used, but more useful are
the functions, for transforming those properties as necessary:

* `$post->title`
* `$post->summary` A short description of the post/page
* `$post->content` The full content of the post/page
* `$post->image` A URL to the main, featured image
* `$post->tags` An array of tags
* `$post->slug` The filename/portion of the URL referring to this post/page
---
* `$post->get_url()`
  * returns an absolute URL to the post.
* `$post->has_image()`
  * Returns `true`/`false` depending on whether a featured image URL was
    provided in the header of the post.
* `$post->has_tags()`
  * Returns `true`/`false` depending on whether this post/page has any tags.
* `$post->has_summary()`
  * Returns `true`/`false` depending on whether this post/page has a summary.
* `$post->date_pretty()`
  * Returns a nice-looking published date to be displayed on the page.
* `$post->date_datetime()`
  * Returns an ISO8601-formatted timestamp for the published date.
* `$post->edited_pretty()`
  * Returns when the post was last edited, formatted nicely.
* `$post->edited_datetime()`
  * Returns an ISO8601-formatted timestamp for the post's edited date.

### Pages

Pages contain all the same details as [posts](#posts), except they are
inherently loaded and displayed differently. Please look at the documentation
above for all the page details.

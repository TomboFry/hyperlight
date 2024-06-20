<?php

define("HYPERLIGHT_INIT", "true");

// Make sure these files exist before making this blog public facing.
require("includes/config.php");
include("includes/blog.class.php");
include("includes/entry.class.php");

// Parsedown is optional, it adds support for markdown blog posts, but also adds 40kb to the installation
if (Config::using_markdown()) {
	include("includes/parsedown.php");
}

$Blog = Blog::parse_url($_SERVER['REQUEST_URI']);

if ($Blog->url === Url::Rss) {
	if ($Blog->machine_type === 'sitemap') {
		include("includes/sitemap.php");
		generate_sitemap($Blog);
		exit;
	}

	include("includes/rss.php");
	print_rss($Blog);
	exit;
}

// Now run the theme
include("themes/" . Config::Theme . "/index.php");

// Once the page has been output by the theme we can kill the process so no other processing gets run
// (may happen on free webhosts that put code at the end of your blog)
die();

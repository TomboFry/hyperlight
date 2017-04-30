<?php

// Make sure these files exist before making this blog public facing.
require("config.php");
include("blog.class.php");
include("entry.class.php");

// Parsedown is optional, it adds support for markdown blog posts, but also adds 40kb to the installation
if (using_parsedown()) {
	include("parsedown.php");
}

/*
 *   BLOG ENGINE STARTING
 */

$post_slug = "";
$page_slug = "";
$pagination = 0;
$tag = "";

function not_blank($var) {
	return (isset($_GET[$var]) && $_GET[$var] !== "");
}

// Requesting a blog post
if (not_blank('post')) {
	$post_slug = $_GET['post'];

// Requesting a page
} else if (not_blank('page')) {
	$page_slug = $_GET['page'];

// Show the archive with/without a tag
} else {
	if (not_blank('tag')) {
		$tag = strtolower($_GET['tag']);
	}
	if (not_blank('pagination')) {
		$pagination = $_GET['pagination'] - 1;
	}
}

// Initialise the blog
//
$Blog = new Blog($post_slug, $page_slug, $pagination, $tag);

// Now run the theme
include("themes/" . Config::Theme . "/index.php");

// Once the page has been output by the theme we can kill the process so no other processing gets run
// (may happen on free webhosts that put code at the end of your blog)
die();

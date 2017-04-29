<?php

// Make sure these files exist before making this blog public facing.
require("config.php");
include("blog.php");

// Parsedown is optional, it adds support for markdown blog posts, but also adds 40kb to the installation
if (using_parsedown()) {
	include("parsedown.php");
}

/*
 *   BLOG ENGINE STARTING
 */

$url = "";
$page = 0;
$tag = "";

function not_blank($var) {
	return (isset($_GET[$var]) && $_GET[$var] !== "");
}

if (not_blank('post')) {
	$url = $_GET['post'];
} else {
	if (not_blank('tag')) {
		$tag = strtolower($_GET['tag']);
	}
	if (not_blank('page')) {
		$page = $_GET['page'] - 1;
	}
}

// Create the blog with a list of entries
$Blog = new Blog($url, $page, $tag);

// Now run the theme
include("themes/" . Config::Theme . "/index.php");

// Once the page has been output by the theme we can kill the process so no other processing gets run
// (may happen on free webhosts that put code at the end of your blog)
die();

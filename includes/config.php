<?php
if (!defined("HYPERLIGHT_INIT")) die();

// Edit these variables to your liking, just don't remove any.

abstract class Config {
	// The path the blog resides in on your server
	// eg. If your blog is on http://example.com/blog, Root = "/blog/"
	// Must end with a slash
	const Root = "/";

	// The title that appears at the top of the blog (theme dependant)
	const Title = "Hyperlight";

	// The location to store the blog posts in
	const PostsDirectory = "posts/";

	// The location to store the pages in
	const PagesDirectory = "pages/";

	// The theme to use. This folder must exist in the "themes" directory with an index.php file to run.
	const Theme = "hyperlight";

	// The text that appears at the bottom of each page (theme dependant)
	const Footer = "&copy; Tom Gardiner 2017";

	// How many posts to display per page before requiring pagination
	const PostsPerPage = 10;

	// The width images get resized to when uploaded
	const ImageWidth = 1024;

	// Determines whether or not to use Parsedown, which converts markdown documents into HTML.
	const Parsedown = true;

	// What format to print the date on posts
	const DatePretty = "l jS F o, H:i:s";

	// What to put in between the Post title and the site title
	// eg. "Latest Post | My Site"
	const TitleSeparator = " | ";
}

/**
 *
 *   DO NOT EDIT FROM HERE
 *
*/

// Prints out the directory containing CSS files
function get_theme_css_dir() {
	echo Config::Root . "themes/" . Config::Theme . "/css";
}

// Prints out the directory containing JS files
function get_theme_js_dir() {
	echo Config::Root . "themes/" . Config::Theme . "/js";
}

// Prints out the link to the homepage
function get_home_link() {
	echo Config::Root;
}

// Returns the full URL, including "http(s)"
function get_full_url() {
	return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
}

// Returns the current page, including whether a tag was included
function get_page_url() {
	$str = Config::Root;
	if (isset($_GET['tag']) && $_GET['tag'] != "") {
		$str .= "tag/{$_GET['tag']}/";
	}
	return $str;
}

// Returns a link to a specific blog post
function get_post_link($post_slug) {
	return Config::Root . "post/" . $post_slug;
}

// Returns a link to the archive of a specific tag
function get_tag_link($tag_slug) {
	return Config::Root . "tag/" . $tag_slug;
}

// Returns whether we can use the markdown conversion
function using_parsedown() {
	return (file_exists("includes/parsedown.php") && Config::Parsedown);
}

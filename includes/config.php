<?php
if (!defined("HYPERLIGHT_INIT")) die();

// Edit these variables to your liking, just don't remove any.

abstract class Config {
	/** The path the blog resides in on your server
	 *  eg. If your blog is on http://example.com/blog, Root = "/blog/"
	 *  Must end with a slash */
	const Root = "/";

	/** The title that appears at the top of the blog (theme dependent) */
	const Title = "Hyperlight";

	/** A short summary about your blog */
	const Description = "This is a hyperlight blog";

	/** The location to store the blog posts in */
	const PostsDirectory = "posts/";

	/** The location to store the pages in */
	const PagesDirectory = "pages/";

	/** The theme to use. This folder must exist in the "themes" directory with an index.php file to run. */
	const Theme = "hyperlight";

	/** The text that appears at the bottom of each page (theme dependant) */
	const Footer = "&copy; Your Name Here";

	/** How many posts to display per page before requiring pagination */
	const PostsPerPage = 10;

	/** The width images get resized to when uploaded */
	const ImageWidth = 1024;

	/** Determines whether or not to use Parsedown, which converts markdown documents into HTML. */
	const UseMarkdown = true;

	/** What format to print the date on posts */
	const DatePretty = "l jS F o, H:i:s";

	/** What to put in between the Post title and the site title
	 * eg. "Latest Post | My Site" */
	const TitleSeparator = " | ";

	/** Set up a list of redirections - useful if your main site is hosted
	 * using hyperlight and want a short URL to go somewhere else.
	 * If, for example, you're hosted on `https://example.com`, the example
	 * below would take you to my website if you visit `https://example.com/tombofry` */
	const Redirections = [
		"tombofry" => "https://www.tombofry.co.uk/",
	];

	// That's it! You can stop editing now :)

	static function using_markdown() {
		return file_exists("includes/parsedown.php") && Config::UseMarkdown;
	}

	/** Prints out the directory containing CSS files */
	static function get_theme_css_dir() {
		return Config::Root . "themes/" . Config::Theme . "/css";
	}

	/** Prints out the directory containing JS files */
	static function get_theme_js_dir() {
		return Config::Root . "themes/" . Config::Theme . "/js";
	}

	/** Returns the full URL, including "http(s)" */
	static function get_base_url() {
		return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . Config::Root;
	}
}

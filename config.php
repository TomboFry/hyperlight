<?php

abstract class Config {
	// The path the blog resides in on your server
	const Root = "/";

	// The title that appears at the top of the blog (theme dependant)
	const Title = "Hyperlight";

	// The location to store the blog posts in
	const PostsDirectory = "posts/";

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

// Returns whether we can use the markdown conversion
function using_parsedown() {
	return file_exists("parsedown.php");
}

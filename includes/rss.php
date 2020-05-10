<?php

if (!defined("HYPERLIGHT_INIT")) die();

$url_base = get_base_url() . Config::Root;
$mime_types = [
	'png' => 'image/png',
	'jpe' => 'image/jpeg',
	'jpeg' => 'image/jpeg',
	'jpg' => 'image/jpeg',
	'gif' => 'image/gif',
	'bmp' => 'image/bmp',
	'ico' => 'image/vnd.microsoft.icon',
	'tiff' => 'image/tiff',
	'tif' => 'image/tiff',
	'svg' => 'image/svg+xml',
	'svgz' => 'image/svg+xml',
];

function rss_image_details ($post) {
	global $mime_types;

	if (empty($post->image)) return;
	$image_url = $post->image;

	// Get image MIME-type
	$image_mime = "";
	$image_segments = explode('.', $image_url);
	$ext = strtolower(array_pop($image_segments));
	if (array_key_exists($ext, $mime_types)) {
		$image_mime = $mime_types[$ext];
	}

	// Use enclosure built-in method
	if ($image_mime !== "") {
		echo "<enclosure ";
		echo "url=\"{$image_url}\" ";
		echo "type=\"{$image_mime}\" ";
		// TODO: Determine image size in bytes
		echo "/>";
	}

	// Use media:content extension
	echo "<media:content ";
	echo "xmlns:media=\"http://search.yahoo.com/mrss/\" ";
	echo "url=\"{$image_url}\" medium=\"image\" ";
	if ($image_mime !== "") echo "type=\"{$image_mime}\" ";
	echo "/>";
}

function rss_post ($post) {
	global $url_base;

	$pubDate = gmdate(DATE_RFC2822, $post->timestamp);
	echo "\n<item>";

	// Print required information
	echo "<title>{$post->title}</title>";
	echo "<pubDate>{$pubDate}</pubDate>";
	echo "<link>{$url_base}post/{$post->slug}</link>";
	echo "<guid>{$url_base}post/{$post->slug}</guid>";

	// Print description
	if ($post->summary !== "") { echo "<description>{$post->summary}</description>"; }

	// Print categories
	foreach ($post->tags as $key => $category) {
		echo "<category>{$category}</category>";
	}

	// Print image
	rss_image_details($post);

	echo "</item>";
}

function rss_xml($Blog) {
	global $url_base;

	$title = Config::Title;
	$lastBuildDate = gmdate(DATE_RFC2822, $Blog->posts[0]->timestamp);

	header("Content-Type: application/rss+xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">
<channel>
	<title>{$title}</title>
	<atom:link href=\"{$url_base}rss\" rel=\"self\" type=\"application/rss+xml\" />
	<description>{$title}</description>
	<generator>Hyperlight CMS</generator>
	<link>{$url_base}</link>
	<lastBuildDate>{$lastBuildDate}</lastBuildDate>";

	// Print each article
	array_walk($Blog->posts, 'rss_post');

	echo "</channel></rss>";
}

switch ($rss) {
	case "json":
		header("Content-Type: application/json;");
		echo json_encode($Blog->posts);
		break;
	case "xml":
	default:
		rss_xml($Blog);
		break;
}
?>

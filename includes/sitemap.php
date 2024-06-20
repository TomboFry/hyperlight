<?php
if (!defined("HYPERLIGHT_INIT")) die();

function array_to_xml(array &$array, string $parent_key = '') {
	$output = [];
	if (empty($parent_key)) {
		array_push($output, '<?xml version="1.0" ?>');
	}

	foreach ($array as $key => $value) {
		$new_key = $key;
		if (is_int($new_key)) {
			$new_key = $parent_key;
		}

		if (is_array($value)) {
			$is_list = array_is_list($value);

			if (!$is_list) array_push($output, "<{$new_key}>");
			array_push($output, array_to_xml($value, $new_key));
			if (!$is_list) array_push($output, "</{$new_key}>");

			continue;
		}

		array_push($output, "<{$new_key}>{$value}</{$new_key}>");
	}
	return implode($output);
}

function generate_sitemap_array(Blog $Blog) {
	$urls = [
		[
			"loc" => Config::get_base_url(),
			"lastmod" => gmdate("c", $Blog->posts[0]->timestamp),
			"priority" => "1.0"
		],
	];

	foreach ($Blog->pages as $page) {
		array_push($urls, [
			"loc" => $page->get_url(),
			"lastmod" => gmdate("c", $page->edited),
			"priority" => "0.8"
		]);
	}

	foreach ($Blog->posts as $post) {
		array_push($urls, [
			"loc" => $post->get_url(),
			"lastmod" => gmdate("c", $post->edited),
			"priority" => "0.5"
		]);
	}
	return [ "urlset" => [ "url" => $urls ] ];
}

function generate_sitemap(Blog $Blog) {
	$urlset = generate_sitemap_array($Blog);
	switch ($Blog->content_type) {
		case '.json':
			header('Content-Type: application/json');
			echo json_encode($urlset);
			break;

		case '.xml':
		default:
			header('Content-Type: text/xml');
			echo array_to_xml($urlset);
			break;
	}
}

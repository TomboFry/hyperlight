<?php
if (!defined("HYPERLIGHT_INIT")) die();

function array_to_xml(array $array, SimpleXMLElement &$xml, string $parent_key = '') {
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$node = $xml;
			if (is_numeric($key)) {
				$node = $xml->addChild($parent_key);
			}
			array_to_xml($value, $node, $key);
			continue;
		}

		$xml->addChild($key, htmlspecialchars($value));
	}
}

function generate_sitemap_array(Blog $Blog) {
	$urls = [
		[
			"loc" => Blog::get_base_url(),
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
			$xml = new SimpleXMLElement('<?xml version="1.0"?><urlset/>');
			array_to_xml($urlset, $xml);
			echo $xml->asXML();
			break;
	}
}

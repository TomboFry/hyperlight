<?php

function rss_xml($Blog) {
	$title = Config::Title;
	$url = get_base_url() . Config::Root;
	header("Content-Type: text/xml;");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><rss version=\"2.0\">
<channel><title>{$title}</title><link>{$url}</link>
<lastBuildDate>{$Blog->posts[0]->date_datetime()}</lastBuildDate>";
	foreach ($Blog->posts as $key => $post) {
		$pubDate = $post->date_datetime();
		echo "<item>";
		echo "<title>{$post->title}</title>";
		echo "<pubDate>{$pubDate}</pubDate>";
		echo "<link>{$url}post/{$post->slug}</link>";
		echo "<guid>{$post->slug}</guid>";
		if ($post->summary !== "") { echo "<description>{$post->summary}</description>"; }
		foreach ($post->tags as $key => $category) {
			echo "<category>{$category}</category>";
		}
		echo "</item>";
	}
	echo "</channel></rss>";
}

switch ($rss) {
	case "xml":
		rss_xml($Blog);
		break;
	case "json":
		header("Content-Type: application/json;");
		echo json_encode($Blog->posts);
		break;
	default:
		header("HTTP/1.0 404 Not Found");
		die("HTTP/1.0 404 Not Found");
		break;
}
?>

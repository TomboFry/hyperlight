<?php

if (!defined("HYPERLIGHT_INIT")) die();

include("header.php");
include("single.php");

if ($Blog->url === Url::Error404) {
	include("404.php");
} else if (count($Blog->posts) === 0) {
	include("empty.php");
} else {
	foreach ($Blog->posts as $entry) {
		$full = ($Blog->url === Url::Post || $Blog->url === Url::Page);
		post($entry, $full);
	}
}

include("footer.php");

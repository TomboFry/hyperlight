<?php

include("header.php");

if ($Blog->page === Page::Error404) {
	include("404.php");
} else if (count($Blog->entries) === 0) {
	include("empty.php");
} else {
	include("single.php");
	foreach ($Blog->entries as $entry) {
		if ($Blog->page === Page::Single) {
			post($entry, true);
		} else {
			post($entry, false);
		}
	}
}

include("footer.php");

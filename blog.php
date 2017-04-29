<?php

class NotFoundException extends Exception {}

abstract class Page {
	const Archive = 0;
	const Single = 1;
	const Error404 = 2;
}

class Blog {
	public $entries;
	public $page;
	private $page_num;
	private $page_num_total;

	function __construct($url, $page, $tag) {
		if ($url !== "") {
			try {
				$this->entries = [new Entry($url, "")];
				$this->page = Page::Single;
				$this->page_num = 0;
				$this->page_num_total = 1;
			} catch (NotFoundException $e) {
				Header("HTTP/1.1 404 Not Found");
				$this->page = Page::Error404;
				$this->page_num = 0;
				$this->page_num_total = 1;
			}
		} else {
			$this->entries = Blog::loadEntries($tag);

			// Sort the posts before manipulating and displaying them
			usort($this->entries, function ($a, $b) {
				return ($a->timestamp > $b->timestamp) ? -1 : 1;
			});

			// Pagination configuration
			$this->page_num = $page;
			$offset = Config::PostsPerPage * $this->page_num;
			$length = Config::PostsPerPage;
			$this->page_num_total = ceil(count($this->entries) / $length);

			// Only return the posts that appear on that page.
			$this->entries = array_slice($this->entries, $offset, $length);
			$this->page = Page::Archive;
		}
	}

	private function loadEntries($tag) {
		$files = scandir(Config::PostsDirectory);
		$files = array_splice($files, 2);

		$entries = [];

		foreach ($files as $file) {
			try {
				$entries[] = new Entry(rtrim($file, '.md'), $tag);
			} catch (NotFoundException $e) {
				// Do nothing, don't add it to the array.
			}
		}

		return $entries;
	}

	// Returns the title, depending on whether you're on a single post or not.
	public function get_title() {
		$str = "";
		if ($this->page === Page::Single) {
			$str .= "{$this->entries[0]->title} | ";
		}
		$str .= Config::Title;

		return $str;
	}

	/*
		PAGINATION FUNCTIONS
	*/
	public function get_page_num() {
		return $this->page_num + 1;
	}

	public function get_page_prev() {
		return get_page_url() . "page/" . $this->page_num;
	}

	public function get_page_next() {
		return get_page_url() . "page/" . ($this->page_num + 2);
	}

	public function has_page_prev() {
		return ($this->page_num === 0) ? false : true;
	}

	public function has_page_next() {
		return ($this->page_num >= $this->page_num_total - 1) ? false : true;
	}

	public function has_pagination() {
		return ($this->page === Page::Archive && ($this->has_page_next() || $this->has_page_prev())) ? true : false;
	}

	public function get_page_total() {
		return $this->page_num_total;
	}
}

class Entry {
	public $title;
	public $slug;
	public $summary;
	public $image;
	public $tags;
	public $content;
	public $timestamp;
	public $edited;

	public function __construct($slug, $tag) {
		$fullpath = Config::PostsDirectory . $slug . ".md";

		if (!file_exists($fullpath)) {
			throw new NotFoundException();
		}

		$file_contents = file_get_contents($fullpath);
		$lines = explode("\n", $file_contents);

		$this->slug = $slug;
		$this->title = trim($lines[0]);
		$this->summary = trim($lines[1]);
		$this->image = trim($lines[2]);
		$this->tags = explode(", ", strtolower(trim($lines[3])));

		if ($tag !== "") {
			if (!in_array($tag, $this->tags)) {
				throw new NotFoundException();
			}
		}

		$metadata_length = 5;
		if (using_parsedown()) {
			$Parsedown = new Parsedown();
			$this->content = $Parsedown->text(implode("\n", array_slice($lines, $metadata_length)));
		} else {
			$this->content = "<p>" . implode("<br/>", array_slice($lines, $metadata_length)) . "</p>";
		}
		$this->timestamp = filectime($fullpath);
		$this->edited = filemtime($fullpath);
	}

	public function has_image() {
		if (isset($this->image) && $this->image != "") {
			return true;
		}
		return false;
	}

	public function has_tags() {
		if (isset($this->tags) && count($this->tags) > 0) {
			return true;
		}
		return false;
	}

	public function date_pretty() {
		return gmdate(Config::DatePretty, $this->timestamp);
	}
	public function date_datetime() {
		return gmdate("Y-m-d\TH:i:s", $this->timestamp);
	}
}

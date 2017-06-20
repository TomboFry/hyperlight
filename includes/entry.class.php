<?php
if (!defined("HYPERLIGHT_INIT")) die();

class Entry {
	public $title;
	public $slug;
	public $summary;
	public $image;
	public $tags;
	public $content;
	public $timestamp;
	public $edited;

	public function __construct($slug, $tag, $url) {
		$fullpath = ($url == Url::Post) ? Config::PostsDirectory : Config::PagesDirectory;
		$fullpath .= $slug . ".md";

		if (!file_exists($fullpath)) {
			throw new NotFoundException();
		}

		$file_contents = file_get_contents($fullpath);
		$lines = explode("\n", $file_contents);

		$this->slug = $slug;
		$this->title = trim($lines[0]);
		$this->summary = trim($lines[1]);
		$this->image = trim($lines[2]);
		$tags = strtolower(trim($lines[3]));
		if ($tags !== "") {
			$this->tags = explode(", ", $tags);
		} else {
			$this->tags = [];
		}

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

class Post extends Entry {
	public function __construct($slug, $tag) {
		parent::__construct($slug, $tag, Url::Post);
	}
}

class Page extends Entry {
	public function __construct($slug) {
		parent::__construct($slug, "", Url::Page);
	}
}

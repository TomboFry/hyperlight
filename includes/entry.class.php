<?php
if (!defined("HYPERLIGHT_INIT")) die();

class NotFoundException extends Exception {}
class NotInFilterException extends Exception {}

class Entry {
	public string $title = '';
	public string $slug;
	public string $summary = '';
	public string $image = '';
	public array $tags = [];
	public string $content = '';
	public int $timestamp;
	public int $edited;

	public function __construct(string $slug, Url $url, string $tag_filter) {
		$fullpath = ($url === Url::Post) ? Config::PostsDirectory : Config::PagesDirectory;

		list(
			'lines' => $lines,
			'ext' => $ext,
			'file_name' => $file_name,
		) = Entry::get_contents($fullpath, $slug);

		$this->slug = $slug;
		$this->title = trim($lines[0]);
		$this->summary = trim($lines[1]);
		$this->image = trim($lines[2]);
		$tags = strtolower(trim($lines[3]));

		if (!empty($tags)) {
			$this->tags = array_map('trim', explode(",", $tags));
		}

		if (!empty($tag_filter)) {
			if (!in_array($tag_filter, $this->tags)) {
				throw new NotInFilterException();
			}
		}

		$this->content = Entry::parse_contents(array_slice($lines, 5), $ext);

		// Optionally sets post date based on filenames starting with an
		// ISO date. eg. "posts/2024-01-01-hello-world.md" will set the
		// timestamp to January 1st, 2024.
		if (preg_match('/^(\d{4}-\d{2}-\d{2})/', $slug, $isodate)) {
			$this->timestamp = strtotime($isodate[1] . "T00:00:00.000Z");
		} else {
			// Fall back to using the file's "modified" timestamp
			$this->timestamp = filemtime($file_name);
		}
		$this->edited = filemtime($file_name);
	}

	private static function get_contents(string $dir, string $slug) {
		$files = scandir($dir);
		$files = array_splice($files, 2);
		$found_file = false;

		foreach ($files as $file) {
			if (!str_starts_with($file, $slug)) continue;

			$found_file = true;
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			break;
		}

		if (!$found_file) {
			throw new NotFoundException();
		}

		$file_name = "{$dir}{$slug}.{$ext}";
		$file_contents = file_get_contents($file_name);

		return [
			"lines" => explode("\n", $file_contents),
			"file_name" => $file_name,
			"ext" => $ext,
		];
	}

	private static function parse_contents(array $lines, string $ext) {
		switch ($ext) {
			case 'html':
				return implode("\n", $lines);

			case 'txt':
				return "<p>" . str_replace("\n\n", "</p><p>", implode("\n", $lines)) . "</p>";

			case 'md':
			default:
				if (Blog::using_markdown()) {
					$Parsedown = new Parsedown();
					return $Parsedown->text(implode("\n", $lines));
				} else {
					$contents = str_replace("\n\n", "</p><p>", implode("\n", $lines));
					$contents = str_replace("\n", "<br/>", $contents);
					return "<p>{$contents}</p>";
				}
		}
	}

	public function get_url() {
		return Blog::get_base_url() . "post/" . $this->slug;
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

	public function has_summary() {
		return !empty($this->summary);
	}

	public function date_pretty() {
		return gmdate(Config::DatePretty, $this->timestamp);
	}

	public function date_datetime() {
		return gmdate('Y-m-d\TH:i:s', $this->timestamp);
	}

	public function edited_pretty() {
		return gmdate(Config::DatePretty, $this->edited);
	}

	public function edited_datetime() {
		return gmdate('Y-m-d\TH:i:s', $this->edited);
	}
}

class Post extends Entry {
	public function __construct($slug, $tag) {
		parent::__construct($slug, Url::Post, $tag);
	}
}

class Page extends Entry {
	public function __construct($slug) {
		parent::__construct($slug, Url::Page, "");
	}

	public function get_url() {
		return Blog::get_base_url() . $this->slug;
	}
}

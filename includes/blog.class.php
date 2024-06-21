<?php
if (!defined("HYPERLIGHT_INIT")) die();

enum Url {
	case Archive;
	case Post;
	case Page;
	case Error404;
	case Rss;
}

class Blog {
	public array $posts = [];
	public array $pages = [];
	public Url $url;
	public string $tag = '';

	// RSS / Sitemap
	public string $machine_type;
	public string $content_type;

	private $_page_num;
	private $_page_num_total;

	function __construct(
		string $post = '',
		string $page = '',
		string $tag = '',
		int $pagination = 0,
		string $machine_type = '',
		string $content_type = ''
	) {
		$this->pages = Blog::load_pages();

		$this->_page_num = 0;
		$this->_page_num_total = 1;

		try {
			if (!empty($post)) {
				$this->posts = [new Post($post, "")];
				$this->url = Url::Post;
				return;
			}

			if (!empty($page)) {
				$this->posts = [new Page($page)];
				$this->url = Url::Page;
				return;
			}

			$this->tag = $tag;
			$this->posts = Blog::load_posts($tag);

			// Handles RSS feeds and sitemaps
			if ($machine_type !== '') {
				$this->url = Url::Rss;
				$this->machine_type = $machine_type;
				$this->content_type = $content_type;
				return;
			}

			// Pagination configuration
			$this->_page_num = $pagination;
			$offset = Config::PostsPerPage * $this->_page_num;
			$length = Config::PostsPerPage;
			$this->_page_num_total = ceil(count($this->posts) / $length);

			$this->posts = array_slice($this->posts, $offset, $length);
			$this->url = Url::Archive;
		} catch (NotFoundException $e) {
			http_response_code(404);
			$this->url = Url::Error404;
		}
	}

	/**
	 * Converts a URL like `/tag/guide/p/2` or `/post/example-post` into
	 * a valid blog configuration
	 */
	public static function parse_url(string $uri): Blog {
		$url = substr(urldecode($uri), strlen(Config::Root));
		$match = [];

		if (preg_match('/^(rss|sitemap)($|\.(xml|json)$)/', $url, $match)) {
			return new Blog('', '', '', 0, $match[1], $match[2]);
		}

		if (preg_match('/^post\/(?<slug>[\w\s-]+)\/?/', $url, $match)) {
			return new Blog($match['slug']);
		}

		if (preg_match('/^(?<slug>[\w\s-]+)$/', $url, $match)) {
			$slug = $match['slug'];

			// Handle redirections and exit
			if (array_key_exists($slug, Config::Redirections)) {
				http_response_code(301);
				header('Location: ' . Config::Redirections[$slug]);
				exit;
			}

			return new Blog('', $slug);
		}

		$tag = '';
		$pagination = 0;

		if (preg_match("/p\/(?<page>\d+)\/?$/", $url, $match)) {
			$pagination = (int) $match['page'] - 1;
			if ($pagination < 0) throw new Error("Page cannot be negative");
		}

		if (preg_match('/^tag\/(?<slug>[\w\s-]+)\/?/', $url, $match)) {
			$tag = $match['slug'];
		}

		return new Blog('', '', $tag, $pagination);
	}

	private function load_posts($tag) {
		$files = scandir(Config::PostsDirectory);
		$files = array_splice($files, 2);

		$posts = [];

		foreach ($files as $file) {
			try {
				$slug = pathinfo($file, PATHINFO_FILENAME);
				$posts[$slug] = new Post($slug, $tag);
			} catch (NotInFilterException $e) {
				// Do nothing, don't add it to the array.
			}
		}

		// Sort the posts before manipulating and displaying them
		usort($posts, fn (Entry $a, Entry $b) => -strnatcmp($a->timestamp, $b->timestamp));

		return $posts;
	}

	private static function load_pages() {
		$files = scandir(Config::PagesDirectory);
		$files = array_splice($files, 2);

		$pages = [];

		foreach ($files as $file) {
			try {
				$slug = pathinfo($file, PATHINFO_FILENAME);
				$pages[$slug] = new Page($slug);
			} catch (NotFoundException $e) {
				// Do nothing, don't add it to the array.
			}
		}

		usort($pages, fn ($a, $b) => strnatcmp($a->slug, $b->slug));

		return $pages;
	}

	/** Returns the title, depending on whether you're on a single post or not. */
	public function get_title() {
		$str = "";
		if ($this->url === Url::Post || $this->url === Url::Page) {
			$str .= $this->posts[0]->title . Config::TitleSeparator;
		}
		$str .= Config::Title;

		return $str;
	}

	public function get_description() {
		switch ($this->url) {
			case Url::Archive:
				if (empty($this->tag)) {
					return htmlentities(Config::Description);
				}
				return htmlentities("Posts tagged with '{$this->tag}'");

			case Url::Page:
			case Url::Post:
				if ($this->posts[0]->has_summary()) {
					return htmlentities($this->posts[0]->summary);
				}

			default:
				return htmlentities(Config::Description);
		}
	}

	public function get_tag_url($tag) {
		return Config::Root . "tag/" . $tag;
	}

	/** Returns the current page, including whether a tag was included */
	function get_canonical_url(bool $include_page = true) {
		$url = Blog::get_base_url();

		if ($this->url === Url::Page) {
			return $url . $this->posts[0]->slug;
		}

		if ($this->url === Url::Post) {
			return $url . "post/" . $this->posts[0]->slug;
		}

		if (!empty($this->tag)) {
			$url .= "tag/{$this->tag}/";
		}

		if ($include_page === true && $this->_page_num > 0) {
			$url .= "p/" . ($this->_page_num + 1);
		}

		return $url;
	}

	// PAGINATION FUNCTIONS

	public function has_pagination() {
		return $this->url === Url::Archive && ($this->has_page_next() || $this->has_page_prev());
	}

	public function get_page_num() {
		return $this->_page_num + 1;
	}

	public function get_page_total() {
		return $this->_page_num_total;
	}

	public function get_page_prev() {
		return $this->get_canonical_url(false) . "p/" . $this->_page_num;
	}

	public function get_page_next() {
		return $this->get_canonical_url(false) . "p/" . ($this->_page_num + 2);
	}

	public function has_page_prev() {
		return $this->_page_num > 0;
	}

	public function has_page_next() {
		return $this->_page_num < $this->_page_num_total - 1;
	}

	static function using_markdown() {
		return file_exists("includes/parsedown.php") && Config::UseMarkdown;
	}

	/** Prints out the directory containing CSS files */
	static function get_theme_css_dir() {
		return Config::Root . "themes/" . Config::Theme . "/css";
	}

	/** Prints out the directory containing JS files */
	static function get_theme_js_dir() {
		return Config::Root . "themes/" . Config::Theme . "/js";
	}

	/** Returns the full URL, including "http(s)" */
	static function get_base_url() {
		$scheme = isset($_SERVER['REQUEST_SCHEME'])
			? $_SERVER['REQUEST_SCHEME']
			: (isset($_SERVER['HTTPS']) ? "https" : "http");

		return $scheme . "://" . $_SERVER['HTTP_HOST'] . Config::Root;
	}
}

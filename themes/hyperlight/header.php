<?php if (!defined("HYPERLIGHT_INIT")) die(); ?>
<!DOCTYPE html>
<html lang="en">
<title><?php echo $Blog->get_title(); ?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<!-- Open Graph Tags -->
<meta name="twitter:card" content="summary" />
<meta property="og:url" content="<?php echo get_full_url(); ?>" />
<meta property="og:title" content="<?php echo $Blog->get_title(); ?>" />
<meta name="twitter:title" content="<?php echo $Blog->get_title(); ?>" />
<?php
if ($Blog->url === Url::Post || $Blog->url === Url::Page) {
	$post = $Blog->posts[0];
	if ($post->has_image() == true) {
		echo "<meta name='twitter:image' content='{$post->image}' />";
		echo "<meta property='og:image' content='{$post->image}' />";
	}
	if ($post->summary != "") {
		$htmlsummary = htmlentities($post->summary);
		echo '<meta name="twitter:description" content="' . $htmlsummary . '" />';
		echo '<meta property="og:description" content="' . $htmlsummary . '" />';
	}
} ?>
<style>
* {
	margin: 0;
	padding: 0;
	line-height: 1;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}

/* http://prismjs.com/download.html?themes=prism-okaidia&languages=markup+css+clike+javascript+csharp+json+php+php-extras+rust */
/**
 * okaidia theme for JavaScript, CSS and HTML
 * Loosely based on Monokai textmate theme by http://www.monokai.nl/
 * @author ocodia
 */

code, pre {
	font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
}
code[class*="language-"],
pre[class*="language-"] {
	color: #f8f8f2;
	background: none;
	text-shadow: 0 1px rgba(0, 0, 0, 0.3);
	text-align: left;
	white-space: pre;
	word-spacing: normal;
	word-break: normal;
	word-wrap: normal;
	line-height: 1.5;
	font-size: 0.85em;

	-moz-tab-size: 4;
	-o-tab-size: 4;
	tab-size: 4;

	-webkit-hyphens: none;
	-moz-hyphens: none;
	-ms-hyphens: none;
	hyphens: none;
}

/* Code blocks */
pre[class*="language-"] {
	padding: 32px;
	margin: .5em 0;
	overflow: auto;
}

:not(pre) > code[class*="language-"],
pre[class*="language-"] {
	background: #272822;
}

/* Inline code */
:not(pre) > code[class*="language-"] {
	padding: .1em;
	border-radius: .3em;
	white-space: normal;
}

.token.comment, .token.prolog, .token.doctype, .token.cdata { color: slategray; }
.token.punctuation { color: #f8f8f2; }
.namespace { opacity: .7; }
.token.property, .token.tag, .token.constant, .token.symbol, .token.deleted { color: #f92672; }
.token.boolean, .token.number { color: #ae81ff; }
.token.selector, .token.attr-name, .token.string, .token.char, .token.builtin, .token.inserted { color: #a6e22e; }

.token.operator, .token.entity, .token.url, .language-css .token.string,
.style .token.string, .token.variable { color: #f8f8f2; }

.token.atrule, .token.attr-value, .token.function { color: #e6db74; }
.token.keyword { color: #66d9ef; }
.token.regex, .token.important { color: #fd971f; }
.token.important, .token.bold { font-weight: bold; }
.token.italic { font-style: italic; }
.token.entity { cursor: help; }

/* PRISM THEMING END */

html { height: 100%; }
body {
	font-family: "Helvetica Neue", Arial, sans-serif;
	padding-top: 64px;
	font-size: 1.5em;
	min-height: 100%;
	display: flex;
	flex-direction: column;
	color: #333;
	overflow-x: hidden;
}
h1,h2,h3,h4,h5,h6 {
	font-weight: 800;
	letter-spacing: -0.03em;
}
.title a {
	letter-spacing: -0.03em;
	line-height: 1;
	margin-bottom: 32px;
	display: inline-block;
	text-decoration: none;
	color: #222;
	font-weight: 800;
}
.container {
	width: 100%;
	max-width: 960px;
	margin: 0 auto;
	flex: 1;
}
a {
	color: <?php echo $colour; ?>;
	text-decoration: none;
}
a:hover {
	color: <?php echo $colour_hover; ?>;
	text-decoration: underline;
}

.entry {
	display: block;
	margin-top: 42px;
	padding-bottom: 48px;
}
.entry:first-of-type {
	margin-top: 32px;
}
.entry:last-of-type {
	border-bottom: 0;
}
.entry .metadata {
	display: block;
	font-size: 0.6em;
	line-height: 1.618;
}
.entry img, pre[class*="language-"] {
	width: 100%;
	width: calc(100% + 64px);
	margin-left: -32px;
}
.content h1, .content h2, .content h3, .content h4, .content h5, .content h6,
.content p, .content img, .content pre, .content ul,
.content ol, .content hr, img.featured {
	margin-bottom: 32px;
	display: block;
}
.content p, .content li, .summary { line-height: 1.618; }
.entry-title { font-size: 2em; }
.entry-title, .summary { margin-bottom: 8px; }
.single .entry-title { margin-bottom: 32px; }
.content h2 { font-size: 1.6em; }
.content h3 { font-size: 1.5em; }
.content h4 { font-size: 1.4em; }
.content ul, .content ol { margin-left: 32px; }

.content blockquote {
	font-style: italic;
	color: #555;
	padding-left: 32px;
	border-left: 3px solid <?php echo $colour; ?>;
}
.content hr {
	border: 0;
	border-top: 1px solid #999;
}
.content table {
	width: 100%;
	width: calc(100% + 64px);
	margin-left: -32px;
	margin-bottom: 32px;
	border-collapse: collapse;
	border: 2px solid #333;
}
.content thead {
	border-bottom: 2px solid #333;
}
.content td, .content th {
	padding: 10px 14px;
	text-align: left;
}
.tags .tag {
	display: inline-block;
	padding: 4px;
	margin-right: 4px;
	border-radius: 4px;
	color: #fff;
	background-color: <?php echo $colour; ?>;
}
.tags .tag:hover {
	text-decoration: none;
	background-color: <?php echo $colour_hover; ?>;
}

.nav {
	display: block;
	margin-left: -12px;
	margin-bottom: 32px;
}
.nav ul, .pagination ul {
	list-style-type: none;
}
.nav li, .pagination li {
	display: inline-block;
	line-height: 2;
}
.nav li a {
	padding: 8px 12px;
}
.pagination {
	margin-bottom: 64px;
}
.pagination ul:after {
	clear:both;
	display: block;
	content: '';
	float: none;
}
.pagination li a {
	padding: 8px 16px;
	border: 2px solid <?php echo $colour; ?>;
	color: <?php echo $colour; ?>;
	border-radius: 8px;
}
.pagination li a:hover {
	border: 2px solid <?php echo $colour; ?>;
	background-color: <?php echo $colour; ?>;
	color: #fff;
}
.pagination .pag-newer {
	float: left;
}
.pagination .pag-older {
	float: right;
}
.footer {
	padding: 64px;
	color: #FFF;
	background-color: <?php echo $colour; ?>;
	font-weight: 800;
}
@media (max-width: 976px) {
	body { padding-top: 0; }
	.container { padding: 32px; }
	.pagination { margin-bottom: 0; }
	.footer { padding: 0; }
	.title { font-size: 1.4em; }
	.entry h2 { font-size: 1.9em; }
	.entry:last-of-type { padding-bottom: 16px; }
}
@media (max-width: 480px) {
	.nav, .entry table { font-size: 0.8em; }
	.entry h2 { font-size: 1.5em; }
	.entry .content h2 { font-size: 1.4em; }
	.entry .content h3 { font-size: 1.3em; }
	.entry .content h4 { font-size: 1.2em; }
	code[class*="language-"],
	pre[class*="language-"]  {
		font-size: 0.7em;
	}
}
</style>
<script src="<?php get_theme_js_dir(); ?>/prism.js" defer></script>

<div class="container">
	<h1 class="title"><a href="<?php get_home_link(); ?>"><?php echo Config::Title; ?></a></h1>
	<nav class="nav">
		<ul>
			<li><a href="<?php get_home_link(); ?>">Home</a></li>
			<?php
				$root = Config::Root;
				foreach ($Blog->pages as $Page) {
					echo "<li><a href='{$root}{$Page->slug}'>{$Page->title}</a></li>";
				}
			?>
		</ul>
	</nav>
	<div class="entries">

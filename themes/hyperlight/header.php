<!DOCTYPE html>
<html lang="en">
<title><?php echo $Blog->get_title(); ?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
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

	.token.comment,
	.token.prolog,
	.token.doctype,
	.token.cdata {
		color: slategray;
	}

	.token.punctuation {
		color: #f8f8f2;
	}

	.namespace {
		opacity: .7;
	}

	.token.property,
	.token.tag,
	.token.constant,
	.token.symbol,
	.token.deleted {
		color: #f92672;
	}

	.token.boolean,
	.token.number {
		color: #ae81ff;
	}

	.token.selector,
	.token.attr-name,
	.token.string,
	.token.char,
	.token.builtin,
	.token.inserted {
		color: #a6e22e;
	}

	.token.operator,
	.token.entity,
	.token.url,
	.language-css .token.string,
	.style .token.string,
	.token.variable {
		color: #f8f8f2;
	}

	.token.atrule,
	.token.attr-value,
	.token.function {
		color: #e6db74;
	}

	.token.keyword {
		color: #66d9ef;
	}

	.token.regex,
	.token.important {
		color: #fd971f;
	}

	.token.important,
	.token.bold {
		font-weight: bold;
	}
	.token.italic {
		font-style: italic;
	}

	.token.entity {
		cursor: help;
	}

	/* PRISM THEMING END */

	html {
		height: 100%;
	}
	body {
		font-family: "Helvetica Neue", "Arimo", "Noto Sans", "Lato", Arial, sans-serif;
		padding-top: 64px;
		font-size: 1.5em;
		min-height: 100%;
		display: flex;
		flex-direction: column;
		color: #333;
		overflow-x: hidden;
	}
	.title a {
		letter-spacing: -0.03em;
		line-height: 1;
		margin-bottom: 32px;
		display: block;
		text-decoration: none;
		color: #333;
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
		margin-top: 72px;
	}
	.entry:first-of-type {
		margin-top: 32px;
	}
	.entry:last-of-type {
		margin-bottom: 64px;
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
	.entry h1, .entry h2, .entry h3, .entry h4, .entry h5, .entry h6,
	.entry .content p, .entry img, .entry pre, .entry .content ul,
	.entry .content ol, .entry .content hr {
		margin-bottom: 32px;
		display: block;
	}
	.entry p, .entry .content li {
		line-height: 1.618;
	}
	.entry .content h2 {
		font-size: 1.4em;
	}
	.entry .content ul, .entry .content ol {
		margin-left: 32px;
	}
	.entry blockquote {
		font-style: italic;
		color: #555;
		padding-left: 32px;
		border-left: 3px solid <?php echo $colour; ?>;
	}
	.entry .content hr {
		border: 0;
		border-top: 1px solid #999;
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
	}
	@media (max-width: 976px) {
		body {
			padding-top: 0;
		}
		.container {
			padding: 32px;
		}
		.pagination {
			margin-bottom: 0;
		}
		.footer {
			padding: 0;
		}
		.title {
			font-size: 1.4em;
		}
		.entry:last-of-type {
			margin-bottom: 0;
		}
	}
	@media (max-width: 480px) {
		.nav {
			font-size: 0.8em;
		}
		.entry h2, .entry .content h2 {
			font-size: 1.3em;
		}
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

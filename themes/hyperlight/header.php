<?php if (!defined("HYPERLIGHT_INIT")) die(); ?><!DOCTYPE html>
<html lang="en">
<title><?php echo $Blog->get_title(); ?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="alternate" type="application/rss+xml" href="<?php echo Blog::get_base_url(); ?>rss.xml" title="RSS Feed">
<link rel="canonical" href="<?php echo $Blog->get_canonical_url(); ?>">
<meta name="generator" content="Hyperlight <?php echo HYPERLIGHT_INIT ?>" />
<!-- Open Graph Tags -->
<meta name="twitter:card" content="summary" />
<meta property="og:title" content="<?php echo $Blog->get_title(); ?>" />
<meta name="twitter:title" content="<?php echo $Blog->get_title(); ?>" />
<meta name="description" content="<?php echo $Blog->get_description(); ?>" />
<meta property="og:url" content="<?php echo $Blog->get_canonical_url(); ?>" />
<?php
if ($Blog->url === Url::Post || $Blog->url === Url::Page) {
	$post = $Blog->posts[0];
	if ($post->has_image()) {
		echo "<meta name='twitter:image' content='{$post->image}' />";
		echo "<meta property='og:image' content='{$post->image}' />";
	}
} ?>
<link rel="stylesheet" type="text/css" href="<?php echo Blog::get_theme_css_dir(); ?>/style.css">

<div class="container">
	<h1 class="title">
		<a href="<?php echo Config::Root; ?>">
			<?php echo Config::Title; ?>
		</a>
	</h1>
	<nav class="nav">
		<ul>
			<li><a href="<?php echo Config::Root; ?>">Home</a></li>
			<?php
				foreach ($Blog->pages as $page) {
					echo "<li><a href='{$page->get_url()}'>{$page->title}</a></li>";
				}
			?>
		</ul>
	</nav>
	<div class="entries">

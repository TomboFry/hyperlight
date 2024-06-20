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
<link rel="alternate" type="application/rss+xml" href="/rss.xml" title="RSS Feed">
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
<link rel="stylesheet" type="text/css" href="<?php echo Config::get_theme_css_dir(); ?>/style.css">

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

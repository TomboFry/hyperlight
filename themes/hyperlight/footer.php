<?php if (!defined("HYPERLIGHT_INIT")) die(); ?>
	</div>
</div>
<?php if ($Blog->has_pagination()) { ?>
<div class="pagination">
	<div class="container">
		<ul>
			<?php if ($Blog->has_page_prev()) { ?>
				<li class="pag-newer"><a href="<?php echo $Blog->get_page_prev(); ?>">< Newer</a></li>
			<?php } ?>

			<?php if ($Blog->has_page_next()) { ?>
				<li class="pag-older"><a href="<?php echo $Blog->get_page_next(); ?>">Older ></a></li>
			<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>
<footer class="footer"><div class="container"><?php echo Config::Footer; ?></div></footer>
</html>

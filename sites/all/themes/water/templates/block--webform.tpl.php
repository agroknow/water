<?php
//BLOCK THEMING
//https://www.drupal.org/node/104319
//https://www.drupal.org/node/1089656

//DEFAULT block.tpl.php IMPLEMENTATION IN 
//modules/system/block/block.tpl.php
?>
<section class="contact">
	<?php print render($title_prefix); ?>
	<?php if ($block->subject): ?>
	  <h3<?php print $title_attributes; ?>><?php print $block->subject ?></h3>
	<?php endif;?>
	  <?php print render($title_suffix); ?>
	<div id="<?php print $block_html_id; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
		<div class="content"<?php print $content_attributes; ?>>
	    <?php print $content ?>
	  	</div>
	</div>
</section>
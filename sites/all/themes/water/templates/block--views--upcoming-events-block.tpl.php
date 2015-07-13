<section data-theme-tpl="block-views-upcoming-events-block" class="slidelist">
    <?php if ($block->subject): ?>
        <!--h2 class="withrightlink clearfix"><?php print $block->subject ?><a href="<?php print base_path(); ?>search/node"><?php print('All events');?></a></h2-->
    <?php endif;?>
    <?php print $content ?>
</section>
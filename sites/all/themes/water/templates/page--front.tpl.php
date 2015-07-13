<header id="header">
    <div class="center clearfix">
<!-- *****
logo
****** -->
        <?php if ($logo):?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="logo ir"><?php print $site_name;?></a>
        <?php endif; ?>
<!-- *****
header_top_right: user_menu, lang_switcher
****** -->
        <?php print render($page['header_top_right']); ?>
<!-- *****
navigation: main_menu
****** -->
        <?php print render($page['navigation']); ?>
<!-- *****
header: search_block
****** -->
        <?php print render($page['header']); ?>
    </div>
</header>

<!-- *****
banner: slider(about_us)
***** -->
<section id="slider" data-theme-tpl="block--views--slider-block">
    <?php print render($page['banner']); ?>
</section>

<section id="blocks">            
    <div class="center">
        <!-- #messages -->
        <?php if ($messages):?>
        <div id="messages-console" class="clearfix"><?php print $messages; ?></div>
        <?php endif; ?>
<!-- *****
sidebar_first: featured_sections, science_links
****** -->
    <?php print render($page['sidebar_first']); ?>
<!-- *****
sidebar_second: view_latest_events, view_latest_new
****** -->
        <section class="twocols clearfix">
        <?php print render($page['sidebar_second']); ?>
        </section>
    </div>  <!-- .center -->          
</section><!-- #blocks -->
<section>
    <div class="center">
<!-- *****
bottom_content: twitter_slider
****** -->
<?php
    print render($page['bottom_content']);
    //print twitter_pull_render('@teokosmo', '', 3);
?>
    </div>
</section>
<footer id="footer">
<!-- *****
footer_first: bottom_menu, connect_with_us, contact_form
****** -->
    <?php print render($page['footer_first']); ?>
<!-- *****
footer_second: partners
****** -->
    <?php print render($page['footer_second']); ?>
<!-- *****
footer_third: copyright
****** -->
    <?php print render($page['footer_third']); ?>
</footer>
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

<section class="basic-wrapper">
    <div class="center">
        <!-- #messages -->
        <?php if ($messages):?>
        <div id="messages-console" class="clearfix"><?php print $messages; ?></div>
        <?php endif; ?>

        <!-- #breadcrumb -->
        <?php print $breadcrumb; ?>

        <section class="listing clearfix <?php if (($page['sidebar_first'] || $page['sidebar_second']) && strtolower(current_path()) != 'persons'){print 'sidebars';} ?>">
            <!-- #title -->
            <?php print render($title_prefix); ?>
            <?php if ($title):?>
            <h1><?php print $title; ?></h1>
            <?php endif; ?>
            <?php print render($title_suffix); ?>

            <!-- #help -->
            <?php print render($page['help']); ?>

            <!-- #tabs -->
            <?php if ($tabs):?>
            <nav><?php print render($tabs); ?></nav>
            <?php endif; ?>

            <!-- #action_links -->
            <?php if ($action_links):?>
            <ul class="action-links"><?php print render($action_links); ?></ul>
            <?php endif; ?>

            <!-- #content -->
            <?php print render($page['content']); ?>
            
            <!-- #sidebars -->
            <?php print render($page['sidebar_first']); ?>
            <?php print render($page['sidebar_second']); ?>
            
            <!-- #feed_icons -->
            <?php print $feed_icons; ?>
        </section>
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
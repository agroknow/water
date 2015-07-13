<header id="header">
    <div class="center clearfix">
        <?php if ($logo):?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="logo ir"><?php print $site_name;?></a>
        <?php endif; ?>
        <?php print render($page['header_top_right']); ?>
        <?php print render($page['navigation']); ?>
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
        
        <section class="listing clearfix">
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
        </section>
    </div>
</section>

<section id="slider">
    <!-- #content -->
    <?php print render($page['content']); ?>
</section>

<section id="blocks">            
    <div class="center">
        <?php print render($page['sidebar_first']); ?>
        <section class="twocols clearfix">
            <?php print render($page['sidebar_second']); ?>
        </section>
    </div>  <!-- .center -->          
</section><!-- #blocks -->
<footer id="footer">
    <?php print render($page['footer_first']); ?>
    <?php print render($page['footer_second']); ?>
    <?php print render($page['footer_third']); ?>
</footer>
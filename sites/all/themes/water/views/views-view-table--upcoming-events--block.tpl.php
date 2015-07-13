<?php

/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $caption: The caption for this table. May be empty.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */

foreach ($rows as $row_count => $row): ?>
<article class="event clearfix">
    <time datetime="2014-12-20 20:00"><?php print $row['field_starting_date']; ?></time>
    <h3><a href="#"><?php print $row['title']; ?></a></h3>
    <!--a href="#" class="slidetoggle ir">open/close</a>
    <section class="clearfix toslide">
        <img src="img/sample100x75.jpg" />
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus risus libero, suscipit vestibulum risus a. </p>
        <a href="#" class="more">more</a>
    </section!-->
<?php 
/*foreach ($row as $field => $content){
    print $content;
}*/
?>
</article>
<?php endforeach; ?>
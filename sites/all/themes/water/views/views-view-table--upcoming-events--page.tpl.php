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
//krumo($rows);exit;
foreach ($rows as $row_count => $row): ?>
<article class="event clearfix">
    <time datetime="2014-12-20 20:00"><?php print $row['field_starting_date']; ?></time>
    <div class="until"><?php print $row['field_ending_date']; ?></div>
    <h3><?php print $row['title']; ?></h3>
</article>
<?php endforeach; ?>
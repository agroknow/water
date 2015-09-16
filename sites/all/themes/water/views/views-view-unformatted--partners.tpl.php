<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php
$rowsnum = count($rows);
$mod4 = $rowsnum % 4;
$mod3 = $rowsnum % 3;
$break = 0;
if ($rowsnum <= 4) {
    $cols = $rowsnum;
} else {
    if($mod4 == 0){
	$cols = 4;
    } else {
	if($mod3 == 0) {
	    $cols = 3;
	} else {
	    if($mod4 == 1) {
		$cols = 3;
		$break = $rowsnum - $mod3;
		$breakcols = $mod3;
	    } else {
		$cols = 4;
		$break = $rowsnum - $mod4;
		$breakcols = $mod4;
	    }
	}
	
    }
}
?>
<?php if (!empty($title)): ?>
    <h3><?php print $title; ?></h3>
<?php endif; ?>
<div class="cols"> 
    
<?php $count = 0; foreach ($rows as $id => $row): ?>
    <?php if(($break && $id == $break) || $count == $cols) { ?>
    </div><div class="cols">
    <?php if(!$break) $count = 0; } ?>
    <div class="col colspan<?php if($break && $id >= $break) { echo 12/$breakcols; } else { echo 12/$cols; } ?>">
    <?php print $row; $count++; ?>
    </div>
<?php endforeach; ?>
</div>

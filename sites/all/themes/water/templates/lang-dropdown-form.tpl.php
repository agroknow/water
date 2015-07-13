<?php
  // Render or hide parts of $form: var_export($form);
  // Example given:
 
/*
hide($form['title']);
print render($form['first']);
//var_export($form);
  // Render remaining form elements as usual.
  print drupal_render_children($form);
*/
//print drupal_render_children($form);
//var_export($form);

//print render($form);
//print drupal_render_children($form);

$form['lang_dropdown_select']['#attributes']['class'][] = 'simple';
print drupal_render_children($form);
?>
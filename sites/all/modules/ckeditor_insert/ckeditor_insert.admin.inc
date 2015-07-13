<?php

function ckeditor_insert_settings_form() {
  drupal_set_message(t('Only unlimited-values file/image fields whose Insert feature is on are available.'), 'warning');
  $file_fields = $image_fields = array(0 => t('None'));
  foreach (field_info_fields() as $field_name => $info) {
    if (in_array($info['type'], array(
      'file',
      'image',
    )) && $info['cardinality'] == -1) {
      foreach ($info['bundles'] as $entity_type => $bundles) {
        foreach ($bundles as $bundle_name) {
          $instance = field_info_instance($entity_type, $field_name, $bundle_name);
          if (isset($instance['widget']['settings']['insert']) && $instance['widget']['settings']['insert']) {
            if ($info['type'] == 'image') {
              $image_fields[$field_name] = $instance['label'];
            }
            else {
              $file_fields[$field_name] = $instance['label'];
            }
          }
        }
      }
    }
  }
  $form['ckeditor_insert_file_field'] = array(
    '#type' => 'select',
    '#title' => t('File field for insert'),
    '#options' => $file_fields,
    '#default_value' => variable_get('ckeditor_insert_file_field', 0),
  );

  $form['ckeditor_insert_image_field'] = array(
    '#type' => 'select',
    '#title' => t('Image field for insert'),
    '#options' => $image_fields,
    '#default_value' => variable_get('ckeditor_insert_image_field', 0),
  );

  return system_settings_form($form);
}

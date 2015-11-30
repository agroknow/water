<?php
/**
 * @file
 * water_fe_news.features.inc
 */

/**
 * Implements hook_views_api().
 */
function water_fe_news_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_image_default_styles().
 */
function water_fe_news_image_default_styles() {
  $styles = array();

  // Exported image style: small.
  $styles['small'] = array(
    'label' => 'small',
    'effects' => array(
      1 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 170,
          'height' => 92,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}

/**
 * Implements hook_node_info().
 */
function water_fe_news_node_info() {
  $items = array(
    'article' => array(
      'name' => t('Article'),
      'base' => 'node_content',
      'description' => t('Generic news.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}

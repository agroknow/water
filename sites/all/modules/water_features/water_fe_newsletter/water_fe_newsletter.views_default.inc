<?php
/**
 * @file
 * water_fe_newsletter.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function water_fe_newsletter_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'newsletter_archive';
  $view->description = 'Display a list of months that link to content for that month.';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'newsletter archive';
  $view->core = 0;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Newsletters';
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['query']['options']['query_comment'] = FALSE;
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['row_plugin'] = 'node';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Contextual filter: Content: Created year + month */
  $handler->display->display_options['arguments']['created_year_month']['id'] = 'created_year_month';
  $handler->display->display_options['arguments']['created_year_month']['table'] = 'node';
  $handler->display->display_options['arguments']['created_year_month']['field'] = 'created_year_month';
  $handler->display->display_options['arguments']['created_year_month']['default_action'] = 'summary';
  $handler->display->display_options['arguments']['created_year_month']['exception']['title_enable'] = TRUE;
  $handler->display->display_options['arguments']['created_year_month']['title_enable'] = TRUE;
  $handler->display->display_options['arguments']['created_year_month']['title'] = '%1';
  $handler->display->display_options['arguments']['created_year_month']['default_argument_type'] = 'fixed';
  $handler->display->display_options['arguments']['created_year_month']['summary']['sort_order'] = 'desc';
  $handler->display->display_options['arguments']['created_year_month']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['created_year_month']['summary_options']['override'] = TRUE;
  $handler->display->display_options['arguments']['created_year_month']['summary_options']['items_per_page'] = '30';
  $handler->display->display_options['arguments']['created_year_month']['specify_validation'] = TRUE;
  /* Contextual filter: Content: Sent (field_sent) */
  $handler->display->display_options['arguments']['field_sent_value']['id'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['table'] = 'field_data_field_sent';
  $handler->display->display_options['arguments']['field_sent_value']['field'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['default_argument_type'] = 'date';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['format'] = 'default_summary';
  /* Filter criterion: Content: Published */
  $handler->display->display_options['filters']['status']['id'] = 'status';
  $handler->display->display_options['filters']['status']['table'] = 'node';
  $handler->display->display_options['filters']['status']['field'] = 'status';
  $handler->display->display_options['filters']['status']['value'] = 1;
  $handler->display->display_options['filters']['status']['group'] = 0;
  $handler->display->display_options['filters']['status']['expose']['operator'] = FALSE;
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'newsletter' => 'newsletter',
  );

  /* Display: Page */
  $handler = $view->new_display('page', 'Page', 'page');
  $handler->display->display_options['defaults']['pager'] = FALSE;
  $handler->display->display_options['pager']['type'] = 'some';
  $handler->display->display_options['pager']['options']['items_per_page'] = '10';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['defaults']['style_plugin'] = FALSE;
  $handler->display->display_options['style_plugin'] = 'default';
  $handler->display->display_options['defaults']['style_options'] = FALSE;
  $handler->display->display_options['defaults']['row_plugin'] = FALSE;
  $handler->display->display_options['row_plugin'] = 'fields';
  $handler->display->display_options['defaults']['row_options'] = FALSE;
  $handler->display->display_options['defaults']['fields'] = FALSE;
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['element_type'] = 'h3';
  $handler->display->display_options['fields']['title']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['title']['node_in_colorbox_width'] = '600';
  $handler->display->display_options['fields']['title']['node_in_colorbox_height'] = '600';
  $handler->display->display_options['fields']['title']['node_in_colorbox_rel'] = '';
  $handler->display->display_options['defaults']['arguments'] = FALSE;
  /* Contextual filter: Content: Sent (field_sent) */
  $handler->display->display_options['arguments']['field_sent_value']['id'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['table'] = 'field_data_field_sent';
  $handler->display->display_options['arguments']['field_sent_value']['field'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['default_argument_type'] = 'date';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['field_sent_value']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['field_sent_value']['year_range'] = '-5:+5';
  $handler->display->display_options['arguments']['field_sent_value']['granularity'] = 'year';
  $handler->display->display_options['arguments']['field_sent_value']['use_fromto'] = 'no';
  $handler->display->display_options['path'] = 'newsletters';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');
  $handler->display->display_options['defaults']['arguments'] = FALSE;
  /* Contextual filter: Content: Sent (field_sent) */
  $handler->display->display_options['arguments']['field_sent_value']['id'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['table'] = 'field_data_field_sent';
  $handler->display->display_options['arguments']['field_sent_value']['field'] = 'field_sent_value';
  $handler->display->display_options['arguments']['field_sent_value']['default_action'] = 'summary';
  $handler->display->display_options['arguments']['field_sent_value']['default_argument_type'] = 'date';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['sort_order'] = 'desc';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['field_sent_value']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['field_sent_value']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['field_sent_value']['year_range'] = '-5:+5';
  $handler->display->display_options['arguments']['field_sent_value']['granularity'] = 'year';
  $handler->display->display_options['arguments']['field_sent_value']['use_fromto'] = 'no';
  $translatables['newsletter_archive'] = array(
    t('Master'),
    t('Newsletters'),
    t('more'),
    t('Apply'),
    t('Reset'),
    t('Sort by'),
    t('Asc'),
    t('Desc'),
    t('Items per page'),
    t('- All -'),
    t('Offset'),
    t('« first'),
    t('‹ previous'),
    t('next ›'),
    t('last »'),
    t('Title'),
    t('All'),
    t('%1'),
    t('Page'),
    t('Block'),
  );
  $export['newsletter_archive'] = $view;

  return $export;
}

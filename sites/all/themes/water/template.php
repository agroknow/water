<?php

/*
 * hook_theme
 */
function water_theme($existing, $type, $theme, $path){
    //varDumpDebug('water_theme......'.drupal_get_path('theme', 'water'));
    //varDumpDebug('water_theme......'.$path);
    $langDDFormTpl = array(
            'render element' => 'form',
            'path' => $path.'/templates' ,
            'template' => 'lang-dropdown-form');
    return array(
        'lang_dropdown_form' => $langDDFormTpl
    );
}

/**
 * Preprocessor for lang_dropdown_form_language theme.
 */
function water_preprocess_lang_dropdown_form(&$variables){
     //varDumpDebug('water_preprocess_lang_dropdown_form_language.......'.drupal_get_path('theme', 'water'));
    //var_export($variables);
}

/*
 * theme search block form
 * https://www.drupal.org/node/154137
 */
function water_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
      $form['search_block_form']['#attributes']['title'] = t('Type a keyword to search in GWP page');
      $form['search_block_form']['#attributes']['placeholder'] = t('Type a keyword to search in GWP page');
      $form['actions']['submit']['#value'] = "";
      $form['search_block_form']['#field_suffix'] = drupal_render($form['actions']['submit']);
  }
}

/*
 * hook_form, hook_form_element etc
 */

/**
 * Preprocess variables for page.tpl.php
 * default variales for page.tpl.php:
 * $logo, $front_page, $site_name, $site_slogan, $messages
 * $title_prefix, $title_suffix, $tabs, $action_links
 * $feed_icons, $breadcrumb
 */
function water_preprocess_page(&$vars) {
  if ( isset($vars['node']) && isset($vars['node']->type) ) {
    // If the node type is "blog_madness" the template suggestion will be "page--blog-madness.tpl.php".
    $vars['theme_hook_suggestions'][] = 'page__'. $vars['node']->type;
      
      if($vars['node']->type == 'deprecated_organization'){
          //var_dump($vars['node']);
          //$vars['organization_geolocation'] = array($vars['node']->field_latitude['und']['0']['value'], $vars['node']->field_longitude['und']['0']['value']);
/*
 * LOAD GMAPS MODULE
 */
    //add html element 'organization-gmap-canvas' in template file that will hold Google map          
    //Load gmap3_tools.inc file
    module_load_include('inc', 'gmap3_tools');
          
    //all gmap3_tools_add_map() function from API file with appropriate map configuratio array
    gmap3_tools_add_map(array(
      'mapId' => 'organization-gmap-canvas',
      'mapOptions' => array(
        'centerX' => -34.397,
        'centerY' => 150.644,
        'zoom' => 12,
      ),
      'markers' => array(
        //gmap3_tools_create_marker($vars['node']->field_latitude['und']['0']['value'], $vars['node']->field_longitude['und']['0']['value'], 'Home', 'Home')
          gmap3_tools_create_marker(-1, -1, 'Home', 'Home')
      ),
      'geocodeAddress' => $vars['node']->field_city['und']['0']['taxonomy_term']->name,  //provide current address in geocoding services and override lat/lgd in markers property with the retrieved ones
      'gmap3ToolsOptions' => array(
        'defaultMarkersPosition' => GMAP3_TOOLS_DEFAULT_MARKERS_POSITION_CENTER,
      ),
    ));
      
      }
      if($vars['node']->type == 'book'){
      //create a variable to hold rich title field added to specific content types
      $view = node_view($vars['node']);
      $vars['rich_title'] = render($view['field_rich_title']);
      }
  }
    
        
    //var_dump($vars);
    //var_export($vars);
    //var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
    
//    $vars['contact_form'] = drupal_render(drupal_get_form('contact_site_form'));
}

/**
 * Preprocess variables for html.tpl.php
 */
function water_preprocess_html(&$variables) {
    $variables['page_bottom_script_tags'] = ''.
        '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>'.
        '<script>window.jQuery || document.write(\'<script src="'.base_path() . path_to_theme().'/js/vendor/jquery-1.11.1.min.js"><\/script>\')</script>'.
        '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>'.
        '<script src="'.base_path() . path_to_theme().'/js/vendor/slick.min.js"></script>'.
        '<script>var oWaterJQuery = $.noConflict(true);</script>'.
        '<script src="'.base_path() . path_to_theme().'/js/main.js"></script>'.
        '<script>
            jQuery(\'table.s-table\').not(\'table.field-multiple-table,form#system-modules table\').stacktable();
            //jQuery(\'table.views-table\').stacktable();
            jQuery(\'#navigation\').slimmenu(
            {
                resizeWidth: \'768\',
                collapserTitle: \'Main Menu\',
                animSpeed: \'medium\',
                easingEffect: null,
                indentChildren: false,
                childrenIndenter: \'&nbsp;\'
            });
             jQuery(\'.tabs.primary\').slimmenu(
            {
                resizeWidth: \'768\',
                collapserTitle: \'\',
                animSpeed: \'medium\',
                easingEffect: null,
                indentChildren: false,
                childrenIndenter: \'&nbsp;\'
            });
        </script>';
    
    global $base_root, $base_path;
    
    $variables['base_root'] = $base_root;
    $variables['base_path'] = $base_path;
    
    /*
     * google fonts
     */
    drupal_add_css('http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&subset=latin,greek-ext', array('type' => 'external'));
    drupal_add_css('http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext', array('type' => 'external'));
    /*
     * core js libraries
     */
    drupal_add_js(drupal_get_path('theme', 'water') . '/js/vendor/modernizr-2.6.2.min.js');
    
}

/**
 * Page alter.
 */
function water_page_alter($page) {
}

/*
 * hook theme_menu_tree (defined in includes/menu.inc)
 */
function water_menu_tree__user_menu($variables){
    //return '<ul class="menu">' . $variables['tree'] . '</ul>';
    return $variables['tree'];
}

/*
 * hook theme_menu_link (defined in includes/menu.inc)
 * 
 * customize display of user menu
 * sample:
 * <a href="#" id="login" class="ir">login</a>
 * <a href="#" id="logout" class="ir">logout</a>
 */
function water_menu_link__user_menu($variables){
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
//set class
    if(isset($element['#localized_options']['attributes']['class'])){
        $element['#localized_options']['attributes']['class'][] = "ir";
    }
    else{
        $element['#localized_options']['attributes']['class'] = array("ir");
    }
//set id
    if(strpos($element['#href'], "logout") !== FALSE ){
        $element['#localized_options']['attributes']['id'] = "logout";
    }
	else if(strpos($element['#href'], "node/180") !== FALSE ){
		$element['#localized_options']['attributes']['id'] = "online-help";
	}
	else{
		$element['#localized_options']['attributes']['id'] = "login";
	}
//generate anchor html with l()    
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);   
    
  return $output;
}

/*
 * hook theme_menu_tree (defined in includes/menu.inc)
 */
function water_menu_tree__main_menu($variables){
    return '<ul id="navigation" class="slimmenu clearfix">' . $variables['tree'] . '</ul>';
}

/*
 * custom theme_menu_tree for submenu
 */
function water_menu_tree__main_menu_sub($variables){
    return '<ul>' . $variables['tree'] . '</ul>';
}
/*
 * hook theme_menu_link (defined in includes/menu.inc)
 */
function water_menu_link__main_menu($variables){
  $element = $variables['element'];
  $sub_menu = '';
  $elm_classes = array();
  $class_attribute = '';

  if ($element['#below']) {
    $element['#below']['#theme_wrappers'] = array('menu_tree__main_menu_sub');
    $sub_menu = drupal_render($element['#below']);
    $elm_classes[] = 'hassub';
//set class for trigger of submenu
    if(isset($element['#localized_options']['attributes']['class'])){
        $element['#localized_options']['attributes']['class'][] = "subtrigger";
    }#
    else{
        $element['#localized_options']['attributes']['class'] = array("subtrigger");
    }
  }
//generate anchor html with l()    
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
//add active class if menu item is selected    
    if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($options['language']) || $options['language']->language == $language_url->language)) {
        $elm_classes[] = 'active';
    }
    
    foreach($elm_classes as $class){
        $class_attribute .= $class." ";
    }
    $class_attribute = trim($class_attribute);
    
    if($class_attribute == ""){
        $output = "<li>" . $output . $sub_menu ."</li>";
    }
    else{
        $output = "<li class='" . $class_attribute . "' >" . $output . $sub_menu ."</li>";    
    }    
//    $output = '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";

    return $output;
}

/*
 * hook theme_breadcrumb
 */
function water_breadcrumb($variables){
    $breadcrumb = $variables['breadcrumb'];
    $crumbs = '';

  if (!empty($breadcrumb)) {
      $crumbs = '<nav class="breadcrumbs clearfix">';

      foreach($breadcrumb as $value) {
           $crumbs .= $value;
      }
      $crumbs .= '</nav>';
    }
    return $crumbs;
}

function water_preprocess_table(&$variables) {
  $variables['attributes']['class'][] = 's-table';
}

function isFrontPage(){
    return (strtolower($_GET['q']) == $front_page);
}

function varDumpDebug($var){
    print '<br/>**************************<br/>';
    print '**************************<br/>';
    print '**************************<br/>';
    var_dump($var);    
    //dpm()
    //ddebug_backtrace($pop = 0)
}

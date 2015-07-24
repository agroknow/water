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
?>

<?php
//Load gmap3_tools.inc file
module_load_include('inc', 'gmap3_tools');
//add html element 'organization-gmap-canvas' in template file that will hold Google map          
print '<div id="organization-gmap-canvas"><div class="ajax-progress" style="width:100%;margin-left:49%;"><div class="throbber"></div></div></div>';
//add html element 'markers-legend' in template file that will hold Google map's legend
//print '<div id="markers-legend"></div>';

$icon = 'marker.png';
$coordinates = array();
$matches = array();
$match = '';
$coordinatesGroup = array();
$geocodeAddresses = array();
$markers = array();
$legendInfo = array();
$text = '';
$inlineDelim = ' ';
$paragraphDelim = '<br/>';
$geolocationIdx = 'field_person_geolocation';

foreach ($rows as $row_count => $row){
    if($row[$geolocationIdx] != ''){
        $node = !empty($row['field_affiliation']) ? node_load($row['field_affiliation']) : NULL;
        $affiliationInfo = '';
        $icon = 'marker.png';
        
        if(!empty($node)){
            //var_dump($node);
            $url = !empty($node->field_url["und"]) ? 
                        l($node->title, $node->field_url["und"][0]["value"], array('external' => TRUE, 'attributes' => array('target'=>'_blank'))) :
                        l($node->title, 'node/'.$node->nid);
            $affiliationInfo = $url;
        }
    //set default coords
        $match = '-1,-1';
    //get string between ()
        if(preg_match('/\(.*\)/', $row[$geolocationIdx], $matches)){
    //remove chars () if match returned
            $match = substr($matches[0], 1, strlen($matches[0])-2);
        }
    //split coordinates
        $coordinates = explode(",", $match);
    //split groups
        $groups = explode(",", $row['field_group']);
        /*
         * add coordinates to $coordinatesGroup
         * if coordinates already exist increase counter of common coordinates
         * and append 0.02 to longitude value in order to display properly in gmap view
         */
        if(!isset($coordinatesGroup[$coordinates[0].$coordinates[1]])){
            $coordinatesGroup[$coordinates[0].$coordinates[1]] = 0;
        }
        else{
            $coordinatesGroup[$coordinates[0].$coordinates[1]]++;
            $coordinates[1] = $coordinates[1] + (0.02 * $coordinatesGroup[$coordinates[0].$coordinates[1]]);
        }    
        /*
         * marker text
         */
        $text = $row['field_first_name'].$inlineDelim.
                $row['title'].$paragraphDelim.
                $affiliationInfo.$paragraphDelim.
                implode($paragraphDelim, $groups);
        /*
         * get icon from taxonomy term
         */
        $term_tree = taxonomy_get_term_by_name($groups[0]);
        foreach ($term_tree as $term) {
            //var_dump($term);
            $icon = (!empty($term) && !empty($term->field_marker_url)) ? $term->field_marker_url['und']['0']['value'] : 'marker.png';
        }        
        /*
         * markers options: https://developers.google.com/maps/documentation/javascript/reference?csw=1#MarkerOptions
         * markers icons: http://mabp.kiev.ua/2010/01/12/google-map-markers/
         */
        $icon_url = file_create_url(variable_get('file_public_path', conf_path() . '/files') . '/gmap3_markers/'.$icon);
        $markers[] = gmap3_tools_create_marker($coordinates[0], $coordinates[1], '', $text, array(
            'icon' => $icon_url,
            'group' => $groups[0]
        ));        
        /*
         * legend info
         */
        if(empty($legendInfo[$groups[0]])){
            $legendInfo[$groups[0]] = array(
                'iconUrl' =>  $icon_url,
                'text' => $groups[0]
            );
        }
    }
}

/*
all gmap3_tools_add_map() function from API file with appropriate map configuration array,
for more map options check https://developers.google.com/maps/documentation/javascript/reference?csw=1#MapOptions
*/
gmap3_tools_add_map(array(
  'mapId' => 'organization-gmap-canvas',
  'mapOptions' => array(
    'centerX' => -34.397,
    'centerY' => 150.644,
    'zoom' => 2,
    'scrollwheel' => false,
  ),
  'legend' => array(
      'header' => '',
      'content' => $legendInfo,
  ),
  'markers' => $markers,
/*
  'markers' => array(
    //gmap3_tools_create_marker($vars['node']->field_latitude['und']['0']['value'], $vars['node']->field_longitude['und']['0']['value'], 'Home', 'Home')
    //gmap3_tools_create_marker(-1, -1, 'Home', 'Home')
  ),
  'geocodeAddress' => $geocodeAddresses,
*/
  'gmap3ToolsOptions' => array(
    'defaultMarkersPosition' => GMAP3_TOOLS_DEFAULT_MARKERS_POSITION_CENTER,
  ),
));


?>

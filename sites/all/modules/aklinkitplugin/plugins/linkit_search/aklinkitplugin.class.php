<?php
/**
 * @file
 * Define Linkit node search plugin class.
 */

/**
 * Reprecents a Linkit node search plugin.
 */
class AkLinkitPlugin extends LinkitSearchPluginNode {

  /**
   * Overrides LinkitSearchPluginEntity::createRowClass().
   *
   * Adds an extra class if the node is unpublished.
   */
  function createRowClass($entity) {
    if ($this->conf['include_unpublished'] && $entity->status == NODE_NOT_PUBLISHED) {
      return 'unpublished-node';
    }
  }

  /**
   * Overrides LinkitSearchPluginNode::getQueryInstance().
   */
  function getQueryInstance() {
    // Create a db select to perform a custom query
    /* Query to create
    SELECT node.title AS node_title, node.nid AS nid, node.language AS node_language, biblio.biblio_type AS biblio_tid, biblio.biblio_citekey AS biblio_biblio_citekey, biblio.vid AS biblio_vid, biblio.biblio_year AS biblio_biblio_year
    FROM 
    {node} node
    INNER JOIN {biblio_contributor} biblio_contributor ON node.vid = biblio_contributor.vid
    INNER JOIN {biblio_contributor_data} biblio_contributor_data ON biblio_contributor.cid = biblio_contributor_data.cid
    LEFT JOIN {biblio} biblio ON node.vid = biblio.vid
    WHERE (( (node.status = '1') AND (node.type IN  ('biblio')) AND (biblio_contributor_data.name like '%searchstring%') ))
    */
    $this->query = db_select('node', 'n');
    $this->query->innerJoin('biblio_contributor', 'bc', 'n.vid = bc.vid');
    $this->query->innerJoin('biblio_contributor_data', 'bcd', 'bc.cid = bcd.cid');
    $this->query->leftJoin('biblio', 'b', 'n.vid = b.vid');
    
    
    $this->query->fields('n',array('nid')); //get nid,title
    $this->query->addExpression("CONCAT(b.biblio_year, ' Author: ', bcd.name)", 'nameyear');
    //$this->query->fields('bcd', array('name')); //get nid,title
    $this->query->condition('n.status', 1);
    $this->query->condition('n.type', 'biblio');
    
  }

  /**
   * Implements LinkitSearchPluginInterface::fetchResults().
   */
  public function fetchResults($search_string) {
    // If the $search_string is not a string, something is wrong and an empty
    // array is returned.
    $matches = array();

    // Get the EntityFieldQuery instance.
    $this->getQueryInstance();
    $or = db_or();
    $or->condition('n.title', '%' . db_like($search_string) . '%', 'LIKE');
    $or->condition('bcd.name', '%' . db_like($search_string) . '%', 'LIKE');
    $this->query->condition($or);

    // Add the search condition to the query object.
    /*$this->query->propertyCondition($this->entity_field_label,
            '%' . db_like($search_string) . '%', 'LIKE')
        ->addTag('linkit_entity_autocomplete')
        ->addTag('linkit_' . $this->plugin['entity_type'] . '_autocomplete');*/
 
/*
 * DEBUGGING
 * to search a biblio node using author name 
 * search must include tables biblio_contributor_data & biblio_contributor & (biblio or node)
 * EntityFieldQuery cannot support current requirement
 * implement plain query execution and return results in the format of EntityFieldQuery ($this->query->execute() & $matches)
 * e.g. (biblio.pages.inc)
 * $db_result = db_query('SELECT bd.cid, bd.drupal_uid, bd.name, bd.lastname,
                                bd.firstname, bd.prefix, bd.suffix,
                                bd.initials, bd.affiliation, bd.md5, bd.literal,
                                COUNT(*) AS cnt
                            FROM {biblio_contributor} b
                                 LEFT JOIN {biblio_contributor_data} bd ON b.cid = bd.cid
                                 INNER JOIN {node} n on n.vid = b.vid
                            ' . $where_clause . '
                            GROUP BY bd.cid, bd.drupal_uid, bd.name, bd.lastname,
                                     bd.firstname, bd.prefix, bd.suffix,
                                     bd.initials, bd.affiliation, bd.md5, bd.literal
                            ORDER BY  lastname ASC, SUBSTRING(firstname,1,1) ASC,
                            initials ASC', array(':filter' => $filter));
 * 
$matches[] = array(
    'title' => $this->entity_field_label,
    'description' => '',
    'path' => '',
    'group' => '',
    'addClass' => '',
);
return $matches;
*/
      
/*    // Add access tag for the query.
    // There is also a runtime access check that uses entity_access().
    $this->query->addTag($this->plugin['entity_type'] . '_access');

    // Bundle check.
    if (isset($this->entity_key_bundle) && isset($this->conf['bundles']) ) {
      $bundles = array_filter($this->conf['bundles']);
      if ($bundles) {
        $this->query->propertyCondition($this->entity_key_bundle, $bundles, 'IN');
      }
    }*/

    // Execute the query.
    $result = $this->query->execute()->fetchAllKeyed();
    
    /*if (!isset($result[$this->plugin['entity_type']])) {
      return array();
    }*/

    $ids = array_keys($result);

    // Load all the entities with all the ids we got.
    $entities = entity_load('node', $ids);

    foreach ($entities AS $key => $entity) {
      // Check the access againt the definded entity access callback.
      if (entity_access('view', 'node', $entity) === FALSE) {
        continue;
      }

      $matches[] = array(
        'title' => $this->createLabel($entity),
        'description' => $this->createDescription($entity) . ' Year: ' . $result[$key],
        'path' => $this->createPath($entity),
        'group' => $this->createGroup($entity),
        'addClass' => $this->createRowClass($entity),
      );

    }
    return $matches;
  }

  /**
   * Overrides LinkitSearchPlugin::buildSettingsForm().
   */
  function buildSettingsForm() {
    // Get the parent settings form.
    $form = parent::buildSettingsForm();

    $form[$this->plugin['name']]['include_unpublished'] = array(
      '#title' => t('Include unpublished nodes'),
      '#type' => 'checkbox',
      '#default_value' => isset($this->conf['include_unpublished']) ? $this->conf['include_unpublished'] : 0,
      '#description' => t('In order to see unpublished nodes, the user most also have permissions to do so. '),
    );

    return $form;
  }
}
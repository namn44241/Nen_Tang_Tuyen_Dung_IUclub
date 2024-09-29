<?php
/*
Plugin Name: Code From Url
Version: 2.0
Plugin URI: tba
Description:
Author: Jared Barneck (Rhyous)
Author URI: http://www.rhyous.com
*/

class github {
  var $db;
  var $table;
  var $cache = array();

  function github() {
    global $wpdb;

    $this->db = $wpdb;
    $this->table = $this->db->prefix . "CodeAsUrl";
  }

  function install() {
    $result = $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
                               `id` int(10) unsigned NOT NULL auto_increment,
                               `url` text NOT NULL,
                               `code` text NOT NULL,
                               `updated` datetime NOT NULL default '0000-00-00 00:00:00',
                               PRIMARY KEY  (`id`)
                               )");
  }

  function uninstall() {
    $result = $this->db->query("DROP TABLE IF EXISTS `{$this->table}`");
  }

  function get_code($text='') {
    $pattern = '/(CodeFromUrl=["\'][^"\']*["\'])/i';
    if (preg_match_all($pattern, $text, $matches)) {
      $urls = [];
      $i = 0;
      foreach($matches[0] as $match) {
        $urls[$i++] = trim(str_replace('CodeFromUrl=', '', $match), "\"");
      }
      $this->__loadCache($urls);

      foreach($matches[0] as $match) {
        $url = trim(str_replace('CodeFromUrl=', '', $match), "\"");
        if (isset($this->cache[$url])) {
          $code = $this->cache[$url];
        } else {
          $code = wp_remote_fopen($url);
          $code = str_replace('<', '&lt;', $code);
          $this->__setCache($url, $code);
        }
        $text = str_replace($match, $code, $text);
      }
    }

    return $text;
  }

  function __loadCache($urls) {
    $sql = $this->db->prepare( "SELECT * FROM $this->table WHERE url IN (%s)", implode('", "', $urls)); 
    $results = $this->db->get_results($sql, ARRAY_A);
    if ($results) {
      $old = array();
      foreach($results as $row) {
        if($row['updated'] < date('Y-m-d H:i:s', strtotime('-1 day'))) {
          $old[] = $row['id'];
        } else {
          $this->cache[$row['url']] = $row['code'];
        }
      }
      
      if($old) {
        $this->db->delete( $this->table, array( 'id' => implode(',', $old) ) );
      }
    }

    return true;
  }

  function __setCache($url, $code) {
    $this->db->insert( $this->table, array( 'url' => $url, 'code' => $code, 'updated' => date('Y-m-d H:i:s')));
  }
}

$github = new github();
register_activation_hook(__FILE__, array($github, 'install'));
register_deactivation_hook(__FILE__, array($github, 'uninstall'));
add_filter('the_content', array($github, 'get_code'), 8);
?>

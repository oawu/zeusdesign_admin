<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class ArticleTag extends OaModel {

  static $table_name = 'article_tags';

  static $has_one = array (
  );

  static $has_many = array (
    array ('mappings', 'class_name' => 'ArticleTagMapping'),
    array ('articles', 'class_name' => 'Article', 'through' => 'mappings', 'conditions' => array ('status = ?', Article::STATUS_2)),
  );

  static $belongs_to = array (
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function destroy () {
    if ($this->mappings)
      foreach ($this->mappings as $mapping)
        if (!$mapping->destroy ())
          return false;

    return $this->delete ();
  }

  public function backup ($has = false) {
    $var = array (
      'id'         => $this->id,
      'name'       => $this->name,
      'updated_at' => $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at' => $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );

    return $has ? array (
        '_' => $var,
        'mappings' => $this->subBackup ('ArticleTagMapping'),
      ) : $var;
  }
}
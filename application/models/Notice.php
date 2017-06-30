<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class Notice extends OaModel {

  static $table_name = 'notices';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );

  const STATUS_1 = 1;
  const STATUS_2 = 2;

  static $statusNames = array (
    self::STATUS_1 => '未讀',
    self::STATUS_2 => '已讀',
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public static function send ($user_ids, $content, $uri = '') {
    if (!is_array ($user_ids)) $user_ids = array ($user_ids);
    
    foreach (array_unique ($user_ids) as $user_id)
      if (!verifyCreateOrm (Notice::create (array ('user_id' => $user_id, 'content' => $content, 'uri' => $uri, 'status' => Notice::STATUS_1))))
        return false;

    return true;
  }
  public function destroy () {
    if (!isset ($this->id)) return false;

    return $this->delete ();
  }
  public function backup ($has = false) {
    $var = array (
      'id'         => $this->id,
      'user_id'    => $this->user_id,
      'content'    => $this->content,
      'uri'        => $this->uri,
      'status'     => $this->status,
      'updated_at' => $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at' => $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );
    return $has ? array (
        '_' => $var,
      ) : $var;
  }
}
<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 * @link        http://www.ioa.tw/
 */

class Deploy extends OaModel {

  static $table_name = 'deploys';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );

  const SUCCESS_NO  = 0;
  const SUCCESS_YES = 1;

  static $successNames = array(
    self::SUCCESS_NO  => '失敗',
    self::SUCCESS_YES => '成功',
  );

  const TYPE_BUILD    = 1;
  const TYPE_UPLOAD   = 2;

  static $typeNames = array(
    self::TYPE_BUILD    => '編譯',
    self::TYPE_UPLOAD   => '上傳（編譯完後上傳）',
  );
  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }
  public function columns_val ($has = false) {
    $var = array (
      'id'         => $this->id,
      'user_id'    => $this->user_id,
      'type'       => $this->type,
      'is_success' => $this->is_success,
      'updated_at' => $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at' => $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );
    return $has ? array ('this' => $var) : $var;
  }
}
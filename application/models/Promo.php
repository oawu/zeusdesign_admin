<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Promo extends OaModel {

  static $table_name = 'promos';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );
  
  const ENABLE_NO  = 0;
  const ENABLE_YES = 1;

  static $enableNames = array(
    self::ENABLE_NO  => '停用',
    self::ENABLE_YES => '啟用',
  );

  const TARGET_BLANK = 1;
  const TARGET_SELF  = 0;

  static $targetNames = array(
    self::TARGET_BLANK => '分頁',
    self::TARGET_SELF  => '本頁',
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);

    OrmImageUploader::bind ('cover', 'PromoCoverImageUploader');
  }
  public function columns_val ($has = false) {
    $var = array (
      'id'         => isset ($this->id) ? $this->id : '',
      'title'      => isset ($this->title) ? $this->title : '',
      'content'    => isset ($this->content) ? $this->content : '',
      'link'       => isset ($this->link) ? $this->link : '',
      'cover'      => isset ($this->cover) ? $this->cover : '',
      'target'     => isset ($this->target) ? $this->target : '',
      'sort'       => isset ($this->sort) ? $this->sort : '',
      'is_enabled' => isset ($this->is_enabled) ? $this->is_enabled : '',
      'updated_at' => isset ($this->updated_at) && $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at' => isset ($this->created_at) && $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );
    return $has ? array ('this' => $var) : $var;
  }
  public function to_array (array $opt = array ()) {
    return array (
        'id' => $this->id,
        'title' => $this->title,
        'content' => $this->content,
        'link' => $this->link,
        'target' => $this->target,
        'is_enabled' => $this->is_enabled,
        'sort' => $this->sort,
        'cover' => array (
            'ori' => $this->cover->url (),
            'w500' => $this->cover->url ('500w'),
          ),
      );
  }
  public function mini_title ($length = 50) {
    if (!isset ($this->title)) return '';
    return $length ? mb_strimwidth (remove_ckedit_tag ($this->title), 0, $length, '…','UTF-8') : remove_ckedit_tag ($this->content);
  }
  public function mini_content ($length = 100) {
    if (!isset ($this->content)) return '';
    return $length ? mb_strimwidth (remove_ckedit_tag ($this->content), 0, $length, '…','UTF-8') : remove_ckedit_tag ($this->content);
  }
  public function mini_link ($length = 80) {
    if (!isset ($this->link)) return '';
    return $length ? mb_strimwidth (remove_ckedit_tag ($this->link), 0, $length, '…','UTF-8') : remove_ckedit_tag ($this->link);
  }
  public function destroy () {
    if (!(isset ($this->cover) && isset ($this->id)))
      return false;

    return $this->delete ();
  }
}
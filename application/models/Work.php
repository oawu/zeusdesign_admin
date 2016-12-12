<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Work extends OaModel {

  static $table_name = 'works';

  static $has_one = array (
  );

  static $has_many = array (
    array ('mappings', 'class_name' => 'WorkTagMapping'),
    array ('images', 'class_name' => 'WorkImage'),
    array ('tags', 'class_name' => 'WorkTag', 'through' => 'mappings'),
    array ('blocks', 'class_name' => 'WorkBlock'),
  );

  static $belongs_to = array (
    array ('user', 'class_name' => 'User'),
  );
  const ENABLE_NO  = 0;
  const ENABLE_YES = 1;

  static $enableNames = array(
    self::ENABLE_NO  => '停用',
    self::ENABLE_YES => '啟用',
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
    
    OrmImageUploader::bind ('cover', 'WorkCoverImageUploader');
  }
  public function columns_val ($has = false) {
    $var = array (
      'id'         => isset ($this->id) ? $this->id : '',
      'user_id'    => isset ($this->user_id) ? $this->user_id : '',
      'title'      => isset ($this->title) ? $this->title : '',
      'cover'      => isset ($this->cover) ? $this->cover : '',
      'content'    => isset ($this->content) ? $this->content : '',
      'is_enabled' => isset ($this->is_enabled) ? $this->is_enabled : '',
      'pv'         => isset ($this->pv) ? $this->pv : '',
      'updated_at' => isset ($this->updated_at) && $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at' => isset ($this->created_at) && $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );
    return $has ? array (
      'this' => $var,
      'mappings' => array_map (function ($mapping) {
        return $mapping->columns_val ();
      }, WorkTagMapping::find ('all', array ('conditions' => array ('work_id = ?', $this->id)))),
      'images' => array_map (function ($image) {
        return $image->columns_val ();
      }, WorkImage::find ('all', array ('conditions' => array ('work_id = ?', $this->id)))),
      'blocks' => array_map (function ($block) {
        return $block->columns_val (true);
      }, WorkBlock::find ('all', array ('conditions' => array ('work_id = ?', $this->id))))) : $var;
  }
  public function to_array (array $opt = array ()) {
    return array (
      'id' => $this->id,
      'user' => $this->user->to_array (),
      'tags' => array_map (function ($tag) {
        return $tag->to_array ();
      }, WorkTag::find ('all', array ('conditions' => array ('id IN (?)', ($tag_ids = column_array ($this->mappings, 'work_tag_id')) ? $tag_ids : array (0))))),
      'title' => $this->title,
      'cover' => array (
          'w300' => $this->cover->url ('300w'),
          'c1200' => $this->cover->url ('1200x630c'),
        ),
      'images' => array_map (function ($image) {
        return $image->to_array ();
      }, $this->images),
      'content' => $this->content,
      'blocks' => array_map (function ($block) {
        return $block->to_array ();
      }, $this->blocks),
      'pv' => $this->pv,
      'is_enabled' => $this->is_enabled,
      'updated_at' => $this->updated_at->format ('Y-m-d H:i:s'),
      'created_at' => $this->created_at->format ('Y-m-d H:i:s'),
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
  public function destroy () {
    if (!(isset ($this->cover) && isset ($this->id)))
      return false;

    if ($this->blocks)
      foreach ($this->blocks as $block)
        if (!$block->destroy ())
          return false;

    if ($this->images)
      foreach ($this->images as $image)
        if (!$image->destroy ())
          return false;

    if ($this->mappings)
      foreach ($this->mappings as $mapping)
        if (!$mapping->destroy ())
          return false;

    return $this->delete ();
  }
  public function blocks () {
    return array_map (function ($block) {
      return  array (
          'title' => $block->title,
          'items' => array_map (function ($item) {
            return array (
                'title' => $item->title,
                'link' => $item->link
              );
          }, $block->items)
        );
    }, $this->blocks);
  }
  public function site_show_page_last_uri () {
    return $this->id . '-' . oa_url_encode ($this->title);
  }
}
<?php defined ('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 * @link        http://www.ioa.tw/
 */

class Invoice extends OaModel {

  static $table_name = 'invoices';

  static $has_many = array (
  );

  static $belongs_to = array (
    array ('tag', 'class_name' => 'InvoiceTag'),
    array ('customer', 'class_name' => 'Customer'),
    array ('user', 'class_name' => 'User'),
  );

  const NO_FINISHED = 0;
  const IS_FINISHED = 1;

  static $finishNames = array(
    self::NO_FINISHED => '未請款',
    self::IS_FINISHED => '已請款',
  );

  public function __construct ($attributes = array (), $guard_attributes = true, $instantiating_via_find = false, $new_record = true) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  public function columns_val ($has = false) {
    $var = array (
      'id'             => $this->id,
      'user_id'        => $this->user_id,
      'customer_id'    => $this->customer_id,
      'invoice_tag_id' => $this->invoice_tag_id,
      'name'           => $this->name,
      'quantity'       => $this->quantity,
      'single_money'   => $this->single_money,
      'all_money'      => $this->all_money,
      'memo'           => $this->memo,
      'is_finished'    => $this->is_finished,
      'closing_at'     => $this->closing_at ? $this->closing_at->format ('Y-m-d') : '',
      'updated_at'     => $this->updated_at ? $this->updated_at->format ('Y-m-d H:i:s') : '',
      'created_at'     => $this->created_at ? $this->created_at->format ('Y-m-d H:i:s') : '',
    );
    return $has ? array ('this' => $var) : $var;
  }
  public function to_array (array $opt = array ()) {
    return array (
        'id' => $this->id,
        'user' => $this->user->to_array (),
        'tag' => $this->tag ? $this->tag->to_array () : array (),
        'customer' => $this->customer ? $this->customer->to_array () : '',
        'name' => $this->name,
        'quantity' => $this->quantity,
        'single_money' => $this->single_money,
        'all_money' => $this->all_money,
        'memo' => $this->memo,
        'is_finished' => $this->is_finished,
        'closing_at' => $this->closing_at ? $this->closing_at->format ('Y-m-d') : '-',
      );
  }
  public function mini_name ($length = 50) {
    if (!isset ($this->name)) return '';
    return $length ? mb_strimwidth (remove_ckedit_tag ($this->name), 0, $length, '…','UTF-8') : remove_ckedit_tag ($this->content);
  }
  public function destroy () {
    if (!isset ($this->id))
      return false;

      return $this->delete ();
  }
}
<?php if (!defined ('BASEPATH')) exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class Delay_controller extends Root_controller {

  public function __construct () {
    parent::__construct ();

    if (!Cfg::system ('delay_job', 'is_check') || !((($value = OAInput::post (Cfg::system ('delay_job', 'key'))) !== null) && ($value == md5 (Cfg::system ('delay_job', 'value')))))
      show_error ('The delay job key or value error! Please confirm your program again.');
  }
}
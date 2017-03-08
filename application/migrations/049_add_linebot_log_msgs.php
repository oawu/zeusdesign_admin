<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2016 OA Wu Design
 */

class Migration_Add_linebot_log_msgs extends CI_Migration {
  public function up () {
    $this->db->query (
      "CREATE TABLE `linebot_log_msgs` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `linebot_log_id` int(11) unsigned NOT NULL DEFAULT 0 COMMENT 'Line Bot Log ID',
        
        `message_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '訊息 ID',
        `message_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '訊息類型',
        `message_text` text NOT NULL COMMENT '訊息內容',

        `updated_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '更新時間',
        `created_at` datetime NOT NULL DEFAULT '" . date ('Y-m-d H:i:s') . "' COMMENT '新增時間',
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    );
  }
  public function down () {
    $this->db->query (
      "DROP TABLE `linebot_log_msgs`;"
    );
  }
}
<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/27
 * Time: 11:10
 */

use common\ReturnData\ReturnData;

Class WxLogin extends ReturnData {
    function drop_table() {
        global $wpdb;
        global $table_prefix;
        $table = $table_prefix . 'firgatebird_wx_login';
        $wpdb->query(
            $wpdb->prepare( "DROP TABLE " . $table)
        );
    }
    function create_table($table) {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS `'. $table .'` (
			`id` int(11) NOT NULL auto_increment,
			`access_token` varchar(256),
            `create_time` timestamp NOT NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        $wpdb->query(
            $wpdb->prepare($sql, [])
        );
        $data = $this->search_token();
        if(!empty($data)) {
            return ReturnData::success($data);
        } else {
            return ReturnData::error();
        }
    }
    function search_token() {
        global $wpdb;
        global $table_prefix;
        $wpdb -> hide_errors();
        $table = $table_prefix . 'firgatebird_wx_login';
        $obj  = $wpdb->get_row( "SELECT * FROM $table ORDER BY id desc LIMIT 1" );
        if(!empty($obj)) {
            if((time() - (int)$obj -> create_time) < 7000) {
                return $obj;
            } else {
                return $this->get_token();
            }
        } else {
            return $this->get_token();
        }
    }
    function get_token() {
        $app_id = get_option('firgatebird_wx_appid');
        $secret = get_option('firgatebird_wx_secret');

        $params = [
            "grant_type" => "client_credential",
            "appid" => $app_id,
            "secret" => $secret,
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/token?' . http_build_query($params);
        $args = array(
            "headers" => [
                "Content-Type" => "application/json;charset=UTF-8"
            ]
        );
        $response = wp_remote_get( $url, $args );
        if ( is_array( $response ) && !is_wp_error($response) && $response['response']['code'] == '200' ) {
            $body = wp_remote_retrieve_body($response); // use the content
            $data = json_decode($body);
            if(empty($data -> access_token)) {
                return ReturnData::error($data);
            } else {
                return $this->save_token($data -> access_token);
            }
        }
    }
    function save_token($access_token) {
        global $wpdb;
        global $table_prefix;

        $table = $table_prefix . 'firgatebird_wx_login';
        $data = $wpdb->insert(
            $table . '',
            array(
                'access_token' => $access_token,
                'create_time' => time(),
            ),
            array(
                '%s',
                '%s',
            )
        );
        if($data !== 1) {
            return ReturnData::error();
        }
        $list = $wpdb->get_row( "SELECT * FROM {$table} WHERE id = {$wpdb->insert_id}", ARRAY_A);
        return $list;
    }
}

function wx_login() {
    $WxLogin = new WxLogin;
    $return = new ReturnData;
    global $wpdb;
    global $table_prefix;
    $table = $table_prefix . 'firgatebird_wx_login';
    $wpdb -> hide_errors();
    $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}");
    if(empty($count)) {
        return $WxLogin->create_table($table);
    } else {
        $data = $WxLogin->search_token();
        if(!empty($data)) {
            return $return->success($data);
        } else {
            return $return->error();
        }
    }
}

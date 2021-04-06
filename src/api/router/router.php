<?php
    add_action( 'rest_api_init', function () {
        register_rest_route( 'fb', 'admin/check_token', array(
            'methods' => 'GET',
            'callback' => 'check_token',
            'permission_callback' => 'noCheck'
        ));
        register_rest_route( 'fb', 'admin/wx_login', array(
            'methods' => 'GET',
            'callback' => 'wx_login',
            'permission_callback' => 'check'
        ));
        // light_word_admin
        register_rest_route( 'fb', 'admin/light_word_admin/getList', array(
            'methods' => 'POST',
            'callback' => 'getListAdmin',
            'permission_callback' => 'check'
        ));
        register_rest_route( 'fb', 'admin/light_word_admin/add', array(
            'methods' => 'POST',
            'callback' => 'add',
            'permission_callback' => 'check'
        ));
        register_rest_route( 'fb', 'admin/light_word_admin/delete', array(
            'methods' => 'POST',
            'callback' => 'delete',
            'permission_callback' => 'check'
        ));
        // user
        register_rest_route( 'fb', 'light_word/getList', array(
            'methods' => 'POST',
            'callback' => 'getList',
            'permission_callback' => 'noCheck'
        ));
    });
?>

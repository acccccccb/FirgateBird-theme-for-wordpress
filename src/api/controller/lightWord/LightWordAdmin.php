<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/30
 * Time: 11:25
 */
use common\ReturnData\ReturnData;
use common\Auth\Auth;
use common\FilterParam\FilterParam;

class LightWordAdmin {
    public $smiley;
    public $smileyImg;
    public function __construct(){  #初始化方法
        $this->smiley = [':?:',':razz:',':sad:',':smile:',':oops:',':grin:',':eek:',':shock:',':cool:',':lol:',':mad:',':wink:',':neutral:',':cry:'];
        $this->smileyImg = [
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f604.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f61b.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f626.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f603.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f633.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f600.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f62e.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f62f.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f60e.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f606.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f621.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f609.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f610.png"></img>',
            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f625.png"></img>',
        ];
    }
    // admin
    function getListAdmin() {
        $check = Auth::check();
        if(!$check) {
            return ReturnData::error([], '没有权限');
        }
        global $wpdb;
        global $table_prefix;
        $wpdb->hide_errors();
        // $wpdb->show_errors();
        $table = $table_prefix . 'firgatebird_light_word';
        $users = $table_prefix . 'users';
        $current_page = (int)FilterParam::post('page') ?: 1;
        $page_size = (int)FilterParam::post('pageSize') ?: 10;
        $start = ($current_page - 1) * $page_size;

        $total = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$table}.show = 1" );
        $list = $wpdb->get_results( "
                          SELECT {$table}.id, {$table}.content, {$table}.status, {$table}.show, {$users}.display_name, {$users}.id AS uid, {$table}.create_time
                          FROM {$table}
                          INNER JOIN {$users}
                          ON {$table}.uid = {$users}.id
                          ORDER BY {$table}.id DESC
                          LIMIT {$start}, {$page_size}
                        ", ARRAY_A);

        foreach ($list as $key => $value) {
            $list[$key]['content'] = str_replace($this->smiley,$this->smileyImg,mb_substr( $value['content'], 0, 300 ));;
            $list[$key]['avatar'] = fox_get_https_avatar(get_avatar_url( (int)($value['uid']), 32));
        }
        return ReturnData::page($list, $current_page, $page_size, $total);
    }
    function add() {
        $check = Auth::check();
        if(!$check) {
            return ReturnData::error([], '没有权限');
        }
        global $wpdb;
        global $table_prefix;

        if(empty(FilterParam::post('content'))) {
            return ReturnData::error(false, '内容不能为空');
        }

        $wpdb->hide_errors();
        //  $wpdb->show_errors();
        $table = $table_prefix . 'firgatebird_light_word';

        $wpdb->insert(
            $table . '',
            array(
                'content' => htmlspecialchars(stripslashes(FilterParam::post('content'))),
                'status' => (int)FilterParam::post('status') ?: 0,
                'show' => (int)FilterParam::post('show') ?: 1,
                'uid' => get_current_user_id(),
                'create_time' => date("Y-m-d H:i:s"),
            ),
            array(
                '%s',
                '%d',
                '%d',
                '%s',
            )
        );

        return ReturnData::success([]);
    }
    function delete() {
        $check = Auth::check();
        if(!$check) {
            return ReturnData::error([], '没有权限');
        }
        global $wpdb;
        global $table_prefix;
        $wpdb->hide_errors();
        //  $wpdb->show_errors();
        $id = FilterParam::post('id');
        $table = $table_prefix . 'firgatebird_light_word';
        $result = $wpdb->delete( $table.'', array( 'id' => $id ) );
        if(!empty($result)) {
            return ReturnData::success(true, '删除成功');
        } else {
            return ReturnData::error(false, '删除失败');
        }
    }
    // user
    function getList() {
        global $wpdb;
        global $table_prefix;
        $wpdb->hide_errors();
        // $wpdb->show_errors();
        $table = $table_prefix . 'firgatebird_light_word';
        $users = $table_prefix . 'users';
        $current_page = (int)FilterParam::post('page') ?: 1;
        $page_size = (int)FilterParam::post('pageSize') ?: 10;
        $start = ($current_page - 1) * $page_size;

        $total = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$table}.show = 1" );
        $list = $wpdb->get_results( "
                          SELECT {$table}.id, {$table}.content, {$table}.status, {$table}.show, {$users}.display_name, {$users}.id AS uid, {$table}.create_time
                          FROM {$table}
                          INNER JOIN {$users}
                          ON {$table}.uid = {$users}.id
                          WHERE {$table}.show = 1
                          ORDER BY {$table}.id DESC
                          LIMIT {$start}, {$page_size}
                        ", ARRAY_A);

        foreach ($list as $key => $value) {
            $list[$key]['content'] = str_replace($this->smiley,$this->smileyImg,mb_substr( $value['content'], 0, 300 ));;
            $list[$key]['avatar'] = fox_get_https_avatar(get_avatar_url( (int)($value['uid']), 32));
        }
        return ReturnData::page($list, $current_page, $page_size, $total);
    }
}
function check() {
    return Auth::check();
};
function noCheck() {
    return true;
}
// admin
function add() {
    $LightWordAdmin = new LightWordAdmin;
    return $LightWordAdmin->add();
};
function delete() {
    $LightWordAdmin = new LightWordAdmin;
    return $LightWordAdmin->delete();
};
function getListAdmin() {
    $LightWordAdmin = new LightWordAdmin;
    return $LightWordAdmin->getListAdmin();
};
// user
function getList() {
    $LightWordAdmin = new LightWordAdmin;
    return $LightWordAdmin->getList();
};

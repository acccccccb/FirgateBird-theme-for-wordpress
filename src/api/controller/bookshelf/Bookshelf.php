<?php
/**
 * Created by PhpStorm.
 * User: wf
 * Date: 2021/3/30
 * Time: 11:25
 */
namespace BookshelfAdmin;
use common\ReturnData\ReturnData;
use common\FilterParam\FilterParam;

class BookshelfAdmin {
    public function __construct(){  #初始化方法

    }
    // user
    function getList() {
        global $wpdb;
        global $table_prefix;
        $wpdb->hide_errors();
        // $wpdb->show_errors();
        $table = $table_prefix . 'firgatebird_bookshelf';
        $users = $table_prefix . 'users';
        $current_page = (int)FilterParam::post('page') ?: 1;
        $page_size = (int)FilterParam::post('pageSize') ?: 10;
        $start = ($current_page - 1) * $page_size;

        $total = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE {$table}.show = 1" );
        $list = $wpdb->get_results( "
                          SELECT {$table}.id,
                           {$table}.name,
                            {$table}.thumb,
                             {$table}.link,
                              {$table}.description,
                               {$table}.comment,
                                {$table}.add_time,
                                {$table}.score,
                                {$table}.type,
                                {$table}.show,
                                 {$users}.display_name,
                                  {$users}.id AS uid,
                                   {$table}.create_time
                          FROM {$table}
                          INNER JOIN {$users}
                          ON {$table}.uid = {$users}.id
                          WHERE {$table}.show = 1
                          ORDER BY {$table}.id DESC
                          LIMIT {$start}, {$page_size}
                        ", ARRAY_A);
        return ReturnData::page($list, $current_page, $page_size, $total);
    }
}
//function check() {
//    return Auth::check();
//};
//function noCheck() {
//    return true;
//}

// user
function getBookshelf() {
    $BookshelfAdmin = new BookshelfAdmin;
    return $BookshelfAdmin->getList();
};

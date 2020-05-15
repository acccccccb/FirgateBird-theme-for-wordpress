<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/8
 * Time: 15:45
 */
function test_function(){
    //page_titile-title标签的内容
    //menu_title-显示在后台左边菜单的标题
    //capability-访问这个页面需要的权限
    //menu_slug-别名，需要独一无二哦
    //function-执行的函数
    add_theme_page( 'title标题', '主题设置', 'administrator', 'ashu_slug','display_function');
}

function display_function(){
    echo '<h1>这是设置页面</h1>';
    echo '<p>开发中...</p>';
}
add_action('admin_menu', 'test_function');
?>
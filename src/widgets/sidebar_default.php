<?php
     require_once( 'sidebar_new_comments.php' );
     require_once( 'sidebar_new_article.php' );
     require_once( 'sidebar_hot_article.php' );
     require_once( 'sidebar_categories.php' );
     require_once( 'sidebar_tools.php' );
     require_once( 'sidebar_author.php' );
     require_once( 'sidebar_calendar.php' );
     require_once( 'sidebar_attack_statistic.php' );
    if(get_option('firgatebird_light_word') == 1) {
        require_once( 'sidebar_light_word.php' );
    }
 /*
 *注销wp默认侧边栏小工具
 */
 function unregister_widgets() {
     //unregister_widget("WP_Widget_Pages");//页面
     //unregister_widget("WP_Widget_Calendar");//文章日程表
     //unregister_widget("WP_Widget_Archives");//文章归档
     //unregister_widget("WP_Widget_Links");//链接
     unregister_widget("WP_Widget_Meta");//登入/登出，管理，Feed 和 WordPress 链接
     //unregister_widget("WP_Widget_Search");//搜索
     //unregister_widget("WP_Widget_Text");//文本
     unregister_widget("WP_Widget_Categories");//分类目录
     unregister_widget("WP_Widget_Recent_Posts");//近期文章
     unregister_widget("WP_Widget_Recent_Comments");//近期评论
     //unregister_widget("WP_Widget_RSS");//RSS订阅
     //unregister_widget("WP_Widget_Tag_Cloud");//标签云
     unregister_widget("WP_Nav_Menu_Widget");//自定义菜单
     //unregister_widget("WP_Widget_Media_Audio");//wp4.8 音频
     //unregister_widget("WP_Widget_Media_Image");//wp4.8 图片
     //unregister_widget("WP_Widget_Media_Video");//wp4.8 视频
     //unregister_widget("WP_Widget_Custom_HTML");//wp4.8.1 html
  }
  add_action("widgets_init", "unregister_widgets");
?>

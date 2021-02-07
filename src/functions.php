<?php
require_once( 'widgets/sidebar_default.php' );
require_once ('config/theme_options.php');
// 精简顶部
//remove_action( ‘wp_head’, ‘feed_links_extra’, 3 ); // Display the links to the extra feeds such as category feeds
//remove_action( ‘wp_head’, ‘feed_links’, 2 ); // Display the links to the general feeds: Post and Comment Feed
//remove_action( ‘wp_head’, ‘rsd_link’ ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
//remove_action( ‘wp_head’, ‘wlwmanifest_link’ ); // Display the link to the Windows Live Writer manifest file.
//remove_action( ‘wp_head’, ‘index_rel_link’ ); // index link
//remove_action( ‘wp_head’, ‘parent_post_rel_link’, 10, 0 ); // prev link
//remove_action( ‘wp_head’, ‘start_post_rel_link’, 10, 0 ); // start link
//remove_action( ‘wp_head’, ‘adjacent_posts_rel_link’, 10, 0 ); // Display relational links for the posts adjacent to the current post.
//remove_action( ‘wp_head’, ‘wp_generator’ ); // Display the XHTML generator that is generated on the wp_head hook, WP version
// 关闭前台顶部导航
show_admin_bar(false);
// 主题色设置
function themeColor() {
    $themeColor = !empty(get_option('firgatebird_color')) ? get_option('firgatebird_color') : '#b93a00';
    $fontColor = !empty(get_option('firgatebird_font_color')) ? get_option('firgatebird_font_color') : '#333333';
    function afterColor($color, $val = 1) {
        $color = str_replace('#','',$color);
        $rgb = array(
            'r' => hexdec(substr($color,0,2)),
            'g' => hexdec(substr($color,2,2)),
            'b' => hexdec(substr($color,4,2))
        );
        $r = round($rgb['r'] * $val);
        $g = round($rgb['g'] * $val);
        $b = round($rgb['b'] * $val);

        if($r < 0) { $r = 0; };
        if($g < 0) { $g = 0; };
        if($b < 0) { $b = 0; };

        if($r > 255) { $r = 255; };
        if($g > 255) { $g = 255; };
        if($b > 255) { $b = 255; };

        return $color = 'rgb('. $r .','. $g .','. $b .')';
    }
    echo '
        <style>
            .article-body,
            body {
                color: '. afterColor($fontColor) .'!important;
            }
            .footer,
            .navbar-inverse,
            .dropdown-menu>li>a:hover,
            .btn-primary,
            .pagination > .active > span,
            .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover,
            .more-link {
                background-color: '. afterColor($themeColor) .';
            }
             .navbar-default .navbar-nav .current-menu-item,
             .navbar-default .navbar-nav .current-menu-parent {
                border-color: '. afterColor($themeColor) .';
             }
            .navbar-default .navbar-nav .current-menu-item,
             .navbar-default .navbar-nav .current-menu-parent,
            .pagination>.active>a,
            .pagination>.active>a:focus,
            .pagination>.active>a:hover,
            .pagination>.active>span,
            .pagination>.active>span:focus,
            .pagination>.active>span:hover,
            .current-menu-item,
            .current-menu-parent, {
                border-color: '. afterColor($themeColor) .';
            }
            a,
            a:link,
            a:visited,
            .pagination > li > a,
            .navbar-default .navbar-nav > li > a,
            .navbar-default .navbar-nav > li > a:focus,
            .navbar-default .navbar-nav>li > a:hover,
            .navbar-inverse .navbar-nav .open .dropdown-menu>li>a,
            .current-menu-item>a,.current-menu-parent>a,.current-menu-item>a:hover,.current-menu-parent>a:hover,
            .article-list-date a:hover {
                color: '. afterColor($themeColor) .';
            }
            .footer-info,
            .footer-info a {
                color: '. afterColor($themeColor, 2) .';
            }
            .footer-info a:hover {
                color: '. afterColor($themeColor, 2.5) .';
            }
            .navbar-inverse .current-menu-item,
            .navbar-inverse .current-menu-parent,
            .more-link:hover {
                background: '. afterColor($themeColor, 1.1) .';
            }
            .navbar-inverse,
            .btn-primary,
            .pagination > .active > span,
            .navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
                border-color: '. afterColor($themeColor, 0.9) .';
            }
            .btn-primary:hover {
                border-color: '. afterColor($themeColor, 1.1) .';
                background: '. afterColor($themeColor, 1.1) .';
            }
            .navbar-inverse .navbar-toggle:focus,
            .navbar-inverse .navbar-toggle:hover,
            .navbar-inverse .navbar-nav>.open>a,
            .navbar-inverse .navbar-nav>.open>a:focus,
            .navbar-inverse .navbar-nav>.open>a:hover {
                background-color: '. afterColor($themeColor, 0.9) .';
            }
            #wp-calendar tbody tr td a {
                color: '. afterColor($themeColor) .';
            }
            #wp-calendar #today {
                background-color: '. afterColor($themeColor) .';
            }
        </style>
    ';
}
// 面包屑导航
function navigation(){
	$blogurl = get_bloginfo('url');
	$blogname = get_bloginfo('name');
	echo '<ol class="breadcrumb">';
	echo '<li><small><a href="'.$blogurl.'"><span class="glyphicon glyphicon-home"></span> 首页</a></small></li>';
	if(is_tag()){
		echo '<li><small> 标签 : ';
		single_tag_title();
		echo '</li></small>';
	}
	if(is_category()) {
		echo '<li><small>';
		single_cat_title();
		echo '</li></small>';
	}
	if(is_single()) {
		echo '<li><small>';
		the_category(', ');
		echo '</li></small>';
		echo '<li><small>';
		single_post_title();
		echo '</li></small>';
	}
	if(is_page()) {
		echo '<li><small>';
		single_post_title();
		echo '</li></small>';
	}
	if(is_archive() && !is_category()) {
		echo '<li><small>';
		wp_title('',true);
		echo '</li></small>';
	}
	if(is_search()) {
		echo '<li><small>';
		wp_title('',true);
		echo '</li></small>';
	}
	echo '</ol>';
}
// 分页代码
function par_pagenavi($range = 6){
	global $paged, $wp_query;
	if ( !$max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	if($max_page > 1){
		if(!$paged){
			$paged = 1;
		}
		if($paged && $paged != 1){
			echo "<li class='0'><a href='/'><span class='glyphicon glyphicon-home'></span></a></li><li><a href='" . get_pagenum_link(1) . "' class='1' title='上一页'>&laquo;</a></li>";
		}
		if($max_page > $range){
			if($paged < $range){
				for($i = 1; $i <= ($range + 1); $i++){
					if($i==$paged) {
						echo "<li class='active'><span>".$i."</span></li>";
					} else {
						echo "<li><a href='" . get_pagenum_link($i) ."'>".$i."</a></li>";
					}
				}
			}
			elseif($paged >= ($max_page - ceil(($range/2)))){
				for($i = $max_page - $range; $i <= $max_page; $i++){
					if($i==$paged) {
						echo "<li class='active'><span>".$i."</span></li>";
					} else {
						echo "<li><a href='" . get_pagenum_link($i) ."'>".$i."</a></li>";
					}
				}
			}

			elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
				for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){
					if($i==$paged) {
						echo "<li class='active'><span>".$i."</span></li>";
					} else {
						echo "<li><a href='" . get_pagenum_link($i) ."'>".$i."</a></li>";
					}
				}
			}
		}
		else {
			for($i = 1; $i <= $max_page; $i++){
				if($i==$paged) {
					echo "<li class='active'><span>".$i."</span></li>";
				} else {
					echo "<li><a href='" . get_pagenum_link($i) ."'>".$i."</a></li>";
				}
			}
		}
		echo "<li>";
		next_posts_link('&raquo;');
		echo "</li>";
	}
}


//评论数
/*   获取文章的评论人数 by zwwooooo | zww.me
	*调用方法：
	*<?php echo zfunc_comments_users($postid); ?>
	*参数说明：$postid 是需要获取评论人数的文章ID
	*一般用法：在一般主题的loop里面可以这样用：
	*<?php echo zfunc_comments_users($post->ID); ?>
	*PS：还可以输出评论总数，用法：
	*<?php echo zfunc_comments_users($postid, 1); ?>
*/
function zfunc_comments_users($postid=0,$which=0) {
	$comments = get_comments('status=approve&type=comment&post_id='.$postid); //获取文章的所有评论
	if ($comments) {
		$i=0; $j=0; $commentusers=array();
		foreach ($comments as $comment) {
			++$i;
			if ($i==1) { $commentusers[] = $comment->comment_author_email; ++$j; }
			if ( !in_array($comment->comment_author_email, $commentusers) ) {
				$commentusers[] = $comment->comment_author_email;
				++$j;
			}
		}
		$output = array($j,$i);
		$which = ($which == 0) ? 0 : 1;
		return $output[$which]; //返回评论人数
	}
	return 0; //没有评论返回0
}

// 评论添加@，by Ludou
function ludou_comment_add_at( $comment_text, $comment = '') {
	if( $comment->comment_parent > 0) {
	$comment_text = '@<a href="#comment-' . $comment->comment_parent . '">'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
	}

	return $comment_text;
}
add_filter( 'comment_text' , 'ludou_comment_add_at', 20, 2);

//emoji表情 by www.imjeff.cn/blog/448/
//评论表情路径
function static_emoji_url() {
	return get_bloginfo('template_directory').'/static/img/smilies/';
}
//首先补全wp的表情库
function smilies_reset() {
	global $wpsmiliestrans, $wp_smiliessearch;
	// don't bother setting up smilies if they are disabled
	if (!get_option('use_smilies')) {
	return;
}
$wpsmiliestrans_fixed = array(
	':mrgreen:' => "\xf0\x9f\x98\xa2",
	':smile:' => "\xf0\x9f\x98\xa3",
	':roll:' => "\xf0\x9f\x98\xa4",
	':sad:' => "\xf0\x9f\x98\xa6",
	':arrow:' => "\xf0\x9f\x98\x83",
	':-(' => "\xf0\x9f\x98\x82",
	':-)' => "\xf0\x9f\x98\x81",
	':(' => "\xf0\x9f\x98\xa7",
	':)' => "\xf0\x9f\x98\xa8",
	':?:' => "\xf0\x9f\x98\x84",
	':!:' => "\xf0\x9f\x98\x85",
	);
	$wpsmiliestrans = array_merge($wpsmiliestrans, $wpsmiliestrans_fixed);
}
//让文章内容和评论支持 emoji 并禁用 emoji 加载的乱七八糟的脚本
function reset_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	add_filter('the_content', 'wp_staticize_emoji');
	add_filter('sidebar_comments', 'wp_staticize_emoji');
	add_filter('get_comment_text', 'wp_staticize_emoji');
	add_filter('get_comments', 'wp_staticize_emoji');
	add_filter('comment_text', 'wp_staticize_emoji',50); //在转换为表情后再转为静态图片
	smilies_reset();
	add_filter('emoji_url', 'static_emoji_url');
}
add_action('init', 'reset_emojis');

//输出表情
function fa_get_wpsmiliestrans(){
	global $wpsmiliestrans;
	$wpsmilies = array_unique($wpsmiliestrans);
	foreach($wpsmilies as $alt => $src_path){
	$emoji = str_replace(array('&#x', ';'), '', wp_encode_emoji($src_path));
	$output .= '<a class="add-smily" data-smilies="'.$alt.'"><img class="wp-smiley" src="'.get_bloginfo('template_directory').'/72x72/'. $emoji .'png" /></a>';
	}
	return $output;
}

//替换头像路径（多说挂了 暂时不用这个）
// function fox_get_https_avatar($avatar) {
//     $avatar = str_replace(array('www.gravatar.com', '0.gravatar.com', '1.gravatar.com', '2.gravatar.com'), 'gravatar.duoshuo.com', $avatar);
//     return $avatar;
// }
//add_filter('get_avatar', 'fox_get_https_avatar');

//清除谷歌字体
function coolwp_remove_open_sans_from_wp_core(){
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'coolwp_remove_open_sans_from_wp_core');

/**
 * WordPress 前台评论添加“删除”和“标识为垃圾”链接
 * https://www.wpdaxue.com/add-delete-spam-links-to-comments.html
 */
function comment_manage_link($id) {
	global $comment, $post;
	$id = $comment->comment_ID;
	if(current_user_can( 'moderate_comments', $post->ID )){
		if ( null === $link ) $link = __('编辑');
		$link = '<a class="comment-edit-link" href="' . get_edit_comment_link( $comment->comment_ID ) . '" title="' . __( '编辑评论' ) . '">' . $link . '</a>';
		$link = $link . ' | <a href="'.admin_url("comment.php?action=cdc&c=$id").'">删除</a> ';
		$link = $link . ' | <a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">标识为垃圾</a>';
		$link = $before . $link . $after;
		return $link;
	}
}
add_filter('edit_comment_link', 'comment_manage_link');
// 前台显示编辑文章功能
function show_edit_button($id) {
if(current_user_can('level_10')){
		$url = get_bloginfo('url');
		echo '
			<div class="btn-group" style="float: right;">
			  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			   操作<span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" style="right: 0!important;left: auto!important;">
				<li><a href="'.home_url().'/wp-admin/post.php?post=' . $id . '&action=edit"><span class="glyphicon glyphicon-edit"></span> 编辑</a></li>
				<li><a href="'.wp_nonce_url("$url/wp-admin/post.php?action=trash&post=$id", 'trash-post_' . $id).'"><span class="glyphicon glyphicon-trash"></span> 移至回收站</a></li>
			  </ul>
			</div>
		';
	}
}
//排除分类
function exclude_category_home( $query ) {
    if ( $query->is_home ) {
		$query->set( 'cat', '-14' );//排除说说分类
    }
    return $query;
}
add_filter( 'pre_get_posts', 'exclude_category_home' );

// 首页幻灯片
function thumb_article() {

	if (have_posts()&& is_sticky() ) {
        echo '
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
            </ol>
            <div class="carousel-inner" role="listbox">
    ';
        while ( have_posts() ) {
            the_post();
            if(has_post_thumbnail() && is_sticky() ) {
                $description1 = get_the_excerpt();
                $description2 = str_replace(array("\r\n", "\r", "\n","&nbsp;",'"',"<",">"),"",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
                // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
                $description = $description1 ? $description1 : $description2;
                echo '<div class="item">';
                echo '<a href="' . get_the_permalink() . '" title="'.get_the_title().'">';
                //echo the_post_thumbnail( $post_id, thumbnail,array( 'class' => 'img-responsive-banner' ) );
                echo '<img class="img-responsive-banner" alt=".get_the_title()." src="';
                echo  the_post_thumbnail_url('codilight_lite_single_large' );
                echo '">';
                echo '</a>';
                echo '<div class="carousel-caption">';
                echo '<h1 class="hidden-xs hidden-sm text-left">'.get_the_title().'</h1>';
                echo '<h4 class="hidden-md hidden-lg text-center">'.get_the_title().'</h4>';
                echo '<p class="hidden-xs hidden-sm text-left" > '.$description.'</p>';
                echo '<a class="hidden-xs hidden-sm btn btn-primary btn-lg mt20" href="'.get_the_permalink().'" role="button">阅读内容</a>';
                echo '</div>';
                echo '</div>';
            }
        }
        echo '
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>
    ';
    } else {
        echo '';
    }
	    wp_reset_query();
}
// 带缩略图的文章

//add_action( 'pre_get_posts', 'five_posts_on_homepage' );
//文章缩略图
 if ( function_exists( 'add_theme_support' ) )   add_theme_support( 'post-thumbnails' );
 //add post thumbnails
 if ( function_exists( 'add_theme_support' ) ) {
  	add_theme_support( 'post-thumbnails' );
 }
 if ( function_exists( 'add_image_size' ) ) {
 	add_image_size( 'customized-post-thumb', 760, 180 );
 }
//TO DO 文章评论
// 热门文章
function hot_posts($post_num=7){
	global $post;
	$args = array(
	'post_password' => '',
	'post_status' => 'publish', // 只选公开的文章.
	'post__not_in' => array($post->ID),//排除当前文章
	'caller_get_posts' => 1, // 排除置顶文章.
    'meta_key' => 'views',
    'orderby' => 'meta_value_num',
    'order'		=>	'DESC',
	'posts_per_page' => $post_num
	);
	$query_posts = new WP_Query();
	$query_posts->query($args);
	$c = 0;
	while( $query_posts->have_posts() ) {
		$query_posts->the_post();
		$c = $c+1;
		echo '<li><span class="most-view-num most-view-num-'.$c.'">'.$c.'</span><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
	}
	wp_reset_query();
}
//相关文章
function same_posts($post_num=7){
	global $post;
    $post_category = get_the_category($post->ID);
	$args = array(
		'category_name' => $post_category[0]->name,
		'post_password' => '',
		'post_status' => 'publish', // 只选公开的文章.
		'post__not_in' => array($post->ID),//排除当前文章
		'caller_get_posts' => 1, // 排除置顶文章.
		'orderby' => 'meta_value_num', // 依评点击量.
		'order'		=>	'DESC',
		'showposts' => $post_num
	);
	$query_posts = new WP_Query();
	$query_posts->query($args);
    while( $query_posts->have_posts() ) {
		$query_posts->the_post();
		echo '<li style="line-height:34px!important;"><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
	}
	wp_reset_query();
}



//随机文章
/**
 * 随机文章 相关文章
 */
function random_posts($posts_num=6,$before='<li class="">',$after='</li>'){
	global $wpdb;
	$sql = "SELECT ID, post_title,guid
			FROM $wpdb->posts
			WHERE post_status = 'publish' ";
	$sql .= "AND post_title != '' ";
	$sql .= "AND post_password ='' ";
	$sql .= "AND post_type = 'post' ";
	$sql .= "ORDER BY RAND() LIMIT 0 , $posts_num ";
	$randposts = $wpdb->get_results($sql);
	$output = '';
	foreach ($randposts as $randpost) {
		$post_title = stripslashes($randpost->post_title);
		$permalink = get_permalink($randpost->ID);
		$output .= $before.'<a href="'
			. $permalink . '"  rel="bookmark" title="';
		$output .= $post_title . '">' . $post_title . '</a>';
		$output .= $after;
	}
	echo $output;
}
	//版权
	function author() {
		echo '
		<div class="alert author mt20 mb20">
			<div class="author-info">
				<div><strong>文档信息：</strong>'.get_the_title().'</div>
				<div><strong>版权声明：</strong><a href = "https://creativecommons.org/licenses/by-nc-nd/3.0/">自由转载-非商用-非衍生-保持署名（创意共享3.0许可证）<img src="'.get_template_directory_uri().'/static/img/licensebuttons.png" /></a></div>
				<div><strong>本文链接：</strong><a href="'.get_permalink().'" target="_self" >'.get_permalink().'</a></div>
			</div>
			<div class="clearfix"></div>
		</div>
		';
	}

	add_action('admin_menu', 'my_page_excerpt_meta_box');
		function my_page_excerpt_meta_box() {
		add_meta_box( 'postexcerpt', '摘要', 'post_excerpt_meta_box', 'page', 'normal', 'core' );
	}
	add_action('admin_menu', 'my_page_tags_meta_box');
		function my_page_tags_meta_box() {
		add_meta_box( 'tagsdiv-post_tag', '关键字', 'post_tags_meta_box', 'page', 'side', 'core' );
	}
	// 最近更新
	function modifiedTime() {
		//var_dump(the_modified_time('Y-n-j G:i'));
		//echo date("Y-m-d");
        query_posts('showposts=1');
        if ( have_posts() ) : while ( have_posts() ) : the_post();
            date_default_timezone_set('PRC');
            $modifiedTime = strtotime(get_the_date('Y-m-d') .' '.get_the_time());
            $nowTime = strtotime(date("Y-m-d G:i"));
            $modTime = ($nowTime - $modifiedTime)/3600;
            if($modTime <= 0.1) {
                echo "刚刚更新";
            }
            if($modTime > 0.1 && $modTime <= 1) {
                $ChangeTime = $modTime*60;
                echo $ChangeTime."分钟前";
            }
            if($modTime>=1 && $modTime < 24) {
                echo floor($modTime)."小时前";
            }
            if($modTime >= 24) {
                $ChangeTime = ($nowTime - $modifiedTime)/86400;
                echo floor($ChangeTime)."天前";
            }
        endwhile; else:
            echo '-';
        endif;
        wp_reset_query();
	}

	// 文章缩略图
	add_filter( 'post_thumbnail_html', 'remove_thumbnail_width_height', 10, 5 );
	function remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
		$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
		return $html;
	}
//取得文章的阅读次数
function post_views($before = ' ', $after = ' Click', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) echo $before, number_format($views), $after;
    else return $views;
}
// 记录阅读数
function record_visitors() {
    if (is_singular()) {
        global $post;
        $post_ID = $post->ID;
        if($post_ID) {
            $post_views = (int)get_post_meta($post_ID, 'views', true);
            if(!update_post_meta($post_ID, 'views', ($post_views+1))) {
                add_post_meta($post_ID, 'views', 1, true);
            }
        }
    }
}
add_action('wp_head', 'record_visitors');

	// 记录点赞数
function record_like() {
    header('Content-Type:application/json; charset=utf-8');
    $action = $_POST["action"];
    $id = (int)$_POST["id"];
    $nonce = $_GET['wpnonce'];
    if (!wp_verify_nonce($nonce, 'wpnonce') ) {
        wp_die("非法操作");
    }
    if(!empty($id) && $action=='record_like') {
        $post_like = (int)get_post_meta($id, 'like', true);
        if(!update_post_meta($id, 'like', ($post_like+1))) {
            add_post_meta($id, 'like', 1, true);
        } else {
            $expire = time() + 99999999;
            $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false; // make cookies work with localhost
            setcookie('record_like_'.$id,$id,$expire,'/',$domain,false);
            echo json_encode(array(
                'msg'=>'success',
                'like'=>$post_like+1,
                'success'=>true
            ));
        }
    }
    exit;
}
//wp_ajax_nopriv效验用户为未登录是启用的方法
add_action( 'wp_ajax_nopriv_record_like', 'record_like' );
//wp_ajax_nopriv效验用户为已登录是启用的方法
add_action( 'wp_ajax_record_like', 'record_like' );
// 获取点赞数
function get_post_like($before = ' ', $after = '', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $like = (int)get_post_meta($post_ID, 'like', true);
    if ($echo) echo $before, number_format($like), $after;
    else return $like;
}
	// 侧栏小工具
	//修改默认的小工具
	// 标签云
	function sidebar_tag_cloud_filter( $args ){
		$newargs = array(
			'smallest'    => 12,  //最小字号
			'largest'     => 20, //最大字号
			'unit'        => 'px',   //字号单位，可以是pt、px、em或%
			'number'      => 40,     //显示个数
			'format'      => 'flat',//列表格式，可以是flat、list或array
			'separator'   => " ",   //分隔每一项的分隔符
			'orderby'     => 'name',//排序字段，可以是name或count
			'order'       => 'ASC', //升序或降序，ASC或DESC
			'exclude'     => null,   //结果中排除某些标签
			'include'     => null,  //结果中只包含这些标签
			'link'        => 'view', //taxonomy链接，view或edit
			'taxonomy'    => 'post_tag', //调用哪些分类法作为标签云
		);
		$return = array_merge( $args, $newargs);
		return $return;
	}
	add_filter( 'widget_tag_cloud_args', 'sidebar_tag_cloud_filter' );
    // 修改日历
    function sidebar_calendar_filter($calendar_output){
        $calendar_output = str_replace('id="wp-calendar"','id="wp-calendar" class="table"',$calendar_output);
        $calendar_output = str_replace('<td><a ','<td class="active"><a ',$calendar_output);
        $calendar_output = str_replace('id="next"','id="next" class="text-right"',$calendar_output);
        $new_calendar_output = str_replace('id="today"','id="today" class="warning"',$calendar_output);
        return $new_calendar_output;
    }
    add_filter('get_calendar', 'sidebar_calendar_filter');
	//增加自定义小工具
	if( function_exists('register_sidebar') ) {
		register_sidebar(array(
			'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-FrigateBird' ),
			'id' => 'sidebar-1',
			'description'   => 'FrigateBird主题的侧边栏小工具',
			'class'         => 'FrigateBird-sidebar',
			'before_widget' => '<aside class="mb20">', // widget 的开始标签
			'after_widget' => '</aside>', // widget 的结束标签
			'before_title' => '<div class="sidebar-tit"><span class="glyphicon glyphicon-th-list"></span> ', // 标题的开始标签
			'after_title' => '</div>' // 标题的结束标签
		));
        register_sidebar(array(
            'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-FrigateBird' ),
            'id' => 'sidebar-2',
            'description'   => 'FrigateBird主题的首页顶部通栏小工具',
            'class'         => 'FrigateBird-sidebar',
            'before_widget' => '<aside class="mb20">', // widget 的开始标签
            'after_widget' => '</aside>', // widget 的结束标签
            'before_title' => '<div class="sidebar-tit"><span class="glyphicon glyphicon-th-list"></span> ', // 标题的开始标签
            'after_title' => '</div>' // 标题的结束标签
        ));
	}

?>

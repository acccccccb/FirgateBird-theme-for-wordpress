<?php
/**
 * Bootpress
 *
 *
 *
 * @package WordPress
 * @subpackage FrigateBird
 * @since FrigateBird 1.0
 */
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no,maximum-scale=1.0, minimum-scale=1.0">
    <?php
		$description = '';
		$keywords = '';
		if (is_home()) {
		   // 将以下引号中的内容改成你的主页description
		   $description = get_bloginfo('description');
		   // 将以下引号中的内容改成你的主页keywords
		   $keywords = 'Marco,前端知识,photoshop,wordpress,jQuery,树莓派,raspberry,小程序,织梦,dedecms,php';
		}
		elseif(is_page()) {
			$description = get_the_excerpt();
			$keywords = get_the_tags();
            if ($keywords) {
              foreach($keywords as $tag) {
                $keywords .= $tag->name . ',';
                $keywords = str_replace("Array","",$keywords);
              }
            }
            $keywords = rtrim($keywords, ",");
		}
		elseif (is_single()) {
		   //$description1 = get_post_meta($post->ID, "_description_value", true);
		   $description1 = get_the_excerpt();
		   $description2 = str_replace(array("\r\n", "\r", "\n","&nbsp;",'"',"<",">"),"",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
		   // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
		   $description = $description1 ? $description1 : $description2;
		   // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
		   $keywords = get_post_meta($post->ID, "_keywords_value", true);
		   if($keywords == '') {
			  $tags = wp_get_post_tags($post->ID);
			  foreach ($tags as $tag ) {
				 $keywords = $keywords . $tag->name . ", ";
			  }
			  $keywords = rtrim($keywords, ', ');
		   }
		}
		elseif (is_category()) {
		   // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
		   $description = category_description();
		   $keywords = single_cat_title('', false);
		}
		elseif (is_tag()){
		   // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
		   $description = tag_description();
		   $keywords = single_tag_title('', false);
		}
		$description = trim(strip_tags($description));
		$keywords = trim(strip_tags($keywords));
    ?>
    <title><?php
    			if (is_home () ) { bloginfo('name');print " | "; bloginfo('description'); }
    			elseif ( is_category() ) { single_cat_title();print " | "; bloginfo('name');}
    			elseif (is_single() ) { single_post_title();print " | ";bloginfo('name');}
    			elseif (is_page() ) { single_post_title();print " | ";bloginfo('name');}
    			elseif (is_tag() ) { single_tag_title();print " | ";bloginfo('name');}
    			else { wp_title('',true); } ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
    <!-- Bootstrap -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/blog.min.css" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/plug-in/FrigateBird-LightBox-master/gallery.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/plug-in/scrollreveal/scrollreveal.min.js?v=1.0.0"></script>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
  </head>
  <body>
	<header>
		<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
	  		<div class="container-fluid">
		    	<!-- Brand and toggle get grouped for better mobile display -->
				<div class="row">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand blog-head-tit" href="<?php bloginfo('url'); ?>"><img class="mr10" alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" width="100" height="50"></a>
					    </div>
					    <!-- Collect the nav links, forms, and other content for toggling -->
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						        <?php 
								    // 列出顶部导航菜单，菜单名称为mymenu，只列出一级菜单
								    wp_nav_menu( array(
										'container' => 'ul',
										'menu_class' => 'nav navbar-nav'
									) );
								?>
						      <ul class="nav navbar-nav navbar-right">
						      	<li class="dropdown blog-nav-hover">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="glyphicon glyphicon-th-large"></span> 功能<span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
                                        <?php global $current_user;
                                            get_currentuserinfo();
                                            if(current_user_can('level_10')){
                                            echo '
                                                <li><a href="'.site_url().'/wp-admin/profile.php"><span class="glyphicon glyphicon-user"></span> '.$current_user->display_name.'</a><li>
                                                <li><a href="'.site_url().'/wp-admin/"><span class="glyphicon glyphicon-cog"></span> 管理</a></li>
                                                <li><a href="'.site_url().'/wp-admin/post-new.php"><span class="glyphicon glyphicon-edit"></span> 撰写</a></li>
                                                <li><a href="'.wp_logout_url().'"><span class="glyphicon glyphicon-off"></span> 注销</a></li>
                                            ';
                                                } else {
                                                    echo '<li><a href="'.wp_login_url().'"><span class="glyphicon glyphicon-off"></span> 登陆</a></li>';
                                                }
                                        ?>
									</ul>
						        </li>
						      </ul>
							<form id="search" class="navbar-form navbar-right" role="search" action="<?php bloginfo('url'); ?>" method="get">
									<div class="container-fluid">
									    <div class="input-group">
									      <input id="s" name="s"  type="text" class="form-control" placeholder="输入关键字搜索" >
									      <span class="input-group-btn">
										  <button type="submit" class="btn btn-primary" value="Search"><span class="glyphicon glyphicon-search"></span></button>
									      </span>
									    </div><!-- /input-group -->
								    </div>

					    	</form>
					    </div><!-- /.navbar-collapse -->
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</nav>
	</header>
    <div class="jumbotron index-banner">
        <div class="container index-banner">

        </div>
    </div>
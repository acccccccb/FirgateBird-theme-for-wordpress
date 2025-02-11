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
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1,user-scalable=no,maximum-scale=1.0, minimum-scale=1.0"
    >
    <?php echo get_option('firgatebird_custom_head'); ?>
    <?php
    $description = '';
    $keywords = '';
    if (is_home()) {
        // 将以下引号中的内容改成你的主页description
        $description = get_bloginfo('description');
        // 将以下引号中的内容改成你的主页keywords
        $keywords = get_option('firgatebird_home_keyword');
    } elseif (is_page()) {
        $description = get_the_excerpt();
        $keywords = get_the_tags();
        if ($keywords) {
            foreach ($keywords as $tag) {
                $keywords .= $tag->name . ',';
                $keywords = str_replace("Array", "", $keywords);
            }
        }
        $keywords = rtrim($keywords, ",");
    } elseif (is_single()) {
        //$description1 = get_post_meta($post->ID, "_description_value", true);
        $description1 = get_the_excerpt();
        $description2 = str_replace(array("\r\n", "\r", "\n", "&nbsp;", '"', "<", ">"), "", mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
        // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
        $description = $description1 ? $description1 : $description2;
        // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
        $keywords = get_post_meta($post->ID, "_keywords_value", true);
        if ($keywords == '') {
            $tags = wp_get_post_tags($post->ID);
            foreach ($tags as $tag) {
                $keywords = $keywords . $tag->name . ", ";
            }
            $keywords = rtrim($keywords, ', ');
        }
    } elseif (is_category()) {
        // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
        $description = category_description();
        $keywords = single_cat_title('', false);
    } elseif (is_tag()) {
        // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
        $description = tag_description();
        $keywords = single_tag_title('', false);
    }
    $description = trim(strip_tags($description));
    $keywords = trim(strip_tags($keywords));
    ?>
    <title><?php
        if (is_home()) {
            bloginfo('name');
            print " | ";
            bloginfo('description');
        } elseif (is_category()) {
            single_cat_title();
            print " | ";
            bloginfo('name');
        } elseif (is_single()) {
            single_post_title();
            print " | ";
            bloginfo('name');
        } elseif (is_page()) {
            single_post_title();
            print " | ";
            bloginfo('name');
        } elseif (is_tag()) {
            single_tag_title();
            print " | ";
            bloginfo('name');
        } else {
            wp_title('', true);
        } ?></title>
    <meta name="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" content="<?php echo $description; ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <?php wp_head(); ?>
    <!-- Bootstrap -->
    <link href="<?php echo get_template_directory_uri(); ?>/static/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/css/blog.min.css?v=1.0.1" />
    <link
        rel="stylesheet"
        href="<?php echo get_template_directory_uri(); ?>/static/plug-in/FrigateBird-LightBox-master/gallery.css"
    />
    <script src="<?php echo get_template_directory_uri(); ?>/static/js/vue.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if (is_singular()) wp_enqueue_script('comment-reply'); ?>
    <?php themeColor() ?>
</head>
<body>
<header>
    <nav
        class="navbar <?php echo !empty(get_option('firgatebird_menu_type')) ? get_option('firgatebird_menu_type') : 'navbar-default'; ?> navbar-fixed-top"
        role="navigation"
    >
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-header">
                        <button
                            type="button"
                            class="navbar-toggle collapsed"
                            data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1"
                        >
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand blog-head-tit" href="<?php bloginfo('url'); ?>">
                            <img
                                class="mr10"
                                alt="Brand"
                                src="<?php echo !empty(get_option('firgatebird_logo_img')) ? get_option('firgatebird_logo_img') : (get_template_directory_uri() . '/static/img/logo.png'); ?>"
                                width="100"
                                height="50"
                            >
                        </a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <?php
                        // 列出顶部导航菜单，菜单名称为mymenu，只列出一级菜单
                        wp_nav_menu(array(
                            'container' => 'ul',
                            'menu_class' => 'nav navbar-nav'
                        ));
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown blog-nav-hover">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-th-large"></span> 功能<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php global $current_user;
                                    wp_get_current_user();
                                    if (current_user_can('level_10')) {
                                        echo '
                                                <li><a href="' . site_url() . '/wp-admin/profile.php"><span class="glyphicon glyphicon-user"></span> ' . $current_user->display_name . '</a><li>
                                                <li><a href="' . site_url() . '/wp-admin/"><span class="glyphicon glyphicon-cog"></span> 管理</a></li>
                                                <li><a href="' . site_url() . '/wp-admin/post-new.php"><span class="glyphicon glyphicon-edit"></span> 撰写</a></li>
                                                <li><a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-off"></span> 注销</a></li>
                                            ';
                                    } else {
                                        echo '<li><a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-off"></span> 登陆</a></li>';
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                        <form
                            id="search"
                            class="navbar-form navbar-right"
                            role="search"
                            action="<?php bloginfo('url'); ?>"
                            method="get"
                        >
                            <div class="container-fluid">
                                <div class="input-group">
                                    <input type="text" id="s" name="s" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit">
                                                    <i class="glyphicon glyphicon-search"></i>
                                                </button>
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
<?php if ((is_home() || is_front_page()) && !is_paged()) { ?>
    <?php
if (have_posts() && is_sticky()) {
    ?>
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators"></ol>
        <div class="carousel-inner" role="listbox">
            <?php
            while (have_posts()) {
                the_post();
                if (is_sticky()) { // has_post_thumbnail() &&
                    $description1 = get_the_excerpt();
                    $description2 = str_replace(array("\r\n", "\r", "\n", "&nbsp;", '"', "<", ">"), "", mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
                    // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
                    $description = $description1 ? $description1 : $description2;
                    ?>
                    <div
                        class="item listBoxItem"
                        <?php if (has_post_thumbnail()) { ?>
                            style="background: url(<?php echo the_post_thumbnail_url("codilight_lite_single_large"); ?>) center center no-repeat!important;background-size: cover!important;"
                        <?php } ?>
                    >
                        <div class="carousel-caption">
                            <h1 class="hidden-xs hidden-sm text-left"><?php echo get_the_title(); ?></h1>
                            <h4 class="hidden-md hidden-lg text-center">
                                <a
                                    style="text-decoration: none;color:#fff;"
                                    href="<?php echo get_the_permalink(); ?>"
                                ><?php echo get_the_title(); ?></a>
                            </h4>
                            <p class="hidden-xs hidden-sm text-left"> <?php echo $description; ?></p>
                            <div class="text-left">
                                <a
                                    class="hidden-xs hidden-sm btn btn-default btn-md mt20"
                                    href="<?php echo get_the_permalink(); ?>"
                                    role="button"
                                >阅读内容</a>
                            </div>
                        </div>
                    </div>

                    <?php

                }
            }
            ?>
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
<?php
} else {
    ?>

    <?php
}
wp_reset_query();
?>
    <script>
        window.onload = () => {
            var sildeN = $('.carousel-inner>.item').length;
            if (sildeN > 0) {
                for (i = 0; i < sildeN; i++) {
                    var sildeHTML = '<li data-target="#carousel-example-generic" data-slide-to="' + i + '"></li>';
                    $('.carousel-indicators').append(sildeHTML);
                }
                $('.item:eq(0),.carousel-indicators>li:eq(0)').addClass('active');
            }
        }
    </script>
<?php } ?>

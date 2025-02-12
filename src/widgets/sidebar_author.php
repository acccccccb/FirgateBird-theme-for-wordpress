<?php
 /**
   * 最新评论
   *
   * */
    class sidebar_author extends WP_Widget {
        /** 构造函数 */
//        function sidebar_author() {
//            parent::WP_Widget(false, $name = 'Theme:作者介绍');
//        }
        function __construct(){
            $widget_ops = array('description' => __('Theme:作者介绍','bb10'));
            parent::__construct('sidebar_author' ,__('Theme:作者介绍','bb10'), $widget_ops);
        }
        /** @see WP_Widget::widget */
        function widget($args, $instance) {
            extract( $args );
            $about_author = $instance['about_author'];
            $about_author_tags = $instance['about_author_tags'];
            $github = $instance['github'];
            $gitee = $instance['gitee'];
            $email = $instance['email'];

            if(!$instance['about_author']) {
                $about_author = get_the_author_meta( 'description', 0  );
            }

            if(!$instance['title']) {
                $instance['title'] = "作者介绍";
            }
            ?>
                <?php echo $before_widget; ?>
                <?php $showtitle = !empty($instance['showtitle']) ? $instance['showtitle'] : 'undefined'; ?>
                <?php $showAvatar = !empty($instance['show_avatar']) ? $instance['show_avatar'] : 'undefined'; ?>
                <?php if($showtitle !== "undefined") { ?>
                    <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-user"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                <?php } ?>

                <nav class="nav pt10 about_author">
                    <?php if($showAvatar == "true") { ?>
                    <div class="site-ico col-lg-4 col-lg-offset-4 col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5">
                        <a href="<?php bloginfo('url'); ?>">
                            <img src="<?php echo fox_get_https_avatar(get_avatar_url(1, array('size' => 100))); ?>" alt="<?php bloginfo('name'); ?>" class="img-responsive img-circle  sidebar-site-img" />
                        </a>
                    </div>
                    <?php } ?>
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <h4 class="text-center"><?php the_author_meta( 'nickname', 0  );?></h4>
                        <div class="col-lg-12 text-center mb10">
                            <?php
                                function randrgb() {
                                    $str='456789BCD';
                                    $estr='#';
                                    $len=strlen($str);
                                    for($i=1;$i<=6;$i++)
                                    {
                                        $num=rand(0,$len-1);
                                        $estr=$estr.$str[$num];
                                    }
                                    return $estr;
                                }
                                $AuthorArray = explode(" ",$about_author_tags);
                                foreach ($AuthorArray as $val) {
                                    print('<span class="label" style="background:'.randrgb().';">'.$val.'</span> ');
                                }
                            ?>
                        </div>


                        <p><?php echo $about_author;?></p>
                        <hr>
                        <div class="mt10 site-info mb10">
                            <div class="site-info-article">
                                <div><?php echo wp_count_posts()->publish;?></div>
                                <div class="site-info-title">文章</div>
                            </div>
                            <div class="site-info-comments">
                                <div><?php global $wpdb;echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?></div>
                                <div class="site-info-title">评论</div>
                            </div>
                            <div class="site-info-view">
                                <div><?php echo get_all('views') ?></div>
                                <div class="site-info-title">浏览</div>
                            </div>
                            <div class="site-info-like">
                                <div><?php echo get_all('like') ?></div>
                                <div class="site-info-title">点赞</div>
                            </div>
                        </div>
                        <hr>
                        <address class="mt10">
                            <?php if($github) { ?>
                                <div><strong>github:</strong></div>
                                <div>
                                    <a href="<?php echo $github;?>"><small><?php echo $github;?></small></a>
                                </div>
                            <?php } ?>
                            <?php if($gitee) { ?>
                                <div class="mt20">
                                    <strong>gitee:</strong>
                                </div>
                                <div>
                                    <a href="<?php echo $gitee;?>"><small><?php echo $gitee;?></small></a>
                                </div>
                            <?php } ?>
                            <?php if($email) { ?>
                                <div class="mt20">
                                    <strong>E-mail:</strong>
                                </div>
                                <div>
                                    <a href="mailto:<?php echo $email;?>"><small><?php echo $email;?></small></a>
                                </div>
                            <?php } ?>
                        </address>
                    </div>
                </nav>
                <?php echo $after_widget; ?>
            <?php
        }

        /** @see WP_Widget::update 后台保存内容 */
        function update($new_instance, $old_instance) {
            return $new_instance;
        }

        /** @see WP_Widget::form 输出设置菜单 */
        function form($instance) {
            $title = esc_attr($instance['title']) ?? '';
            $about_author = $instance['about_author'] ?? '';
            $about_author_tags = $instance['about_author_tags'] ?? '';
            $github = $instance['github'] ?? '';
            $gitee = $instance['gitee'] ?? '';
            $email = $instance['email'] ?? '';
            $showtitle = $instance['showtitle'] ?? '';
            $showAvatar = $instance['show_avatar'] ?? '';
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                        <?php _e('Title:'); ?>
                        <input maxlength="20" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                    </label>
                    <?php if($showtitle=="true") { ?>
                            <input checked class="checkbox" id="<?php echo $this->get_field_id('showtitle'); ?>" name="<?php echo $this->get_field_name('showtitle'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('showtitle'); ?>">显示标题</label>
                            <?php } else { ?>
                            <input class="checkbox" id="<?php echo $this->get_field_id('showtitle'); ?>" name="<?php echo $this->get_field_name('showtitle'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('showtitle'); ?>">显示标题</label>
                    <?php } ?>
                    <?php if($showAvatar=="true") { ?>
                        <input checked class="checkbox" id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('show_avatar'); ?>">显示头像</label>
                    <?php } else { ?>
                        <input class="checkbox" id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('show_avatar'); ?>">显示头像</label>
                    <?php } ?>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('about_author_tags'); ?>">
                        个人标签(用空格隔开)：
                        <input class="widefat" maxlength="200" id="about_author_tags" name="<?php echo $this->get_field_name('about_author_tags'); ?>" type="text" value="<?php echo $about_author_tags; ?>">
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('about_author'); ?>">
                        简单介绍下自己：
                        <textarea rows="3" cols="20" class="widefat" id="<?php echo $this->get_field_id('about_author'); ?>" name="<?php echo $this->get_field_name('about_author'); ?>" ><?php echo $about_author; ?></textarea>
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('github'); ?>">
                        Github：
                        <input class="widefat" maxlength="200" id="github" name="<?php echo $this->get_field_name('github'); ?>" type="text" value="<?php echo $github; ?>">
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('github'); ?>">
                        Gitee：
                        <input class="widefat" maxlength="200" id="gitee" name="<?php echo $this->get_field_name('gitee'); ?>" type="text" value="<?php echo $gitee; ?>">
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('email'); ?>">
                        E-mail:
                        <input class="widefat" type="text" maxlength="50" id="email" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $email; ?>">
                    </label>
                </p>

            <?php
        }

    } // class FooWidget
    register_widget("sidebar_author");
?>

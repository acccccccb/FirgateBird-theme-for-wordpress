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
                <?php $showtitle = $instance['showtitle']; ?>
                <?php if($showtitle=="true" || $showtitle == "undefined") { ?>
                    <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-user"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                <?php } ?>

                <nav class="nav pt20">
                    <div class="site-ico col-lg-4 col-lg-offset-4 col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5">
                        <a href="<?php bloginfo('url'); ?>">
                            <img src="<?php echo get_site_icon_url(); ?>" alt="<?php bloginfo('name'); ?>" class="img-responsive img-circle  sidebar-site-img" />
                        </a>
                    </div>
                    <div class="col-lg-12 col-xs-12 col-md-12">
                        <h3 class="text-center"><?php the_author_meta( 'nickname', 0  );?></h3>
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
                        <address class="mt10">
                            <?php if($github) { ?>
                                <strong>github:</strong><br>
                                <a href="<?php echo $github;?>"><small><?php echo $github;?></small></a><br><br>
                            <?php } ?>
                            <?php if($gitee) { ?>
                                <strong>gitee:</strong><br>
                                <a href="<?php echo $gitee;?>"><small><?php echo $gitee;?></small></a><br><br>
                            <?php } ?>
                            <?php if($email) { ?>
                                <strong>E-mail:</strong><br>
                                <a href="mailto:<?php echo $email;?>"><small><?php echo $email;?></small></a><br><br>
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
            $title = esc_attr($instance['title']);
            $about_author = $instance['about_author'];
            $about_author_tags = $instance['about_author_tags'];
            $github = $instance['github'];
            $gitee = $instance['gitee'];
            $email = $instance['email'];
            $showtitle = $instance['showtitle'];
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

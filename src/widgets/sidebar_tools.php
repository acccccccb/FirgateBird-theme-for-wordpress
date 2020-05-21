<?php
 /**
   * 最新评论
   * 
   * */
    class sidebar_tools extends WP_Widget {
        /** 构造函数 */
        function sidebar_tools() {
            parent::WP_Widget(false, $name = 'Theme:工具');	
        }

        /** @see WP_Widget::widget */
        function widget($args, $instance) {		
            extract( $args );
            if(!$instance['title']) {
                $instance['title'] = "工具";
            }
            if(!$num_comments) {
                $instance['num_comments'] = 5;
            }
            if(!$comment_len) {
                $instance['comment_len'] = 80;
            }
            if(!$avatar_size) {
                $instance['avatar_size'] = 42;
            }
            ?>
                <?php echo $before_widget; ?>
                    <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-cog"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                    <ul class="list-unstyled line-height-30">
                    <?php global $current_user;
                        get_currentuserinfo();
                        if(current_user_can('level_10')){
                        echo '
                            <li><a href="'.site_url().'/wp-admin/profile.php"><span class="glyphicon glyphicon-user"></span> '.$current_user->display_name.'</a><li>
                            <li><a href="'.site_url().'/wp-admin/"><span class="glyphicon glyphicon-cog"></span> 管理</a></li>
                            <li><a href="'.site_url().'/wp-admin/post-new.php"><span class="glyphicon glyphicon-edit"></span> 撰写</a></li>
                            <li><a href="'.wp_logout_url().'"><span class="glyphicon glyphicon-off"></span> 登出</a></li>
                        ';
                        } else {
                                echo '<li><a href="'.wp_login_url().'"><span class="glyphicon glyphicon-off"></span> 登陆</a></li>';
                        }
                    ?>
                </ul>
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
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                        <?php _e('Title:'); ?>
                        <input maxlength="20" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                    </label>
                </p>
            <?php 
        }

    } // class FooWidget
    register_widget("sidebar_tools");
?>
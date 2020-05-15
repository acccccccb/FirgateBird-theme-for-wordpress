<?php
 /**
   * 最新评论
   * 
   * */
    class sidebar_categories extends WP_Widget {
        /** 构造函数 */
        function sidebar_categories() {
            parent::WP_Widget(false, $name = 'Theme:文章分类');	
        }

        /** @see WP_Widget::widget */
        function widget($args, $instance) {		
            extract( $args );
            if(!$instance['title']) {
                $instance['title'] = "文章分类";
            }
            ?>
                <?php echo $before_widget; ?>
                <?php echo '<div class="sidebar-tit">'.'<span class="glyphicon glyphicon-folder-open"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                        <?php 
                            // 列出顶部导航菜单，菜单名称为mymenu，只列出一级菜单
                            wp_nav_menu( array(
                                'container' => 'ul',
                                'menu_class' => 'tacked list-unstyled line-height-30'
                            ) );
                        ?>
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
	register_widget("sidebar_categories");
?>
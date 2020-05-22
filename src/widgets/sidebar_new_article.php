<?php
 /**
   * 最新评论
   * 
   * */
    class sidebar_new_article extends WP_Widget {
        /** 构造函数 */
//        function sidebar_new_article() {
//            parent::WP_Widget(false, $name = 'Theme:最新文章');
//        }
        function __construct(){
            $widget_ops = array('description' => __('Theme:最新文章','bb10'));
            parent::__construct('sidebar_new_article' ,__('Theme:最新文章','bb10'), $widget_ops);
        }
        /** @see WP_Widget::widget */
        function widget($args, $instance) {		
            extract( $args );
            if(!$instance['title']) {
                $instance['title'] = "最新文章";
            }
            if(!$instance['ArticleNum']) {
                $instance['ArticleNum'] = 10; 
            }
            ?>
                <?php echo '<aside class="mb20">' ?>
                    <?php echo '<div class="sidebar-tit">'.'<span class="glyphicon glyphicon-list-alt"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                    <ul class="list-unstyled line-height-30 sidebar-article-tit">
                        <?php
                            $ArticleNum = $instance['ArticleNum'];// 文章数量

                            query_posts('showposts='.$ArticleNum);
                            if ( have_posts() ) : while ( have_posts() ) : the_post();
                                echo '<li><a href="' . get_the_permalink() . '">'. get_the_title() . '</a></li>';
                            endwhile; else:
                                echo '<li>暂无文章</li>';
                            endif;
                            wp_reset_query();
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
            $ArticleNum = $instance['ArticleNum'];
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                        <?php _e('Title:'); ?>
                        <input maxlength="20" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('ArticleNum'); ?>">
                        文章调用数量
                        <input class="widefat" type="text" maxlength="2" id="ArticleNum" name="<?php echo $this->get_field_name('ArticleNum'); ?>" type="number" value="<?php echo $ArticleNum; ?>">
                    </label>
                </p>
            <?php 
        }

    } // class FooWidget
	register_widget("sidebar_new_article");
?>
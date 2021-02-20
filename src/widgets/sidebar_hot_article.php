<?php
 /**
   * 最热文章
   *
   * */
    class sidebar_hot_article extends WP_Widget {
        /** 构造函数 */
//        function sidebar_hot_article() {
//            parent::WP_Widget(false, $name = 'Theme:热门文章');
//        }
        function __construct(){
            $widget_ops = array('description' => __('Theme:热门文章','bb10'));
            parent::__construct('sidebar_hot_article' ,__('Theme:热门文章','bb10'), $widget_ops);
        }
        /** @see WP_Widget::widget */
        function widget($args, $instance) {
            extract( $args );
            if(!$instance['title']) {
                $instance['title'] = "热门文章";
            }
            if(!$instance['ArticleNum']) {
                $instance['ArticleNum'] = 10;
            }
            ?>
                <?php echo '<aside class="mb20">' ?>
                    <?php echo '<div class="sidebar-tit">'.'<span class="glyphicon glyphicon-list-alt"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                    <ul class="list-unstyled most-view line-height-30 sidebar-article-tit">
                        <?php
                            $ArticleNum = $instance['ArticleNum'];// 文章数量
                        global $post;
                        $args = array(
                            'post_password' => '',
                            'post_status' => 'publish', // 只选公开的文章.
                            'post__not_in' => array($post->ID),//排除当前文章
                            'ignore_sticky_posts' => 1, // 排除置顶文章.
                            'meta_key' => 'views',
                            'orderby' => 'meta_value_num',
                            'order'		=>	'DESC',
                            'posts_per_page' => $ArticleNum
                        );
                        $query_posts = new WP_Query();
                        $query_posts->query($args);
                        $c = 0;
                        while( $query_posts->have_posts() ) {
                            $query_posts->the_post();
                            $c = $c+1;
                            echo '
                                <li>
                                    <a title="'.get_the_title().'" style="display:inline-block!important;vertical-align: middle;overflow: hidden;width: calc(100% - 100px);" href="'.get_the_permalink().'">
                                        <span class="most-view-num most-view-num-'.$c.'">'.$c.'</span>'.get_the_title().'
                                    </a>
                                    <span style="display:inline-block!important;vertical-align: middle;text-align: right;width: 96px;overflow: hidden;font-size: 12px;">
                                        '.get_post_meta(get_the_ID(), 'views', true).'
                                    </span>
                                </li>
                            '; // get_post_meta(get_the_ID(), 'views', true)
                        }
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
	register_widget("sidebar_hot_article");
?>

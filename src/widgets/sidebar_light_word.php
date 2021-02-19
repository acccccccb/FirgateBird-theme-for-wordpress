<?php
/**
 * 最新评论
 *
 * */
class sidebar_light_word extends WP_Widget {
    /** 构造函数 */
//    function sidebar_light_word() {
//        parent::WP_Widget(false, $name = 'Theme:日历');
//    }
    function __construct(){
        $widget_ops = array('description' => __('Theme:轻言','bb10'));
        parent::__construct('sidebar_light_word' ,__('Theme:轻言','bb10'), $widget_ops);
    }
    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        if(!$instance['title']) {
            $instance['title'] = "轻言";
        }
        ?>
        <?php echo $before_widget; ?>
        <?php $showtitle = $instance['showtitle']; ?>
        <?php if($showtitle=="true" || $showtitle == "undefined") { ?>
            <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-comment"></span>&nbsp;' . $instance['title'] . $after_title; ?>
        <?php } ?>

        <div class="row">
            <div class="col-xs-12">
        <?php
            global $wpdb;
            global $table_prefix;
            $table = $table_prefix . 'firgatebird_light_word';
            // $wpdb->show_errors();
            $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}");
            if($count === NULL) {
        ?>
            <div>
                <p>暂无数据, 请先去后台初始化</p>
            </div>
        <?php } else { ?>
                <div>
                    <?php
                        $list = $wpdb->get_results( "
                              SELECT *
                              FROM {$table}
                              ORDER BY id DESC
                              LIMIT 0, 5
                            ", ARRAY_A);
                        foreach ($list as $item) {
                            ?>
                            <div class="media">
                                <div class="media-left">
                                    <?php global $current_user;get_currentuserinfo();echo get_avatar( $current_user->user_email, 32); ?>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $item['create_time']?></h4>
                                    <?php echo $item['content']?>
                                </div>
                            </div>
                    <?php } ?>
                </div>
        <?php } ?>
            </div>
        </div>
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
        <?php
    }

} // class FooWidget
register_widget("sidebar_light_word");
?>

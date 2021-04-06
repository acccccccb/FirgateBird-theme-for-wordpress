<?php
/**
 * 最新评论
 *
 * */
class sidebar_calendar extends WP_Widget {
    /** 构造函数 */
//    function sidebar_calendar() {
//        parent::WP_Widget(false, $name = 'Theme:日历');
//    }
    function __construct(){
        $widget_ops = array('description' => __('Theme:日历','bb10'));
        parent::__construct('sidebar_calendar' ,__('Theme:日历','bb10'), $widget_ops);
    }
    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        if(!$instance['title']) {
            $instance['title'] = "日历";
        }
        ?>
        <?php echo $before_widget; ?>
        <?php $showtitle = $instance['showtitle'] ?? false; ?>
        <?php if($showtitle=="true" || $showtitle == "undefined") { ?>
            <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-calendar"></span>&nbsp;' . $instance['title'] . $after_title; ?>
        <?php } ?>

        <div class="row">
            <div class="col-xs-12">
                <?php get_calendar(); ?>
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
        $showtitle = $instance['showtitle'] ?? false;
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
register_widget("sidebar_calendar");
?>

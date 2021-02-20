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
        $user = wp_get_current_user();
        $allowed_roles = array( 'administrator' );
        extract( $args );
        if(!$instance['title']) {
            $instance['title'] = "轻言";
        }
        ?>
        <?php echo $before_widget; ?>
        <?php $showtitle = $instance['showtitle']; ?>
        <?php if($showtitle=="true" || $showtitle == "undefined") { ?>
            <div class="sidebar-tit">
                <span class="glyphicon glyphicon-comment"></span>&nbsp;<?php echo $instance['title']; ?>
                <?php if ( array_intersect( $allowed_roles, $user->roles ) ) {?>
                    <script>
                        function showSidebarLightWordEdit() {
                            const display = document.getElementById('firgatebird_form_add_item').style.display;
                            document.getElementById('firgatebird_form_add_item').style.display = (display === 'block' ? 'none' : 'block');
                        }
                    </script>
                    <a style="float: right; font-size: 14px; opacity: .5;margin-left: 4px;" onclick="showSidebarLightWordEdit()" href="javascript:void();">添加</a>
                    <a style="float: right; font-size: 14px; opacity: .5;margin-left: 4px;" href="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word">管理</a>
                <?php }?>
            <?php echo $after_title;?>
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
                <p>此功能尚未启用, 请先去后台<strong>启用此功能</strong></p>
                <a href="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word" class="btn btn-danger" style="color: #fff;">启用</a>
            </div>
        <?php } else { ?>
                <div>
                    <?php
                    $user = wp_get_current_user();
                    $allowed_roles = array( 'administrator' );
                    if ( array_intersect( $allowed_roles, $user->roles ) ) {
                        ?>
                        <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
                        <form method="post" name="firgatebird_form_add_item" id="firgatebird_form_add_item" style="display: none;" target="rfFrame" onsubmit="addItem()" action="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word&add=true" class="validate" autocomplete="off">
                            <div class="input-group">
                                <input type="text" name="content" id="sidebarLigntWordInput" class="form-control" placeholder="发表想法...">
                                <input type="text" name="status" class="hidden" value="0">
                                <input type="text" name="show" class="hidden" value="1">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">提交</button>
                                </span>
                            </div><!-- /input-group -->
                            <div class="light-word-emoj-edit">
                                <a href="javascript:sidebarLightWordgrin(':?:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f604.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':razz:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f61b.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':sad:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f626.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':smile:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f623.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':oops:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f633.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':grin:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f600.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':eek:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f62e.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':shock:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f62f.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':cool:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f60e.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':lol:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f606.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':mad:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f621.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':wink:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f609.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':neutral:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f610.png" width="16" /></a>
                                <a href="javascript:sidebarLightWordgrin(':cry:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f625.png" width="16" /></a>
                            </div>
                        </form>
                        <script>
                            function addItem() {
                                document.getElementById('rfFrame').onload = function(res){
                                    if(res.returnValue) {
                                        window.location.reload();
                                    } else {
                                        window.alert('添加失败');
                                    }
                                };
                            }
                            function submitDelete(id) {
                                const  r = confirm("确认要删除吗？");
                                if (r == true){
                                    document.getElementById('firgatebird_form_delete_item_btn_' + id).click();
                                }
                            }
                            function deleteItem() {
                                document.getElementById('rfFrame').onload = function(res){
                                    if(res.returnValue) {
                                        window.location.reload();
                                    } else {
                                        window.alert('删除失败');
                                    }
                                };
                            }
                            function sidebarLightWordgrin(emoj) {
                                document.getElementById('sidebarLigntWordInput').value += emoj;
                            }
                        </script>
                        <style>
                            .light-word-emoj {
                                vertical-align: text-top;
                                margin-top: 2px;
                            }
                            .light-word-emoj-edit img {
                                width: 16px;
                            }
                        </style>
                    <?php } ?>
                    <?php
                        //评论表情路径
                        $smiley = [':?:',':razz:',':sad:',':smile:',':oops:',':grin:',':eek:',':shock:',':cool:',':lol:',':mad:',':wink:',':neutral:',':cry:'];
                        $smileyImg = [
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f604.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f61b.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f626.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f603.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f633.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f600.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f62e.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f62f.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f60e.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f606.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f621.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f609.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f610.png"></img>',
                            '<img width="16" height="16" class="light-word-emoj" src="'.get_template_directory_uri().'/static/img/smilies/1f625.png"></img>',
                        ];
                        $ArticleNum = $instance['ArticleNum'] ? $instance['ArticleNum'] : 5 ;
                        $list = $wpdb->get_results( "
                              SELECT *
                              FROM {$table}
                              WHERE 'show'=0
                              ORDER BY id DESC
                              LIMIT 0, $ArticleNum
                            ", ARRAY_A);
                        foreach ($list as $item) {
                            ?>
                            <div class="media">
                                <div class="media-left">
                                    <?php global $current_user;wp_get_current_user();echo get_avatar( $current_user->user_email, 32); ?>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <span style="font-size: 14px;font-weight: 500;"><?php echo $current_user->display_name ?></span>
                                        <small style="font-size: 12px; opacity: .5">
                                            <?php echo $item['create_time']?>
                                            <?php if ( array_intersect( $allowed_roles, $user->roles ) ) {?>
                                            <form style="display: none;" method="post" id="firgatebird_form_delete_item" name="firgatebird_form_delete_item" target="rfFrame" onsubmit="deleteItem()" action="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word&delete=true" class="validate">
                                                <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                                <button type="submit" id="firgatebird_form_delete_item_btn_<?php echo $item['id']?>" style="display: none;">删除</button>
                                            </form>
                                            <a id="delete_<?php echo $item['id']?>" href="javascript:void(0);" onclick="submitDelete(<?php echo $item['id']?>)">删除</a>
                                            <?php }?>
                                        </small>
                                    </h4>
                                    <p style="font-size: 14px;line-height: 150%;color: #333;font-family: 'Microsoft Yahei'">
                                        <?php $commentsText = $item['content']?>
                                        <?php $commentsText = str_replace($smiley,$smileyImg,mb_substr( $commentsText, 0, 300 )); ?>
                                        <?php echo $commentsText?>
                                    </p>
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
        $ArticleNum = $instance['ArticleNum'];
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
            <label for="<?php echo $this->get_field_id('ArticleNum'); ?>">
                最多显示几条
                <input class="widefat" type="text" maxlength="2" id="ArticleNum" name="<?php echo $this->get_field_name('ArticleNum'); ?>" type="number" value="<?php echo $ArticleNum; ?>">
            </label>
        </p>
        <?php
    }

} // class FooWidget
register_widget("sidebar_light_word");
?>

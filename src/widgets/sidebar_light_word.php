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
        <div id="firgatebird_light_word_sidebar">
            <?php $showtitle = $instance['showtitle'] ?? false; ?>
            <?php $showavatar = $instance['showavatar'] ?? false; ?>
            <?php if($showtitle=="true" || $showtitle == "undefined") { ?>
            <div class="sidebar-tit">
                <span class="glyphicon glyphicon-grain"></span>&nbsp;<?php echo $instance['title']; ?>
                <?php if ( array_intersect( $allowed_roles, $user->roles ) ) {?>
                    <a href="javascript:;" style="float: right; font-size: 14px; opacity: .5;margin-left: 4px;" @click="addShow = !addShow">
                        {{ !addShow ? '添加' : '取消' }}
                    </a>
                    <a style="float: right; font-size: 14px; opacity: .5;margin-left: 4px;" href="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word">管理</a>
                <?php }?>
                <?php echo $after_title;?>
                <?php } ?>
                <?php
                wp_enqueue_script('wp-api', get_template_directory_uri() . '/static/js/blog.js');
                wp_localize_script( 'wp-api', 'wpApiSettings', array(
                    'root' => esc_url_raw( rest_url() ),
                    'nonce' => wp_create_nonce( 'wp_rest' )
                ));
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        global $wpdb;
                        global $table_prefix;
                        $wpdb->hide_errors();
                        //  $wpdb->show_errors();
                        $table = $table_prefix . 'firgatebird_light_word';
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
                                    <form method="post" name="firgatebird_form_add_item" id="firgatebird_form_add_item" v-show="addShow" target="rfFrame" onsubmit="addItem()" action="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word&add=true" class="validate" autocomplete="off">
                                        <div class="light-word-emoj-edit">
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':?:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f604.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':razz:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f61b.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':sad:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f626.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':smile:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f623.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':oops:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f633.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':grin:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f600.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':eek:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f62e.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':shock:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f62f.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':cool:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f60e.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':lol:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f606.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':mad:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f621.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':wink:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f609.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':neutral:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f610.png" width="16" /></a>
                                            <a href="javascript:;" @click="sidebarLightWordgrin(':cry:')"><img src="<?php echo get_template_directory_uri(); ?>/static/img/smilies/1f625.png" width="16" /></a>
                                        </div>
                                        <textarea name="content" required v-model="form.content" placeholder="发表想法..." rows="3" style="width: 100%;max-width: 100%;min-width: 100%;min-height: 38px;"></textarea>
                                        <input type="text" name="status" class="hidden" v-model="form.status">
                                        <input type="text" name="show" class="hidden" v-model="form.show">
                                        <div style="text-align: right;">
                                            <button class="btn btn-default fl" :disabled="loading" type="button" @click="addShow = false">取消</button>
                                            <button class="btn btn-primary" :disabled="loading" type="button" @click="add">提交</button>
                                        </div>
                                    </form>
                                <?php } ?>
                                <div v-if="list.length > 0">
                                    <div class="mt10" v-for="item in list">
                                        <div class="media">
                                            <?php if($showavatar=="true") { ?>
                                                <div class="media-left">
                                                    <img
                                                        class="avatar avatar-32 photo"
                                                        loading="lazy"
                                                        :src="item.avatar"
                                                        width="32"
                                                        height="32"
                                                        :alt="item.display_name"
                                                    >
                                                </div>
                                            <?php } ?>
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <span style="font-size: 14px;font-weight: 500;">
                                                        {{ item.display_name }}
                                                    </span>
                                                    <small style="font-size: 12px; opacity: .5">
                                                        {{ item.create_time }}
                                                        <?php if ( array_intersect( $allowed_roles, $user->roles ) ) {?>
                                                            <a href="javascript:void(0);" @click="del(item.id)">删除</a>
                                                        <?php }?>
                                                    </small>
                                                </h4>
                                                <p style="font-size: 14px;line-height: 150%;color: #333;font-family: 'Microsoft Yahei'" v-html="item.content"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager sidebar-pager" style="margin: 10px 0;">
                                        <li class="previous" :class="page === 1 ? 'disabled' : ''"><a href="javascript:;" @click="jumpTo(page - 1)">上一页</a></li>
                                        <span class="page-number">{{ page }} / {{ totalPage }}</span>
                                        <li class="next" :class="page === totalPage ? 'disabled' : ''"><a href="javascript:;" @click="jumpTo(page + 1)">下一页</a></li>
                                    </ul>
                                </div>
                                <div v-else>暂无内容</div>
                                <style>
                                    .light-word-emoj {
                                        vertical-align: text-top;
                                        margin-top: 2px;
                                    }
                                    .light-word-emoj-edit img {
                                        width: 16px;
                                    }
                                </style>
                            </div>
                            <script>
                                new Vue({
                                    el: '#firgatebird_light_word_sidebar',
                                    data() {
                                        return {
                                            addShow: false,
                                            loading: false,
                                            list: [],
                                            page: 1,
                                            totalPage: 1,
                                            pageSize: <?php echo $instance['ArticleNum'] ? $instance['ArticleNum'] : 5 ;?>,
                                            form: {
                                                show: 1,
                                                status: 0,
                                                content: '',
                                            }
                                        }
                                    },
                                    created() {
                                        const _this = this;
                                        window.onload = () => {
                                            _this.getList();
                                        }
                                    },
                                    methods: {
                                        sidebarLightWordgrin(emoj) {
                                            this.form.content += emoj;
                                        },
                                        jumpTo(page) {
                                            if(page < 1 || page > this.totalPage) {
                                                return;
                                            }
                                            this.page = page;
                                            this.getList();
                                        },
                                        getList() {
                                            const _this = this;
                                            jQuery.ajax({
                                                url: '/wp-json/fb/light_word/getList',
                                                method: 'POST',
                                                data: {
                                                    page: this.page,
                                                    pageSize: <?php echo $instance['ArticleNum'] ? $instance['ArticleNum'] : 5 ;?>
                                                },
                                                beforeSend: ( xhr ) => {
                                                    xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                                                },
                                                success: (res) => {
                                                    _this.list = res.data.rows;
                                                    _this.totalPage = res.data.totalPage;
                                                }
                                            });
                                        },
                                        del(id) {
                                            const _this = this;
                                            window.$confirmModal({
                                                title: '删除确认',
                                                content: '确认要删除吗？',
                                                confirm: () => {
                                                    jQuery.ajax({
                                                        url: '/wp-json/fb/admin/light_word_admin/delete',
                                                        method: 'POST',
                                                        data: {
                                                            id,
                                                        },
                                                        beforeSend: ( xhr ) => {
                                                            xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                                                        },
                                                        success: (res) => {
                                                            if(res.code === 200) {
                                                                _this.getList();
                                                            } else {
                                                                window.alert(res.message || '删除失败');
                                                            }
                                                        }
                                                    });
                                                }
                                            });

                                        },
                                        add() {
                                            if(!this.form.content) {
                                                window.alert('内容不能为空');
                                                return;
                                            }
                                            const _this = this;
                                            _this.loading = true;
                                            jQuery.ajax({
                                                url: '/wp-json/fb/admin/light_word_admin/add',
                                                method: 'POST',
                                                data: this.form,
                                                beforeSend: ( xhr ) => {
                                                    xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
                                                },
                                                success: (res) => {
                                                    if(res.code === 200) {
                                                        _this.addShow = false;
                                                        _this.page = 1;
                                                        _this.form.content = '';
                                                        _this.getList();
                                                    } else {
                                                        window.alert(res.message || '添加失败');
                                                    }
                                                    _this.loading = false;
                                                }
                                            });
                                        }
                                    }
                                });
                            </script>
                        <?php } ?>
                    </div>
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
        $showavatar = $instance['showavatar'] ?? false;
        $ArticleNum = $instance['ArticleNum'] ?? 5;
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
            <?php if($showavatar=="true") { ?>
                <input checked class="checkbox" id="<?php echo $this->get_field_id('showavatar'); ?>" name="<?php echo $this->get_field_name('showavatar'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('showavatar'); ?>">显示头像</label>
            <?php } else { ?>
                <input class="checkbox" id="<?php echo $this->get_field_id('showavatar'); ?>" name="<?php echo $this->get_field_name('showavatar'); ?>" type="checkbox" value="true"> <label for="<?php echo $this->get_field_id('showavatar'); ?>">显示头像</label>
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

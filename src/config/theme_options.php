<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/8
 * Time: 15:45
 */
function firgatebird_option_function(){
    //page_titile-title标签的内容
    //menu_title-显示在后台左边菜单的标题
    //capability-访问这个页面需要的权限
    //menu_slug-别名，需要独一无二哦
    //function-执行的函数
    add_theme_page( 'title标题', '主题设置', 'administrator', 'firgatebird_slug','display_function');
}
?>
<?php function display_function(){ ?>
    <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="formOnSubmit()" action="options.php" class="validate">
        <h1>主题设置</h1>
        <div class="widget-content" style="margin-top:50px;">
            <div class="form-field term-description-wrap">
                <div style="margin-bottom: 10px;">
                    <label for="firgatebird_color">主题色：</label>
                </div>
                <input
                    type="color"
                    name="firgatebird_color"
                    id="firgatebird_color"
                    value="<?php echo get_option('firgatebird_color'); ?>"
                    placeholder="主题色"
                >
            </div>
            <div class="form-field term-description-wrap">
                <div style="margin-bottom: 10px;">
                    <label for="firgatebird_font_color">正文颜色：</label>
                </div>
                <input
                    type="color"
                    name="firgatebird_font_color"
                    id="firgatebird_font_color"
                    value="<?php echo get_option('firgatebird_font_color'); ?>"
                    placeholder="正文颜色"
                >
            </div>
            <div class="form-field term-description-wrap">
                <div style="margin-bottom: 10px;">
                    <label for="firgatebird_logo_img">LOGO设置(100 x 50)：</label>
                </div>
                <div style="margin-bottom: 10px;">
                    <img class="mr10" alt="Brand" src="<?php echo !empty(get_option('firgatebird_logo_img')) ? get_option('firgatebird_logo_img') : (get_template_directory_uri() . '/static/img/logo.png'); ?>" width="100" height="50">
                </div>
                <input
                    type="text"
                    name="firgatebird_logo_img"
                    id="firgatebird_logo_img"
                    value="<?php echo get_option('firgatebird_logo_img'); ?>"
                    placeholder="顶部导航logo图片地址(100 x 50)"
                >
            </div>
            <div class="form-field term-description-wrap">
                <label for="firgatebird_menu_type">
                    <div style="margin-bottom: 10px;">导航样式：</div>
                </label>
                <select
                    style="width: 630px;"
                    class="postform"
                    name="firgatebird_menu_type"
                    id="firgatebird_menu_type"
                    value="<?php echo get_option('firgatebird_menu_type'); ?>"
                >
                    <option value="navbar-default" <?php echo get_option('firgatebird_menu_type')=='navbar-default'?'selected':'' ?> >浅色</option>
                    <option value="navbar-inverse" <?php echo get_option('firgatebird_menu_type')=='navbar-inverse'?'selected':'' ?> >深色</option>
                </select>
            </div>
            <div class="form-field term-description-wrap">
                <div style="margin-bottom: 10px;">
                    <label for="firgatebird_home_keyword">首页关键词：</label>
                    <p class="description">首页的keyword字段值，用英文逗号隔开</p>
                </div>
                <input
                    type="text"
                    name="firgatebird_home_keyword"
                    id="firgatebird_home_keyword"
                    value="<?php echo get_option('firgatebird_home_keyword'); ?>"
                    placeholder="首页关键词"
                >
            </div>
            <div class="form-field term-description-wrap">
                <label for="firgatebird_custom_head">
                    <div style="margin-bottom: 10px;">插入head标签的代码：</div>
                </label>
                <textarea
                    name="firgatebird_custom_head"
                    id="firgatebird_custom_head"
                    cols="100"
                    rows="5"
                    placeholder="插入head标签的代码"
                ><?php echo get_option('firgatebird_custom_head'); ?></textarea>
            </div>
            <div class="form-field term-description-wrap">
                <label for="firgatebird_stats_code">
                    <div style="margin-bottom: 10px;">统计代码：</div>
                </label>
                <textarea
                    name="firgatebird_stats_code"
                    id="firgatebird_stats_code"
                    cols="100"
                    rows="5"
                    placeholder="页面底部统计代码"
                ><?php echo get_option('firgatebird_stats_code'); ?></textarea>
            </div>
            <div class="form-field term-description-wrap">
                <label for="firgatebird_stats_code">
                    <div style="margin-bottom: 10px;">自定义HTML(插入到页面最下方)：</div>
                </label>
                <textarea
                    name="firgatebird_custom_code"
                    id="firgatebird_custom_code"
                    cols="100"
                    rows="5"
                    placeholder="自定义HTML代码"
                ><?php echo get_option('firgatebird_custom_code'); ?></textarea>
            </div>
            <?php wp_nonce_field('update-options'); ?>
            <input type="hidden" name="action" value="update" />
            <input
                type="hidden"
                name="page_options"
                value="firgatebird_stats_code,firgatebird_logo_img,firgatebird_menu_type,firgatebird_custom_code,firgatebird_custom_head,firgatebird_color,firgatebird_home_keyword,firgatebird_font_color"
            />
            <p class="submit">
                <button class="button button-primary" id="firgatebird_submit" type="submit" name="option_save" >保存设置</button>
                <span id="firgatebird_message" style="display: none;">保存成功</span>
            </p>
        </div>
    </form>
    <style>
        .validate {
            max-width: 600px;
        }
        .term-description-wrap {
            margin: 1em 0;
            padding: 0;
        }
        label {
            font-weight: bold;
        }
        .form-field {
            margin-bottom: 20px;
        }
        #firgatebird_message {
            color: green;
            display: inline-block;
            margin-left: 10px;
        }
        .description {
            color: #999;
        }
    </style>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
    <script>
        function formOnSubmit(){
            document.getElementById('firgatebird_message').style.display = 'none';
            document.getElementById('firgatebird_submit').innerText = '正在保存...';
            document.getElementById('firgatebird_submit').disabled = true;
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    document.getElementById('firgatebird_message').style.display = 'inline-block';
                    window.location.reload();
                } else {
                    window.alert('保存失败');
                }
                document.getElementById('firgatebird_submit').disabled = false;
                document.getElementById('firgatebird_submit').innerText = '保存设置';
            };
        }
    </script>
<?php } ?>
<?php add_action('admin_menu', 'firgatebird_option_function');?>

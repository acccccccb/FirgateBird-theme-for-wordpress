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
    <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="formOnSubmit()" action="options.php">
        <h1>主题设置</h1>
        <div class="widget-content" style="margin-top:50px;">
            <p>
                <label for="firgatebird_menu_type">
                    导航设置：
                    <select name="firgatebird_menu_type" id="firgatebird_menu_type" value="<?php echo get_option('firgatebird_menu_type'); ?>">
                        <option value="navbar-default" <?php echo get_option('firgatebird_menu_type')=='navbar-default'?'selected':'' ?> >浅色</option>
                        <option value="navbar-inverse" <?php echo get_option('firgatebird_menu_type')=='navbar-inverse'?'selected':'' ?> >深色</option>
                    </select>
                </label>
            </p>
            <?php wp_nonce_field('update-options'); ?>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="firgatebird_menu_type" />
            <p class="submit">
                <input type="submit" name="option_save" value="<?php _e('保存设置'); ?>" />
            </p>
        </div>
    </form>
    <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
    <script>
        function formOnSubmit(){
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    alert('保存成功');
                }
            };
        }
    </script>
<?php } ?>
<?php add_action('admin_menu', 'firgatebird_option_function');?>
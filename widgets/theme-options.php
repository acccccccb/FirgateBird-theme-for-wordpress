<?php
/**
 * Created by PhpStorm.
 * User: futureis404
 * Date: 2018/4/22
 * Time: 16:12
 */
//注册数据
add_action('admin_init', 'register_theme_settings');
function register_theme_settings() {
    register_setting("theme_mods_freshblog","theme_mods_freshblog");
}
//添加admin外观菜单
add_action('admin_menu', 'add_theme_options_menu');
function add_theme_options_menu() {
    add_theme_page(
        'FrigateBird Theme Options',
        '主题设置',
        'edit_theme_options',
        'theme-options',
        'theme_settings_admin'
    );
}
?>
<?php function theme_settings_admin() { ?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/themeConfig.min.css">
   <div class="frig-opt-main">
       <div class="frig-opt-lead">
           <h1>感谢您使用FrigateBird主题！</h1>
           <p>
               只需点击下鼠标，你就可以自定义这款主题！
           </p>
       </div>
       <div class="frig-opt-item frig-opt-item-1">
           <form class="frig-opt-changeColor" action="">
               <table class="form-table">

                   <tbody>

       <tr>
           <th scope="row">是否显示侧栏</th>
           <td> <fieldset><legend class="screen-reader-text"><span>成员资格</span></legend><label for="users_can_register">
                       <input name="users_can_register" id="users_can_register" value="1" type="checkbox">
                       显示侧栏</label>
               </fieldset></td>
       </tr>

       <tr>
           <th scope="row"><label for="firg-opt-theme-color">主题颜色</label></th>
           <td>
               <select name="firg-opt-theme-color" id="firg-opt-theme-color">
                   <option selected="selected" value="blue">天空蓝</option>
                   <option value="green">原谅色</option>
                   <option value="pigi">佩奇粉</option>
                   <option value="gray">科技灰</option>
           </td>
       </tr>


       <tr>
           <th scope="row">页面布局</th>
           <td>
               <fieldset><legend class="screen-reader-text"><span>布局</span></legend>
                   <label><input name="date_format" value="普通" checked="checked" type="radio"> <span class="date-time-text format-i18n">普通</span></label><br>
                   <label><input name="date_format" value="瀑布流" type="radio"> <span class="date-time-text format-i18n">瀑布流</span></label><br>
                   </p>	</fieldset>
           </td>
       </tr>

       <tr>
           <th scope="row">ICP备案号</th><td><input name="zh_cn_l10n_icp_num" id="zh_cn_l10n_icp_num" value="粤ICP备16034821号" class="regluar-text ltr" type="text"><p class="description">仅对WordPress自带主题有效。</p></td></tr></tbody></table>
               <input type="hidden" name="update_themeoptions" value="true" />
               <p><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
           </form>
       </div>
   </div>
<?php } ?>

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
    add_theme_page( '主题设置', '主题设置', 'administrator', 'firgatebird_slug','display_function');
}
?>

<?php function display_function() {?>
    <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="formOnSubmit()" action="options.php" class="validate">
        <div class="widget-content" style="margin-top:50px;">
            <h1>主题设置</h1>
            <div style="display: block; height: 26px;">
                <ul class="subsubsub">
                    <li class="all"><a href="javascript: void(0);" id="tab_0" onclick="showTab(this)" data-index="0" data-name="base_option" class="current">基本设置</a> |</li>
                    <li class="all"><a href="javascript: void(0);" id="tab_1" onclick="showTab(this)" data-index="1" data-name="high_level_option">高级设置</a> |</li>
                    <li class="all"><a href="javascript: void(0);" id="tab_2" onclick="showTab(this)" data-index="2" data-name="board_option">看板</a></li>
                </ul>
            </div>

            <div class="tabs_body card" data-index="0" style="max-width: 100%;">
                <?php require_once( 'model/base_option.php' );?>
            </div>
            <div class="tabs_body card" data-index="1" style="display: none;max-width: 100%;">
                <?php require_once( 'model/high_level_option.php' );?>
            </div>
            <div class="tabs_body card" data-index="1" style="display: none;max-width: 100%;">
                <?php require_once( 'model/board_option.php' );?>
            </div>

            <input type="hidden" name="action" value="update" />
            <input
                id="page_options"
                type="hidden"
                name="page_options"
                value=""
            />
            <p class="submit">
                <button class="button button-primary" id="firgatebird_submit" type="submit" name="option_save" >保存设置</button>
                <span id="firgatebird_message" style="display: none;">保存成功</span>
            </p>
        </div>
        <?php wp_nonce_field('update-options'); ?>
    </form>
    <style>
        .validate {
            max-width: 800px;
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
        let currentTab = 'base_option';
        function showTab(e) {
            document.getElementById('tab_0').classList = '';
            document.getElementById('tab_1').classList = '';
            document.getElementById('tab_2').classList = '';
            e.classList = 'current';
            const index = Number(e.dataset.index);
            const $tabs = document.getElementsByClassName('tabs_body');
            currentTab = e.dataset.name;
            document.getElementById('firgatebird_message').style.display = 'none';
            for(let i = 0; i< $tabs.length; i++) {
                if(index === i) {
                    $tabs[i].style.display = 'block';
                } else {
                    $tabs[i].style.display = 'none';
                }
            }
        }
        function formOnSubmit(){
            const $pageOptions = document.getElementById('page_options');
            const params = {
                base_option: ['firgatebird_color', 'firgatebird_font_color','firgatebird_logo_img', 'firgatebird_menu_type','firgatebird_bg_img','firgatebird_bg_attachment', 'firgatebird_bg_repeat', 'firgatebird_bg_size'],
                high_level_option: ['firgatebird_stats_code', 'firgatebird_home_keyword','firgatebird_custom_head', 'firgatebird_custom_code'],
                board_option: ['firgatebird_live2d', 'firgatebird_live2d_message'],
            };
            $pageOptions.value = params[currentTab].join(',');
            document.getElementById('firgatebird_message').style.display = 'none';
            document.getElementById('firgatebird_submit').innerText = '正在保存...';
            document.getElementById('firgatebird_submit').disabled = true;
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    document.getElementById('firgatebird_message').style.display = 'inline-block';
                    // window.location.reload();
                } else {
                    window.alert('保存失败');
                }
                document.getElementById('firgatebird_submit').disabled = false;
                document.getElementById('firgatebird_submit').innerText = '保存设置';
            };
        }
    </script>
<?php }?>

<?php add_action('admin_menu', 'firgatebird_option_function');?>

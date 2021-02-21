<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/8
 * Time: 15:45
 */
function firgatebird_light_word_function(){
    //page_titile-title标签的内容
    //menu_title-显示在后台左边菜单的标题
    //capability-访问这个页面需要的权限
    //menu_slug-别名，需要独一无二哦
    //function-执行的函数
    $user = wp_get_current_user();
    $allowed_roles = array( 'administrator' );
    if ( array_intersect( $allowed_roles, $user->roles ) ) {
        date_default_timezone_set('PRC');
        global $table_prefix;
        $table = $table_prefix . 'firgatebird_light_word';
        if(!empty($_GET['init_data']) && $_GET['init_data'] === 'true') {
            create_table($table);
            die();
        }
        if(!empty($_GET['add']) && $_GET['add'] === 'true') {
            add_item($table);
            die();
        }
        if(!empty($_GET['delete']) && $_GET['delete'] === 'true') {
            if(!empty($_POST['id'])) {
                delete_item($table, $_POST['id']);
            }
            die();
        }
        if(!empty($_GET['update']) && $_GET['update'] === 'true') {
            if(!empty($_POST['id'])) {
                update_item($table, $_POST['id']);
            }
            die();
        }
        if(!empty($_GET['clear']) && $_GET['clear'] === 'true') {
            if($_POST['clear'] == "clear-all-data") {
                clear_item($table);
            }
            die();
        }
    } else {
        die();
    }
    if(get_option('firgatebird_light_word') == 1) {
        add_submenu_page( 'edit.php', '轻言', '轻言', 'administrator', 'firgatebird_light_word','firgatebird_light_word_display');
    }
}
?>
<?php
    function create_table($table) {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS `'. $table .'` (
			`id` int(11) NOT NULL auto_increment,
			`content` text,
            `uid` int(11) unsigned default 0,
            `status` int(1) unsigned default 0,
            `show` int(1) unsigned default 1,
            `create_time` datetime default NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        $wpdb->query(
            $wpdb->prepare($sql)
        );
    }
    function add_item($table) {
        global $wpdb;
        $wpdb->insert(
            $table . '',
            array(
                'content' => htmlspecialchars(stripslashes($_POST['content'])),
                'status' => $_POST['status'],
                'show' => $_POST['show'],
                'uid' => get_current_user_id(),
                'create_time' => date("Y-m-d H:i:s"),
            ),
            array(
                '%s',
                '%d',
                '%d',
                '%s',
            )
        );
    }
    function delete_item($table, $id) {
        global $wpdb;
        $wpdb->delete( $table.'', array( 'id' => $id ) );
    }
    function clear_item($table) {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare( "DROP TABLE " . $table)
        );
    }
    function update_item($table, $id) {
        global $wpdb;
        $wpdb->update(
            $table . '',
            array(
                'content' => htmlspecialchars(stripslashes($_POST['content'])),
                'status' => $_POST['status'],
                'show' => $_POST['show'],
            ),
            array( 'id' => $id ),
            array(
                '%s',
                '%d',
                '%d',
            )
        );
    }
?>
<?php function firgatebird_light_word_display() {?>
    <div class="wrap">
        <h1 class="wp-heading-inline">轻言</h1>
        <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
        <?php
        global $wpdb;
        global $table_prefix;
        $table = $table_prefix . 'firgatebird_light_word';
        // $wpdb->show_errors();
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}");
        $current_page = !empty($_GET['current_page']) ? $_GET['current_page'] : 1;
        $page_size = !empty($_GET['page_size']) ? $_GET['page_size'] : 10;
        $total_page = ceil($count / $page_size);
        if($count === NULL) {
        ?>
            <div style="margin-top: 20px;">
                <p>这是一个类似微博的小工具，可以在主题自带的小工具里显示简短的信息，支持HTML代码</p>
                <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="initData()" action="edit.php?page=firgatebird_light_word&init_data=true" class="validate">
                    <div style="border: 2px dashed #b4b9be;margin-bottom: 20px;padding: 16px;">
                        <p><strong>此功能尚未启用，继续操作前请先 <span style="color: red;">备份数据库</span>。</strong></p>
                        <button id="start-install-btn" type="submit" class="button button-primary">开启轻言</button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="tablenav top">
                <form method="post" name="firgatebird_form_add_item" id="firgatebird_form_add_item" target="rfFrame" onsubmit="addItem()" action="edit.php?page=firgatebird_light_word&add=true" class="validate">
                    <div class="alignleft actions">
                        <input name="content" type="text" style="width: 300px;" placeholder="正文" value="">
                    </div>
                    <div class="alignleft actions">
                        <select name="status">
                            <option value="0" selected>无状态</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="alignleft actions">
                        <select name="show">
                            <option value="1" selected>显示</option>
                            <option value="0">隐藏</option>
                        </select>
                    </div>
                    <div class="alignleft actions">
                        <button type="submit" class="button button-primary">添加</button>
                    </div>
                </form>
                <div class="alignright actions">
                    <form method="post" target="rfFrame" onsubmit="submitClearAll()" action="edit.php?page=firgatebird_light_word&clear=true" class="validate hidden">
                        <input name="clear" type="text" value="clear-all-data">
                        <button type="submit" id="firgatebird_form_clear_btn" class="button button-link" style="display: none;">清空数据</button>
                    </form>
                    <button type="button" onclick="clearAllData()" class="button button-link">清空数据</button>
                </div>
            </div>
            <table class="wp-list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <th class="manage-column column-title column-primary" width="80">ID</th>
                        <th class="manage-column column-title column-primary">正文</th>
                        <th class="manage-column column-title column-primary" width="160">发布人</th>
                        <th class="manage-column column-title column-primary" width="160">状态</th>
                        <th class="manage-column column-title column-primary" width="160">显示</th>
                        <th class="" width="160" align="center">创建时间</th>
                        <th class="" width="100" align="center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $start = ($current_page - 1) * $page_size;
                        $list = $wpdb->get_results( "
                          SELECT *
                          FROM {$table}
                          ORDER BY id DESC
                          LIMIT {$start}, {$page_size}
                        ", ARRAY_A);

                    ?>
                    <?php if(count($list) == 0) {?>
                        <tr>
                            <td></td>
                            <td style="text-align: center;">准备工作已经完成，现在试着添加一条内容吧。也可以去站点页面的轻言小工具处新增/删除内容</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                    <?php foreach ($list as $item) { ?>
                        <tr>
                            <td>
                                <?php echo $item['id']?>
                                <input type="text" style="display: none;" value="<?php echo $item['id']?>">
                            </td>
                            <td id="td_content_edit_<?php echo $item['id']?>" class="td_edit_false">
                                <span><?php echo htmlspecialchars_decode($item['content'])?></span>
                                <input id="edit_content_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['content']?>">
                            </td>
                            <td>
                                <?php
                                    $user = get_user_by('id', $item['uid']);
                                    echo $user->display_name;
                                ?>
                            </td>
                            <td id="td_status_edit_<?php echo $item['id']?>" class="td_edit_false">
                                <span><?php echo $item['status']?></span>
                                <select id="edit_status_<?php echo $item['id']?>" name="status" style="width: 100%;">
                                    <option value="0" <?php echo $item['show'] == 0 ? 'selected' : ''?>>无状态</option>
                                    <option value="1" <?php echo $item['status'] == 1 ? 'selected' : ''?>>1</option>
                                    <option value="2" <?php echo $item['status'] == 1 ? 'selected' : ''?>>2</option>
                                    <option value="3" <?php echo $item['status'] == 1 ? 'selected' : ''?>>3</option>
                                </select>
                            </td>
                            <td id="td_show_edit_<?php echo $item['id']?>" class="td_edit_false">
                                <span><?php echo $item['show'] == 1 ? '显示' : '隐藏'?></span>
                                <select id="edit_show_<?php echo $item['id']?>" name="show" style="width: 100%;">
                                    <option value="1" <?php echo $item['show'] == 1 ? 'selected' : ''?>>显示</option>
                                    <option value="0" <?php echo $item['show'] == 0 ? 'selected' : ''?>>隐藏</option>
                                </select>
                            </td>
                            <td>
                                <?php echo $item['create_time']?>
                            </td>
                            <td>
                                <form style="display: none;" method="post" id="firgatebird_form_update_item_<?php echo $item['id']?>" name="firgatebird_form_update_item_<?php echo $item['id']?>" target="rfFrame" onsubmit="updateItem()" action="edit.php?page=firgatebird_light_word&update=true" class="validate">
                                    <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                    <input id="update_content_<?php echo $item['id']?>" name="content" style="display: none;" type="text" value="<?php echo htmlspecialchars($item['content']) ?>">
                                    <input id="update_show_<?php echo $item['id']?>" name="show" style="display: none;" type="text" value="<?php echo $item['show']?>">
                                    <input id="update_status_<?php echo $item['id']?>" name="status" style="display: none;" type="text" value="<?php echo $item['status']?>">
                                    <button type="submit" id="firgatebird_form_update_item_btn_<?php echo $item['id']?>" style="display: none;">保存</button>
                                </form>
                                <a href="javascript:void(0);" style="display: none;" id="save_<?php echo $item['id']?>" onclick="submitUpdate(<?php echo $item['id']?>)">保存</a>
                                <a href="javascript:void(0);" id="update_<?php echo $item['id']?>" onclick="toggleEdit(<?php echo $item['id']?>, true)">修改</a>
                                <a href="javascript:void(0);" style="display: none;" id="cancel_<?php echo $item['id']?>" onclick="toggleEdit(<?php echo $item['id']?>, false)">取消</a>

                                <form style="display: none;" method="post" id="firgatebird_form_delete_item" name="firgatebird_form_delete_item" target="rfFrame" onsubmit="deleteItem()" action="edit.php?page=firgatebird_light_word&delete=true" class="validate">
                                    <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                    <button type="submit" id="firgatebird_form_delete_item_btn_<?php echo $item['id']?>" style="display: none;">删除</button>
                                </form>
                                <a id="delete_<?php echo $item['id']?>" href="javascript:void(0);" onclick="submitDelete(<?php echo $item['id']?>)">删除</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--分页-->
            <div class="tablenav bottom">
                <div class="tablenav-pages">
                    <span class="displaying-num">
                        <?php echo $count;?>个项目
                    </span>
                    <?php if($current_page > 1) {?>
                        <a class="pagination-links" href="edit.php?page=firgatebird_light_word&current_page=1">
                            <span class="tablenav-pages-navspan button" aria-hidden="true">«</span>
                        </a>
                        <a class="tablenav-pages-navspan button" aria-hidden="true" href="edit.php?page=firgatebird_light_word&current_page=<?php echo $current_page-1; ?>">‹</a>
                    <?php } else { ?>
                        <span class="pagination-links"><span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
                        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
                    <?php } ?>
                    <span class="screen-reader-text">当前页</span>
                    <span id="table-paging" class="paging-input">
                        <span class="tablenav-paging-text">
                            第<?php echo $current_page; ?>页，共
                            <span class="total-pages"><?php echo $total_page;?></span>页
                        </span>
                    </span>
                    <?php if($current_page < $total_page) {?>
                        <a class="next-page button" href="edit.php?page=firgatebird_light_word&current_page=<?php echo $current_page+1; ?>">
                            <span class="screen-reader-text">下一页</span>
                            <span aria-hidden="true">›</span>
                        </a>
                        <a class="tablenav-pages-navspan button disabled" aria-hidden="true" href="edit.php?page=firgatebird_light_word&current_page=<?php echo $total_page; ?>">
                            »
                        </a>
                    <?php } else { ?>
                        <a class="next-page button disabled" href="javascript:void(0);">
                            <span class="screen-reader-text">下一页</span>
                            <span aria-hidden="true">›</span>
                        </a>
                        <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <script>
        function initData() {
            document.getElementById('start-install-btn').innerHTML = '正在初始化...';
            document.getElementById('start-install-btn').disabled = true;
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    window.alert('数据初始化成功');
                    window.location.reload();
                } else {
                    window.alert('数据初始化失败');
                }
            };
        }
        function addItem() {
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    window.location.reload();
                } else {
                    window.alert('添加失败');
                }
            };
        }

        function toggleEdit(id, action) {
            const classList = action === true ? 'td_edit_true' : 'td_edit_false';
            document.getElementById('td_content_edit_' + id).classList = classList;
            document.getElementById('td_status_edit_' + id).classList = classList;
            document.getElementById('td_show_edit_' + id).classList = classList;

            document.getElementById('save_' + id).style.display = action === true ? 'inline-block' : 'none';
            document.getElementById('cancel_' + id).style.display = action === true ? 'inline-block' : 'none';
            document.getElementById('update_' + id).style.display = action === true ? 'none' : 'inline-block';
            document.getElementById('delete_' + id).style.display = action === true ? 'none' : 'inline-block';
        }

        function submitUpdate(id) {
            document.getElementById('update_content_' + id).value = document.getElementById('edit_content_' + id).value;
            document.getElementById('update_show_' + id).value = document.getElementById('edit_show_' + id).value;
            document.getElementById('update_status_' + id).value = document.getElementById('edit_status_' + id).value;
            document.getElementById('firgatebird_form_update_item_btn_' + id).click();
        }
        function updateItem() {
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    window.location.reload();
                } else {
                    window.alert('修改失败');
                }
            };
        }

        function clearAllData() {
            const  r = confirm("将会删除所有轻言内容？此操作不可恢复");
            if (r == true){
                document.getElementById('firgatebird_form_clear_btn').click();
            }
        }
        function submitClearAll() {
            document.getElementById('rfFrame').onload = function(res){
                if(res.returnValue) {
                    window.location.reload();
                } else {
                    window.alert('清空失败');
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
    </script>
    <style>
        .td_edit_false span {
            display: block;
        }
        .td_edit_false input, .td_edit_false select {
            display: none!important;
        }

        .td_edit_true span {
            display: none;
        }
        .td_edit_true input, .td_edit_false select {
            display: block;
        }
    </style>
<?php }?>
<?php add_action('admin_menu', 'firgatebird_light_word_function');?>

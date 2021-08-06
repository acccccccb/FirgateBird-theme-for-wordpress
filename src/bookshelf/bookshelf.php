<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/8
 * Time: 15:45
 */
function firgatebird_bookshelf_function(){
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
        $firgatebird_bookshelf_table = $table_prefix . 'firgatebird_bookshelf';
        if(!empty($_GET['init_data']) && $_GET['init_data'] === 'true' && $_GET['page'] === 'firgatebird_bookshelf') {
            firgatebird_bookshelf_create_table($firgatebird_bookshelf_table);
            die();
        }
        if(!empty($_GET['add']) && $_GET['add'] === 'true' && $_GET['page'] === 'firgatebird_bookshelf') {
            firgatebird_bookshelf_add_item($firgatebird_bookshelf_table);
            die();
        }
        if(!empty($_GET['add']) && $_GET['add'] === 'json' && $_GET['page'] === 'firgatebird_bookshelf') {
            firgatebird_bookshelf_add_item_json($firgatebird_bookshelf_table);
            die();
        }
        if(!empty($_GET['delete']) && $_GET['delete'] === 'true' && $_GET['page'] === 'firgatebird_bookshelf') {
            if(!empty($_POST['id'])) {
                firgatebird_bookshelf_delete_item($firgatebird_bookshelf_table, $_POST['id']);
            }
            die();
        }
        if(!empty($_GET['update']) && $_GET['update'] === 'true' && $_GET['page'] === 'firgatebird_bookshelf') {
            if(!empty($_POST['id'])) {
                firgatebird_bookshelf_update_item($firgatebird_bookshelf_table, $_POST['id']);
            }
            die();
        }
        if(!empty($_GET['clear']) && $_GET['clear'] === 'true' && $_GET['page'] === 'firgatebird_bookshelf') {
            if($_POST['clear'] == "clear-all-data") {
                firgatebird_bookshelf_clear_item($firgatebird_bookshelf_table);
            }
            die();
        }
    } else {
        die();
    }
    add_submenu_page( 'edit.php', '书架', '书架', 'administrator', 'firgatebird_bookshelf','firgatebird_bookshelf_display');
}
?>
<?php
    function firgatebird_bookshelf_create_table($firgatebird_bookshelf_table) {
        global $wpdb;
        $sql = 'CREATE TABLE IF NOT EXISTS `'. $firgatebird_bookshelf_table .'` (
			`id` int(11) NOT NULL auto_increment,
			`name` varchar(256),
			`thumb` varchar(256),
			`link` varchar(256),
			`description` varchar(256),
			`comment` varchar(256),
			`add_time` datetime default NULL,
			`score` int(1) unsigned default 0,
			`type` int(1) unsigned default 0,
            `uid` int(11) unsigned default 0,
            `show` int(1) unsigned default 1,
            `create_time` datetime default NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        $wpdb->query(
            $wpdb->prepare($sql)
        );
    }
    function firgatebird_bookshelf_add_item($firgatebird_bookshelf_table) {
        global $wpdb;
        $wpdb->insert(
            $firgatebird_bookshelf_table . '',
            array(
                'name' => htmlspecialchars(stripslashes($_POST['name'])),
                'thumb' => $_POST['thumb'],
                'link' => $_POST['link'],
                'description' => $_POST['description'],
                'comment' => $_POST['comment'],
                'add_time' => $_POST['add_time'],
                'score' => $_POST['score'],
                'type' => $_POST['type'],
                'show' => $_POST['show'],
                'uid' => get_current_user_id(),
                'create_time' => date("Y-m-d H:i:s"),
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%s',
            )
        );
    }
    function firgatebird_bookshelf_add_item_json($firgatebird_bookshelf_table) {
        $json_str = $_POST['json'];
        $list = json_decode(stripslashes($json_str), true);
        global $wpdb;
        foreach( $list as $item ) {
            $wpdb->insert(
                $firgatebird_bookshelf_table . '',
                array(
                    'name' => htmlspecialchars(stripslashes($item['name'])),
                    'thumb' => $item['thumb'],
                    'link' => $item['link'],
                    'description' => $item['description'],
                    'comment' => $item['comment'],
                    'add_time' => $item['add_time'],
                    'score' => $item['score'],
                    'type' => $item['type'],
                    'show' => $item['show'],
                    'uid' => get_current_user_id(),
                    'create_time' => date("Y-m-d H:i:s"),
                ),
                array(
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%d',
                    '%d',
                    '%d',
                    '%s',
                )
            );
        }
    }
    function firgatebird_bookshelf_delete_item($firgatebird_bookshelf_table, $id) {
        global $wpdb;
        $wpdb->delete( $firgatebird_bookshelf_table.'', array( 'id' => $id ) );
    }
    function firgatebird_bookshelf_clear_item($firgatebird_bookshelf_table) {
        global $wpdb;
        $wpdb->query(
            $wpdb->prepare( "DROP TABLE " . $firgatebird_bookshelf_table)
        );
    }
    function firgatebird_bookshelf_update_item($firgatebird_bookshelf_table, $id) {
        global $wpdb;
        $wpdb->update(
            $firgatebird_bookshelf_table . '',
            array(
                'name' => htmlspecialchars(stripslashes($_POST['name'])),
                'thumb' => $_POST['thumb'],
                'link' => $_POST['link'],
                'description' => $_POST['description'],
                'comment' => $_POST['comment'],
                'add_time' => $_POST['add_time'],
                'score' => $_POST['score'],
                'type' => $_POST['type'],
                'show' => $_POST['show'],
                'uid' => get_current_user_id(),
            ),
            array( 'id' => $id ),
            array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d'
            )
        );
    }
?>
<?php function firgatebird_bookshelf_display() {?>
    <div class="wrap">
        <h1 class="wp-heading-inline">书架</h1>
        <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
        <?php
        global $wpdb;
        global $table_prefix;
        $firgatebird_bookshelf_table = $table_prefix . 'firgatebird_bookshelf';
        $wpdb->hide_errors();
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$firgatebird_bookshelf_table}");
        $current_page = !empty($_GET['current_page']) ? $_GET['current_page'] : 1;
        $page_size = !empty($_GET['page_size']) ? $_GET['page_size'] : 10;
        $total_page = ceil($count / $page_size);
        if($count === NULL) {
        ?>
            <div style="margin-top: 20px;">
                <p>这是书架</p>
                <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="firgatebird_bookshelf_init_data()" action="edit.php?page=firgatebird_bookshelf&init_data=true" class="validate">
                    <div style="border: 2px dashed #b4b9be;margin-bottom: 20px;padding: 16px;">
                        <p><strong>此功能尚未启用，继续操作前请先 <span style="color: red;">备份数据库</span>。</strong></p>
                        <button id="start-install-btn" type="submit" class="button button-primary">开启</button>
                    </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="tablenav top">
                <div class="alignright actions">
                    <form method="post" target="rfFrame" onsubmit="submitClearAll()" action="edit.php?page=firgatebird_bookshelf&clear=true" class="validate hidden">
                        <input name="clear" type="text" value="clear-all-data">
                        <button type="submit" id="firgatebird_form_clear_btn" class="button button-link" style="display: none;">清空数据</button>
                    </form>
                    <button type="button" onclick="clearAllData()" class="button button-link">清空数据</button>
                </div>
            </div>
            <div style="width: 100%;height: 600px;overflow: scroll;">
                <table class="wp-list-table widefat fixed striped table-view-list posts">
                    <thead>
                        <tr>
                            <th class="manage-column column-title column-primary" width="50">ID</th>
                            <th class="manage-column column-title column-primary" width="50">缩略图</th>
                            <th class="manage-column column-title column-primary" width="100">名称</th>
                            <th class="manage-column column-title column-primary" width="50">链接</th>
                            <th class="manage-column column-title column-primary" width="100">描述</th>
                            <th class="manage-column column-title column-primary" width="160">评价</th>
                            <th class="manage-column column-title column-primary" width="50">评分</th>
                            <th class="manage-column column-title column-primary" width="50">类型</th>
                            <th class="" width="80" align="center">加入时间</th>
                            <th class="" width="40" align="center">显示</th>
                            <th class="" width="60" align="center">创建人</th>
                            <th class="" width="120" align="center">创建时间</th>
                            <th class="" width="100" align="center">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $start = ($current_page - 1) * $page_size;
                            $keyword = $_GET['keyword'];
                            if(empty($keyword)) {
                                $list = $wpdb->get_results( "
                                  SELECT *
                                  FROM {$firgatebird_bookshelf_table}
                                  ORDER BY id DESC
                                  LIMIT {$start}, {$page_size}
                                ", ARRAY_A);
                            } else {
                                $list = $wpdb->get_results( "
                                  SELECT *
                                  FROM {$firgatebird_bookshelf_table}
                                  WHERE `name` LIKE '{$keyword}'
                                  ORDER BY id DESC
                                  LIMIT {$start}, {$page_size}
                                ", ARRAY_A);
                            }
                        ?>
                        <?php if(count($list) == 0) {?>
                            <tr>
                                <td></td>
                                <td style="text-align: center;">准备工作已经完成，现在试着添加一条内容吧。也可以去站点页面的小工具处新增/删除内容</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                                <td id="td_thumb_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span>
                                        <img src="<?php echo esc_html($item['thumb'])?>" height="50">
                                    </span>
                                    <input id="edit_thumb_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['thumb']?>">
                                </td>
                                <td id="td_name_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span>
                                        <a target="_blank" href="<?php echo esc_html($item['link']) ?>" title="<?php echo esc_html($item['name'])?>"><?php echo esc_html($item['name'])?></a>
                                    </span>
                                    <input id="edit_name_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['name']?>">
                                </td>
                                <td id="td_link_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span>
                                        <a target="_blank" href="<?php echo esc_html($item['link'])?>" title="<?php echo esc_html($item['name'])?>">Link</a>
                                    </span>
                                    <input id="edit_link_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['link']?>">
                                </td>
                                <td id="td_description_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span><?php echo esc_html($item['description'])?></span>
                                    <input id="edit_description_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['description']?>">
                                </td>
                                <td id="td_comment_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span><?php echo esc_html($item['comment'])?></span>
                                    <input id="edit_comment_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['comment']?>">
                                </td>
                                <td id="td_score_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span><?php echo esc_html($item['score'])?></span>
                                    <input id="edit_score_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['score']?>">
                                </td>
                                <td id="td_type_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span>
                                        <?php if($item['type'] == 1) { echo '书籍'; }?>
                                        <?php if($item['type'] == 2) { echo '电影'; }?>
                                        <?php if($item['type'] == 0) { echo '未分类'; }?>
                                    </span>
                                    <select id="edit_type_<?php echo $item['id']?>" name="type" style="width: 100%;">
                                        <option value="1" <?php echo $item['type'] == 1 ? 'selected' : ''?>>书籍</option>
                                        <option value="2" <?php echo $item['type'] == 2 ? 'selected' : ''?>>电影</option>
                                    </select>
                                </td>
                                <td id="td_add_time_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span><?php echo date('Y-m-d',strtotime($item['add_time']));?></span>
                                    <input id="edit_add_time_<?php echo $item['id']?>" type="text" style="width: 100%;" value="<?php echo $item['add_time']?>">
                                </td>
                                <td id="td_show_edit_<?php echo $item['id']?>" class="td_edit_false">
                                    <span><?php echo $item['show'] == 1 ? '显示' : '隐藏'?></span>
                                    <select id="edit_show_<?php echo $item['id']?>" name="show" style="width: 100%;">
                                        <option value="1" <?php echo $item['show'] == 1 ? 'selected' : ''?>>显示</option>
                                        <option value="0" <?php echo $item['show'] == 0 ? 'selected' : ''?>>隐藏</option>
                                    </select>
                                </td>
                                <td>
                                    <?php
                                    $user = get_user_by('id', $item['uid']);
                                    echo $user->display_name;
                                    ?>
                                </td>
                                <td>
                                    <?php echo $item['create_time']?>
                                </td>
                                <td>
                                    <form style="display: none;" method="post" id="firgatebird_form_firgatebird_bookshelf_update_item_<?php echo $item['id']?>" name="firgatebird_form_firgatebird_bookshelf_update_item_<?php echo $item['id']?>" target="rfFrame" onsubmit="updateItem()" action="edit.php?page=firgatebird_bookshelf&update=true" class="validate">
                                        <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                        <input id="update_name_<?php echo $item['id']?>" name="name" style="display: none;" type="text" value="<?php echo $item['name']?>">
                                        <input id="update_thumb_<?php echo $item['id']?>" name="thumb" style="display: none;" type="text" value="<?php echo $item['thumb']?>">
                                        <input id="update_link_<?php echo $item['id']?>" name="link" style="display: none;" type="text" value="<?php echo $item['link']?>">
                                        <input id="update_description_<?php echo $item['id']?>" name="description" style="display: none;" type="text" value="<?php echo $item['description']?>">
                                        <input id="update_comment_<?php echo $item['id']?>" name="comment" style="display: none;" type="text" value="<?php echo $item['comment']?>">
                                        <input id="update_score_<?php echo $item['id']?>" name="score" style="display: none;" type="text" value="<?php echo $item['score']?>">
                                        <input id="update_add_time_<?php echo $item['id']?>" name="add_time" style="display: none;" type="text" value="<?php echo $item['add_time']?>">
                                        <input id="update_type_<?php echo $item['id']?>" name="type" style="display: none;" type="text" value="<?php echo $item['type']?>">


                                        <input id="update_show_<?php echo $item['id']?>" name="show" style="display: none;" type="text" value="<?php echo $item['show']?>">
                                        <input id="update_status_<?php echo $item['id']?>" name="status" style="display: none;" type="text" value="<?php echo $item['status']?>">
                                        <button type="submit" id="firgatebird_form_bookshelf_update_item_btn_<?php echo $item['id']?>" style="display: none;">保存</button>
                                    </form>
                                    <a href="javascript:void(0);" style="display: none;" id="save_<?php echo $item['id']?>" onclick="submitUpdate(<?php echo $item['id']?>)">保存</a>
                                    <a href="javascript:void(0);" id="update_<?php echo $item['id']?>" onclick="toggleEdit(<?php echo $item['id']?>, true)">修改</a>
                                    <a href="javascript:void(0);" style="display: none;" id="cancel_<?php echo $item['id']?>" onclick="toggleEdit(<?php echo $item['id']?>, false)">取消</a>

                                    <form style="display: none;" method="post" id="firgatebird_form_firgatebird_bookshelf_delete_item_<?php echo $item['id']?>" name="firgatebird_form_firgatebird_bookshelf_delete_item" target="rfFrame" onsubmit="deleteItem()" action="edit.php?page=firgatebird_bookshelf&delete=true" class="validate">
                                        <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                        <button type="submit" id="firgatebird_form_firgatebird_bookshelf_delete_item_btn_<?php echo $item['id']?>" style="display: none;">删除</button>
                                    </form>
                                    <a id="delete_<?php echo $item['id']?>" href="javascript:void(0);" onclick="submitDelete(<?php echo $item['id']?>)">删除</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!--分页-->
            <div class="tablenav bottom">
                <div class="tablenav-pages">
                    <span class="displaying-num">
                        <?php echo $count;?>个项目
                    </span>
                    <?php if($current_page > 1) {?>
                        <a class="pagination-links" href="edit.php?page=firgatebird_bookshelf&current_page=1">
                            <span class="tablenav-pages-navspan button" aria-hidden="true">«</span>
                        </a>
                        <a class="tablenav-pages-navspan button" aria-hidden="true" href="edit.php?page=firgatebird_bookshelf&current_page=<?php echo $current_page-1; ?>">‹</a>
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
                        <a class="next-page button" href="edit.php?page=firgatebird_bookshelf&current_page=<?php echo $current_page+1; ?>">
                            <span class="screen-reader-text">下一页</span>
                            <span aria-hidden="true">›</span>
                        </a>
                        <a class="tablenav-pages-navspan button disabled" aria-hidden="true" href="edit.php?page=firgatebird_bookshelf&current_page=<?php echo $total_page; ?>">
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
        <form method="post" autocomplete="off" name="firgatebird_form_firgatebird_bookshelf_add_item" id="firgatebird_form_firgatebird_bookshelf_add_item" target="rfFrame" onsubmit="addItem()" action="edit.php?page=firgatebird_bookshelf&add=true" class="validate">
            <div class="actions">
                <input name="name" type="text" style="width: 300px;" placeholder="名称" value="">
            </div>
            <div class="actions">
                <input name="thumb" type="text" style="width: 300px;" placeholder="缩略图" value="">
            </div>
            <div class="actions">
                <input name="link" type="text" style="width: 300px;" placeholder="超链接" value="">
            </div>
            <div class="actions">
                <input name="description" type="text" style="width: 300px;" placeholder="描述" value="">
            </div>
            <div class="actions">
                <input name="comment" type="text" style="width: 300px;" placeholder="评价" value="">
            </div>
            <div class="actions">
                <input name="score" type="text" style="width: 300px;" placeholder="评分" value="">
            </div>
            <div class="actions">
                <select name="type">
                    <option value="1" selected>书籍</option>
                    <option value="2">电影</option>
                </select>
            </div>
            <div class="actions">
                <input name="add_time" type="text" style="width: 300px;" placeholder="加入时间" value="">
            </div>
            <div class="actions">
                <select name="show">
                    <option value="1" selected>显示</option>
                    <option value="0">隐藏</option>
                </select>
            </div>
            <div class="actions">
                <button type="submit" class="button button-primary">添加</button>
            </div>
        </form>

        <div class="margin-top: 20px;">
            <form method="post" autocomplete="off" name="firgatebird_form_firgatebird_bookshelf_add_item" id="firgatebird_form_firgatebird_bookshelf_add_item_json" target="rfFrame" onsubmit="addItem()" action="edit.php?page=firgatebird_bookshelf&add=json" class="validate">
                <div class="actions">
                    <textarea style="width: 100%;" rows="20" name="json"></textarea>
                </div>
                <div class="actions">
                    <button type="submit" class="button button-primary">添加JSON</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function firgatebird_bookshelf_init_data() {
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
            document.getElementById('td_thumb_edit_' + id).classList = classList;
            document.getElementById('td_name_edit_' + id).classList = classList;
            document.getElementById('td_link_edit_' + id).classList = classList;
            document.getElementById('td_description_edit_' + id).classList = classList;
            document.getElementById('td_comment_edit_' + id).classList = classList;
            document.getElementById('td_score_edit_' + id).classList = classList;
            document.getElementById('td_type_edit_' + id).classList = classList;
            document.getElementById('td_add_time_edit_' + id).classList = classList;
            document.getElementById('td_show_edit_' + id).classList = classList;

            document.getElementById('save_' + id).style.display = action === true ? 'inline-block' : 'none';
            document.getElementById('cancel_' + id).style.display = action === true ? 'inline-block' : 'none';
            document.getElementById('update_' + id).style.display = action === true ? 'none' : 'inline-block';
            document.getElementById('delete_' + id).style.display = action === true ? 'none' : 'inline-block';
        }

        function submitUpdate(id) {
            console.log('保存');
            document.getElementById('update_name_' + id).value = document.getElementById('edit_name_' + id).value;
            document.getElementById('update_thumb_' + id).value = document.getElementById('edit_thumb_' + id).value;
            document.getElementById('update_link_' + id).value = document.getElementById('edit_link_' + id).value;
            document.getElementById('update_description_' + id).value = document.getElementById('edit_description_' + id).value;
            document.getElementById('update_comment_' + id).value = document.getElementById('edit_comment_' + id).value;
            document.getElementById('update_score_' + id).value = document.getElementById('edit_score_' + id).value;
            document.getElementById('update_add_time_' + id).value = document.getElementById('edit_add_time_' + id).value;
            document.getElementById('update_type_' + id).value = document.getElementById('edit_type_' + id).value;

            document.getElementById('update_show_' + id).value = document.getElementById('edit_show_' + id).value;
            document.getElementById('firgatebird_form_bookshelf_update_item_btn_' + id).click();
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
            const  r = confirm("将会删除所有内容？此操作不可恢复");
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
                document.getElementById('firgatebird_form_firgatebird_bookshelf_delete_item_btn_' + id).click();
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
<?php add_action('admin_menu', 'firgatebird_bookshelf_function');?>

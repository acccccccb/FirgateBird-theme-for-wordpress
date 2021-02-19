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
    $init_data = $_GET['init_data'];
    global $table_prefix;
    $table = $table_prefix . 'firgatebird_light_word';
    if($init_data === 'true') {
        create_table($table);
        die();
    }
    if($_GET['add'] === 'true') {
        add_item($table);
        die();
    }
    if($_GET['delete'] === 'true') {
        if(!empty($_POST['id'])) {
            delete_item($table, $_POST['id']);
        }
        die();
    }
    add_theme_page( '轻言', '轻言', 'administrator', 'firgatebird_light_word','firgatebird_light_word_display');
}
?>
<?php
    function create_table($table) {
        $sql = 'CREATE TABLE IF NOT EXISTS `'. $table .'` (
			`id` int(11) NOT NULL auto_increment,
			`content` text,
            `status` int(1) unsigned default 0,
            `show` int(1) unsigned default 1,
            `create_time` datetime default NULL,
			UNIQUE KEY `id` (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
    function add_item($table) {
        global $wpdb;
        $wpdb->show_errors();
        $wpdb->insert(
            $table . '',
            array(
                'content' => $_POST['content'],
                'status' => $_POST['status'],
                'show' => $_POST['show'],
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
        $wpdb->delete( $table.'', array( 'ID' => $id ) );
    }
?>
<?php function firgatebird_light_word_display() {?>
    <div class="wrap">
        <h1 class="wp-heading-inline">设置</h1>
        <iframe id="rfFrame" name="rfFrame" src="about:blank" style="display:none;"></iframe>
        <?php
        global $wpdb;
        global $table_prefix;
        $table = $table_prefix . 'firgatebird_light_word';
        // $wpdb->show_errors();
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}");
        $current_page = $_GET['current_page'] ? $_GET['current_page'] : 1;
        $page_size = $_GET['page_size'] ? $_GET['page_size'] : 10;
        $total_page = ceil($count / $page_size);
        if($count === NULL) {
        ?>
            <div>
                <p>暂无数据</p>
                <form method="post" name="firgatebird_form" id="firgatebird_form" target="rfFrame" onsubmit="initData()" action="themes.php?page=firgatebird_light_word&init_data=true" class="validate">
                    <button id="start-install-btn" type="submit" class="button button-primary">初始化</button>
                </form>
            </div>
        <?php } else { ?>
            <div class="tablenav top">
                <form method="post" name="firgatebird_form_add_item" id="firgatebird_form_add_item" target="rfFrame" onsubmit="addItem()" action="themes.php?page=firgatebird_light_word&add=true" class="validate">
                    <div class="alignleft actions">
                        <input name="content" type="text" width="200" placeholder="快速添加条目" value="快速添加条目">
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
            </div>
            <table class="wp-list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <th class="manage-column column-title column-primary" width="80">ID</th>
                        <th class="manage-column column-title column-primary">正文</th>
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
                        foreach ($list as $item) {
                    ?>
                        <tr>
                            <td><?php echo $item['id']?></td>
                            <td><?php echo $item['content']?></td>
                            <td><?php echo $item['status']?></td>
                            <td><?php echo $item['show']?></td>
                            <td><?php echo $item['create_time']?></td>
                            <td>
                                <form method="post" name="firgatebird_form_delete_item" target="rfFrame" onsubmit="deleteItem()" action="themes.php?page=firgatebird_light_word&delete=true" class="validate">
                                    <input name="id" style="display: none;" type="text" value="<?php echo $item['id']?>">
                                    <button type="submit" class="button">删除</button>
                                </form>
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
                        <a class="pagination-links" href="/wp-admin/themes.php?page=firgatebird_light_word&current_page=1">
                            <span class="tablenav-pages-navspan button" aria-hidden="true">«</span>
                        </a>
                        <a class="tablenav-pages-navspan button" aria-hidden="true" href="/wp-admin/themes.php?page=firgatebird_light_word&current_page=<?php echo $current_page-1; ?>">‹</a>
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
                        <a class="next-page button" href="/wp-admin/themes.php?page=firgatebird_light_word&current_page=<?php echo $current_page+1; ?>">
                            <span class="screen-reader-text">下一页</span>
                            <span aria-hidden="true">›</span>
                        </a>
                        <a class="tablenav-pages-navspan button disabled" aria-hidden="true" href="/wp-admin/themes.php?page=firgatebird_light_word&current_page=<?php echo $total_page; ?>">
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
                document.getElementById('start-install-btn').innerHTML = '初始化';
                document.getElementById('start-install-btn').disabled = false;
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
<?php }?>
<?php add_action('admin_menu', 'firgatebird_light_word_function');?>

<?php
 /**
   * 最新评论
   *
   * */
    class sidebar_attack_statistic extends WP_Widget {
        /** 构造函数 */
//        function sidebar_attack_statistic() {
//            parent::WP_Widget(false, $name = 'Theme:攻击统计');
//        }
        function __construct(){
            $widget_ops = array('description' => __('Theme:攻击统计','bb10'));
            parent::__construct('sidebar_attack_statistic' ,__('Theme:攻击统计','bb10'), $widget_ops);
        }
        /** @see WP_Widget::widget */
        function widget($args, $instance) {
            extract( $args );

            if(!$instance['title']) {
                $instance['title'] = "攻击统计";
            }
            ?>
                <?php echo $before_widget; ?>
                <?php $showtitle = !empty($instance['showtitle']) ? $instance['showtitle'] : 'undefined'; ?>
                <?php if($showtitle !== "undefined") { ?>
                    <?php echo '<div class="sidebar-tit">' . '<span class="glyphicon glyphicon-screenshot"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                <?php } ?>
                <?php
//                    $showtype = !empty($instance['showtype']) ? $instance['showtype'] : '1';
                    function year_amount($list, $year) {
                        $month_title = [];
                        for ($i=1; $i<=12; $i++) {
                            array_push($month_title, date('Y-m',strtotime($year . "-" . $i)));
                        }
                        $res = [];
                        foreach ($month_title as $key => $val) {
                            $count_arr = 0;
                            foreach ($list as $k => $v) {
                                if($v['month'] == $val) {
                                    $count_arr += 1;
                                }
                            }
                            array_push($res, $count_arr);
                        }
                        return $res;
                    }

                    function day_mount($list, $day) {
                        $count_arr = 0;
                        foreach ($list as $k => $v) {
                            if($v['day'] == $day) {
                                $count_arr += 1;
                            }
                        }
                        return $count_arr;
                    }
                    function ipGroupRank($list, $tableName) {
                        $arr = [];
                        foreach ($list as $k => $v) {
                            if(!empty($v[$tableName]) && $v['day'] == date('Y-m-d')) {
                                $count = empty($arr[$v[$tableName]]) ? 0 : (int)$arr[$v[$tableName]];
                                $arr[$v[$tableName]] = $count + 1;
                            }
                        }
                        arsort($arr);
                        return array_slice($arr,0,10);
                    }
                    function get_data($showtype) {
                        global $wpdb;
                        global $table_prefix;
                        $tabName = $showtype == '1' ? 'aiowps_failed_logins' : 'aiowps_events';
                        $timeColName = $showtype == '1' ? 'failed_login_date' : 'event_date';

                        $bulk_actions = $table_prefix . $tabName;
                        $wpdb->show_errors();


                        $pre_year = date("Y",strtotime("-1 year"));
                        $year = date("Y");
                        $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$bulk_actions}");

                        $sql = "
                              SELECT
                              *,
                              DATE_FORMAT(". $timeColName .", '%Y-%m-%d') AS 'day',
                              DATE_FORMAT(". $timeColName .", '%Y') AS 'year',
                              DATE_FORMAT(". $timeColName .", '%Y-%m') AS 'month'
                              FROM {$bulk_actions}
                              WHERE YEAR(`". $timeColName ."`) = {$year}
                              ORDER BY ". $timeColName ." ASC
                        ";

                        $sql2 = "
                              SELECT
                              *,
                              DATE_FORMAT(". $timeColName .", '%Y-%m-%d') AS 'day',
                              DATE_FORMAT(". $timeColName .", '%Y') AS 'year',
                              DATE_FORMAT(". $timeColName .", '%Y-%m') AS 'month'
                              FROM {$bulk_actions}
                              WHERE YEAR(`". $timeColName ."`) = {$pre_year}
                              ORDER BY ". $timeColName ." ASC
                        ";
                        $list = $wpdb->get_results( $sql, ARRAY_A);
                        $list2 = $wpdb->get_results( $sql2, ARRAY_A);


                        $groupData = ipGroupRank($list, 'ip_or_host');
                        $groupData2 = ipGroupRank($list, 'login_attempt_ip');
                        $year_all = year_amount($list, $year);
                        $month_all = $year_all[(int)(date('m')) -1];
                        $pre_month_all = $year_all[(int)(date('m')) -2];
                        $day_all = day_mount($list, date('Y-m-d'));
                        $pre_day_all = day_mount($list, date("Y-m-d",strtotime("-1 day")));
                        $pre_year_all = year_amount($list2, $pre_year);
                        return array(
                            'year_all' => $year_all,
                            'month_all' => $month_all,
                            'pre_month_all' => $pre_month_all,
                            'day_all' => $day_all,
                            'pre_day_all' => $pre_day_all,
                            'pre_year_all' => $pre_year_all,
                            'total_count' => $total_count,
                            'groupData' => $groupData,
                            'groupData2' => $groupData2,
                        );
                    }

                    $field_login = get_data('1');
                    $not_found = get_data('2');
                ?>

                <div>
                    <div id="container" style="height: 300px;width: 100%;"></div>
                    <div id="container2" style="height: 300px;width: 100%;"></div>
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.2.2/dist/echarts.min.js"></script>
                    <script>
                        (() => {
                            let dom = document.getElementById("container");
                            let myChart = echarts.init(dom);
                            let option;
                            option = {
                                title: {
                                    top: 19,
                                    left: 25,
                                    text: '<?php echo date("Y");?>年'
                                },
                                tooltip: {
                                    trigger: 'axis'
                                },
                                legend: {
                                    right: 0,
                                    top: 20,
                                },
                                xAxis: {
                                    type: 'category',
                                    data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                                },
                                yAxis: {
                                    type: 'value',
                                    max: null
                                },
                                series: [
                                    {
                                        name: '暴力破解',
                                        label: {
                                            show: true,
                                            position: 'top'
                                        },
                                        data:[ <?php echo join(",",$field_login['year_all'] )?>],
                                        type: 'line',
                                        showBackground: true,
                                        itemStyle: {
                                            color: '#f05f50'
                                        },
                                    },
                                    {
                                        name: '扫描器',
                                        label: {
                                            show: false,
                                            position: 'middle'
                                        },
                                        data:[ <?php echo join(",",$not_found['year_all'] )?>],
                                        type: 'line',
                                        itemStyle: {
                                            color: '#f0a04f'
                                        },
                                    },
                                ]
                            };
                            if (option && typeof option === 'object') {
                                myChart.setOption(option);
                            }
                        })()
                    </script>
                    <script>
                        (() => {
                            let dom = document.getElementById("container2");
                            let myChart = echarts.init(dom);
                            let option;
                            const ipData = <?php echo json_encode($not_found['groupData']);?>;
                            let source = [];
                            const arr = Object.keys(ipData);
                            for(let i=0;i<10;i++) {
                                source.push({
                                    ip: arr[i] ? arr[i] : '空缺' + i,
                                    count: arr[i] ? ipData[arr[i]] : 0
                                });
                            }
                            option = {
                                title: {
                                    top: 0,
                                    left: 25,
                                    text: '今日排行'
                                },
                                tooltip: {
                                    trigger: 'axis'
                                },
                                grid: {
                                    x: 70,
                                    y: 30,
                                    left: '0',            // 固定左边刻度宽度
                                    containLabel: true
                                },
                                xAxis: {
                                    type: 'value',
                                },
                                yAxis: {
                                    type: 'category',
                                    data: source.map(item => (item.ip)).reverse()
                                },
                                series: [
                                    {
                                        type: 'bar',
                                        data: source.map(item => (item.count)).reverse()
                                    }
                                ]
                            };
                            if (option && typeof option === 'object') {
                                myChart.setOption(option);
                            }
                        })()
                    </script>
                    <div>
                        <table class="table table-condensed table-striped table-hover table-condensed">
                            <thead class="text-center">
                                <th width="100">统计</th>
                                <th>今日</th>
                                <th>昨日</th>
                                <th>本月</th>
                                <th>上月</th>
                            </thead>
                            <tr class="text-center">
                                <td>暴力破解</td>
                                <td><?php echo $field_login['day_all'];?></td>
                                <td><?php echo $field_login['pre_day_all'];?></td>
                                <td><?php echo $field_login['month_all'];?></td>
                                <td><?php echo $field_login['pre_month_all'];?></td>
                            </tr>
                            <tr class="text-center">
                                <td>扫描器</td>
                                <td><?php echo $not_found['day_all'];?></td>
                                <td><?php echo $not_found['pre_day_all'];?></td>
                                <td><?php echo $not_found['month_all'];?></td>
                                <td><?php echo $not_found['pre_month_all'];?></td>
                            </tr>
                            <tr class="text-center">
                                <td>合计</td>
                                <td><?php echo (int)$not_found['day_all'] + (int)$field_login['day_all'];?></td>
                                <td><?php echo (int)$not_found['pre_day_all'] + (int)$field_login['pre_day_all'];?></td>
                                <td><?php echo (int)$not_found['month_all'] + (int)$field_login['month_all'];?></td>
                                <td><?php echo (int)$not_found['pre_month_all'] + (int)$field_login['pre_month_all'];?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="mb10">总受攻击次数： <?php echo (int)$field_login['total_count'] + (int)$not_found['total_count'];?> 次</div>

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
            $title = esc_attr($instance['title']) ?? '';
            $showtitle = $instance['showtitle'] ?? '';
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
    register_widget("sidebar_attack_statistic");
?>

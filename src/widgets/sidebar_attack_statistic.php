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
                    global $wpdb;
                    global $table_prefix;
                    $bulk_actions = $table_prefix . 'aiowps_failed_logins';
                    $wpdb->hide_errors();

                    $pre_year = date("Y",strtotime("-1 year"));
                    $year = date("Y");
                    $total_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$bulk_actions}");

                    if($total_count === NULL) {
                        echo "<div>未开启插件： All In One WP Security</div>";
                    } else {



                    $sql = "
                          SELECT
                          *,
                          DATE_FORMAT(failed_login_date, '%Y-%m-%d') AS 'day',
                          DATE_FORMAT(failed_login_date, '%Y') AS 'year',
                          DATE_FORMAT(failed_login_date, '%Y-%m') AS 'month'
                          FROM {$bulk_actions}
                          WHERE YEAR(`failed_login_date`) = {$year}
                          ORDER BY failed_login_date ASC
                    ";

                    $sql2 = "
                          SELECT
                          *,
                          DATE_FORMAT(failed_login_date, '%Y-%m-%d') AS 'day',
                          DATE_FORMAT(failed_login_date, '%Y') AS 'year',
                          DATE_FORMAT(failed_login_date, '%Y-%m') AS 'month'
                          FROM {$bulk_actions}
                          WHERE YEAR(`failed_login_date`) = {$pre_year}
                          ORDER BY failed_login_date ASC
                    ";
                    $list = $wpdb->get_results( $sql, ARRAY_A);
                    $list2 = $wpdb->get_results( $sql2, ARRAY_A);
                    function dataGroup(array $dataArr,$keyStr){
                        $newArr=[];
                        foreach ($dataArr as $k => $val) {    //数据根据日期分组
                            $newArr[$val[$keyStr]][] = $val;
                        }
                        return $newArr;
                    }

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

                    $year_all = year_amount($list, $year);
                    $month_all = $year_all[(int)(date('m')) -1];
                    $day_all = day_mount($list, date('Y-m-d'));
                    $pre_day_all = day_mount($list, date("Y-m-d",strtotime("-1 day")));
                    $pre_year_all = year_amount($list2, $pre_year);

            ?>

                <div>
                    <div id="container" style="height: 300px;width: 100%;"></div>
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.2.2/dist/echarts.min.js"></script>
                    <script>
                        var dom = document.getElementById("container");
                        var myChart = echarts.init(dom);
                        var option;
                        option = {
                            title: {
                                top: 20,
                                right: 40,
                                text: '<?php echo $year;?>'
                            },
                            legend: {
                                left: 40,
                                top: 20,
                            },
                            xAxis: {
                                type: 'category',
                                data: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月']
                            },
                            yAxis: {
                                type: 'value'
                            },
                            series: [
                                {
                                    name: '本年',
                                    label: {
                                        show: true,
                                        position: 'top'
                                    },
                                    data:[
                                    <?php foreach ($year_all as $key => $count) { ?>
                                        <?php echo $count.',';?>
                                    <?php } ?>],
                                    type: 'bar',
                                    showBackground: true,
                                    itemStyle: {
                                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                                            { offset: 1, color: '#72f666' },
                                            { offset: 0.5, color: '#f0ec38' },
                                            { offset: 0, color: '#f03900' }
                                        ])
                                    },
                                },
                                {
                                    name: '去年',
                                    label: {
                                        show: false,
                                        position: 'top'
                                    },
                                    data:[
                                        <?php foreach ($pre_year_all as $key => $count) { ?>
                                        <?php echo $count.',';?>
                                        <?php } ?>],
                                    type: 'line',
                                    itemStyle: {
                                        color: '#008af6'
                                    },
                                },
                            ]
                        };
                        if (option && typeof option === 'object') {
                            myChart.setOption(option);
                        }
                    </script>

                    <div>今日被攻击: <?php echo $day_all;?> 次</div>
                    <div>昨日被攻击: <?php echo $pre_day_all;?> 次</div>
                    <div>本月被攻击: <?php echo $month_all;?> 次</div>
                    <div>总受攻击次数： <?php echo $total_count;?> 次</div>

                </div>
                <?php } ?>
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

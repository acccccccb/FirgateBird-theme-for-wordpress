<?php
/*
Template Name: 书架

*/
?>
<?php get_header(); ?>
<style>
    .time-line-title {
        width: 100%;
        clear: both;
        text-align: center;
        font-size: 26px;
        font-weight: bold;
        padding: 20px 0;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <?php navigation();?>
        </div>
        <div class="col-lg-10 col-lg-offset-1 mb20" id="ajax-box">
            <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
                <article class="border-bottom-1 index-article">
                    <div class="article-tit">
                        <?php $id = $post->ID; show_edit_button($id); ?>
                        <div class="clearboth"></div>
                    </div>
                    <div class="article-body">
                        <?php the_content(); ?>
                    </div>
                    <div class="clearboth"></div>
                    <!-- book list-->
                    <div class="mb20 row">
                        <?php
                        global $wpdb;
                        global $table_prefix;
                        $table = $table_prefix . 'firgatebird_bookshelf';
                        // $wpdb->show_errors();
                        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE `show`=1 and `type`=1");
                        if($count === NULL) {
                            ?>
                            <div>
                                <p>此功能尚未启用, 请先去后台<strong>启用此功能</strong></p>
                                <a href="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word" class="btn btn-danger" style="color: #fff;">启用</a>
                            </div>
                        <?php } else { ?>
                            <div class="col-xs-12" style="text-align: right; padding: 20px;font-size: 14px;">
                                迄今为止，共读过<?php echo $count?>本
                            </div>
                            <?php
                            $show_all = htmlspecialchars($_GET['show_all']);
                            if($show_all == 'true') {
                                $sql = "
                                  SELECT
                                  *,
                                  DATE_FORMAT(add_time, '%Y-%m-%d') AS 'add_time',
                                  DATE_FORMAT(add_time, '%Y') AS 'timeline'
                                  FROM {$table}
                                  WHERE (`show`=1 and `type`=1)
                                  ORDER BY add_time DESC
                                ";
                            } else {
                                $sql = "
                                  SELECT
                                  *,
                                  DATE_FORMAT(add_time, '%Y-%m-%d') AS 'add_time',
                                  DATE_FORMAT(add_time, '%Y') AS 'timeline'
                                  FROM {$table}
                                  WHERE (`show`=1 and `type`=1) and (date_format(`add_time`,'%Y') = date_format(now(),'%Y'))
                                  ORDER BY add_time DESC
                                ";
                            }
                            $list = $wpdb->get_results( $sql, ARRAY_A );
                            function dataGroup(array $dataArr,$keyStr){
                                $newArr=[];
                                foreach ($dataArr as $k => $val) {    //数据根据日期分组
                                    $newArr[$val[$keyStr]][] = $val;
                                }
                                return $newArr;
                            }
                            $group = dataGroup($list, 'timeline');
                            ?>
                            <?php foreach ($group as $key => $groupitem) {?>
                                <div class="time-line-title">
                                    - <?php echo $key?> -
                                </div>
                                <?php foreach ($groupitem as $item) {?>
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb20">
                                        <a href="<?php echo $item['link']?>" title="<?php echo $item['name']?>" target="_blank" rel="external nofollow" class="book-list">
                                            <div class="book-thumb">
                                                <img
                                                    class="lazyload"
                                                    data-container="body"
                                                    data-toggle="tooltip"
                                                    data-placement="right"
                                                    title="<?php echo $item['comment']?>"
                                                    data-src="<?php echo $item['thumb']?>"
                                                    src="data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs="
                                                    alt="<?php echo $item['name']?>"
                                                >
                                            </div>
                                            <div class="book-title">
                                                《<?php echo $item['name']?>》
                                            </div>
                                            <div class="score-box">
                                                <?php $score = (int)$item['score']; ?>
                                                <?php for ($n = 0; $n < 5; $n++) {?>
                                                    <?php if($n < $score) {?>
                                                        <i class="glyphicon glyphicon-star score-full"></i>
                                                    <?php } else { ?>
                                                        <i class="glyphicon glyphicon-star-empty score-empty"></i>
                                                    <?php } ?>
                                                <?php } ?>
                                                <span class="score-value"><?php echo sprintf("%.1f",$score);?>分</span>
                                            </div>
                                            <div class="book-desc">
                                                作者：<?php echo $item['description']?>
                                            </div>
                                            <div class="book-desc">
                                                阅读日期：<?php echo date('Y-m-d',strtotime($item['add_time']));?>
                                            </div>
                                        </a>
                                    </div>
                                <?php }?>
                            <?php } ?>
                        <?php }?>
                        <div class="clearboth"></div>
                        <?php if($show_all !== 'true') { ?>
                            <div class="text-center">
                                <a target="_self" href="?show_all=true" class="btn btn-default">查看全部</a>
                            </div>
                        <?php } ?>
                    </div>
                </article>
            <?php else: ?>
                <article class="border-bottom-1 index-article">
                    <h3 class="mb20">暂无内容</h3>
                </article>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<script>
    jQuery('[data-toggle="tooltip"]').tooltip();
    window.addEventListener("load", function() {
        lazyload();
    });
</script>
</body>
</html>


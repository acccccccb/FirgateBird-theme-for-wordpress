<?php
/*
Template Name: 电影

*/
?>
<?php get_header(); ?>
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
                        $wpdb->hide_errors();
                        $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE `show`=1 and `type`=2");
                        if($count === NULL) {
                            ?>
                            <div>
                                <p>此功能尚未启用, 请先去后台<strong>启用此功能</strong></p>
                                <a href="<?php echo site_url(); ?>/wp-admin/edit.php?page=firgatebird_light_word" class="btn btn-danger" style="color: #fff;">启用</a>
                            </div>
                        <?php } else { ?>
                            <div class="col-xs-12" style="text-align: right; padding: 20px;font-size: 14px;">
                                迄今为止，看过<?php echo $count?>部电影
                            </div>
                            <?php
                            $list = $wpdb->get_results( "
                                  SELECT *
                                  FROM {$table}
                                  WHERE `show`=1 and `type`=2
                                  ORDER BY add_time DESC
                                ", ARRAY_A );
                            foreach ($list as $item) {
                            ?>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb20">
                                    <a href="<?php echo $item['link']?>" target="_blank" rel="external nofollow" class="book-list">
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
                                            <?php echo $item['description']?>
                                        </div>
                                        <div class="book-desc">
                                            观看日期：<?php echo date('Y-m-d',strtotime($item['add_time']));?>
                                        </div>
                                    </a>
                                </div>
                            <?php }?>
                        <?php }?>
                        <div class="clearboth"></div>
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
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    window.addEventListener("load", function(event) {
        lazyload();
    });
</script>
<?php get_footer(); ?>
</body>
</html>


<?php
/*
Template Name: 书架

*/
?>
<?php get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <?php navigation();?>
        </div>
        <div class="col-lg-10 col-lg-offset-1 mb20" id="ajax-box" style="height: 2000px;">
            <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
                <article class="border-bottom-1 index-article">
                    <div class="article-tit">
                        <?php $id = $post->ID; show_edit_button($id); ?>
                        <div class="clearboth"></div>
                    </div>
                    <div class="article-body" style="display: none;">
                        <?php the_content(); ?>
                    </div>
                    <div class="index-thumb mt20 mb20 hidden">
                        <a href=""><img src="" alt=""  class="img-responsive"/></a>
                    </div>
                    <div class="clearboth"></div>
                    <!-- book list-->
                    <div class="mb20 row">
                        <?php for ($i = 0; $i < 6; $i++) { ?>
                            <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb20">
                                <div class="book-list">
                                    <div class="book-thumb">
                                        <img
                                            data-toggle="tooltip"
                                            data-placement="top"
                                            title="不错，写的很详细"
                                            src="http://wordperss.localhost.com/wp-content/themes/FirgateBird/static/img/book.png"
                                            alt=""
                                        >
                                    </div>
                                    <div class="book-title">Javascript设计模式</div>
                                    <div class="score-box">
                                        <?php $score = $i + 1; ?>
                                        <?php for ($n = 0; $n < 5; $n++) {?>
                                            <?php if($n < $score) {?>
                                                <i class="glyphicon glyphicon-star score-full"></i>
                                            <?php } else { ?>
                                                <i class="glyphicon glyphicon-star-empty score-empty"></i>
                                            <?php } ?>
                                        <?php } ?>
                                        <span class="score-value"><?php echo sprintf("%.1f",$score);?>分</span>
                                    </div>
                                    <div class="book-desc">作者: Ilya Grigorik</div>
                                    <div class="book-desc">添加日期：2020-05-06</div>
                                </div>
                            </div>
                        <?php } ?>
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
</script>
<?php get_footer(); ?>
</body>
</html>


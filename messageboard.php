<?php
/*
Template Name: 留言板

*/
?>
<?php get_header(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <?php navigation();?>
        </div>
        <div class="col-lg-9" id="ajax-box">
            <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
                <article class="border-bottom-1 index-article">
                    <div class="article-tit">
                        <?php $id = $post->ID; show_edit_button($id); ?>
                    </div>
                    <div class="article-body">
                        <?php the_content(); ?>
                    </div>
                    <div class="index-thumb mt20 mb20 hidden">
                        <a href=""><img src="" alt=""  class="img-responsive"/></a>
                    </div>
                    <div class="clearboth"></div>
                </article>
                <?php comments_template(); ?>
            <?php else: ?>
                <article class="border-bottom-1 index-article">
                    <h3 class="mb20">没有文章</h3>
                </article>
            <?php endif; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
</body>
</html>


<?php
if(is_page()) {
    echo '<div class="row">';
} else {
//    row masonry 加上此类名启用瀑布流布局
    echo '<div class="row">';
}
?>
<?php
function checkStr($str,$target) {
    $tmpArr = explode($str,$target);
    if(count($tmpArr)>1) {
        return 1;
    } else {
        return 0;
    }
}
?>
<?php if(have_posts()):?>
    <?php while (have_posts()) : the_post(); ?>
    <?php if(!is_sticky()) {?>
        <?php
            if(is_page()) {
                echo '<div class="scrollreveal col-lg-12 mb20">';
            } else {
                echo '<div class="scrollreveal col-lg-12 item mb20">';
            }
        ?>
            <?php
                if ( has_post_thumbnail()) { // check if the post has a Post Thumbnail assigned to it.
                    $theThumbnail = get_the_post_thumbnail( $post_id, thumbnail,array( 'class' => 'lazyload','alt' => get_the_title(),'size'=>'thumbnail' ));
                    $theThumbnail = str_replace('srcset="','data-srcset="',$theThumbnail);
                    $theThumbnail = str_replace('src="','srcset="',$theThumbnail);
                    echo '<div class="article-list-thumbnail">';
                    echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'">';
                    echo $theThumbnail;
                    echo '</a>';
                    echo '</div>';
                }
            ?>
            <div class="index-article">
                <div class="article-tit mb10 mt10"><a href="<?php the_permalink() ?>" data-link="<?php the_permalink() ?>"  class="ajax-article" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                    <?php $id = $post->ID; show_edit_button($id); ?>
                </div>
                <div class="the-article-info hidden">
                    <h4 class="mb10">
                        <small class="mr20"><span class="glyphicon glyphicon-folder-open"></span> <?php the_category(', ') ?></small>
                        <small class="mr20"><span class="glyphicon glyphicon-calendar"></span><?php the_time('Y.n.j') ?></small>
                        <small class="mr20 hidden"><span class="glyphicon glyphicon-user"></span><?php _e('Author'); ?>：<?php the_author(', ') ?></small>
                        <small class="mr20"><span class="glyphicon glyphicon-comment"></span> <span class="badge hidden"></span> <?php echo zfunc_comments_users($post->ID); ?></small>
                    </h4>
                </div>

                <div class="article-body">
                    <?php
                        $content = preg_replace('(<img class=\")','<img class="lazyload img-responsive ',get_the_content(''));
                        $content = preg_replace('(<img src=\")','<img class="lazyload img-responsive" data-src="',$content);
                        echo $content;
                    ?>
                </div>
                <div class="row border-top-1 mt20 article-list-info">
                    <div class="col-lg-6 col-xs-12 article-list-meta">
                        <small><?php the_tags('#', '  #' , ''); ?></small>
                    </div>
                    <div class="col-lg-6 col-xs-12 text-right article-list-date">
                        <small class="mr10"><span class="glyphicon glyphicon-folder-open"></span> <?php $category = get_the_category(); echo $category[0]->cat_name; ?></small>
                        <small class="mr10"><span class="glyphicon glyphicon-calendar"></span> <?php the_time('Y.n.j') ?></small>
                        <small class="mr10"><span class="glyphicon glyphicon-fire"></span> <?php echo post_views(); ?></small>
                        <small><span class="glyphicon glyphicon-comment"></span> <?php echo zfunc_comments_users(get_the_ID()); ?></small>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php endwhile; ?>
<?php else: ?>
    <?php if(is_search()): ?>
        <div class="col-lg-12">
            <div class="index-article">
                <h3 class="mb20">该分类下没有文章</h3>
            </div>
        </div>
    <?php else: ?>
        <div class="col-lg-12 ">
            <div class="index-article">
                <h3 class="mb20">该分类下没有文章</h3>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
</div>
<nav aria-label="Page navigation clearfix">
    <ul class="pagination">
        <?php par_pagenavi(5); ?>
    </ul>
</nav>



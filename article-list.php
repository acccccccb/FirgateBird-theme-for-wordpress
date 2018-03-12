<?php if(have_posts()):?>
    <?php while (have_posts()) : the_post(); ?>
        <article class="border-bottom-1 index-article">
            <div class="article-tit mb20 mt20"><a href="<?php the_permalink() ?>" data-link="<?php the_permalink() ?>"  class="ajax-article" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                <?php $id = $post->ID; show_edit_button($id); ?>
            </div>

                <?php
                    if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
                        echo '<div class="img-responsive mb10">';
                        echo '<a href="'.get_the_permalink().'" title="'.get_the_title().'">';
                        echo get_the_post_thumbnail( $post_id, thumbnail,array( 'class' => 'img-responsive','alt' => get_the_title() ));
                        echo '</a>';
                        echo '</div>';
                    }
                ?>
                <div class="article-body">
                <?php
                    //$content = get_the_content();
                    //$trimmed_content = wp_trim_words( $content, 300, '<a href="'. get_permalink() .'"> ...阅读更多</a>' );
                    //echo $trimmed_content;
                    the_content('阅读更多');
                    ?>
                </div>

            <h4 class="mb20 hidden">
                <small class="mr20"><span class="glyphicon glyphicon-tag mr10"></span>标签：</small>
            </h4>
            <div style="clear:both;"></div>
            <div class="the-article-info">
                <h4 class="mb10">
                    <small class="mr20"><span class="glyphicon glyphicon-folder-open"></span> <?php the_category(', ') ?></small>
                    <small class="mr20"><span class="glyphicon glyphicon-calendar"></span><?php the_time('M') ?><?php the_time('d') ?></small>
                    <small class="mr20 hidden"><span class="glyphicon glyphicon-user"></span><?php _e('Author'); ?>：<?php the_author(', ') ?></small>
                    <small class="mr20"><span class="glyphicon glyphicon-comment"></span> <span class="badge hidden"></span> <?php echo zfunc_comments_users($post->ID); ?></small>
                </h4>
            </div>
        </article>
    <?php endwhile; ?>
<?php else: ?>
    <?php if(is_search()): ?>
        <article class="border-bottom-1 index-article">
            <h3 class="mb20">未找到搜索结果</h3>
        </article>
    <?php else: ?>
        <article class="border-bottom-1 index-article">
            <h3 class="mb20">该分类下没有文章</h3>
        </article>
    <?php endif; ?>
<?php endif; ?>
<nav aria-label="Page navigation">
    <ul class="pagination">
        <?php par_pagenavi(5); ?>
    </ul>
</nav>



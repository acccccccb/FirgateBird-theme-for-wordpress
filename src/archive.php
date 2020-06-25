<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <?php navigation();?>
            </div>
            <div class="col-lg-7 col-lg-offset-1" id="ajax-box">
			    <div class="row">
                    <?php if(have_posts()):?>
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="col-lg-2 text-right">
                                <article class="archive-list-time">
                                    <p><?php the_time('Y-m-d') ?></p>
                                </article>
                            </div>
                            <div class="col-lg-10">
                                <article class="border-bottom-1 archive-list Rolling-effects">
                                    <a href="<?php the_permalink() ?>" data-link="<?php the_permalink() ?>"  class="ajax-article" title="<?php the_title(); ?>">
                                        <p><?php the_title(); ?></p>
                                    </a>
                                </article>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <article class="border-bottom-1 index-article">
                            <h3 class="mb20">该分类下没有文章</h3>
                        </article>
                    <?php endif; ?>
                </div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

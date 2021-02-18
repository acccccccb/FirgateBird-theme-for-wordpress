<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<?php navigation();?>
			</div>
			<div class="col-lg-7 col-lg-offset-1" id="ajax-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
				<article class="border-bottom-1 index-article">
					<div class="article-tit mb20 mt20"><?php the_title(); ?>
					<?php $id = $post->ID; show_edit_button($id); ?>
					</div>
					<div class="article-info">
						<h4 class="mb20">
							<small class="mr20"><span class="glyphicon glyphicon-calendar"></span><?php the_time('Y.n.j') ?></small>
							<small class="mr20 hidden"><span class="glyphicon glyphicon-user"></span><?php _e('Author'); ?>：<?php the_author(', ') ?></small>
							<small class="mr20"><span class="glyphicon glyphicon-comment"></span> <span class="badge hidden"></span> <?php echo zfunc_comments_users($post->ID); ?></small>
						</h4>
					</div>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
					<div class="index-thumb mt20 mb20 hidden">
						<a href=""><img src="" alt=""  class="img-responsive"/></a>
					</div>
				<?php author(); ?>
                <div class="mt20">
                    <nav aria-label="pre-pager">
                        <ul style="padding-left: 0;">
                            <li><?php if (get_previous_post()) { previous_post_link('%link','上一篇：%title');} else {echo '<span class="article-last">已是最后文章</span>';} ?></li>
                            <li><?php if (get_next_post()) { next_post_link('%link','下一篇：%title');} else {echo "<span class='article-first'>已是最新文章</span>";} ?></li>
                        </ul>
                    </nav>
                </div>
				</article>
                <div class="mt20">
                    <?php comments_template(); ?>
                </div>
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

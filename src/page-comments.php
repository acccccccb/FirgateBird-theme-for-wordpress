<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<?php navigation();?>
			</div>
			<div class="col-lg-9">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
				<article class="border-bottom-1 index-article">
					<div class="article-tit mb20 mt20"><?php the_title(); ?>
					<?php $id = $post->ID; show_edit_button($id); ?>
					</div>
					<div class="article-info">
						<h4 class="mb20">
							<small class="mr20"><span class="glyphicon glyphicon-calendar"></span><?php the_time('M') ?><?php the_time('d') ?></small>
							<small class="mr20 hidden"><span class="glyphicon glyphicon-user"></span><?php _e('Author'); ?>：<?php the_author(', ') ?></small>
							<small class="mr20"><span class="glyphicon glyphicon-comment"></span> <span class="badge hidden"></span> <?php echo zfunc_comments_users($post->ID); ?></small>
						</h4>
					</div>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
				<?php author(); ?>
				<div class="clearboth mt20 mb20">
					<div class="page-tags-main">
						<?php echo the_tags('<div class="btn-group btn-group-xs"><div class="btn" disabled="disabled" ><span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;tags:</div></div><div class="btn-group btn-group-xs" role="group" aria-label="tags"><div class="btn btn-default">', '</div><div class="btn btn-default">', '</div></div>'); ?>
					</div>
				</div>
				</article>
				
				<div class="col-lg-6 more-article mt20 mb20">
				<div class="page-header">
					<h2>相关文章 <small>Related articles</small></h2>
				</div>
				<div class="right mt20">
					<ul class="list-unstyled">
						<?php same_posts(6); ?>
					</ul>
				</div><!-- 随机文章 -->
			</div>
			<div class="col-lg-6 more-article mt20 mb20">
				<div class="page-header">
					<h2>热门文章 <small>Related articles</small></h2>
				</div>
				<div class="right mt20">
					<ul class="list-unstyled most-view">
						<?php hot_posts(6); ?>
					</ul>
				</div><!-- 随机文章 -->
			</div>
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
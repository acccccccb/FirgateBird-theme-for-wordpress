<?php
/*
Template Name: full-page

*/
?>
<?php get_header(); ?>
	<div class="container-fluid mb20">
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1">
				<?php navigation();?>
			</div>
			<div class="col-lg-10 col-lg-offset-1" id="ajax-box">
				<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
				<article class="border-bottom-1 index-article">
					<div class="article-tit mb20 mt20"><?php the_title(); ?>
					<?php $id = $post->ID; show_edit_button($id); ?>
					</div>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
					<div class="index-thumb mt20 mb20 hidden">
						<a href=""><img src="" alt=""  class="img-responsive"/></a>
					</div>
				</article>
				<?php else: ?>
					<article class="border-bottom-1 index-article">
					<h3 class="mb20">没有文章</h3>
				</article>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

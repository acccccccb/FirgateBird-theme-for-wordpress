<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-7 col-lg-offset-1" id="ajax-box">
				<article class="border-bottom-1 index-article">
					<div align="center" >
					<img src="<?php echo get_template_directory_uri(); ?>/img/404.gif"  class="img-responsive"/>
					</div>
				</article>
			<div class="col-lg-12 more-article">
				<div class="alert alert-info hidden" role="alert"><p class="lead">相关文章</p></div>
				<div class="right">
					<h3 class="mb10">你可能也喜欢：</h3>
					<ul class="list-unstyled">
						<?php random_posts(); ?>
					</ul>
				</div><!-- 随机文章 -->
			</div>
				</article>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-7 col-lg-offset-1" id="ajax-box">
			<?php if (!is_home() && !is_front_page() && !is_tag() && !is_is_archive() && !is_paged() ) { // 暂时不要这个 ?>
				<div id="myCarousel" class="carousel slide mb20">
				<!-- 轮播（Carousel）指标 -->
				<ol class="carousel-indicators">
				</ol>
				<!-- 轮播（Carousel）项目 -->
				<div class="carousel-inner">
					<?php thumb_article(); ?>
				</div>
				<!-- 轮播（Carousel）导航 -->
				<a class="carousel-control left" href="#myCarousel"
				   data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#myCarousel"
				   data-slide="next">&rsaquo;</a>
			</div>
		<?php } ?>
		<?php get_template_part( 'article-list' ); ?>
				
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php get_footer(); ?>
	<script>
		var sildeN = $('.carousel-inner>.item').length;
		if (sildeN > 0) {
			for(i=0;i<sildeN; i++) {
				var sildeHTML = '<li data-target="#myCarousel" data-slide-to="'+ i +'"></li>';
				$('.carousel-indicators').append(sildeHTML);
			}
			$('.item:eq(0),.carousel-indicators>li:eq(0)').addClass('active');
		}
	</script>
  </body>
</html>

<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<?php navigation();?>
		</div>
			<div class="col-lg-7 col-lg-offset-1" id="ajax-box">
				<article class="border-bottom-1 index-article">
					<div align="center" >
					<img src="<?php echo get_template_directory_uri(); ?>/static/img/404.gif"  class="img-responsive"/>
					</div>
				</article>

                <div class="col-lg-12 more-article mt20 mb20">
                    <div class="page-header" style="margin-top: 0;">
                        <h3 style="margin-top: 0;">热门文章</h3>
                    </div>
                    <div class="right mt20">
                        <ul class="list-unstyled most-view">
                            <?php hot_posts(6); ?>
                        </ul>
                    </div><!-- 随机文章 -->
                </div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

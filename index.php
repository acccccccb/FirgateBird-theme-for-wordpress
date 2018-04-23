<?php get_header(); ?>

	<div class="container-fluid">
		<div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php navigation();?>
                </div>
            </div>
			<div class="col-lg-9" id="ajax-box">
                <div class="row">
                    <div class="col-lg-12">
                            <?php get_template_part( 'article-list' ); ?>
                    </div>
                </div>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

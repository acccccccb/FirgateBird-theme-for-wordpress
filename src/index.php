<?php get_header(); ?>

	<div class="container-fluid">
		<div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="row">
                    <?php navigation();?>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <?php if(is_active_sidebar( "sidebar-2" )) { ?>
                    <?php dynamic_sidebar( 'sidebar-2' ); ?>
                <?php } ?>
            </div>
			<div class="col-lg-7 col-lg-offset-1" id="ajax-box">
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

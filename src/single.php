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
							<small class="mr20"><span class="glyphicon glyphicon-folder-open"></span> <?php the_category(', ') ?></small>
							<small class="mr20"><span class="glyphicon glyphicon-calendar"></span><?php the_time('Y.n.j') ?></small>
							<small class="mr20 hidden"><span class="glyphicon glyphicon-user"></span><?php _e('Author'); ?>：<?php the_author(', ') ?></small>
                            <small class="mr20"><span class="glyphicon glyphicon glyphicon-fire"></span> <span class="badge"></span> <?php echo bigNumber(get_post_meta($post->ID, 'views', true)); ?></small>
							<small class="mr20"><span class="glyphicon glyphicon-comment"></span> <span class="badge hidden"></span> <?php echo zfunc_comments_users($post->ID); ?></small>
							<small class="mr20"><span class="glyphicon glyphicon-heart"></span> <span class="badge hidden"></span> <?php echo get_post_like()?></small>
						</h4>
					</div>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
					<div class="index-thumb mt20 mb20 hidden">
						<a href=""><img src="" alt=""  class="img-responsive"/></a>
					</div>
                    <div class="text-center mt20 mb20">
                        <button onclick="iLike()" id="like_btn"  class="btn btn-danger" type="button">
                            <i class="glyphicon glyphicon-heart"></i> 赞 （<span id="single_like" data-like="<?php echo get_post_like()?>" ><?php echo get_post_like()?></span>）
                        </button>
                    </div>
                    <script>
                        function iLike(){
                            var iLike = <?php echo isset($_COOKIE['record_like_'.$post->ID])?'true':'false' ?>;
                            if(iLike) {
                                document.getElementById('like_btn').disabled = true;
                            } else {
                                var wpnonce = '<?php echo wp_create_nonce('wpnonce');?>';
                                var $el = document.getElementById('single_like');
                                jQuery.ajax({
                                    type: 'POST',
                                    url: "<?php echo admin_url( 'admin-ajax.php' );?>?wpnonce="+wpnonce,    // ajaxurl为内置js变量，值为"/wp-admin/admin-ajax.php"
                                    dataType:'json',
                                    data: {
                                        'action': 'record_like',    // ajax action名称
                                        'id':<?php echo $post->ID?>,
                                    },
                                    success: function (res) {
                                        $el.innerHTML = res.like;
                                        document.getElementById('like_btn').disabled = true;
                                    }
                                });
                            }
                        }
                        (function(){
                            var iLike = <?php echo isset($_COOKIE['record_like_'.$post->ID])?'true':'false' ?>;
                            if(iLike) {
                                document.getElementById('like_btn').disabled = true;
                            }
                        })()
                    </script>
				<?php author(); ?>
				<div class="clearboth mt20 mb20">
					<div class="article-list-meta">
                        <?php echo the_tags('<div>#', '#', '</div>')?>
					</div>
				</div>
				<div class="mt20">
					<nav aria-label="pre-pager">
						<ul style="padding-left: 0;">
							<li><?php if (get_previous_post()) { previous_post_link('%link','上一篇：%title');} else {echo '<span class="article-last">已是最后文章</span>';} ?></li>
							<li><?php if (get_next_post()) { next_post_link('%link','下一篇：%title');} else {echo "<span class='article-first'>已是最新文章</span>";} ?></li>
						</ul>
					</nav>
				</div>
				</article>

			<div class="col-lg-6 more-article mt20 mb20">
				<div class="page-header" style="margin-top: 0;">
					<h3 style="margin-top: 0;">相关文章</h3>
				</div>
				<div class="right mt20">
					<ul class="list-unstyled">
						<?php same_posts(7); ?>
					</ul>
				</div><!-- 随机文章 -->
			</div>
			<div class="col-lg-6 more-article mt20 mb20">
				<div class="page-header" style="margin-top: 0;">
					<h3 style="margin-top: 0;">热门文章</h3>
				</div>
				<div class="right mt20">
					<ul class="list-unstyled most-view">
						<?php hot_posts(7); ?>
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
            <div class="col-lg-3 sidebar-bg">
                <?php if(is_active_sidebar( "sidebar-2" )) { ?>
                    <?php dynamic_sidebar( 'sidebar-2' ); ?>
                <?php } ?>
            </div>
		</div>
	</div>
	<?php get_footer(); ?>
  </body>
</html>

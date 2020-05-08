	<footer>
		<div class="container-fluid footer">
			<div class="row">
				<div class="col-lg-12 footer-info text-left">
					<div class="row">
						
				
						<div class="col-lg-3 mb20">
							<p>
								<strong><span class="glyphicon glyphicon-home"></span> 关于本站：</strong><br>
								<?php echo get_bloginfo('description'); ?>
							</p>
						</div>
						<div class="col-lg-4 mb20">
							<a href="<?php echo site_url(); ?>">返回首页</a> | <a href="#top">回到顶部</a> | <a href="/comments-html">联系作者</a> | <script src="https://s22.cnzz.com/z_stat.php?id=1262730622&web_id=1262730622" language="JavaScript"></script> | 加载时间：<?php timer_stop(1); ?>s<br />
							Powered by wordpress | Theme: <a href="http://www.ihtmlcss.com/wordpress-theme-frigatebird-html/">FrigateBird</a> design by <a href="http://www.ihtmlcss.com">Marco</a><br />
							Copyright © 2016-<?php echo date('Y');?> <a href="http://www.ihtmlcss.com">www.ihtmlcss.com</a> | <a href="http://www.beian.miit.gov.cn" rel="external nofollow" target="_blank"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a>
						</div>
						<div class="col-lg-2 mb20">
							<p>
								<span class="glyphicon glyphicon-signal"></span> 日志总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?><br>
								<span class="glyphicon glyphicon-calendar"></span> 建站天数：<?php echo floor((time()-strtotime("2016-3-15"))/86400); ?><br>
								<span class="glyphicon glyphicon-pencil"></span> 最近更新：<?php modifiedTime(); ?>
							</p>
						</div>
                        <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/weixin.min.png" alt="微信公众号" class="img-responsive">
                        </div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div id="go_top"><a href="#top"><img src="<?php echo get_template_directory_uri(); ?>/img/gotop.gif" width=81 height=91 alt="回到顶部"/></a></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<div id="img-mask" >
		<div id="img-url"></div>
	</div>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/blog.min.js?v=1.0.1"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/plug-in/FrigateBird-LightBox-master/gallery.js?v=1.0.0"></script>
    <?php wp_footer(); ?>
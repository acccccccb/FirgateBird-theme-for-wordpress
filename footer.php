	<footer>
		<div class="container-fluid footer">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-1 footer-info text-left">
					<a href="<?php echo get_site_icon_url(); ?>">返回首页</a> | <a href="#top">回到顶部</a> | <a href="/comments-html">联系作者</a> | <script src="https://s22.cnzz.com/z_stat.php?id=1262730622&web_id=1262730622" language="JavaScript"></script> | 加载时间：<?php timer_stop(1); ?>s<br />
					由 Wordpress 强力驱动 | Theme: <a href="http://www.ihtmlcss.com/abouttheme/">FrigateBird v1.0</a> by <a href="http://www.ihtmlcss.com">Marco</a><br />
					© 2016-2018 <a href="http://www.ihtmlcss.com">www.ihtmlcss.com</a> | <a href="http://www.miitbeian.gov.cn/" rel="external nofollow" target="_blank"><?php echo get_option( 'zh_cn_l10n_icp_num' );?></a>
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
    <script src="<?php echo get_template_directory_uri(); ?>/js/blog.min.js?v=1.0.0"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/plug-in/FrigateBird-LightBox-master/gallery.js?v=1.0.0"></script>
    <?php wp_footer(); ?>
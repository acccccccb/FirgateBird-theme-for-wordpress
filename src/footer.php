	<footer>
		<div class="container-fluid footer">
			<div class="row">
				<div class="col-lg-12 footer-info text-left">
					<div class="row">


						<div class="col-lg-3 col-lg-offset-1 mb20">
							<p>
								<strong><span class="glyphicon glyphicon-home"></span> 关于本站：</strong><br>
								<?php echo get_bloginfo('description'); ?>
							</p>
						</div>
						<div class="col-lg-4 mb20">
							<a href="<?php echo site_url(); ?>">返回首页</a>
                            | <a href="#top">回到顶部</a>
                            | <a href="/comments-html">联系作者</a>
                            <?php if(!empty(get_option( 'firgatebird_stats_code' ))) { ?>
                                | <?php echo get_option( 'firgatebird_stats_code' ); ?>
                            <?php } ?>
                            | 加载时间：<?php timer_stop(1); ?>s<br />
							Powered by wordpress | Theme: <a href="http://www.ihtmlcss.com/wordpress-theme-frigatebird-html/">FrigateBird</a>
                            design by <a href="http://www.ihtmlcss.com">Marco</a><br />
							Copyright © 2016-<?php echo date('Y');?> <a href="http://www.ihtmlcss.com">www.ihtmlcss.com</a>
                            <?php if(!empty(get_option( 'zh_cn_l10n_icp_num' ))) { ?>
                                | <a href="http://www.beian.miit.gov.cn" rel="external nofollow" target="_blank">
                                    <?php echo get_option( 'zh_cn_l10n_icp_num' ); ?>
                                </a>
                            <?php } ?>
						</div>
						<div class="col-lg-2 mb20">
							<p>
								<span class="glyphicon glyphicon-signal"></span> 日志总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?><br>
								<span class="glyphicon glyphicon-calendar"></span> 建站天数：<?php echo floor((time()-strtotime("2016-3-15"))/86400); ?><br>
								<span class="glyphicon glyphicon-pencil"></span> 最近更新：<?php modifiedTime(); ?>
							</p>
						</div>
<!--                        <div class="col-lg-1 col-md-1 hidden-sm hidden-xs">-->
<!--                            <img src="--><?php //echo get_template_directory_uri(); ?><!--/static/img/weixin.min.png" alt="微信公众号" class="img-responsive">-->
<!--                        </div>-->
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div id="go_top"><a href="#top"><img src="<?php echo get_template_directory_uri(); ?>/static/img/top.svg" width="50" alt="回到顶部"/></a></div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<div id="img-mask" >
		<div id="img-url"></div>
	</div>
    <script src="<?php echo get_template_directory_uri(); ?>/static/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/static/js/blog.min.js?v=1.0.1"></script>

    <?php if (!empty(get_option('firgatebird_live2d'))) {?>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/plug-in/Live2D-master/live2d/css/live2d.css">
        <div id="landlord" style="position:fixed;left:20px;bottom:0;">
            <div class="message" style="opacity:0"></div>
            <canvas id="live2d" width="280" height="250" class="live2d" ></canvas>
            <div class="hide-button">隐藏</div>
        </div>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/static/plug-in/Live2D-master/live2d/js/live2d.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/static/plug-in/Live2D-master/live2d/js/message.js"></script>
        <script>
            <?php
                $message = get_option('firgatebird_live2d_message');
                $message = trim($message);
                $message = explode(PHP_EOL, $message);
                $message = json_encode($message);
            ?>
            let messageList = {
                "mouseover": [
                    {
                        "selector": ".title a",
                        "text": ["要看看 {text} 么？"]
                    },
                    {
                        "selector": ".searchbox",
                        "text": ["在找什么东西呢，需要帮忙吗？"]
                    }
                ],
                "click": [
                    {
                        "selector": "#landlord #live2d",
                        "text": <?php echo $message; ?>
                    }
                ]
            };
            let home_Path = '<?php bloginfo('url'); ?>/';
            initTips(messageList);
            initMessage(home_Path);
            loadlive2d("live2d", "<?php echo get_template_directory_uri(); ?>/static/plug-in/Live2D-master/live2d/model/tia/model.json");
            initLive2d ();
        </script>
    <?php }?>
    <?php echo get_option('firgatebird_custom_code'); ?>
    <?php wp_footer(); ?>

<div class="col-lg-3 sidebar-bg"> <!-- 侧栏 -->
	<?php // 如果没有使用 Widget 才显示以下内容, 否则会显示 Widget 定义的内容
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
	?>
		<!-- 如果没有使用 Widget 显示以下内容 is_active_sidebar( $index );  -->
		<aside class="mb20"><!-- 功能 -->
			<p>
				<h2>Congratulations!</h2>
			</p>
			<p>
				很高兴你使用了这个主题！这个主题自带小工具，你可以去wordpress后台启用它们，如果你对此主题有任何疑问，请发送邮件至：<u>tabzhang#foxmail.com</u>
			</p>
		</aside>
	<?php endif; ?>

	<?php if(!is_active_sidebar( "sidebar-1" )) { ?>
		<?php echo '边栏1未启用'; ?>
	<?php } ?>

</div>
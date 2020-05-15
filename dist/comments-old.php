<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
?>
<?php
if ( post_password_required() ) {
	return;
}
?>
<div class="comments comments-main">
	<?php if ( have_comments() ) : ?>
	<div class="alert alert-info" role="alert">
		<p class="lead">
			<?php
					printf( _nx( '1条评论', '%1$s 条评论', get_comments_number(), 'comments title'),
						number_format_i18n( get_comments_number() ), get_the_title() );
			?>
		</p>
	</div>
	<ul class="list-unstyled comments-li">
		<?php
			wp_list_comments( array(
				'style'       => 'li',
				'short_ping'  => true,
				'avatar_size' => 24,
				'reply_text'  => '<div class="col-xs-1 col-xs-offset-10 col-lg-1 col-lg-offset-11"><div class="btn btn-default btn-xs " >回复</div></div><div class="clearfix"></div>',
			) );
		?>
	<?php elseif( !have_comments() && !comments_open() ) : ?>
		<div class="alert alert-info" role="alert">这篇文章的评论已被关闭</div><style>.smiley{display:none}</style>
	<?php elseif( !have_comments() && comments_open() ) : ?>
		<div class="alert alert-info" role="alert">暂无评论</div>
	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( '
		<div class="alert alert-warning alert-dismissible" role="alert">
		    <span class="glyphicon glyphicon-bell"></span> <strong>这篇文章的评论已被关闭</strong>
		</div><style>.smiley{display:none}</style>
		', 'bootpress' ); ?></p>
	<?php endif; ?>	  
	</ul>
</div>

<div class="comments-main">
	<?php
	comment_form(
	    array(
		    'fields' => array(
			    'author' => '
				    <div class="form-horizontal">
				    	<div class="input-group mb10 col-lg-12">
							<div class="input-group-addon"><span class="glyphicon glyphicon glyphicon-user"></span></div>
							<input id="author" name="author" aria-required="true" class="form-control" type="text" placeholder="昵称" required="required" value="'.$comment_author.'">
				    	</div>
			    ',
			    'email' => '
						<div class="input-group mb10 col-lg-12">
							<div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
							<input id="email" name="email" aria-describedby="email-notes" aria-required="true" class="form-control" type="email" placeholder="邮箱" required="required" value="'.$comment_author_email.'" >
					    </div>    
			    ',
			    'url' => '
						<div class="input-group mb10 col-lg-12">
							<div class="input-group-addon"><span class="glyphicon glyphicon glyphicon-link"></span></div>
							<input id="url" name="url" class="form-control" type="url" placeholder="网址" value="'.$comment_author_url.'" >
						</div>
					</div>    
			    '
			),
		    'label_submit'=>'提交回复',
		    'container_submit'=>'div',
		    'class_submit'=>'btn btn-primary btn-block',
		    'comment_field'=>'
				<div class="form-group">
					<label for="comment" class="hidden">回复</label>
					<textarea id="comment" name="comment" rows="5" cols="" class="form-control" placeholder="输入回复内容" required="required"></textarea>
				</div>    
		    ',
		    'title_reply'       => __( '<h2 class="mb20">发表评论</h2>' ),
		    'comment_notes_before' => '<p class="comment-notes">' .
		    __( '<div class="alert alert-warning alert-dismissible" role="alert">
			    <span class="glyphicon glyphicon-bell"></span> <strong>注意：</strong><i>"评论内容</i>、<i>昵称</i>、<i>邮箱"</i>&nbsp;&nbsp;为必填项，邮件地址不会被公开。
			</div>' ) . ( $req ? $required_text : '' ) .
		    '</p>'.'<p class="form-allowed-tags small">'.
		    sprintf(
		      __( '你可以使用这些<abbr title="HyperText Markup Language">HTML</abbr>标签: %s' ),
		      ' <code>' . allowed_tags() . '</code>'
		    ) 
		    . '</p>',
		    'cancel_reply_link' => __( '<div class="btn btn-danger btn-xs col-xs-1 col-xs-offset-11">取消</div><div class="clearfix"></div>' ),
		    'logged_in_as' => '<p class="">' .
		    sprintf(
		    __( '已登陆为<a href="%1$s">%2$s</a> <a href="%3$s" title="注销">[注销]</a>' ),
		      admin_url( 'profile.php' ),
		      $user_identity,
		      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		    ) . '</p>',
		    'must_log_in' => '<p class="must-log-in">' .
		    sprintf(
		      __( '
				<div class="alert alert-warning alert-dismissible" role="alert">
				    <span class="glyphicon glyphicon-bell"></span> <strong>注意：</strong>你需要<a href="%s">登陆</a>才能发表评论。<style>.smiley{display:none}</style>
				</div>
		      ' ),
		      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		    ) . '</p>',
	    )
    );
	print '<p class="smiley">';	include(TEMPLATEPATH . '/smiley.php');print '</p>';
?>
</div>

<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
?>
<?php
if ( post_password_required() ) {
	return;
}
?>
<?php echo '&nbsp;'/*fix a bug*/; ?>
<div class="comments comments-main">
	<div class="page-header">
		<h2>文章评论 <small>Article Comments</small></h2>
	</div>
	<ul class="new-comments media-list">
	    <?php function article_comments($comment, $args, $depth)
	    { $GLOBALS['comment'] = $comment; ?>
	    <li class="comment media list-unstyled" id="li-comment-<?php comment_ID(); ?>">
		    	<a href="<?php get_comment_author_link(); ?>" class="media-left"><?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 42); } ?></a>
		    <div class="comment-body media-body">
		    <h4 class="media-heading">
		    	<?php printf(__('<b>%s</b>'), get_comment_author_link()); ?><small> 发表于<?php echo get_comment_time('Y-m-d H:i'); ?><span class="comments-edit"> | <?php edit_comment_link('修改'); ?></span></small>
		    </h4>   
		    <div class="comment_content" id="comment-<?php comment_ID(); ?>">
		    <div class="comment_text">
		    <?php if ($comment->comment_approved == '0') : ?>
		    <div class="alert alert-warning alert-dismissible" role="alert">你的评论正在审核，稍后会显示出来！</div>
		    <?php endif; ?>
		    	<?php comment_text(); ?>
		    <div class="reply">
		    <?php comment_reply_link(array_merge( $args, array('reply_text' => '<div class="col-xs-1 col-xs-offset-10 col-lg-1 col-lg-offset-11"><div class="btn btn-default btn-xs " >回复</div></div><div class="clearfix"></div>','depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		    </div></div></div></div>
	    </li>
	    <?php } ?>
		<?php 
			if ( have_comments() && comments_open() )	{
				printf('<div class="alert alert-info" role="alert"><p class="lead">《'.get_the_title().'》有'.get_comments_number().'条评论</p></div>');
				wp_list_comments('type=comment&callback=article_comments');
			} elseif (!have_comments() && comments_open() ) {
				printf('<div class="alert alert-info" role="alert"><p class="lead">暂无评论</p></div>');
			} elseif (!comments_open() && !have_comments() ) {
				printf('<div class="alert alert-info" role="alert"><p class="lead">评论已经关闭</p></div>');
			}
			elseif (have_comments() && !comments_open()) {
				printf('<div class="alert alert-info" role="alert"><p class="lead">评论已经关闭</p></div>');
			}
		?>
	</ul>

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
		    'title_reply'       => __( '发表评论' ),
		    'comment_notes_before' => '<div class="comment-notes">' .
		    __( '<div class="alert alert-warning alert-dismissible" role="alert">
			    <span class="glyphicon glyphicon-bell"></span> <strong>注意：</strong><i>"评论内容</i>、<i>昵称</i>、<i>邮箱"</i>&nbsp;&nbsp;为必填项，邮件地址不会被公开。
			</div>' ) . ( $req ? $required_text : '' ) .
		    '</div>'.'<div class="form-allowed-tags small hidden">'.
		    sprintf(
		      __( '你可以使用这些<abbr title="HyperText Markup Language">HTML</abbr>标签: %s' ),
		      ' <code>' . allowed_tags() . '</code>'
		    ) 
		    . '</div>',
		    'cancel_reply_link' => __( '<div class="btn btn-danger btn-xs col-lg-1 col-lg-offset-11 col-xs-2 col-xs-offset-10">取消</div><div class="clearfix"></div>' ),
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
	print '<div class="smiley">';	include(TEMPLATEPATH . '/smiley.php');print '</div>';
?>
</div>
	<!-- 模态框 警告 -->
	<div class="modal fade" id="myModal">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title"><span class="glyphicon glyphicon-bell"></span> 当当当！</h4>
	      </div>
	      <div class="modal-body">
	        <p>似乎没有填写完整呢，未正确填写的项将会以红色框标识。</p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">朕知道了</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


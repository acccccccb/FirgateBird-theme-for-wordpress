<?php
    if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
        die ('Please do not load this page directly. Thanks!');
    }
    if ( post_password_required() ) {
        die();
    }
?>
<div style="clear: both;"></div>
<div class="comments comments-main">
	<div class="page-header" style="margin-top: 0;">
		<h3 style="margin-top: 0;">
            <i class="glyphicon glyphicon-comment" style="opacity: .3"></i>
            文章评论
            <small>
                <?php
                    if( have_comments() && comments_open() ) {
                        echo '<span class="badge">'.get_comments_number().'</span>';
                    } elseif (!have_comments() && comments_open() ) {
                        echo '<span class="badge">暂无评论</span>';
                    } elseif (!comments_open() && !have_comments() ) {
                        echo '<span class="badge">评论已关闭</span>';
                    }
                    elseif (have_comments() && !comments_open()) {
                        echo '<span class="badge">评论已关闭</span>';
                    }
                ?>
            </small>
        </h3>
	</div>
	<div class="row fix-row">
        <ul class="new-comments media-list">
            <?php function article_comments($comment, $args, $depth)
            { $GLOBALS['comment'] = $comment; ?>
                <li class="mb10 pt10 comment media list-unstyled col-xs-12" id="li-comment-<?php comment_ID(); ?>">
                    <a href="<?php get_comment_author_link(); ?>" class="media-left"><?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 42); } ?></a>
                    <div class="comment-body media-body row">
                        <div class="col-lg-12">
                            <h4 class="media-heading">
                                <?php printf(__('<b>%s</b>'), get_comment_author_link()); ?>
                                <small>
                                    发表于<?php echo get_comment_time('Y-m-d H:i'); ?>
                                    <span class="comments-edit"><?php edit_comment_link('修改'); ?></span>
                                    <?php echo get_comment_reply_link(
                                        array_merge( $args, array(
                                                'before'=>' | ',
                                                'reply_text' => '回复',
                                                'depth' => $depth,
                                                'max_depth' => $args['max_depth']
                                            )
                                        )
                                    )
                                    ?>
                                </small>
                            </h4>
                            <div class="comment_content" id="comment-<?php comment_ID(); ?>">
                                <div class="comment_text">
                                    <?php if ($comment->comment_approved == '0') : ?>
                                        <div class="alert alert-warning alert-dismissible" role="alert">你的评论正在审核，稍后会显示出来！</div>
                                    <?php endif; ?>
                                    <?php comment_text(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <?php
            if ( have_comments() && comments_open() )	{
                wp_list_comments('type=comment&callback=article_comments');
            } elseif (!have_comments() && comments_open() ) {
                printf('<div><p class="lead">暂无评论</p></div>');
            } elseif (!comments_open() && !have_comments() ) {
                printf('<div><p class="lead">评论已经关闭</p></div>');
            }
            elseif (have_comments() && !comments_open()) {
                printf('<div><p class="lead">评论已经关闭</p></div>');
            }
            ?>
        </ul>
    </div>

	<?php

	comment_form(
	    array(
		    'fields' => array(
			    'author' => '
				    <div class="form-horizontal col-lg-12">
				    	<div class="row fix-row">
                            <div class="input-group col-lg-3 mb10">
                                <div class="input-group-addon"><span class="glyphicon glyphicon glyphicon-user"></span></div>
                                <input id="author" name="author" aria-required="true" class="form-control" type="text" placeholder="昵称" required="required" value="'.$comment_author.'">
                            </div>
                        </div>
			    ',
			    'email' => '
                        <div class="row fix-row">
                            <div class="input-group col-lg-3 mb10">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                <input id="email" name="email" aria-describedby="email-notes" aria-required="true" class="form-control" type="email" placeholder="邮箱" required="required" value="'.$comment_author_email.'" >
                            </div>    
					    </div>    
			    ',
			    'url' => '
                    <div class="row fix-row">
                            <div class="input-group col-lg-3 hidden mb10">
                                <div class="input-group-addon"><span class="glyphicon glyphicon glyphicon-link"></span></div>
                                <input id="url" name="url" class="form-control" type="url" placeholder="网址" value="'.$comment_author_url.'" >
                            </div>
                        </div>    
					</div>  
			    '
			),
            'class_form'=>'row comment-form',
            'id_submit' => 'submit',
//            'submit_before' => '<span class="glyphicon glyphicon-ok"></span>',
		    'label_submit'=>'提交评论',
		    'submit_field'=>'<div class="form-submit col-xs-12">%1$s %2$s</div>',
		    'class_submit'=>'btn btn-primary btn-md',
		    'comment_field'=>'
                <div class="form-group col-lg-6 col-xs-12">
                    <label for="comment" class="hidden">回复</label>
                    <textarea id="comment" name="comment" rows="5" cols="" class="form-control" placeholder="输入回复内容" required="required"></textarea>
                </div>    
		    ',
		    'title_reply'       => __( '<i class="glyphicon glyphicon-edit"></i> 发表评论' ),
		    'comment_notes_before' => '<div class="comment-notes col-lg-12">' .
		    __( '<div>
			    <span class="glyphicon glyphicon-bell"></span> <strong>注意：</strong><i>"评论内容</i>、<i>昵称</i>、<i>邮箱"</i>&nbsp;&nbsp;为必填项，邮件地址不会被公开。
			</div>' ) . ( $req ? (isset($required_text) ? $required_text : '') : '' ) .
		    '</div>'.'<div class="form-allowed-tags small col-lg-12 hidden">'.
		    sprintf(
		      __( '你可以使用这些<abbr title="HyperText Markup Language">HTML</abbr>标签: %s' ),
		      ' <code>' . allowed_tags() . '</code>'
		    )
		    . '</div>',
		    'cancel_reply_link' => __( '<div class="btn btn-danger btn-xs col-lg-1 col-lg-offset-11 col-xs-2 col-xs-offset-10">取消</div><div class="clearfix"></div>' ),
		    'logged_in_as' => '<div class="col-lg-12">' .
		    sprintf(
		    __( '已登陆为<a href="%1$s">%2$s</a> <a href="%3$s" title="注销">[注销]</a>' ),
		      admin_url( 'profile.php' ),
		      $user_identity,
		      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		    ) . '</div>',
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
    function smiley(){
        echo '<div class="col-lg-12 smiley">';
        include(TEMPLATEPATH . '/smiley.php');
        echo '</div>';
    }
    smiley();
?>
</div>

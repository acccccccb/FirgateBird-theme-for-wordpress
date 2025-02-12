<?php
 /**
   * 最新评论
   *
   * */
    class sidebar_new_comments extends WP_Widget {
        /** 构造函数 */
//        function sidebar_new_comments() {
//            parent::WP_Widget(false, $name = 'Theme:最新评论');
//        }
        function __construct(){
            $widget_ops = array('description' => __('Theme:最新评论','bb10'));
            parent::__construct('sidebar_new_comments' ,__('Theme:最新评论','bb10'), $widget_ops);
        }
        /** @see WP_Widget::widget */
        function widget($args, $instance) {
            extract( $args );
            if(empty($instance['title'])) {
                $instance['title'] = "最新评论";
            }
            if(empty(($instance['num_comments']))==true) {
                $instance['num_comments'] = 5;
            }
            if(empty(($instance['comment_len']))==true) {
                $instance['comment_len'] = 80;
            }
            if(empty(($instance['avatar_size']))==true) {
                $instance['avatar_size'] = 32;
            }
            ?>
                <?php echo $before_widget; ?>
                    <?php echo '<div class="sidebar-tit">'.'<span class="glyphicon glyphicon-comment"></span>&nbsp;' . $instance['title'] . $after_title; ?>
                    <ul class="list-unstyled sidebar-comment mt10">
                        <?php

                            $num_comments = $instance['num_comments'];//调用评论数
                            $comment_len = $instance['comment_len'];//评论长度
                            $avatar_size = $instance['avatar_size'];// 头像尺寸
                            $comments = get_comments(array(
                                'number' => $num_comments,
                                'status' => 'approve',
                                'user_id' => 'approve'
                            ));

                            if ( $comments ) {
                                $commentHTML = '';
                                $smiley = [':?:',':razz:',':sad:',':smile:',':oops:',':grin:',':eek:',':shock:',':cool:',':lol:',':mad:',':wink:',':neutral:',':cry:'];
                                $smileyImg = [
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f604.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f61b.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f626.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f603.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f633.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f600.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f62e.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f62f.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f60e.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f606.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f621.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f609.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f610.png"></img>',
                                    '<img width="16" height="16" src="'.get_template_directory_uri().'/static/img/smilies/1f625.png"></img>',
                                ];
                                foreach($comments as $comment) :
                                    $commentsText = strip_tags($comment->comment_content);
                                    $commentHTML .= '<div class="media">';
                                    $commentHTML .= '<a title="发表在：'. $comment->post_title.'" class="media-left" href="' . get_permalink($comment->comment_post_ID).'#comment-' .$comment->comment_ID . '">';
                                    $commentHTML .= get_avatar($comment, $avatar_size);
                                    $commentHTML .= '</a>';
                                    $commentHTML .= '<div class="media-body siderbar_comments">';
                                    $commentHTML .= '<h4 class="media-heading"><b><a href="'.get_permalink($comment->comment_post_ID).'">'.get_comment_author( $comment->comment_ID ).'</a>'. '</b> <small>' .get_comment_date("Y-d-m H:i:s",$comment->comment_ID) .'</small></h4><p>';
//                                    $commentHTML .= substr( $commentsText, 0, $comment_len );
                                    $commentHTML .= str_replace($smiley,$smileyImg,mb_substr( $commentsText, 0, $comment_len ));
                                    $commentHTML .= '</p></div>';
                                    $commentHTML .= '</div>';
                                endforeach;
                            } else {
                                $commentHTML .= '暂无评论';
                            }
                            echo $commentHTML;
                        ?>
                    </ul>
                <?php echo $after_widget; ?>
            <?php
        }

        /** @see WP_Widget::update 后台保存内容 */
        function update($new_instance, $old_instance) {
            return $new_instance;
        }

        /** @see WP_Widget::form 输出设置菜单 */
        function form($instance) {
            $title = esc_attr($instance['title']);
            $avatar_size = $instance['avatar_size'];
            $num_comments = $instance['num_comments'];
            $comment_len = $instance['comment_len'];
            ?>
                <p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                        <?php _e('Title:'); ?>
                        <input maxlength="20" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('avatar_size'); ?>">
                        头像尺寸：(默认:32)
                        <input maxlength="3" class="widefat" type="number" id="avatar_size" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="number" value="<?php echo $avatar_size; ?>">
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('num_comments'); ?>">
                        调用评论数：(默认:5)
                        <input maxlength="2" class="widefat" type="number" id="num_comments" name="<?php echo $this->get_field_name('num_comments'); ?>" type="number" value="<?php echo $num_comments; ?>">
                    </label>
                </p>
                <p>
                    <label for="<?php echo $this->get_field_id('comment_len'); ?>">
                        评论长度：(默认:80)
                        <input maxlength="3" class="widefat" type="number" id="comment_len" name="<?php echo $this->get_field_name('comment_len'); ?>" type="number" value="<?php echo $comment_len; ?>">
                    </label>
                </p>
            <?php
        }

    } // class FooWidget
    register_widget("sidebar_new_comments");
?>

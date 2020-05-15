<?php
class catPostsWidget extends WP_Widget {
	/*
	 ** 声明一个数组$widget_ops，用来保存类名和描述，以便在主题控制面板正确显示小工具信息
	 ** $control_ops 是可选参数，用来定义小工具在控制面板显示的宽度和高度
	 ** 最后是关键的一步，调用WP_Widget来初始化我们的小工具
	 **/
	function catPostsWidget(){
		$widget_ops = array('classname'=>'widget_random_posts','description'=>'随机显示你博客中的文章');
		$control_ops = array('width'=>250,'height'=>300);
		$this->WP_Widget(false, '分类文章调用', $widget_ops, $control_ops);
	}
}

function form($instance){
	//title:模块标题，title_en:英文标题，showPosts:显示文章数量，cat:分类目录ID
	$instance = wp_parse_args((array)$instance,array('title'=>'分类文章','title_en'=>'Title','showPosts'=>10,'cat'=>0));//默认值
		$title = htmlspecialchars($instance['title']);
		$title_en = htmlspecialchars($instance['title_en']);
		$showPosts = htmlspecialchars($instance['showPosts']);
		$cat = htmlspecialchars($instance['cat']);
	echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title').'">标题:<input style="width:200px;" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.$title.'" /></label></p>';
	echo '<p style="text-align:left;"><label for="'.$this->get_field_name('title_en').'">英文标题:<input style="width:200px;" id="'.$this->get_field_id('title_en').'" name="'.$this->get_field_name('title_en').'" type="text" value="'.$title_en.'" /></label></p>';
	echo '<p style="text-align:left;"><label for="'.$this->get_field_name('showPosts').'">文章数量:<input style="width:200px;" id="'.$this->get_field_id('showPosts').'" name="'.$this->get_field_name('showPosts').'" type="text" value="'.$showPosts.'" /></label></p>';
	echo '<p style="text-align:left;"><label for="'.$this->get_field_name('cat').'">分类ID:<input style="width:200px" id="'.$this->get_field_id('cat').'" name="'.$this->get_field_name('cat').'" type="text" value="'.$cat.'" /></label></p>';
}

function update($new_instance,$old_instance){
	$instance = $old_instance;
	$instance['title'] = strip_tags(stripslashes($new_instance['title']));
	$instance['title_en'] = strip_tags(stripslashes($new_instance['title_en']));
	$instance['showPosts'] = strip_tags(stripslashes($new_instance['showPosts']));
	$instance['cat'] = strip_tags(stripslashes($new_instance['cat']));
	return $instance;
}

function widget($args, $instance){
	extract($args);
	$title = apply_filters('widget_title', empty($instance['title']) ? __('分类文章Title','yang') : $instance['title']);//小工具前台标题
	$title = $title . ''.$instance['title_en'].'';
	$showPosts = empty($instance['showPosts']) ? 10 : $instance['showPosts'];
	$cat = empty($instance['cat']) ? 0 : $instance['cat'];
 
	echo $before_widget;
	if( $title ) echo $before_title . $title . $after_title;
 
	$query = new WP_Query("cat=$cat&showposts=$showPosts&orderby=rand");
	if($query->have_posts()){
		echo '<ul>';
		while($query->have_posts()){
			$query->the_post();
			echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
		}
		echo '</ul>';
	}
 
	echo $after_widget;
}


?>
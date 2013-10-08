<?php
/**
 * Module Name: 博客统计状态
 * Module Description: 显示博客基本统计信息（访客数量需要WP-PostViews插件支持，建站日期手动输入）
 */

class Leniy_Blogstat_Widget extends WP_Widget {

	function Leniy_Blogstat_Widget() {
		$widget_ops = array( 'classname' => 'leniy_widget_blogstat', 'description' => __( "显示wordpress基本状态统计信息", 'leniytweaks' ) );
		$this->WP_Widget( 'leniy_widget_blogstat', __( '博客统计状态 (Leniy)', 'leniytweaks' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;

		global $wpdb;
		$count_posts = wp_count_posts();
		$count_published_posts = $count_posts->publish;/*日志总数*/
		$count_comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE 1");/*评论总数*/
		$count_tags = wp_count_terms('post_tag');/*标签数量*/
		$begin = $wpdb->get_results("SELECT MIN(post_date) AS MIM_d FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
		$begin = date('Y-m-d', strtotime($begin[0]->MIM_d));/*建站日期*/
		$rundays = floor((time()-strtotime($begin))/86400);/*运行天数*/
		$last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");
		$last = date('Y-m-d', strtotime($last[0]->MAX_m));/*最后更新*/
		$qw_views = $wpdb->get_results("SELECT sum(meta_value) AS qwviews FROM $wpdb->postmeta WHERE meta_key LIKE 'views'");
		$count_views = $qw_views[0]->qwviews;/*访客数量*/

		$output = '';
		$output .= '<li>日志总数：' . $count_published_posts . ' 篇</li>';
		$output .= '<li>评论总数：' . $count_comments        . ' 条</li>';
		$output .= '<li>标签数量：' . $count_tags            . ' 个</li>';
		$output .= '<li>建站日期：' . $begin                             ;
		$output .= '<li>运行天数：';
			$rundays_year =  floor( $rundays/365 );
			$rundays_month = floor( ($rundays - $rundays_year * 365)/30 );
			$rundays_day =   $rundays - $rundays_year * 365 - $rundays_month * 30;
			if($rundays_year  > 0) $output .= $rundays_year  . ' 年 ';
			if($rundays_month > 0) $output .= $rundays_month . ' 个月 ';
			if($rundays_day   > 0) $output .= $rundays_day   . ' 天 ';
			$output .= '</li>';
		$output .= '<li>最后更新：' . $last                              ;
		if($count_views > 0) $output .= '<li>访客数量：' . $count_views         . ' 人次</li>';

		$output = '<ul>' . $output . '</ul>';
		$output = '<div class="leniy-blogstat-container">' . $output . '</div>';
		echo $output;

		echo "\n" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('博客统计', 'leniytweaks') ) );

		$title      = esc_attr( $instance['title'] );

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( '标题:', 'leniytweaks' ) . '
			<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
			</label></p>';
	}

} //Class Leniy_Blogstat_Widget

function leniy_blogstat_widget_init() {
	register_widget( 'Leniy_Blogstat_Widget' );
}
add_action( 'widgets_init', 'leniy_blogstat_widget_init' );

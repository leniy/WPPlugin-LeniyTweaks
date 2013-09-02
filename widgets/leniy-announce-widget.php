<?php
/**
 * Module Name: 博客公告
 * Module Description: 显示博主的最新公告信息（手动指定page的id，并把对应page设为私密属性）
 */

class Leniy_Announce_Widget extends WP_Widget {

	function Leniy_Announce_Widget() {
		$widget_ops = array( 'classname' => 'leniy_widget_announce', 'description' => __( "显示博主的最新公告信息", 'leniytweaks' ) );
		//$control_ops = array( 'width' => 350 );
		//$this->WP_Widget( 'leniy_widget_announce', __( '博客公告 (Leniy)', 'leniytweaks' ), $widget_ops, $control_ops );
		$this->WP_Widget( 'leniy_widget_announce', __( '博客公告 (Leniy)', 'leniytweaks' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;

		$show_pageid  = absint( $instance['page_id'] );   //post或page页面的id
		$show_num     = absint( $instance['show_num'] );  //公告显示条数
		$output = '';
		$comments = get_comments("number=" . $show_num . "&post_id=" . $show_pageid);
		if ( !empty($comments) ) {
			foreach ($comments as $comment) {
				$output .= '<li>'. convert_smilies($comment->comment_content) . ' <span style="color:#999;">(' . get_comment_date('Y/m/d H:i',$comment->comment_ID) . ')</span></li>';
			}
		}
		if ( empty($output) ) $output = '<li>欢迎光临本博！</li>';
		$output = '<ul>' . $output . '</ul>';
		if( current_user_can( 'manage_options' ) )
			$output .= '<p style="text-align:right;">[<a href="' . get_page_link($show_pageid) . '#respond" rel="nofollow" class="anno">发表公告</a>]</p>';
		$output = '<div class="leniy-announce-container">' . $output . '</div>';
		echo $output;

		echo "\n" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_pageid']   = absint( $new_instance['show_pageid'] );
		$instance['show_num']  = absint( $new_instance['show_num'] );

		return $instance;
	}

	function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('公告栏', 'leniytweaks'), 'show_pageid' => '289', 'show_num' => '1' ) );

		$title     = esc_attr( $instance['title'] );
		$show_pageid   =   absint( $instance['show_pageid'] );
		$show_num  =   absint( $instance['show_num'] );

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( '标题:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
		</label></p>
		<p><label for="' .  $this->get_field_id( 'show_pageid' ) . '">' . esc_html__( '私密文章或页面的ID:', 'leniytweaks' ) . '
		<input size="3" id="' .  $this->get_field_id( 'show_pageid' ) . '" name="' . $this->get_field_name( 'show_pageid' ) . '" type="text" value="' .  $show_pageid . '" /><br>(' . __( '公告为本文章或页面的评论', 'leniytweaks' ) . ')
		</label></p>
		<p><label for="' . $this->get_field_id( 'show_num' ) . '">' . esc_html__( '公告显示条数:', 'leniytweaks' ) . '
		<input size="3" id="' . $this->get_field_id( 'show_num' ) . '" name="' . $this->get_field_name( 'show_num' ) . '" type="text" value="' . $show_num . '" />
		</label></p>';
	}

} //Class Leniy_Announce_Widget

function leniy_announce_widget_init() {
	register_widget( 'Leniy_Announce_Widget' );
}
add_action( 'widgets_init', 'leniy_announce_widget_init' );

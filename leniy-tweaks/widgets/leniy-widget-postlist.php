<?php
/**
 * Module Name: 近期推荐文章
 * Module Description: 显示近期推荐文章（排序方式为：发布日期、修改日期、随机；可设置显示数量）
 */

class Leniy_Postlist_Widget extends WP_Widget {

	function Leniy_Postlist_Widget() {
		$widget_ops = array( 'classname' => 'leniy_widget_postlist', 'description' => __( "您站点近期推荐的文章", 'leniytweaks' ) );
		$this->WP_Widget( 'leniy_widget_postlist', __( '近期文章 (Leniy)', 'leniytweaks' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;

		$limit   = $instance['limit'];
		$orderby = $instance['orderby'];

		$output = '';
		query_posts(array(
			'order'            => DESC,
			'orderby'          => $orderby,
			'showposts'        => $limit,
			'caller_get_posts' => 1,
			)
		);
		while (have_posts()) : the_post();
			$output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
		endwhile;
		wp_reset_query();
	
		$output = '<ul>' . $output . '</ul>';
		$output = '<div class="leniy-postlist-container">' . $output . '</div>';
		echo $output;

		echo "\n" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']   = strip_tags( $new_instance['title']   );
		$instance['limit']   = strip_tags( $new_instance['limit']   );
		$instance['orderby'] = strip_tags( $new_instance['orderby'] );

		return $instance;
	}

	function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title'   => __('近期推荐文章', 'leniytweaks'), 'limit'   => '10', 'orderby' => 'date'	) );

		$title   = esc_attr( $instance['title'] );
		$limit   = strip_tags($instance['limit']);
		$orderby = strip_tags($instance['orderby']);

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( '标题:', 'leniytweaks' ) . '
			<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
			</label></p>
			<p><label for="' . $this->get_field_id( 'limit' ) . '">' . esc_html__( '显示文章数量:', 'leniytweaks' ) . '
			<input class="widefat" id="' . $this->get_field_id( 'limit' ) . '" name="' . $this->get_field_name( 'limit' ) . '" type="text" value="' . $limit . '" />
			</label></p>
			<p><label for="' . $this->get_field_id( 'orderby' ) . '">' . esc_html__( '排列方式:', 'leniytweaks' ) . '
			<select class="widefat" id="' . $this->get_field_id('orderby') . '" name="' . $this->get_field_name('orderby') . '" style="width:100%;">
				<option value="comment_count" ' . selected('comment_count', $instance['orderby']) . '>按评论数</option>
				<option value="date" ' . selected('date', $instance['orderby']) . '>按发布时间</option>
				<option value="rand" ' . selected('rand', $instance['orderby']) . '>随机显示</option>
			</select>
			</label></p>';
	}

} //Class Leniy_Postlist_Widget

function leniy_postlist_widget_init() {
	register_widget( 'Leniy_Postlist_Widget' );
}
add_action( 'widgets_init', 'leniy_postlist_widget_init' );

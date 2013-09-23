<?php
/**
 * Module Name: 社交网络
 * Module Description: 展示社交网络图标，方便进入各个帐号（已添加nofollow，不会分散权重）
 */

class Leniy_Socialbox_Widget extends WP_Widget {

	function Leniy_Socialbox_Widget() {
		$widget_ops = array( 'classname' => 'leniy_widget_socialbox', 'description' => __( "显示博主的社交网站图标列表", 'leniytweaks' ) );
		$this->WP_Widget( 'leniy_widget_socialbox', __( '社交网络 (Leniy)', 'leniytweaks' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( $title )
			echo $before_title . esc_html( $title ) . $after_title;

		$url_rss       = $instance['url_rss'];
		$url_blog      = $instance['url_blog'];
		$url_qqweibo   = $instance['url_qqweibo'];
		$url_sinaweibo = $instance['url_sinaweibo'];
		$url_email     = $instance['url_email'];

		$output = '';
		$output .= '<a rel="external nofollow" target="_blank" class="sb-rss"       href="' . $url_rss       . '">RSS Feed</a>';
		$output .= '<a rel="external nofollow" target="_blank" class="sb-blog"      href="' . $url_blog      . '">Leniy</a>';
		$output .= '<a rel="external nofollow" target="_blank" class="sb-qqweibo"   href="' . $url_qqweibo   . '">腾讯微博@leniytsan</a>';
		$output .= '<a rel="external nofollow" target="_blank" class="sb-sinaweibo" href="' . $url_sinaweibo . '">新浪微博@leniycc</a>';
		$output .= '<a rel="external nofollow" target="_blank" class="sb-email"     href="mailto:' . $url_email     . '">Email</a>';

		$output = '<div class="leniy-socialbox-container">' . $output . '</div>';
		echo $output;

		echo '<style>
.leniy-socialbox-container {
	padding:0 0 5px 0;
	margin: auto;
	overflow: hidden;
}
.leniy-socialbox-container a {
	float:left;
	width:54px;
	height:54px;
	margin:0 6px;
	padding:0;
	text-indent:-9999em;
	background-color:transparent;
	background-size:100% auto;
	background-repeat:no-repeat;
}
.leniy-socialbox-container .sb-blog      {background-image:url(' . plugins_url( 'socialboximg/socialbox.leniy.png' , __FILE__ ) . ');}
.leniy-socialbox-container .sb-rss       {background-image:url(' . plugins_url( 'socialboximg/socialbox.rss.png' , __FILE__ ) . ');}
.leniy-socialbox-container .sb-sinaweibo {background-image:url(' . plugins_url( 'socialboximg/socialbox.sinaweibo.png' , __FILE__ ) . ');}
.leniy-socialbox-container .sb-qqweibo   {background-image:url(' . plugins_url( 'socialboximg/socialbox.qqweibo.png' , __FILE__ ) . ');}
.leniy-socialbox-container .sb-email     {background-image:url(' . plugins_url( 'socialboximg/socialbox.email.png' , __FILE__ ) . ');}
.leniy-socialbox-container .sb-qq        {background-image:url(' . plugins_url( 'socialboximg/socialbox.qq.png' , __FILE__ ) . ');}
</style>
';
		echo "\n" . $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']         = $new_instance['title'];
		$instance['url_rss']       = $new_instance['url_rss'];
		$instance['url_blog']      = $new_instance['url_blog'];
		$instance['url_qqweibo']   = $new_instance['url_qqweibo'];
		$instance['url_sinaweibo'] = $new_instance['url_sinaweibo'];
		$instance['url_email']     = $new_instance['url_email'];
		return $instance;
	}

	function form( $instance ) {
		// Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('社交网络', 'leniytweaks'), 'url_rss' => 'http://feed.leniy.org', 'url_blog' => 'http://blog.leniy.org', 'url_qqweibo' => 'http://t.qq.com/leniytsan', 'url_sinaweibo' => 'http://weibo.com/leniycc', 'url_email' => 'm@leniy.org' ) );

		$title         = esc_attr( $instance['title'] );
		$url_rss       = $instance['url_rss'];
		$url_blog      = $instance['url_blog'];
		$url_qqweibo   = $instance['url_qqweibo'];
		$url_sinaweibo = $instance['url_sinaweibo'];
		$url_email     = $instance['url_email'];

		echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( '标题:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( 'url_rss' ) . '">' . esc_html__( 'RSS地址:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'url_rss' ) . '" name="' . $this->get_field_name( 'url_rss' ) . '" type="text" value="' . $url_rss . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( 'url_blog' ) . '">' . esc_html__( '博客地址:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'url_blog' ) . '" name="' . $this->get_field_name( 'url_blog' ) . '" type="text" value="' . $url_blog . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( 'url_qqweibo' ) . '">' . esc_html__( 'QQ微博地址:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'url_qqweibo' ) . '" name="' . $this->get_field_name( 'url_qqweibo' ) . '" type="text" value="' . $url_qqweibo . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( 'url_sinaweibo' ) . '">' . esc_html__( '新浪微博地址:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'url_sinaweibo' ) . '" name="' . $this->get_field_name( 'url_sinaweibo' ) . '" type="text" value="' . $url_sinaweibo . '" />
		</label></p>
		<p><label for="' . $this->get_field_id( 'url_email' ) . '">' . esc_html__( '邮箱:', 'leniytweaks' ) . '
		<input class="widefat" id="' . $this->get_field_id( 'url_email' ) . '" name="' . $this->get_field_name( 'url_email' ) . '" type="text" value="' . $url_email . '" />
		</label></p>';
	}

} //Class Leniy_Socialbox_Widget

function leniy_socialbox_widget_init() {
	register_widget( 'Leniy_Socialbox_Widget' );
}
add_action( 'widgets_init', 'leniy_socialbox_widget_init' );

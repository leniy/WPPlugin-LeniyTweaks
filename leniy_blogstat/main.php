<?php

//博客统计状态
//访客数量需要WP-PostViews插件支持
//建站日期手动输入


//小工具函数
if (!function_exists('leniy_widget_blogstat')) {
	function leniy_widget_blogstat($args) {
		extract($args);
		echo $before_widget;
		echo $before_title . '博客统计' . $after_title;
		leniy_widget_blogstat_main();
		echo $after_widget;
	}
}
//注册小工具
wp_register_sidebar_widget(
	'leniy_widget_blogstat',   // 本小工具的独立ID
	'博客统计状态(Leniy)',                     // 小工具名称
	'leniy_widget_blogstat',   // callback调用的函数名
	array(                          // 选项
		'description' => '显示wordpress基本状态统计信息'
	)
);

//小工具内容主函数
if (!function_exists('leniy_widget_blogstat_main')) {
	function leniy_widget_blogstat_main() {
		global $wpdb;
		?>
				<ul>
					<li>日志总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?> 篇</li>
					<li>评论总数：<?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE 1");?> 条 </li>
					<li>标签数量：<?php echo $count_tags = wp_count_terms('post_tag'); ?> 个</li>
					<li>建站日期：<?php $begin = $wpdb->get_results("SELECT MIN(post_date) AS MIM_d FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$begin = date('Y-m-d', strtotime($begin[0]->MIM_d));echo $begin; ?></li>
					<li>运行天数：<?php echo floor((time()-strtotime($begin))/86400);?> 天</li>
					<li>最后更新：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-m-d', strtotime($last[0]->MAX_m));echo $last; ?></li>
					<li>访客数量：<?php $qw_views = $wpdb->get_results("SELECT sum(meta_value) AS qwviews FROM yg3jg5_postmeta WHERE meta_key LIKE 'views'");echo $qw_views[0]->qwviews; ?> 人次</li>
				</ul>
		<?php
	}
}

?>

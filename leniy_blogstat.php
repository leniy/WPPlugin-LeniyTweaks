<?php

//博客统计状态
if (!function_exists('leniy_blogstat')) {
	function leniy_blogstat() {
		global $wpdb;
		?>
			<table><tr>
			<td>博客统计</td>
			<td>
				<ul>
					<li>日志总数：<?php $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?> 篇</li>
					<li>评论总数：<?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments where comment_author!='".(get_option('swt_user'))."'");?> 篇  <a title="致歉：2012.08月博客迁移，之前的评论数据丢失。除极少数在rss中找回来外，别的评论已无法恢复。" style="color: red;"><b>？</b></a></li>
					<li>标签数量：<?php echo $count_tags = wp_count_terms('post_tag'); ?> 个</li>
					<li>建站日期：2006-10-25</li>
					<li>运行天数：<?php echo floor((time()-strtotime("2006-10-25"))/86400);?> 天</li>
					<li>最后更新：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-m-d', strtotime($last[0]->MAX_m));echo /*$last;*/date('Y-m-d'); ?></li>
					<li>访客数量：<?php $qw_views = $wpdb->get_results("SELECT sum(meta_value) AS qwviews FROM yg3jg5_postmeta WHERE meta_key LIKE 'views'");echo $qw_views[0]->qwviews; ?>  <a title="2012.08月博客迁移，重新计数。" style="color: red;"><b>？</b></a></li>
				</ul>
			</td>
		</tr></table>
		<?php
	}
}

?>

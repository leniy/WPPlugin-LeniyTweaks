<?php

//博客公告
//手动指定page的id，并把对应page设为私密属性


//小工具函数
if (!function_exists('leniy_widget_announcement')) {
	function leniy_widget_announcement($args) {
		extract($args);
		echo $before_widget;
		echo $before_title . '公告栏' . $after_title;
		leniy_widget_announcement_main();
		echo $after_widget;
	}
}

//注册小工具
wp_register_sidebar_widget(
	'leniy_widget_announcement',   // 本小工具的独立ID
	'博客公告(Leniy)',             // 小工具名称
	'leniy_widget_announcement',   // callback调用的函数名
	array(                         // 选项
		'description' => '显示博主的最新公告信息'
	)
);

//小工具内容主函数
if (!function_exists('leniy_widget_announcement_main')) {
	function leniy_widget_announcement_main() {
		$page_ID=289;   //page页面的id
		$num=1;         //公告显示条数
		echo '<ul>';
		$announcement = '';
		$comments = get_comments("number=$num&post_id=$page_ID");
		if ( !empty($comments) ) {
			foreach ($comments as $comment) {
				$announcement .= '<li>'. convert_smilies($comment->comment_content) . ' <span style="color:#999;">(' . get_comment_date('Y/m/d H:i',$comment->comment_ID) . ')</span></li>';
			}
		}
		if ( empty($announcement) ) $announcement = '<li>欢迎光临本博！</li>';
		echo $announcement;
		echo '</ul>';
		if ($user_ID) echo '<p style="text-align:right;">[<a href="' . get_page_link($page_ID) . '#respond" rel="nofollow" class="anno">发表公告</a>]</p>';
	}
}

?>

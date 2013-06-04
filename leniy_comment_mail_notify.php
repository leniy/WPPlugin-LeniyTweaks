<?php

//评论邮件回复

if (!function_exists('leniy_comment_mail_notify')) {
	function leniy_comment_mail_notify($comment_id) {
		$comment = get_comment($comment_id);
		if($comment->comment_parent!='0'){
			$parent_comment = get_comment($comment->comment_parent);
			leniy_send_email($parent_comment,$comment);
		}
	}
}
if (!function_exists('leniy_send_email')) {
	function leniy_send_email($parent_comment,$comment){
		$admin_email  = get_bloginfo('admin_email');//管理员邮箱
		$author_email = $comment->comment_author_email;//评论人邮箱
		$parent_email = $parent_comment->comment_author_email;//被评论人邮箱
		if($comment->comment_approved != 'spam' && trim($parent_email) != $admin_email && trim($parent_email) != $author_email) {
			$mail_to      = trim($parent_comment->comment_author) . " <" . trim($parent_email) . ">";//收件人信息（包含邮件和昵称）
			$mail_from    = trim($comment->comment_author) . " <" . trim($author_email) . ">";//发件人信息（包含邮件和昵称）
			$mail_subject = '您在 [' . get_the_title($parent_comment->comment_post_ID) . '] 的留言有了回复';//主题
			$mail_message = '
				<div style="background-color: #fff; border: 1px solid #666666; color: #111; -moz-border-radius: 8px; -webkit-border-radius: 8px; -khtml-border-radius: 8px; border-radius: 8px; font-size: 12px; width: 702px; margin: 0 auto; margin-top: 10px; font-family: 微软雅黑, Arial;">
				<div style="background: #666666; width: 100%; height: 60px; color: white; -moz-border-radius: 6px 6px 0 0; -webkit-border-radius: 6px 6px 0 0; -khtml-border-radius: 6px 6px 0 0; border-radius: 6px 6px 0 0;">
				<span style="height: 60px; line-height: 60px; margin-left: 30px; font-size: 12px;">
				您在 <a style="text-decoration: none; color: #abf28d; font-weight: 600;" href="' . get_option('home') . '">' . get_option('blogname') . '</a> 博客上的留言有回复啦！
				</span></div>
				<div style="width: 90%; margin: 0 auto;"><br />' . trim($parent_comment->comment_author) . ', 您好：<br /><br />
				您曾在 《<a style="text-decoration: none; color: #5692bc; font-weight: 600;" href="' . get_permalink($parent_comment->comment_post_ID) . '">' . get_the_title($parent_comment->comment_post_ID) . '</a>》 发表了评论：
				<div style="background-color: #eee; border: 1px solid #DDD; padding: 20px; margin: 15px 0;">' . trim($parent_comment->comment_content) . '</div>
				' . trim($comment->comment_author) . ' 给您的回复如下：
				<div style="background-color: #eee; border: 1px solid #DDD; padding: 20px; margin: 15px 0;">' . trim($comment->comment_content) . '</div>
				您可以点击 <a style="text-decoration: none; color: #5692bc;" href="' . htmlspecialchars(get_comment_link($parent_comment->comment_ID,array("type" => "all"))) . '">查看回复的完整內容</a><p style="color:white;">.</p>
				<br />
				</div>
				</div>
	';
			$from = 'From: ' . $mail_from;
			$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
			wp_mail( $mail_to, $mail_subject, $mail_message, $headers );
		}
	}
}
add_action('comment_post', 'leniy_comment_mail_notify');
add_action('comment_unapproved_to_approved', 'leniy_comment_mail_notify');

?>

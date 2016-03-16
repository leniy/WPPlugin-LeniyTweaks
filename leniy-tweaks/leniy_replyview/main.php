<?php

//回复可见
//使用短代码：
//[replyview notice="提示信息"]这儿是隐藏内容[/replyview]

if (!function_exists('leniy_replyview')) {
	function leniy_replyview($atts,$content=null){
		extract(shortcode_atts(array("notice" => '请勿发送垃圾评论及无意义评论，此类评论自动删除'),$atts));
		$massage = '<center style="border: 1px solid; border-color: #867F75;background-color: #E2D4BE;"><span class="locked">' . $notice . '<br>此处内容需要 <a href="'. get_permalink().'#respond" title="回复本文">回复</a> 后, <a href="javascript:window.location.reload();" title="刷新">刷新</a> 页面才能查看。</span></center>';
		$email=null;
		$user_ID=(int)wp_get_current_user()->ID;
		if($user_ID>0){
			$email = get_userdata($user_ID)->user_email;
		} else if(isset($_COOKIE['comment_author_email_'.COOKIEHASH])){
			$email=str_replace('%40','@',$_COOKIE['comment_author_email_'.COOKIEHASH]);
		} else{return $massage;}
		if(empty($email)){return $massage;}
	
		global $wpdb;
		$post_id=get_the_ID();
		$query="SELECT `comment_ID`
	FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id}
	and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
		if($wpdb->get_results($query)){
			return $content;
		} else{return $massage;}
	}
}
add_shortcode('replyview', 'leniy_replyview');

?>

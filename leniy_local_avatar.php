<?php

//服务器本地缓存Avatar头像
//主题文件中使用get_avatar( $comment的部分，需要修改为leniy_local_avatar( $comment->comment_author_email

if (!function_exists('leniy_local_avatar')) {
	function leniy_local_avatar( $email, $size = '32', $default = '', $alt = '') {
		$f = md5( strtolower( $email ) );
		$a = LENIY_PLUGIN_URL . 'avatar/' . $f . $size . '.png';
		$e = LENIY_PLUGIN_DIR . 'avatar/' . $f . $size . '.png';
		$d = LENIY_PLUGIN_DIR . 'avatar/' . $f . '-d.png';
	
		if($default=='')
			$default = LENIY_PLUGIN_URL . 'avatar/default.png';

		$t = 2592000; // 缓存有效期30天, 这里单位:秒
		if ( !is_file($e) || (time() - filemtime($e)) > $t ) {
			if ( !is_file($d) || (time() - filemtime($d)) > $t ) {
				// 验证是否有头像
				$uri = 'http://www.gravatar.com/avatar/' . $f . '?d=404';
				$headers = @get_headers($uri);
				if (!preg_match("|200|", $headers[0])) {
					// 没有头像，则新建一个空白文件作为标记
					$handle = fopen($d, 'w');
					fclose($handle);
	
					$a = $default;
				}
				else {
					// 有头像且不存在则更新
					$r = get_option('avatar_rating');
					$g = 'http://www.gravatar.com/avatar/'. $f. '?s='. $size. '&r=' . $r;
					copy($g, $e);
				}
			}
			else {
				$a = $default;
			}
		}
	
		$avatar = "<img alt='{$alt}' src='{$a}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return apply_filters('leniy_local_avatar', $avatar, $email, $size, $default, $alt);
	}
}

?>
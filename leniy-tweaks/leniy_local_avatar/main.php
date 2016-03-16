<?php

//服务器本地缓存Avatar头像
//不必修改主题文件

if (!function_exists('leniy_local_avatar')) {
	function leniy_local_avatar( $source ) {
		//$source为wp函数get_avatar返回的html元素，其中图片地址类似：http://1.gravatar.com/avatar/邮箱md5值?s=图片尺寸&d=wavatar&r=G
		$time = 604800; // 缓存有效期7天, 这里单位:秒
		preg_match('/avatar\/([a-z0-9]+)\?s=(\d+)/',$source,$tmp);
		//$tmp[1]为md5值，$tmp[2]为图片尺寸（单位为px）
		$cache_dir = LENIY_PLUGIN_DIR . 'leniy_local_avatar/cache/' . $tmp[1] . $tmp[2] . '.png';
		$cache_url = LENIY_PLUGIN_URL . 'leniy_local_avatar/cache/' . $tmp[1] . $tmp[2] . '.png';
		$default   = LENIY_PLUGIN_URL . 'leniy_local_avatar/default.png';


		if ( !is_file($cache_dir) || (time() - filemtime($cache_dir)) > $time ) {
			//如果缓存文件不存在或超时，则更新缓存到$cache_dir文件
			copy( 'http://www.gravatar.com/avatar/' . $tmp[1] . '?s=' . $tmp[2] . '&d=' . $default . '&r=' . get_option('avatar_rating') , $cache_dir );
		}
		if (filesize($cache_dir)<10) {
			//缓存文件小于10字节，说明头像不存在，则返回默认图片
			$returnimg = $default;
		}else {
			$returnimg = $cache_url;
		}
		return '<img alt="" src="' . $returnimg . '" class="avatar avatar-' . $tmp[2] . ' photo" width="' . $tmp[2] . '" height="' . $tmp[2] . '" />';
	}
}
add_filter('get_avatar','leniy_local_avatar');

?>

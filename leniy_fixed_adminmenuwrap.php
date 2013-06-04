<?php

//固定WordPress后台管理工具栏
if (!function_exists('leniy_fixed_adminmenuwrap')) {
	function leniy_fixed_adminmenuwrap(){
		echo '<style type="text/css">#adminmenuwrap{position:fixed;left:0px;z-index:2;}</style>';
	}
}
add_action('admin_head', 'leniy_fixed_adminmenuwrap');

?>

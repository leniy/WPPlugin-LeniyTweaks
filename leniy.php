<?php
/*
	Plugin Name: Leniy Tweaks
	Plugin URI: http://blog.leniy.org/leniy-tweaks.html
	Description: 为中国大陆用户设计的wordpress小工具，适合中文用户习惯
	Version: 0.6.5
	Author: leniy
	Author URI: http://blog.leniy.org/
	Text Domain: leniylang
*/

require_once(plugin_dir_path( __FILE__ ).'/inc/leniy_admin_menu.php');

if ( ! defined( 'LENIY_PLUGIN_DIR' ) ) {
    define( 'LENIY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'LENIY_PLUGIN_URL' ) ) {
    define( 'LENIY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}


/* ************************* 内置功能 ************************* */
require_once( LENIY_PLUGIN_DIR . 'leniy_comment_mail_notify/main.php' );//评论邮件回复
require_once( LENIY_PLUGIN_DIR . 'leniy_replyview/main.php' );//回复可见
require_once( LENIY_PLUGIN_DIR . 'leniy_fixed_adminmenuwrap/main.php' );//固定WordPress后台管理工具栏
require_once( LENIY_PLUGIN_DIR . 'leniy_local_avatar/main.php' );//服务器本地缓存Avatar头像




/* ************************* 小工具 ************************* */
require_once( LENIY_PLUGIN_DIR . 'widgets/widget.php' );


?>

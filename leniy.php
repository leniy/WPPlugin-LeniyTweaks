<?php
/*
	Plugin Name: Leniy Tweaks
	Plugin URI: http://blog.leniy.org/leniy-tweaks.html
	Description: 为中国大陆用户设计的wordpress小工具，适合中文用户习惯
	Version: 0.3.2
	Author: leniy
	Author URI: http://blog.leniy.org/
	Text Domain: leniylang
*/

/*  Copyright 2012-2013 Leniy (m@leniy.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'LENIY_PLUGIN_DIR' ) ) {
    define( 'LENIY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'LENIY_PLUGIN_URL' ) ) {
    define( 'LENIY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

//评论邮件回复
require_once( LENIY_PLUGIN_DIR . 'leniy_comment_mail_notify/main.php' );

//博客统计状态小工具
require_once( LENIY_PLUGIN_DIR . 'widgets/leniy-blogstat-widget.php' );

//回复可见
require_once( LENIY_PLUGIN_DIR . 'leniy_replyview/main.php' );

//固定WordPress后台管理工具栏
require_once( LENIY_PLUGIN_DIR . 'leniy_fixed_adminmenuwrap/main.php' );

//服务器本地缓存Avatar头像
require_once( LENIY_PLUGIN_DIR . 'leniy_local_avatar/main.php' );

//系统公告小工具
require_once( LENIY_PLUGIN_DIR . 'widgets/leniy-announce-widget.php' );

?>

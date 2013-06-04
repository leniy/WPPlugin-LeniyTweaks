<?php
/*
	Plugin Name:Leniy functions
	Version: 0.1
	Author: leniy
*/

if ( ! defined( 'LENIY_PLUGIN_DIR' ) ) {
    define( 'LENIY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'LENIY_PLUGIN_URL' ) ) {
    define( 'LENIY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

//评论邮件回复
require_once( LENIY_PLUGIN_DIR . 'leniy_comment_mail_notify.php' );

//博客统计状态
require_once( LENIY_PLUGIN_DIR . 'leniy_blogstat.php' );

//回复可见
require_once( LENIY_PLUGIN_DIR . 'leniy_replyview.php' );

//固定WordPress后台管理工具栏
require_once( LENIY_PLUGIN_DIR . 'leniy_fixed_adminmenuwrap.php' );

//服务器本地缓存Avatar头像
require_once( LENIY_PLUGIN_DIR . 'leniy_local_avatar.php' );






















//建立博客以来每日的评论数分布
function leniy_comment_details($leniy_date_format="%Y-%m-%d"){
	global $wpdb;
	$query="SELECT COUNT(*) AS `cnt` , DATE_FORMAT( `comment_date` , '" . $leniy_date_format . "' ) AS d FROM $wpdb->comments GROUP BY d ORDER BY `d` ASC";
	$output = $wpdb->get_results($query);
	foreach ($output as $o) {
		echo "<li>" . $o->d . "," . $o->cnt . "</li>";
	}
}



//这儿是首页第一篇文章随机显示的代码,By Leniy's Blog
function leniy_echo_random_post($leniy_number = 1){
	/* 获取当前日期 */
	$today_num_day = gmdate('d', ( time() + ( get_option('gmt_offset' ) * 3600 ) ) );
	$today_num_month = gmdate('m', ( time() + ( get_option('gmt_offset' ) * 3600 ) ) );
	$today_num_year = gmdate('Y', ( time() + ( get_option('gmt_offset' ) * 3600 ) ) );

	$today_day = $today_num_day;
	switch ($today_num_month) {
		case '01': $today_month = '一月'; break;
		case '02': $today_month = '二月'; break;
		case '03': $today_month = '三月'; break;
		case '04': $today_month = '四月'; break;
		case '05': $today_month = '五月'; break;
		case '06': $today_month = '六月'; break;
		case '07': $today_month = '七月'; break;
		case '08': $today_month = '八月'; break;
		case '09': $today_month = '九月'; break;
		case '10': $today_month = '十月'; break;
		case '11': $today_month = '十一月'; break;
		case '12': $today_month = '十二月'; break;
	}
	switch ($today_num_year) {
		case '2013': $today_year = '癸巳年'; break;
	}

	$leniy_rand_args = array( 'post_type' => 'post', 'author' => '1', 'orderby' => 'comment_count rand', 'order' => 'ASC', 'caller_get_posts' => '1' );
	$leniy_rand_query = new WP_Query( $leniy_rand_args );

	for ($iii = 1; $iii <= $leniy_number; $iii++) {
		$leniy_rand_query->the_post(); ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('%s', 'leniy'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
					<div class="post_intro">
						<span><?php the_author() ?><?php printf(__(' 发表于 %s 分类', 'leniy'), get_the_category_list(', ')); ?>，<?php the_tags( '标签: '); ?></span>
						<?php edit_post_link(__('<span>编辑</span>', 'leniy'), '', ''); ?>
					</div>
					<div class="content_date">
						<div class="datebg">
							<span class="day"><?php /*the_time('d')*/echo $today_day; ?></span>
							<span><?php /*the_time('F')*/echo $today_month; ?></span>
							<span><?php /*the_time('Y')*/echo $today_year; ?></span>
						</div>
					</div>
					<div class="comments">
						<span class="cmt_num"><?php comments_popup_link('0', '1', '%'); ?></span>
					</div>
					<div class="entry">
						<p> <a href="<?php the_permalink();echo "#more-";the_ID(); ?>" class="more-link"><span>阅读全文 &raquo;</span></a></p>
						<!-- <?php the_content(__('<span>阅读全文 &raquo;</span>', 'kubrick')); ?> -->
					</div>
				</div>
	<?php
	}
	wp_reset_postdata(); /* 这儿恢复文章显示方式，避免后面正常首页的内容也随机 */

}

function leniy_add_copyright_content($content) {
	$leniystr = '';
	if(is_feed()) {
		$leniystr .= 'Copyright &copy; 2006-2013 by <a href="%permalink%">Leniy</a> under license CC BY-NC-ND 3.0';
		$leniystr .= '<br />本文版权所有，转载请务必保留版权信息。<img src="http://i.creativecommons.org/l/by-nc-nd/3.0/80x15.png" />';
		$leniystr .= '<br /><small>(Digital Fingerprint:02fb34c032377a40069a23226d133442)</small>';

		$leniystr = str_replace('%permalink%', get_permalink($post->ID), $leniystr);
	}
	return $content . $leniystr;
}
//add_filter('the_content', 'leniy_add_copyright_content');

?>
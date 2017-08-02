<?php
function tangstyle_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'tangstyle_page_menu_args' );

if ( ! function_exists( 'tangstyle_content_nav' ) ) :

register_nav_menus(array('header-menu' => __( 'JieStyle导航菜单' ),));
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 150 );

//去除头部无用代码
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'locale_stylesheet' );
remove_action( 'wp_head', 'noindex', 1 );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_oembed_add_host_js');
remove_action( 'wp_head', 'wp_resource_hints', 2 );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_footer', 'wp_print_footer_scripts' );
remove_action( 'publish_future_post', 'check_and_publish_future_post', 10, 1 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'rest_api_init', 'wp_oembed_register_route');
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10);
remove_filter( 'oembed_response_data', 'get_oembed_response_data_rich', 10, 4);

add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');

//禁用Emoji表情
function disable_emojis() {
 remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
 remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
 remove_action( 'wp_print_styles', 'print_emoji_styles' );
 remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
 remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
 remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
 remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
 add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
 if ( is_array( $plugins ) ) {
 return array_diff( $plugins, array( 'wpemoji' ) );
 } else {
 return array();
 }
}

//替换Gravatar服务器
function kratos_get_avatar( $avatar ) {
$avatar = preg_replace( "/http:\/\/(www|\d).gravatar.com/","https://cn.gravatar.com",$avatar );
return $avatar;
}
add_filter( 'get_avatar', 'kratos_get_avatar' );

//评论模板
function tangstyle_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'tangstyle' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'tangstyle' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
    <li id="li-comment-<?php comment_ID(); ?>">
    <div id="comment-<?php comment_ID(); ?>">
    	<div class="avatar"><?php echo get_avatar( $comment, 40 );?></div>
    	<div class="comment">
        	<div class="comment_meta">
            <?php printf(__('<cite>%s</cite>'), get_comment_author_link()) ?>
            <span class="time"><?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></span>
            <span class="reply"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '回复', 'tangstyle' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
            <?php edit_comment_link( __( '编辑', 'tangstyle' ), '<span class="edit_link">', '</span>' ); ?>
            </div>
            <?php comment_text(); ?>
            <?php if ( '0' == $comment->comment_approved ) : ?><p style="color:#F00;"><?php _e( '您的评论正在等待审核。', 'tangstyle' ); ?></p><?php endif; ?>
        </div>
    </div>
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

// 获得热评文章
function tangstyle_get_most_viewed($posts_num=10, $days=180){
    global $wpdb;
    $sql = "SELECT ID , post_title , comment_count FROM $wpdb->posts WHERE post_type = 'post' AND TO_DAYS(now()) - TO_DAYS(post_date) < $days AND ($wpdb->posts.`post_status` = 'publish' OR $wpdb->posts.`post_status` = 'inherit') ORDER BY comment_count DESC LIMIT 0 , $posts_num ";
    $posts = $wpdb->get_results($sql);
    $output = "";
    foreach ($posts as $post){
        $output .= "\n<li><a href= \"".get_permalink($post->ID)."\" title=\"".$post->post_title."\" >".$post->post_title."</a></li>";
    }
    echo $output;
}

//分页
function pagination($query_string){
global $posts_per_page, $paged;
$my_query = new WP_Query($query_string ."&posts_per_page=-1");
$total_posts = $my_query->post_count;
if(empty($paged))$paged = 1;
$prev = $paged - 1;							
$next = $paged + 1;	
$range = 5; // 分页数设置
$showitems = ($range * 2)+1;
$pages = ceil($total_posts/$posts_per_page);
if(1 != $pages){
	echo "<div class='pagination'>";
	echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."' class='fir_las'>最前</a>":"";
	echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' class='page_previous'>« 上一页</a>":"";		
	for ($i=1; $i <= $pages; $i++){
	if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
	echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
	}
	}
	echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."' class='page_next'>下一页 »</a>" :"";
	echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."' class='fir_las'>最后</a>":"";
	echo "</div>\n";
	}
}

//彩色标签云
function colorCloud($text) {
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
return $text;
}
function colorCloudCallback($matches) {
$text = $matches[1];
$color = dechex(rand(0,16777215));
$pattern = '/style=(\'|\")(.*)(\'|\")/i';
$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);

//新窗口打开评论里的链接
function remove_comment_links() {
global $comment;
$url = get_comment_author_url();
$author = get_comment_author();
if ( empty( $url ) || 'http://' == $url )
$return = $author;
else
$return = "<a href='$url' rel='nofollow' target='_blank'>$author</a>";
return $return;
}
add_filter('get_comment_author_link', 'remove_comment_links');
remove_filter('comment_text', 'make_clickable', 9);

//移除WordPress版本号
function wpbeginner_remove_version() {
return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');

// 评论回应邮件通知
function comment_mail_notify($comment_id) {
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改为你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  $to = $parent_id ? trim(get_comment($parent_id)->comment_author_email) : '';
  $spam_confirmed = $comment->comment_approved;
  if (($parent_id != '') && ($spam_confirmed != 'spam') && ($to != $admin_email) && ($comment_author_email == $admin_email)) {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // no-reply 可改为可用的 e-mail.
    $subject = '您在 [' . get_option("blogname") . '] 的评论有新的回复';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在 [' . get_option("blogname") . '] 的文章 《' . get_the_title($comment->comment_post_ID) . '》 上发表评论:<br />'
       . nl2br(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 给您的回复如下:<br />'
       . nl2br($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复的完整內容</a></p>
      <p>欢迎再次光临 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件由系统自动发出,请勿直接回复.)</p>
    </div>';
	$message = convert_smilies($message);
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');

?>
<?php
$themename = "JieStyle";
$shortname = "tang";
$options = array (
	array("name" => "标题（Title)",
	"id" => $shortname."_title",
	"type" => "text",
	"std" => "网站标题",
	"explain" => "SEO设置<br>它将显示在网站首页的title标签里，必填项。"
	),
	array("name" => "描述（Description）",
	"id" => $shortname."_description",
	"type" => "textarea",
	"css" => "class='h80px'",
	"std" => "网站描述",
	"explain" => "SEO设置<br>它将显示在网站首页的meta标签的description属性里"
	),
	array("name" => "关键字（KeyWords）",
	"id" => $shortname."_keywords",
	"type" => "textarea",
	"css" => "class='h60px'",
	"std" => "网站关键字",
	"explain" => "SEO设置<br>多个关键字请以英文逗号隔开，它将显示在网站首页的meta标签的keywords属性里"
	),
	array("name" => "版权年份",
	"id" => $shortname."_years",
	"std" => "2012",
	"type" => "text",
	"explain" => "它将显示在页面底部"
	),
	array("name" => "是否显示新浪微博",
    "id" => $shortname."_weibo",
    "type" => "select",
    "std" => "隐藏",
    "options" => array("隐藏", "显示")),
	array("name" => "新浪微博地址",
    "id" => $shortname."_weibo_url",
    "type" => "text",
    "std" => "https://weibo.com/782622",
	"explain" => "请输入您的新浪微博地址"),
	array("name" => "是否显示Twitter",
    "id" => $shortname."_twitter",
    "type" => "select",
    "std" => "隐藏",
    "options" => array("隐藏", "显示")),
	array("name" => "Twitter地址",
    "id" => $shortname."_twitter_url",
    "type" => "text",
    "std" => "https://twitter.com/JieTangOK",
	"explain" => "请输入您的Twitter地址"),
	array("name" => "是否显示Facebook",
    "id" => $shortname."_facebook",
    "type" => "select",
    "std" => "隐藏",
    "options" => array("隐藏", "显示")),
	array("name" => "Facebook地址",
    "id" => $shortname."_facebook_url",
    "type" => "text",
    "std" => "https://www.facebook.com/jietangok",
	"explain" => "请输入您的Facebook地址"),
	array("name" => "分享代码",
	"id" => $shortname."_share",
	"type" => "textarea",
	"css" => "class='h80px'",
	"explain" => "请在此处输入您的分享代码，来自第三方或者您自己的代码，它将显示在文章的结尾处，如果没有请留空<br>第三方分享工具主要有：百度分享、JiaThis、BShare 等等"
	),
	array("name" => "统计代码",
	"id" => $shortname."_tongji",
	"type" => "textarea",
	"css" => "class='h80px'",
	"explain" => "页面底部可以显示第三方统计<br>您可以放一个或者多个统计代码"
	),
	array("name" => "文章下方广告",
	"id" => $shortname."_ads_article",
	"type" => "textarea",
	"css" => "class='h80px'",
	"explain" => "文章页正文下方广告位<br>宽度：728像素；高度不限<br>留空则不显示"
	),
	array("name" => "全局底部广告",
	"id" => $shortname."_ads_bottom",
	"type" => "textarea",
	"css" => "class='h80px'",
	"explain" => "页面底部广告位，全局显示<br>宽度：728像素；高度不限<br>留空则不显示"
	),
);
function mytheme_add_admin() {
    global $themename, $shortname, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
            update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
            foreach ($options as $value) {
            if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
            header("Location: themes.php?page=functions.php&saved=true");
            die;
        } else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] );
                update_option( $value['id'], $value['std'] );
            }
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_theme_page($themename." 设置", "$themename 设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 设置已保存。</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' 设置已重置。</strong></p></div>';
?>

<style type="text/css">
.wrap h2 {color:#09C;}
.themeadmin {border:1px dashed #999;margin-top:20px;width:420px;position:10px;}
.options {margin-top:20px;}
.options input,.options textarea {padding:2px;border:1px solid;border-color:#666 #CCC #CCC #666;background:#F9F9F9;color:#333;resize:none;width:400px;}
.options .h80px {height:80px;}
.options .h60px {height:60px;}
.options .setup {border-top:1px dotted #CCC;padding:10px 0 10px 10px;overflow:hidden;}
.options .setup h3 {font-size:14px;margin:0;padding:0;}
.options .setup .value {float:left;width:410px;}
.options .setup .explain {float:left;}
</style>
<div class="wrap">
	<h2><b><?php echo $themename; ?>主题设置</b></h2>
    <hr />
	<div>主题作者：<a href="https://tangjie.me" target="_blank">唐杰</a> ¦ 当前版本：<a href="https://tangjie.me/jiestyle" target="_blank">V1.2</a> ¦ 主题介绍、使用帮助及升级请访问：<a href="https://tangjie.me/jiestyle" target="_blank">https://tangjie.me/JieStyle</a></div>
<form method="post">
<div class="options">
<?php foreach ($options as $value) {
	if ($value['type'] == "text") { ?>
	<div class="setup">
		<h3><?php echo $value['name']; ?></h3>
    	<div class="value"><input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?>" /></div>
    	<div class="explain"><?php echo $value['explain']; ?></div>
	</div>
	<?php } elseif ($value['type'] == "textarea") { ?>
	<div class="setup">
    	<h3><?php echo $value['name']; ?></h3>
        <div class="value"><textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" <?php echo $value['css']; ?> ><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo $value['std']; } ?></textarea></div>
        <div class="explain"><?php echo $value['explain']; ?></div>
    </div>
    <?php } elseif ($value['type'] == "select") { ?>
	<div class="setup">
    	<h3><?php echo $value['name']; ?></h3>
        <div class="value">
<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?>
		<option value="<?php echo $option;?>" <?php if (get_settings( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>>
		<?php
		if ((empty($option) || $option == '' ) && isset($value['option'])) {
			echo $value['option'];
		} else {
			echo $option; 
		}?></option><?php } ?>
</select>
        </div>
        <div class="explain"><?php echo $value['explain']; ?></div>
    </div>
	<?php } ?>
<?php } ?>
</div>
<div class="submit">
<input style="font-size:12px !important;" name="save" type="submit" value="保存设置" class="button-primary" />
<input type="hidden" name="action" value="save" />
</div>
</form>

<form method="post">
	<div style="margin:50px 0;border-top:1px solid #F00;padding-top:10px;">
    <input style="font-size:12px !important;" name="reset" type="submit" value="还原默认设置" />
    <input type="hidden" name="action" value="reset" />
    </div>
</form>

</div>
<?php
}
add_action('admin_menu', 'mytheme_add_admin');
?>
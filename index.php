<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">
  <h1 class="name"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
  <p class="description"><?php bloginfo('description'); ?></p>
  <div class="line"></div>
  <div class="primary">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php if ( is_sticky() ) : ?>
    <h2 class="uptop"><span>[置顶]</span> <a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    <?php else : ?>
    <div class="post">
      <div class="info">
        <div class="date">
          <div class="day"><?php the_time('d'); ?></div>
          <div class="month"><?php the_time('F'); ?></div>
        </div>
        <div class="meta">
          <h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
          <div class="comments"><i class="iconfont">&#xf0066;</i><?php comments_popup_link ('没有评论','1条评论','%条评论'); ?></div>
          <div class="tags"><i class="iconfont">&#xf0060;</i><?php the_tags('',', ',''); ?></div>
        </div>
      </div>
      <div class="clear"></div>
      <p><?php echo mb_strimwidth(strip_tags(apply_filters('content', $post->post_content)), 0, 310,""); ?><a href="<?php the_permalink() ?>" title="详细阅读:<?php the_title(); ?>" rel="bookmark" class="more">阅读全文...</a></p>
    </div>
    <?php endif; ?>
    <?php endwhile; ?>
    <?php pagination($query_string); ?>
  </div>
  <div class="secondary">
    <div class="widget">
      <h3>分类目录</h3>
      <ul>
        <?php wp_list_categories('depth=1&title_li=0&orderby=name&show_count=1'); ?>
      </ul>
    </div>
    <div class="widget">
      <h3>热门文章</h3>
      <ul>
        <?php tangstyle_get_most_viewed(); ?>
      </ul>
    </div>
    <div class="widget">
      <h3>随机文章</h3>
      <ul>
        <?php $rand_posts = get_posts('numberposts=10&orderby=rand');  foreach( $rand_posts as $post ) : ?>
        <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
          <?php the_title(); ?>
          </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="widget">
      <h3>标签云</h3>
      <div class="tagcloud">
        <?php wp_tag_cloud();?>
      </div>
    </div>
    <div class="comments">
      <h3>最新评论</h3>
      <ul>
        <?php
			global $wpdb;
			$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,16) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' ORDER BY comment_date_gmt DESC LIMIT 10";
			$comments = $wpdb->get_results($sql);
			$output = $pre_HTML;
			foreach ($comments as $comment) {$output .= "\n<li>".get_avatar(get_comment_author_email(), 32).strip_tags($comment->comment_author).":<br />" . " <a href=\"" . get_permalink($comment->ID) ."#comment-" . $comment->comment_ID . "\" title=\"评论来源: " .$comment->post_title . "\">" . strip_tags($comment->com_excerpt)."</a></li>";}
			$output .= $post_HTML;
			$output = convert_smilies($output);
			echo $output;
		?>
      </ul>
    </div>
    <div class="widget">
      <h3>友情链接</h3>
      <ul>
        <?php wp_list_bookmarks('title_li=&categorize=0'); ?>
      </ul>
    </div>
  </div>
  <div class="clear"></div>
  <div class="ads_bottom"><?php echo stripslashes(get_option('tang_ads_bottom')); ?></div>
  <div id="footer">
    <p>&copy; <?php echo get_option('tang_years'); ?> <b><?php bloginfo('name'); ?></b>.</p>
    <p>Powered by <b>WordPress</b>. Theme by <a href="https://tangjie.me/jiestyle" title="JieStyle" target="_blank"><b>JieStyle One</b></a> | <?php echo get_option( 'zh_cn_l10n_icp_num' );?></p>
  </div>
</div>
<?php get_footer(); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">
  <h1 class="name"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
  <p class="description"><?php bloginfo('description'); ?></p>
  <div class="line"></div>
  <div class="primary">
    <h3 class="category">分类: <?php $current_category = single_cat_title(); ?></h3>
    <div class="line"></div>
    <?php while ( have_posts() ) : the_post(); ?>
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
  </div>
  <div class="clear"></div>
  <div class="ads_bottom"><?php echo stripslashes(get_option('tang_ads_bottom')); ?></div>
  <div id="footer">
    <p>&copy; <?php echo get_option('tang_years'); ?> <b><?php bloginfo('name'); ?></b>.</p>
    <p>Powered by <b>WordPress</b>. Theme by <a href="http://tangjie.me/jiestyle" title="JieStyle" target="_blank"><b>JieStyle One</b></a> | <?php echo get_option( 'zh_cn_l10n_icp_num' );?></p>
  </div>
</div>
<?php get_footer(); ?>

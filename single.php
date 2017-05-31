<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">
  <h1 class="name"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
  <p class="description"><?php bloginfo('description'); ?></p>
  <div class="line"></div>
  <?php while ( have_posts() ) : the_post(); ?>
  <div class="article">
    <div class="info">
      <div class="date">
        <div class="day"><?php the_time('d'); ?></div>
        <div class="month"><?php the_time('F'); ?></div>
      </div>
      <div class="meta">
        <h2 class="title"><?php the_title(); ?></h2>
        <div class="the">作者: <?php the_author() ?></div>
        <div class="the">分类: <?php the_category(', ') ?></div>
        <div class="the">发布时间: <?php the_time('Y-m-d H:i') ?></div>
        <div class="the"><?php edit_post_link('编辑', '<span class="meat_span">', '</span>'); ?></div>
      </div>
    </div>
    <div class="clear"></div>
    <div class="text">
      <?php the_content(); ?>
    </div>
    <div class="tags"><i class="iconfont">&#xf0060;</i><?php the_tags('',', ',''); ?></div>
  </div>
  <?php endwhile; ?>
  <div class="ads_article"><?php echo stripslashes(get_option('tang_ads_article')); ?></div>
  <div class="text_add">
    <div class="copy">
      <p style="color:#F00;">本文出自 <?php bloginfo('name');?> ，转载时请注明出处及相应链接。</p>
      <p style="color:#777;font-size:12px;margin-top:4px;">本文永久链接: <?php the_permalink() ?></p>
    </div>
    <div class="share"><?php echo stripslashes(get_option('tang_share')); ?></div>
  </div>
  <div class="post_link">
    <div class="prev"><?php previous_post_link('« %link') ?></div>
    <div class="next"><?php next_post_link('%link »') ?></div>
  </div>
  <div id="comments">
    <?php comments_template(); ?>
  </div>
  <div class="ads_bottom"><?php echo stripslashes(get_option('tang_ads_bottom')); ?></div>
  <div id="footer">
    <p>&copy; <?php echo get_option('tang_years'); ?> <b><?php bloginfo('name'); ?></b>.</p>
    <p>Powered by <b>WordPress</b>. Theme by <a href="https://tangjie.me/jiestyle" title="JieStyle" target="_blank"><b>JieStyle One</b></a> | <?php echo get_option( 'zh_cn_l10n_icp_num' );?></p>
  </div>
</div>
<?php get_footer(); ?>
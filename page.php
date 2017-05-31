<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <h1 class="name"><?php the_title(); ?></h1>
  <div class="line"></div>
  <div class="text"><?php the_content(); ?></div>
  <div id="comments"><?php comments_template(); ?></div>
  <?php endwhile; else: ?>
  <?php endif; ?>
  <div id="footer">
    <p>&copy; <?php echo get_option('tang_years'); ?> <b><?php bloginfo('name'); ?></b>.</p>
    <p>Powered by <b>WordPress</b>. Theme by <a href="https://tangjie.me/jiestyle" title="JieStyle" target="_blank"><b>JieStyle One</b></a> | <?php echo get_option( 'zh_cn_l10n_icp_num' );?></p>
  </div>
</div>
<?php get_footer(); ?>

<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">
  <h1 class="name"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
  <p class="description"><?php bloginfo('description'); ?></p>
  <div class="line"></div>
  <div class="errors_404"> <a href="/" class="to_home"> </a> <a href="javascript:history.go(-1)" class="to_back"> </a> </div>
</div>
<?php get_footer(); ?>
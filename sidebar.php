<div id="sidebar" class="phone">
  <div id="logo"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a></div>
  <div id="menu" class="menu-v">
    <?php wp_nav_menu (array(
	'theme_location'  => 'header-menu',
	'container'       => false,
	'menu'            => '',
	'menu_id'         => 'nav',
	'echo'            => true,
	'fallback_cb'     => '',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul>%3$s</ul>',
	'depth'           => 0,
	'walker'          => '',)
	); ?>
    <ul>
      <li style="background:none;"><a href="#">关注我</a>
        <ul>
          <li><a href="<?php bloginfo('rss2_url'); ?>" rel="nofollow" target="_blank"><i class="iconfont">&#xf01bc;</i>RSS订阅</a></li>
          <?php if (get_option('tang_weibo') == '显示') { ?>
          <li><a href="<?php echo stripslashes(get_option('tang_weibo_url')); ?>" rel="external nofollow" target="_blank"><i class="iconfont">&#xf01af;</i>新浪微博</a></li>
          <?php { echo ''; } ?>
          <?php } else { } ?>
          <?php if (get_option('tang_twitter') == '显示') { ?>
          <li><a href="<?php echo stripslashes(get_option('tang_twitter_url')); ?>" rel="external nofollow" target="_blank"><i class="iconfont">&#xf000e;</i>Twitter</a></li>
          <?php { echo ''; } ?>
          <?php } else { } ?>
          <?php if (get_option('tang_facebook') == '显示') { ?>
          <li><a href="<?php echo stripslashes(get_option('tang_facebook_url')); ?>" rel="external nofollow" target="_blank"><i class="iconfont">&#xf000f;</i>Facebook</a></li>
          <?php { echo ''; } ?>
          <?php } else { } ?>
        </ul>
      </li>
    </ul>
  </div>
  <div class="sidebox">
    <div class="search">
      <form id="searchform" class="searchform" method="get" action="<?php bloginfo('home'); ?>">
        <input type="text" id="s" name="s" value="输入并回车" onfocus="this.value=''" onblur="this.value='输入并回车'"/>
      </form>
    </div>
  </div>
</div>
<div class="bar">
  <a href="javascript:void(0);" onclick="sidebar_phone('div', 'phone')">
  <div class="phone"><i class="iconfont">&#xf0161;</i>收起</div>
  <div class="phone" style="display:none;"><i class="iconfont">&#xf0161;</i>展开</div>
  </a>
</div>

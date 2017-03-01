<?php
if ( post_password_required() )
	return;
?>
<?php if ( have_comments() ) : ?>

<h3><?php comments_number(__('没有评论','1条评论','%条评论'));?></h3>
<ol class="comment_list">
  <?php wp_list_comments( array( 'callback' => 'tangstyle_comment', 'style' => 'ol' ) ); ?>
</ol>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
<div id="comment-nav-below" class="comment_nav" role="navigation">
  <div class="nav-previous"><?php previous_comments_link( __( '上一页', 'tangstyle' ) ); ?></div>
  <div class="nav-next"><?php next_comments_link( __( '下一页', 'tangstyle' ) ); ?></div>
</div>
<?php endif; ?>
<?php elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
<p><?php _e( '评论已关闭!', 'tangstyle' ); ?></p>
<?php endif; ?>

<?php comment_form(); ?>

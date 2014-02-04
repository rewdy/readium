<?php /*

Readium Theme
-------------

article-attachment.php

Attachment default template file	

* Called from within the loop. Will not work otherwise. *

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (is_singular()) : ?>
	<div class="back-to-post"><?php previous_post_link('%link', '&laquo; Back to post &#8220;%title&#8221;'); ?></div>
	<?php endif; ?>

	<!-- Post Title -->
	<?php if (!is_singular()) :?>
	<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php endif;?>

	<!-- Attachment Content -->
	<div id="the-attachment">
	<?php echo wp_get_attachment_image($post->ID, 'large'); ?>
	</div>

	<?php if ( ! empty( $post->post_excerpt ) ) : ?>
	<div class="attachment-caption">
		<?php the_excerpt(); ?>
	</div>
	<?php endif; ?>

	<?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages') . ':', 'after' => '</div>')); ?>

	<nav id="image-navigation" class="row clearfix">
		<?php $thumbsize = array(150, 100); ?>
		<span class="g6"><?php previous_image_link($thumbsize); ?></span>
		<span class="g6 right"><?php next_image_link($thumbsize); ?></span>
	</nav>

	<!-- Post Links -->
	<div class="links">
		<ul class="link-list">
			<li><a href="<?php the_permalink(); ?>" title="<?php __('Permalink'); ?>" class="perma-link"><i class="fa fa-link"></i><span class="text"><?php __('Permalink'); ?></span></a></li>
			<?php if (comments_open()) : ?>
			<?php $comment_icon = '<i class="fa fa-comment"></i>'; ?>
			<li><?php comments_popup_link($comment_icon . '<span class="text">Comment</span>', $comment_icon . '<span class="text">1 Comment</span>', $comment_icon . '<span class="text">% Comments</span>'); ?></li>
			<?php endif; ?>
			<?php edit_post_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>', '<li>', '</li>' ); ?>
		</ul>
	</div>

	<!-- Post Meta -->
	<?php $categories_list = get_the_category_list(', '); ?>
	<?php $tags_list = get_the_tag_list('', ', '); ?>

	<div class="details"><?php if ($categories_list) : ?>Posted in <?php echo $categories_list; ?> &bullet; <?php endif; ?><a href="<?php the_permalink(); ?>" title="Permalink"><?php the_time(get_option('date_format')); ?></a></div>

	<?php if (is_singular()) : ?>
	<div class="sharing">
		<div class="sharing-heading">Share</div>
		<?php share_links(get_permalink(), get_the_title()); ?>
	</div>
	<?php endif; ?>

</article>

<?php if (is_single()) : ?>
<div class="directional-links horizontal">
	<div class="nav-previous"><?php previous_post_link('%link', '<i class="fa fa-angle-left"></i> <span class="text">&#8220;%title&#8221;</span>'); ?></div>
	<div class="nav-next"><?php next_post_link('%link', '<span class="text">&#8220;%title&#8221;</span> <i class="fa fa-angle-right"></i>'); ?></div>
</div>
<?php endif; ?>

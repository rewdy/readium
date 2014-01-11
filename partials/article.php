<?php /*

Readium Theme
-------------

article.php

Article default template file	

* Called from within the loop. Will not work otherwise. *

*/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Post Title -->
	<?php if (!is_singular()) :?>
	<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php else : ?>
	<h1><?php the_title(); ?></h1>
	<?php endif;?>

	<?php /*if (is_singular()) : ?>
	<!-- Post Author -->
	<div class="authorship clearfix">
		<span class="avatar"><?php echo get_avatar(get_the_author_meta('ID'), 32); ?></span>
		<span class="post-author vcard"><?php printf(__('<span class="says">Posted by</span> <cite class="fn">%s</cite>'), get_author_posts_link()); ?></span>
	</div>
	<?php endif; */?>

	<!-- Post Content -->
	<?php if (!is_singular()) : ?>
	<?php the_excerpt(); ?>
	<?php else : ?>
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages') . ':', 'after' => '</div>')); ?>
	<?php endif; ?>

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

	<div class="sharing">
		<div class="sharing-heading">Share</div>
		<?php share_links(get_permalink(), get_the_title()); ?>
	</div>

	<div class="readline"><!-- Indcator for how much of the article has been read --></div>

</article>
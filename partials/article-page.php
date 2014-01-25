<?php /*

Readium Theme
-------------

article.php

Article *page* template file	

* Called from within the loop. Will not work otherwise. *

*/
?>

<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

	<!-- Post Title -->
	<?php if (!is_singular()) :?>
	<h2><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php endif;?>

	<!-- Post Content -->
	<?php if (is_search()) : ?>
	<?php the_excerpt(); ?>
	<?php else : ?>
	<?php the_content(); ?>
	<?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages') . ':', 'after' => '</div>')); ?>
	<?php endif; ?>

	<!-- Post Links -->
	<div class="links">
		<ul class="link-list">
			<?php if (comments_open()) : ?>
			<?php $comment_icon = '<i class="fa fa-comment"></i>'; ?>
			<li><?php comments_popup_link($comment_icon . '<span class="text">Comment</span>', $comment_icon . '<span class="text">1 Comment</span>', $comment_icon . '<span class="text">% Comments</span>'); ?></li>
			<?php endif; ?>
			<?php edit_post_link('<i class="fa fa-pencil"></i><span class="text">Edit</span>', '<li>', '</li>' ); ?>
		</ul>
	</div>

	<!-- Post Meta -->
	<div class="details"><a href="<?php the_permalink(); ?>" title="Permalink"><?php the_time(get_option('date_format')); ?></a></div>

	<div class="readline"><!-- Indcator for how much of the article has been read --></div>
	
</article>
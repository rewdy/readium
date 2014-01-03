<?php /*

Readium Theme
-------------

index.php

Main template file	

*/

?>

<?php get_header(); ?>

					<div id="content-body">

						<div class="grid">
							<div class="g12<?php echo (!is_singular()) ? ' listing' : ''; ?>">
								
								<?php if (have_posts()) : ?>

									<?php if (is_archive() || is_home()) get_template_part('partials/archiveheading'); ?>

									<?php /* Start the Loop */ ?>
									<?php while (have_posts()) : the_post(); ?>

									<?php get_template_part('partials/article', get_post_type()); ?>

									<?php endwhile; ?>

									<?php // echo paginate_links(); ?>

									<?php if (get_next_posts_link() != '') :?>
									<div class="nav-previous left"><?php next_posts_link( '&larr; Older posts' ); ?></div>
									<?php endif; ?>
									<?php if (get_previous_posts_link() != '') :?>
									<div class="nav-next right"><?php previous_posts_link( 'Newer posts &rarr;' ); ?></div>
									<?php endif; ?>

								<?php else : ?>

								<article id="post-0" class="post no-results not-found">
									<h2>Nothing Found</h2>

									<p>I'm sorry, but no results were found. Perhaps searching will help find a related post.</p>

									<?php get_search_form(); ?>
									
								</article>

								<?php endif; ?>

							</div>
						</div>

					</div> <!-- close #content-body -->

					<?php comments_template(); ?>

<?php get_footer(); ?>
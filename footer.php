<?php /*

Readium Theme
-------------

footer.php

Footer template file	

*/

?>

				</div> <!-- close #wrapper -->
				
				<footer id="site-footer">
					<div class="grid">
						
						<?php get_sidebar('footer'); ?>

						<div class="g12 center">
							<div class="lined">
								<p>&copy; <?php echo date('Y'); ?> All rights reserved. | <a href="<?php echo site_url(); ?>">Home</a> | <a href="#top">Top</a></p>
							</div>
						</div>
					</div>
				</footer>
				
			</div> <!-- close #page -->
		</div> <!-- close #control -->

		<?php wp_footer(); ?>

	</body>
</html>
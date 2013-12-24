<?php /*

Readium Theme
-------------

sidebar-footer.php

Sidebar footer template file	

*/

?>

						<?php if (is_active_sidebar('footer-widgets')) : ?>
							<div id="footer-widgets" class="clearfix">

								<?php dynamic_sidebar('footer-widgets'); ?>
								
							</div>
						<?php endif; ?>

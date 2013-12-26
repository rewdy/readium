<?php /*

Readium Theme
-------------

sidebar-drawer.php

Sidebar drawer template file

*/

?>

					<?php if (is_active_sidebar('drawer-widgets')) : ?>

					<div id="drawer-widgets">
						<?php dynamic_sidebar('drawer-widgets'); ?>

					</div>
					<?php endif; ?>
					
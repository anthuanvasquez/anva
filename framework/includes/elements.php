<?php

/**
 * Get sidebars position
 */
function tm_sidebars( $position, $columns ) {
	?>
	<div class="sidebar-wrapper col-sm-<?php echo $columns; ?>">
		<?php get_sidebar( $position ); ?>
	</div><!-- .sidebar-wrapper (end) -->
	<?php
}
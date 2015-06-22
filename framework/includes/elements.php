<?php

function anva_display_sidebar( $id ) {
	if ( dynamic_sidebar( $id ) ) : endif;
}

/**
 * Get sidebars columns and location
 */
function anva_sidebars( $position, $columns ) {
	?>
	<div class="sidebar-wrapper col-sm-<?php echo esc_attr( $columns ); ?>">
		<?php get_sidebar( $position ); ?>
	</div><!-- .sidebar-wrapper (end) -->
	<?php
}
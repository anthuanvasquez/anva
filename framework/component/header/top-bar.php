<?php
/**
 * The default template used for top bar.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

$top_bar_color  = anva_get_option( 'top_bar_color' );
$top_bar_layout = anva_get_option( 'top_bar_layout' );

$class = '';
if ( 'dark' === $top_bar_color ) {
	$class = ' dark';
}
?>
<!-- Top Bar -->
<div id="top-bar" class="top-bar<?php echo esc_attr( $class ); ?>">
	<div class="container clearfix">

		<!-- Top Links -->
		<div class="col_half nobottommargin">
			<div class="top-links">
				<?php wp_nav_menu( anva_get_wp_nav_menu_args( 'top_bar' ) );  ?>
			</div><!-- .top-links (end) -->
		</div>

		<!-- Top Social -->
		<div class="col_half fright col_last nobottommargin">
			<div id="top-social" class="top-social">
				<ul>
					<?php
						$style    = '';
						$shape    = '';
						$border   = '';
						$size     = '';
						$position = 'top-bar';
						anva_social_icons( $style, $shape, $border, $size, $position );
					?>
				</ul>
			</div><!-- #top-social (end) -->
		</div>

	</div>
</div><!-- #top-bar (end) -->
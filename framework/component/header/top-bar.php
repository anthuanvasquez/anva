<?php
$top_bar_color  = anva_get_option( 'top_bar_color' );
$top_bar_layout = anva_get_option( 'top_bar_layout' );

$class = '';
if ( 'dark' == $top_bar_color ) {
	$class = 'class="dark"';
}
?>
<!-- Top Bar -->
<div id="top-bar"<?php echo $class; ?>>
	<div class="container clearfix">

		<!-- Top Links -->
		<div class="col_half nobottommargin">
			<div class="top-links">
				<?php wp_nav_menu( anva_get_wp_nav_menu_args( 'top_bar' ) );  ?>
			</div><!-- .top-links end -->
		</div>

		<!-- Top Social -->
		<div class="col_half fright col_last nobottommargin">
			<div id="top-social">
				<ul>
					<?php anva_social_icons( $style = '', $shape = '', $border = '', $size = '', $position = 'top-bar' ); ?>
				</ul>
			</div><!-- #top-social end -->
		</div>

	</div>
</div><!-- #top-bar end -->

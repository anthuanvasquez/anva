<?php
$class            = '';
$side_panel_color = anva_get_option( 'side_panel_color' );
if ( 'dark' == $side_panel_color ) {
	$class = ' class="dark"';
}

if ( 'custom' == $side_panel_color ) {
	$class = ' class="dark side-panel-has-custom"';
}
?>
<div class="body-overlay"></div>

<div id="side-panel"<?php echo $class; ?>>
	<div id="side-panel-trigger-close" class="side-panel-trigger">
		<a href="#">
			<i class="icon-line-cross"></i>
		</a>
	</div>

	<div class="side-panel-wrap">
		<?php anva_display_sidebar( 'side_panel_sidebar' ); ?>
	</div>
</div>

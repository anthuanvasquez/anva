<?php
$footer_copyright = anva_get_option( 'footer_copyright' );
$footer_copyright = anva_footer_copyright_helpers( $footer_copyright );
$display          = anva_get_option( 'footer_extra_display' );
?>
<div id="copyrights">
	<div class="container clearfix">
		<div class="col_half">
			<div class="copyright-text">
				<?php echo anva_kses( $footer_copyright ); ?>
			</div>
			<div class="copyright-links">
				<?php wp_nav_menu( anva_get_wp_nav_menu_args( 'footer' ) ); ?>
			</div>
		</div>

		<div class="col_half col_last tright">
			<div class="fright clearfix">
				<?php anva_social_icons( $style = '', $shape = '', $border = 'borderless', $size = 'small' ); ?>
			</div>

			<div class="clear"></div>

			<?php
			if ( $display ) :
				$text = anva_get_option( 'footer_extra_info' );
				$text = anva_extract_icon( $text );
				echo anva_kses( $text );
			endif;
			?>
		</div>
	</div>
</div><!-- #copyrights (end) -->

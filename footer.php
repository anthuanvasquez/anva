<?php
/**
 * The template for displaying the footer.
 *
 * @version 1.0.0
 */
				anva_below_layout();
				?>
				
			</div><!-- .container (end) -->
		</div><!-- .main-content (end) -->
	</section><!-- CONTENT (end) -->

	<?php anva_content_after(); ?>

	<?php
		$class = '';
		$footer_color = anva_get_option( 'footer_color', 'dark' );
		if ( $footer_color ) {
			$class = 'class="' . esc_attr( $footer_color ) . '"';
		}
	?>

	<?php anva_footer_above(); ?>

	<!--BOTTOM (start) -->
	<footer id="bottom" <?php echo $class; ?>>
		
		<div id="footer-content" class="container clearfix">
			<?php anva_footer_content(); ?>
		</div><!-- .footer-content (end) -->

		<div id="copyrights">
			<div class="container clearfix">
				<?php anva_footer_copyrights(); ?>
			</div>
		</div><!-- #copyrights (end) -->

	</footer><!-- BOTTOM (end) -->

	<?php
		anva_footer_below();	
		anva_bottom_after();
	?>

	</div><!-- CONTAINER (end) -->
</div><!-- WRAPPER (end) -->

<?php
	anva_after();
	wp_footer();
?>
</body>
</html>
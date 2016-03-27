<?php
/**
 * The template for displaying the footer.
 *
 * @version 1.0.0
 */
			do_action( 'anva_below_layout' );
		?>
		</div><!-- .content-wrap (end) -->
	</section><!-- CONTENT (end) -->

	<?php do_action( 'anva_content_after' ); ?>

	<?php
		$class = '';
		$footer_color = anva_get_option( 'footer_color', 'dark' );
		if ( $footer_color ) {
			$class = 'class="' . esc_attr( $footer_color ) . '"';
		}
	?>

	<?php do_action( 'anva_footer_above' ); ?>

	<!--FOOTER (start) -->
	<footer id="footer" <?php echo $class; ?>>
		
		<div class="container clearfix">
			<?php do_action( 'anva_footer_content' ); ?>
		</div><!-- .container (end) -->

		<div id="copyrights">
			<div class="container clearfix">
				<?php do_action( 'anva_footer_copyrights' ); ?>
			</div>
		</div><!-- #copyrights (end) -->

	</footer><!-- FOOTER (end) -->

	<?php do_action( 'anva_footer_below' ); ?>
	<?php do_action( 'anva_bottom_after' ); ?>

</div><!-- WRAPPER (end) -->

<?php do_action( 'anva_after' ); ?>
<?php wp_footer(); ?>

</body>
</html>
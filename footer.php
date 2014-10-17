	<?php tm_content_after(); ?>
	
	<footer id="footer" role="contentinfo">
		<div class="footer-inner">
			
			<div class="footer-content">
				<div class="footer-widget">
					<div class="grid-columns">
						<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : endif; ?>
					</div>
				</div>
			</div>

			<div class="footer-copyright">
				<?php do_action( 'tm_footer_text' ); ?>
			</div>

		</div>
	</footer><!-- #footer (end) -->

</div><!-- #container (end) -->

<?php wp_footer(); ?>

<?php tm_layout_after(); ?>

</body>
</html>
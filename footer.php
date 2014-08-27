	<?php tm_content_after(); ?>
	
	<footer id="footer" class="footer-container" role="contentinfo">
		<div class="site-footer">
			<div class="footer-inner">
				
				<div class="footer-content footer-widget">
					<div class="grid-columns row-fluid">
						<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : endif; ?>
					</div>
				</div>
				
				<div class="footer-sub-content">
					<?php do_action( 'tm_footer_text' ); ?>
				</div>

			</div>
		</div>
	</footer><!-- #footer (end) -->

</div><!-- #container (end) -->

<?php wp_footer(); ?>

<?php tm_layout_after(); ?>

</body>
</html>
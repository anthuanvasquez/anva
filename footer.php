		</div><!-- #content -->
	</div><!-- .content-container -->
	
	<footer id="footer" class="footer-container" role="contentinfo">
		<div class="site-footer">
			<div class="footer-inner">
				
				<div class="footer-content footer-widget">
					<div class="grid-columns row-fluid">
						<?php if ( ! dynamic_sidebar( 'footer-sidebar' ) ) : endif; ?>
					</div>
				</div>
				
				<div class="footer-sub-content">
					<p><strong><?php bloginfo( 'name' ); ?></strong>. &copy; <?php echo date('Y'); ?> <?php echo tm_get_local( 'footer_copyright' ); ?> <?php echo tm_get_local( 'footer_text' ); ?> <a href="<?php echo esc_url( 'http://3mentes.com/'); ?>">3mentes.</a></p>	
				</div>

			</div>
		</div>
	</footer><!-- .footer-container -->
</div><!-- #container -->

<?php wp_footer(); ?>

<?php tm_layout_after(); ?>

</body>
</html>
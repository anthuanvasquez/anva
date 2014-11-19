				<?php tm_content_after(); ?>
				
			</div><!-- .main-content (end) -->
		</div><!-- .main-inner (end) -->
	</div><!-- #main (end) -->
	
	<div id="bottom">
		<footer id="footer">
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
	</div><!-- #bottom (end) -->

</div><!-- #container (end) -->

<?php tm_layout_after(); ?>
<?php wp_footer(); ?>
</body>
</html>
<?php
/**
 * The template for displaying the footer.
 */

				anva_content_after();
				?>
				
			</div><!-- .main-content (end) -->
		</div><!-- .main-inner (end) -->
	</div><!-- MAIN (end) -->
	
	<!--BOTTOM (start) -->
	<div id="bottom">
		<footer id="footer">
			<div class="footer-inner">
				<div class="footer-content">
					<?php anva_footer_content(); ?>
				</div><!-- .footer-content (end) -->

				<div class="footer-copyright">
					<?php anva_footer_text(); ?>
				</div><!-- .footer-copyright (end) -->
			</div>
		</footer><!-- #footer (end) -->
	</div><!-- BOTTOM (end) -->

</div><!-- CONTAINER (end) -->

<?php anva_layout_after(); ?>
<?php wp_footer(); ?>
</body>
</html>
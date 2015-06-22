<?php
/**
 * The template for displaying the footer.
 */

				anva_below_layout();
				?>
				
			</div><!-- .container (end) -->
		</div><!-- .main-content (end) -->
	</section><!-- CONTENT (end) -->

	<?php anva_content_after(); ?>

	<?php anva_bottom_before(); ?>
	
	<!--BOTTOM (start) -->
	<div id="bottom">

		<?php anva_footer_above(); ?>
		
		<footer id="footer">
			<div class="container clearfix">
				<div class="footer-content">
					<?php anva_footer_content(); ?>
				</div><!-- .footer-content (end) -->
			</div>

			<div id="copyrights">
				<div class="container clearfix">
					<?php anva_footer_copyrights(); ?>
				</div>
			</div><!-- #copyrights (end) -->
		</footer><!-- #footer (end) -->

		<?php anva_footer_below(); ?>

	</div><!-- BOTTOM (end) -->
	
	<?php anva_bottom_after(); ?>

</div><!-- CONTAINER (end) -->
</div><!-- WRAPPER (end) -->

<?php anva_after(); ?>
<?php wp_footer(); ?>
</body>
</html>
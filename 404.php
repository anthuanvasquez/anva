<?php
/**
 * The template file for 404's.
 * 
 * @version 1.0.0
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-12">
		<div class="main">
			<?php get_template_part( 'content', '404' ); ?>
		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
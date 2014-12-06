<?php
/**
 * Template Name: Contact Us
 *
 * The template used for displaying page contact form
 */

get_header();
?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'content', 'page' ); ?>
			<div class="form-container">
				<?php echo anva_contact_form(); ?>
			</div>
		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
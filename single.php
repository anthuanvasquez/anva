<?php get_header(); ?>

<div class="row grid-columns">
	<div class="content-area col-sm-8">
		<div class="main" role="main">
		
		<?php tm_post_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php get_template_part( 'content', 'single' ); ?>
		
		<?php tm_post_after(); ?>

			<?php
				$single_comment = tm_get_option( 'single_comment' );
				if( 1 == $single_comment ) :
					if( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				endif;
			?>

		<?php endwhile; ?>

		</div><!-- .main (end) -->
	</div><!-- .content-area (end) -->
	
	<?php tm_sidebars( 'right', '4' ); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
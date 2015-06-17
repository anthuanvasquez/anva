<?php
/**
 * The template file for page.
 */

$classes = '';
$sidebar = anva_get_post_meta( '_sidebar_column' );

switch ( $sidebar ) {
	case 'left':
	case 'rght':
		$classes = 'col-sm-9';
		break;
	
	case 'double':
	case 'double_left':
	case 'double_right':
		$classes = 'col-sm-6';
		break;

	case 'fullwidth':
		$classes = 'col-sm-12';
		break;
	
	default:
		$classes = 'col-sm-9';
		break;
}

get_header();
?>

<div class="row grid-columns">

	<?php anva_sidebar_before(); ?>

	<div class="content-area <?php echo esc_attr( $classes ); ?>">
		<?php anva_content_post_before(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php
				$single_comment = anva_get_option( 'single_comment' );
				if ( 1 == $single_comment ) :
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				endif;
			?>

		<?php endwhile; ?>

		<?php anva_content_post_after(); ?>
	</div><!-- .content-area (end) -->
	
	<?php anva_sidebar_after(); ?>
	
</div><!-- .grid-columns (end) -->

<?php get_footer(); ?>
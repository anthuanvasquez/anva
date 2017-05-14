<?php

$style            = '';
$classes          = array();
$mini             = anva_get_post_meta( '_anva_page_title_mini' );
$tagline          = anva_get_post_meta( '_anva_page_tagline' );
$title_align      = anva_get_post_meta( '_anva_title_align' );
$title_bg         = anva_get_post_meta( '_anva_title_bg' );
$title_bg_color   = anva_get_post_meta( '_anva_title_bg_color' );
$title_bg_image   = anva_get_post_meta( '_anva_title_bg_image' );
$title_bg_cover   = anva_get_post_meta( '_anva_title_bg_cover' );
$title_bg_text    = anva_get_post_meta( '_anva_title_bg_text' );
$title_bg_padding = anva_get_post_meta( '_anva_title_bg_padding' );

// Remove title background.
if ( 'nobg' == $title_bg ) {
	$classes[] = 'page-title-nobg';
}

// Add dark background
if ( 'dark' == $title_bg || ( 'custom' == $title_bg && $title_bg_text && 'yes' != $mini ) ) {
	$classes[] = 'page-title-dark';
}

if ( 'yes' == $mini ) {
	$classes[] = 'page-title-mini';
}

// Add background color and parallax image
if ( 'custom' == $title_bg && 'yes' != $mini ) {
	$title_bg_padding = $title_bg_padding . 'px';

	$style .= 'padding:' . esc_attr( $title_bg_padding ) . ' 0;';
	$style .= 'background-color:' . esc_attr( $title_bg_color ) . ';';

	if ( ! empty( $title_bg_image ) ) {
		$classes[] = 'page-title-parallax';
		$style .= 'background-image:url("' . esc_url( $title_bg_image ) . '");';
	}

	if ( $title_bg_cover ) {
		$style .= '-webkit-background-size:cover;';
		$style .= '-moz-background-size:cover;';
		$style .= '-ms-background-size:cover;';
		$style .= 'background-size:cover;';
	}

	$style = "style='{$style}'";
}

// Align title to the right
if ( 'right' == $title_align ) {
	$classes[] = 'page-title-right';
}

// Title centered
if ( 'center' == $title_align ) {
	$classes[] = 'page-title-center';
}

$classes = implode( ' ', $classes );
$classes = 'class="' . esc_attr( $classes ) . '"';

?>
<section id="page-title" <?php echo $classes; ?> <?php echo $style; ?>>
	<div class="container clearfix">
		<h1>
			<?php anva_the_page_title(); ?>
		</h1>
		<?php
			if ( ! empty ( $tagline ) ) {
				printf( '<span>%s</span>', esc_html( $tagline ) );
			}

			// Get post types for top navigation.
			$post_types = array( 'portfolio', 'galleries' );
			$post_types = apply_filters( 'anva_post_types_top_navigation', $post_types );

			if ( is_singular( $post_types ) ) {
				/**
				 * Hooked.
				 *
				 * @see anva_post_type_navigation_default
				 */
				do_action( 'anva_post_type_navigation' );
			} else {
				/**
				 * Hooked.
				 *
				 * @see anva_breadcrumbs_default
				 */
				do_action( 'anva_breadcrumbs' );
			}
		?>
	</div>
</section><!-- #page-title (end) -->

<?php
/**
 * The template file for woocommerce plugin.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version     1.0.0
 * @author      Anthuan Vásquez
 * @copyright   Copyright (c) Anthuan Vásquez
 * @link        http://anthuanvasquez.net
 * @package     Anva WordPress Framework
 */
get_header();
?>

<div class="container clearfix">

	<?php get_sidebar( 'left' ); ?>

	<div class="<?php echo anva_get_column_class( 'content' ); ?>">
		<?php woocommerce_content(); ?>
	</div><!-- .postcontent (end) -->

	<?php get_sidebar( 'right' ); ?>
	
</div><!-- .container (end) -->

<?php get_footer(); ?>
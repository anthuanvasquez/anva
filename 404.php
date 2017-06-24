<?php
/**
 * The template for displaying 404 pages.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @link       https://anthuanvasquez.net
 *
 * @package    AnvaFramework
 * @subpackage Anva
 * @version    1.0.0
 * @since      1.0.0
 * @author     Anthuan Vasquez <me@anthuanvasquez.net>
 * @copyright  Copyright (c) 2017, Anthuan Vasquez
 */

// Do not allow directly accessing to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div class="container clearfix">
	<div class="col_full">
		<?php anva_get_template_part( 'page', 'content-404' ); ?>
	</div><!-- .col_full (end) -->
</div><!-- .container (end) -->

<?php get_footer();

<?php
/**
 * Template Name: Content Builder
 *
 * The template file used for displaying the content builder.
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

    <?php do_action( 'anva_posts_content_before' ); ?>

    <div class="custom-content-layout clearfix">
        <?php
            /**
             * hooked @see anva_elements
             */
            do_action( 'anva_content_builder' );
        ?>
    </div>

    <?php do_action( 'anva_posts_content_after' ); ?>

<?php get_footer(); ?>

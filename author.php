<?php
/**
 * The template file for author archives.
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

    <div class="<?php anva_column_class( 'content' ); ?>">

        <?php do_action( 'anva_posts_content_before' ); ?>

        <?php
            $author = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) );
        ?>

        <div class="author-wrap bottommargin-lg">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><span><a href="<?php echo esc_url( $author->user_url ); ?>"><?php echo $author->display_name; ?></a></span></h3>
                </div>
                <div class="panel-body">
                    <div class="author-image">
                        <?php echo get_avatar( $author->user_email, '300' ); ?>
                    </div>
                    <div class="author-description">
                        <?php echo wpautop( $author->description ); ?>
                    </div>
                </div>
            </div>
        </div>

        <div id="posts" class="<?php anva_post_class( 'archive' ); ?>">
            <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        anva_get_template_part( 'content' );
                    }
                    anva_num_pagination();
                } else {
                    anva_get_template_part( 'none' );
                }
            ?>
        </div><!-- #posts (end) -->

        <?php do_action( 'anva_posts_content_after' ); ?>

    </div><!-- .postcontent (end) -->

    <?php get_sidebar( 'right' ); ?>

</div><!-- .container (end) -->

<?php get_footer(); ?>

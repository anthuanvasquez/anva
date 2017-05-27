<?php
/**
 * The default template used for posts tags.
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

$tags = the_tags( '', ' ' );

if ( $tags ) :
?>
<div class="tagcloud-wrap">
	<?php
	$classes = 'tagcloud clearfix';

	if ( is_single() )
		$classes .= ' bottommargin';
	?>

	<div class="<?php echo esc_attr( $classes ); ?>">
		<?php echo $tags; ?>
	</div><!-- .tagcloud (end) -->
</div><!-- .tagcloud-wrap (end) -->
<?php
endif;

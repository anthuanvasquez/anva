<?php
/**
 * The default template used for 404's.
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
?>
<div class="entry-wrap">
	<article id="page-404" class="page page-404">
		<div class="entry-content">
			<?php echo wpautop( anva_get_local( '404_description' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- #page-404 (end) -->
</div><!-- .entry-wrap (end) -->
<div class="tagcloud-wrap">
	<?php
	$classes = 'tagcloud clearfix';

	if ( is_single() )
		$classes .= ' bottommargin';
	?>

	<div class="<?php echo esc_attr( $classes ); ?>">
		<?php the_tags( '', ' ' ); ?>
	</div><!-- .tagcloud (end) -->
</div><!-- .tagcloud-wrap (end) -->

<?php
$single_post_reading_bar = anva_get_option( 'single_post_reading_bar' );
if ( is_singular( 'post' ) && 'show' === $single_post_reading_bar ) :
?>
<div id="post-reading-wrap">
	<div class="post-reading-bar">
		<div class="post-reading-indicator-container">
			<span class="post-reading-indicator-bar"></span>
		</div>

		<div class="container clearfix">
			<div class="spost clearfix notopmargin nobottommargin">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php the_post_thumbnail( 'thumbnail' ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-c">
					<div class="post-reading-label">
						<?php _e( 'You Are Reading', 'anva' ); ?>
					</div>
					<div class="entry-title">
						<h4><?php the_title(); ?></h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- #post-reading-wrap (end) -->
<?php
endif;

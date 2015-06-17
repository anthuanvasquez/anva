<?php

/*
 * Display default header logo 
 */
function anva_header_logo_default() {
	$logo 	= anva_get_option('logo');
	$image 	= get_template_directory_uri() . '/assets/images/logo.png';
	$name 	= get_bloginfo( 'name' );
	?>
	<div id="brand">
		<?php
			printf(
				'<a id="logo" class="standard-logo" href="%3$s" title="<?php echo $name; ?>"><img src="%1$s" alt="%2$s" /><span class="sr-only">%2$s</span></a>',
				( empty( $logo ) ? esc_url( $image ) : esc_url( $logo ) ),
				$name,
				esc_url( home_url() )
			);
		?>
	</div><!-- #brand (end) -->
	<?php
}

/*
 * Display default main navigation
 */
function anva_main_navigation_default() {
	if ( has_nav_menu( 'primary' ) ) :
	$trigger = '<a href="#" id="primary-menu-trigger"><i class="fa fa-bars"></i></a>';
	?>
		<nav id="navigation" class="navigation clearfix" role="navigation">
			<?php
				wp_nav_menu( apply_filters( 'anva_main_navigation_default', array( 
					'theme_location'  => 'primary',
					'container'       => 'div',
					'container_class' => 'container clearfix',
					'container_id'    => 'primary-menu',
					'menu_class'      => 'navigation-menu sf-menu clearfix',
					'menu_id'         => '',
					'echo'            => true,
					'items_wrap'      => $trigger .'<ul id="%1$s" class="%2$s">%3$s</ul>' )
				));
			?>
		</nav><!-- #main-navigation (end) -->
	<?php else : ?>
		<div class="navigation-message well well-sm"><?php echo anva_get_local( 'menu_message' ); ?></div>
	<?php endif;
}

/*
 * Display social media icons
 */
function anva_social_icons() {
	$size  = 'social-small';
	$style = 'social-colored';
	printf(
		'<ul class="social-media top-social-media">%1$s</ul>',
		anva_social_media( $size, $style )
	);
}

/*
 * Print favion and apple touch icons in head
 */
function anva_apple_touch_icon() {
	$image_path = get_template_directory_uri() . '/assets/images';
	?>
	<!-- ICONS (start) -->
	<link rel="shortcut icon" href="<?php echo $image_path . '/favicon.png'; ?>" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $image_path . '/apple-touch-icon-76x76.png'; ?>" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $image_path . '/apple-touch-icon-120x120.png'; ?>" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?php echo $image_path . '/apple-touch-icon-152x152.png'; ?>" />
	<!-- ICONS (end) -->
	<?php
}

/*
 * Print meta viewport
 */
function anva_viewport() {
	if ( 1 == anva_get_option( 'responsive' ) ) :
	?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	endif;
}

/*
 * Print custom css styles in head
 */
function anva_custom_css() {
	$styles = '';
	$custom_css = anva_get_option( 'custom_css' );
	$custom_css = anva_compress( $custom_css );
	if ( ! empty( $custom_css ) ) {
		$styles = '<style type="text/css">' . $custom_css . '</style>';
	}
	echo $styles; 
}

/*
 * Display footer widgets
 */
function anva_footer_content_default() {
	?>
	<div class="footer-widget">
		<div class="grid-columns">
			<?php if ( ! dynamic_sidebar( 'footer' ) ) : endif; ?>
		</div>
	</div>
	<?php
}

/*
 * Display default footer text copyright
 */
function anva_footer_copyrights_default() {
	printf(
		'<p>&copy; %1$s <strong>%2$s</strong> %3$s %4$s %5$s. <a id="gotop" href="#"><i class="fa fa-chevron-up"></i></a></p>',
		anva_get_current_year( apply_filters( 'anva_footer_year', date( 'Y' ) ) ),
		get_bloginfo( 'name' ),
		anva_get_local( 'footer_copyright' ),
		apply_filters( 'anva_footer_credits', anva_get_local( 'footer_text' ) ),
		apply_filters( 'anva_footer_author', '<a href="'. esc_url( 'http://anthuanvasquez.net/') .'">Anthuan Vasquez</a>' )
	);
}

function anva_addon() {
	?>	
	<div id="addon">
		<div class="container clearfix">
			<div class="addon-content">
				<?php anva_header_addon(); ?>
			</div>
		</div>
	</div><!-- #addon (end) -->
	<?php
}

function anva_featured_default() {
	if ( is_front_page() ) :
	?>
	<!-- FEATURED (start) -->
	<div id="featured">
		<div class="featured-inner">
			<?php
				if ( function_exists( 'anva_slideshows_featured' ) ) {
					echo anva_slideshows_featured( 'homepage' );
				}
			?>
		</div><!-- .featured-inner (end) -->
	</div><!-- FEATURED (end) -->
	<?php
	endif;
}

/*
 * Display breadcrumbs
 */
function anva_breadcrumbs_default() {
	$single_breadcrumb = anva_get_option( 'single_breadcrumb' );
	if ( 1 == $single_breadcrumb ) {
		if ( function_exists( 'yoast_breadcrumb' ) && ! is_front_page() && ! is_home() ) {
			?>
			<div id="breadcrumbs">
				<div class="container clearfix">
					<div class="breadcrumbs-content">
						<?php yoast_breadcrumb( '<p>', '</p>' ); ?>
					</div><!-- breadcrumbs-content (end) -->
				</div><!-- breadcrumbs-inner (end) -->
			</div><!-- #breadcrumbs (end) -->
			<?php
		}
	}
}

/*
 * Wrapper main content start
 */
function anva_above_layout_default() {
	?>
	<div id="sidebar-layout">
	<?php
}

/*
 * Wrapper main content end
 */
function anva_below_layout_default() {
	?>
	</div><!-- #sidebar-layout (end) -->
	<?php
}

/*
 * Display sidebars location before
 */
function anva_sidebar_before_default() {
	if ( is_page() || is_single() ) {
		
		$sidebars = anva_get_post_meta( '_sidebar_column' );
		$position = 'left';
		$columns  = 3;

		switch ( $sidebars ) {
			case 'left':
				anva_sidebars( $position, $columns );
				break;
			case 'double':
				anva_sidebars( $position, $columns );
				break;
			case 'double_left':
				anva_sidebars( $position, $columns );
				anva_sidebars( 'right', $columns );
				break;
		}
	}
}

/*
 * Display sidebars location after
 */
function anva_sidebar_after_default() {
	if ( is_page() ) {
		
		$sidebars  = anva_get_post_meta( '_sidebar_column' );
		$position = 'right';
		$columns  = 3;

		switch ( $sidebars ) {
			case 'right':
				anva_sidebars( $position, $columns );
				break;
			case 'double':
				anva_sidebars( $position, $columns );
				break;
			case 'double_right':
				anva_sidebars( 'left', $columns );
				anva_sidebars( $position, $columns );
				break;
		}
	}
}

function anva_off_canvas_navigation() {
	if ( 'off_canvas_navigation' == anva_get_option( 'navigation' ) ) :
	?>
	<a href="#" id="off-canvas-trigger">
		<i class="fa fa-bars"></i>
	</a>
	<!-- OFF-CANVAS (start) -->
	<div id="off-canvas">	
		<div  class="off-canvas-inner">
			<div class="off-canvas-content off-canvas-left">
				<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu( array( 
							'theme_location'  => 'primary',
							'container'       => 'div',
							'container_class' => 'off-canvas-navigation',
							'container_id'    => '',
							'menu_class'      => 'off-canvas-menu sf-menu',
							'menu_id'         => '',
							'echo'            => true,
							'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>' )
						);
					}
				?>
			</div>
		</div>
	</div><!-- OFF-CANVAS (end) -->
	<?php
	endif;
}

/*
 * Display debug information if WP_DEBUG is enabled
 * and current user is an adminsitrator 
 */
function anva_debug_info() {
	if ( true == WP_DEBUG && current_user_can( 'administrator' ) ) :
	?>
		<div class="container clearfix">
			<div class="debug-info alert alert-info topmargin bottommargin">
				<ul class="resetlist">
					<li><strong>Debug Info</strong></li>
					<li><span>Queries:</span> Page generated in <?php timer_stop(1); ?> seconds with <?php echo get_num_queries(); ?> database queries.</li>
					<li><span>Theme Name:</span> <?php echo anva_get_theme( 'name' ); ?></li>
					<li><span>Theme Version:</span> <?php echo anva_get_theme( 'version' ); ?></li>
					<li><span>Theme Author:</span> <?php echo anva_get_theme( 'author' ); ?></li>
				</ul>
			</div>
		</div>
	<?php
	endif;
}
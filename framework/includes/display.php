<?php

/*
 * Print favion and apple touch icons in head
 */
function anva_head_apple_touch_icon() {
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
function anva_head_viewport() {
	if ( 1 == anva_get_option( 'responsive' ) ) :
	?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	endif;
}

/*
 * Print custom css styles in head
 */
function anva_head_custom_css() {
	$styles = '';
	$custom_css = anva_get_option( 'custom_css' );
	$custom_css = anva_compress( $custom_css );
	if ( ! empty( $custom_css ) ) {
		$styles = '<style type="text/css">' . $custom_css . '</style>';
	}
	echo $styles; 
}

/*
 * Top Bar
 */
function anva_top_bar_default() {
	?>	
	<div id="top-bar">
		<div class="container clearfix">
			<div class="grid_6">
				<div id="top-links">
					<?php anva_header_secondary_menu(); ?>
				</div>
			</div>
			<div class="grid_6 grid_last fright nobottommargin">
				<div id="top-social">
					<?php 
						$size  	= '';
						$color 	= '';
						$style 	= 'social-noborder';
						echo anva_social_icons( $size, $color, $style ); ?>
				</div>
			</div>
		</div>
	</div><!-- #addon (end) -->
	<?php
}

/*
 * Display default header logo 
 */
function anva_header_logo_default() {
	$default_logo = get_template_directory_uri() . '/assets/images/logo.png';
	$logo 				= anva_get_option('logo');
	$name 				= get_bloginfo( 'name' );
	?>
	<div id="logo">
		<?php
			printf(
				'<a href="%3$s" class="standard-logo"><img src="%1$s" alt="%2$s" /></a>',
				( empty( $logo ) ? esc_url( $default_logo ) : esc_url( $logo ) ),
				$name,
				esc_url( home_url() )
			);
		?>
	</div><!-- #logo (end) -->
	<?php
}

/*
 * Display default extra header information
 */
function anva_header_extras_default() {
	?>	
	<ul id="header-extras" class="header-extras">
		<li>
			<i class="fa fa-envelope"></i>
			<div class="text">
				Drop an Email
				<span>info@canvas.com</span>
			</div>
		</li>
		<li id="header-search">
			<?php anva_site_search(); ?>
		</li>
	</ul><!-- #header-extras (end) -->
	<?php
}

/*
 * Display default main navigation
 */
function anva_header_primary_menu_default() {
	if ( has_nav_menu( 'primary' ) ) :
	$trigger = '<a href="#" id="primary-menu-trigger"><i class="fa fa-bars"></i></a>';
	?>
		<nav id="primary-menu" role="navigation">
			<div class="container cleafix">
				<?php
					wp_nav_menu( apply_filters( 'anva_main_navigation_default', array( 
						'theme_location'  => 'primary',
						'container'       => '',
						'container_class' => '',
						'container_id'    => '',
						'menu_class'      => 'sf-menu clearfix',
						'menu_id'         => '',
						'echo'            => true,
						'items_wrap'      => $trigger .'<ul id="%1$s" class="%2$s">%3$s</ul>' )
					));

					anva_header_primary_menu_addon();
				?>
			</div>
		</nav><!-- #main-navigation (end) -->
	<?php else : ?>
		<div class="container clearfix">
			<div class="navigation-message well well-sm"><?php echo anva_get_local( 'menu_message' ); ?></div>
		</div>
	<?php endif;
}

/*
 * Display default menu addons
 */
function anva_header_primary_menu_addon_default() {
	?>	
	<ul id="header-menu-addon">
		<li>
			<div id="top-search">
				<a href="#" id="top-search-trigger">
					<i class="fa fa-search"></i>
				</a>
			</div>
		</li>
		<li>
			<div id="top-cart">
				<a href="#" id="top-cart-trigger">
					<i class="fa fa-shopping-cart"></i>
					<span class="badge">0</span>
				</a>
			</div>
		</li>
		<li>
			<div id="top-lang">
				<a href="#" id="top-lang-trigger">
					<i class="fa fa-flag"></i>
				</a>
			</div>
		</li>
	</ul><!-- #menu-addon (end) -->
	<?php
}

/*
 * Display footer widgets
 */
function anva_footer_content_default() {
	?>
	<div class="sidebar sidebar-footer footer-widget">
		<div class="sidebar-inner clearfix">
			<?php anva_display_sidebar( 'footer' ); ?>
		</div>
	</div>
	<?php
}

/*
 * Display default footer text copyright
 */
function anva_footer_copyrights_default() {
	printf(
		'<div class="grid_6">&copy; %1$s <strong>%2$s</strong> %3$s %4$s %5$s. <a id="gotop" href="#" class="gotop gotop-md"><i class="fa fa-chevron-up"></i></a></div>',
		anva_get_current_year( apply_filters( 'anva_footer_year', date( 'Y' ) ) ),
		get_bloginfo( 'name' ),
		anva_get_local( 'footer_copyright' ),
		apply_filters( 'anva_footer_credits', anva_get_local( 'footer_text' ) ),
		apply_filters( 'anva_footer_author', '<a href="'. esc_url( 'http://anthuanvasquez.net/') .'">Anthuan Vasquez</a>' )
	);
}

/*
 * Display default featured slider
 */
function anva_featured_default() {
	if ( anva_supports( 'featured', 'front' ) ) {
		$slideshows = anva_get_slideshows();
		if ( function_exists( 'anva_put_slideshows' ) && isset( $slideshows['main'] ) ) {
			echo anva_put_slideshows( 'main' );
		}
	}
}

function anva_featured_before_default() {
	?>
		<!-- FEATURED (start) -->
		<div id="featured">
			<div class="featured-content">
				<div class="container clearfix">
	<?php
}

function anva_featured_after_default() {
	?>
			</div><!-- .container (end) -->
		</div><!-- .featured-content (end) -->
	</div><!-- FEATURED (end) -->
	<?php
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
 * Display sidebars location after
 */
function anva_fixed_sidebars( $position ) {

	$layout = anva_get_field( 'sidebar_layout' );
	
	// Set default layout
	if ( ! is_page() && ! is_single() ) {
		$layout = 'right';
	}

	// Sidebar Left, Sidebar Right, Double Sidebars
	if ( $layout == $position || $layout == 'double' ) {

		do_action( 'anva_fixed_sidebar_before', $position  );
		anva_display_sidebar( 'sidebar_'. $position );
		do_action( 'anva_fixed_sidebar_after', $position );

	}

	// Double Left Sidebars
	if ( $layout == 'double_left' && $position == 'left' ) {

		// Left Sidebar
		do_action( 'anva_fixed_sidebar_before', 'left'  );
		anva_display_sidebar( 'sidebar_left' );
		do_action( 'anva_fixed_sidebar_after', 'left' );

		// Right Sidebar
		do_action( 'anva_fixed_sidebar_before', 'right'  );
		anva_display_sidebar( 'sidebar_right' );
		do_action( 'anva_fixed_sidebar_after', 'right' );

	}

	// Double Right Sidebars
	if ( $layout == 'double_right' && $position == 'right' ) {

		// Left Sidebar
		do_action( 'anva_fixed_sidebar_before', 'left'  );
		anva_display_sidebar( 'sidebar_left' );
		do_action( 'anva_fixed_sidebar_after', 'left' );

		// Right Sidebar
		do_action( 'anva_fixed_sidebar_before', 'right'  );
		anva_display_sidebar( 'sidebar_right' );
		do_action( 'anva_fixed_sidebar_after', 'right' );

	}
}

function anva_fixed_sidebar_before_default( $side ) {
	?>
	<div class="sidebar sidebar-<?php echo esc_attr( $side ) .' '. esc_attr( anva_get_column_class( $side ) ); ?>">
	<div class="sidebar-inner">
	<?php
}

function anva_fixed_sidebar_after_default() {
	?>
	</div><!-- .sidebar-inner (end) -->
	</div><!-- .sidebar (end) -->
	<?php
}

function anva_side_menu() {
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

function anva_sidebar_above_header() {
	?>
	<div class="sidebar sidebar-above-header">
		<div class="sidebar-inner">
			<div class="container clearfix">
				<?php anva_display_sidebar( 'above_header' ); ?>
			</div>
		</div>
	</div><!-- .sidebar (end) -->
	<?php
}

function anva_sidebar_above_content() {
	?>
	<div class="sidebar sidebar-above-content">
		<div class="sidebar-inner clearfix">
			<?php anva_display_sidebar( 'above_content' ); ?>
		</div>
	</div><!-- .sidebar (end) -->
	<?php
}

function anva_sidebar_below_content() {
	?>
	<div class="sidebar sidebar-below-content">
		<div class="sidebar-inner clearfix">
			<?php anva_display_sidebar( 'below_content' ); ?>
		</div>
	</div><!-- .sidebar (end) -->
	<?php
}

function anva_posts_meta_default() {
	$single_meta = anva_get_option( 'single_meta' );
	if ( 1 == $single_meta ) {
		anva_posted_on();
	}
}

/*
 * Display debug information if WP_DEBUG is enabled
 * and current user is an adminsitrator 
 */
function anva_debug_info() {
	if ( true == WP_DEBUG ) :
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
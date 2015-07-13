<?php

/*
 * Print favion and apple touch icons in head
 */
function anva_head_apple_touch_icon() {
	
	$html  		= '';
	$sizes 		= '';
	$favicon 	= anva_get_option( 'favicon' );
	$image 		= get_template_directory_uri() . '/assets/images';
	
	if ( ! $favicon ) {
		$favicon = $image . '/favicon.png';
	}

	$links[] = array(
		'rel' => 'shortcut icon',
		'image' => $favicon,
		'size' => '',
	);

	$links[] = array(
		'rel' => 'apple-touch-icon',
		'image' => $image . '/apple-touch-icon-76x76.png',
		'size' => '76x76',
	);

	$links[] = array(
		'rel' => 'apple-touch-icon',
		'image' => $image . '/apple-touch-icon-120x120.png',
		'size' => '120x120',
	);

	$links[] = array(
		'rel' => 'apple-touch-icon',
		'image' => $image . '/apple-touch-icon-152x152.png',
		'size' => '152x152',
	);

	foreach ( $links as $key => $value ) {
		if ( isset( $value['size'] ) && ! empty( $value['size'] ) )
			$sizes = ' sizes="'. esc_attr( $value['size'] ) .'" ';

		$html .= '<link rel="'. esc_attr( $value['rel'] ) .'"'. $sizes .'href="'. esc_attr( $value['image'] ) .'" />';
	}

	echo $html;
}

/*
 * Print meta viewport
 */
function anva_head_viewport() {
	if ( 'yes' == anva_get_option( 'responsive' ) ) {
		echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
	}
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
					<?php echo anva_social_media(); ?>
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
	
	$option 	= anva_get_option( 'logo' );
	$classes 	= 'logo-'. $option['type'];
	$name 		= get_bloginfo( 'name' );
	
	if ( $option['type'] == 'custom' || $option['type'] == 'title' || $option['type'] == 'title_tagline' ) {
		$classes .= ' logo-text';
	}

	if ( $option['type'] == 'custom' && ! empty( $option['custom_tagline'] ) ) {
		$classes .= ' logo-has-tagline';
	}

	if ( $option['type'] == 'title_tagline' ) {
		$classes .= ' logo-has-tagline';
	}

	echo '<div id="logo" class="'. esc_attr( $classes ) .'">';
	if ( ! empty( $option['type'] ) ) {
		switch ( $option['type'] ) {

			case 'title' :
				echo '<h1 class="text-logo"><a href="'. home_url() .'">'. $name .'</a></h1>';
				break;

			case 'title_tagline' :
				echo '<h1 class="text-logo"><a href="'. home_url() .'">'. $name .'</a></h1>';
				echo '<span class="logo-tagline">'. get_bloginfo('description') .'</span>';
				break;

			case 'custom' :
				echo '<h1 class="text-logo"><a href="'. home_url() .'">'. $option['custom'] .'</a></h1>';
				if ( $option['custom_tagline'] ) {
					echo '<span class="logo-tagline">'. $option['custom_tagline'] .'</span>';
				}
				break;

			case 'image' :
				$image_1x = $option['image'];
				$image_2x = '';

				if ( ! empty( $option['image_2x'] ) ) {
					$image_2x = $option['image_2x'];
				}

				echo '<a href="'. home_url() .'"><img src="'. $image_1x .'" alt="'. $name .'" data-image-2x="'. $image_2x .'" /></a>';
				break;
		}
	}
	echo '</div><!-- .#logo (end) -->';
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
				Drop an Email <span>info@anvas.com</span>
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
						'walker' 			=> new tg_walker(),
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
	<div class="footer-widgets grid-columns">
		<?php anva_display_footer_sidebar_locations(); ?>
	</div>
	<?php
}

/*
 * Display default footer text copyright
 */
function anva_footer_copyrights_default() {
	$footer_copyright = anva_get_option( 'footer_copyright' );
	$html  = '';
	$html .= '<div class="grid_6">';

	if ( $footer_copyright || ! empty( $footer_copyright ) ) {
		$html .= sprintf( $footer_copyright );
	} else {
		$html .= sprintf( 'Copyright %1$s <strong>%2$s</strong> %3$s %4$s.', '2015', get_bloginfo( 'name' ), __( 'Designed by', anva_textdomain() ), __( '<a href="'. esc_url( 'http://anthuanvasquez.net/' ) .'">Anthuan Vasquez</a>', anva_textdomain() ) );
	}

	$html .= '<a id="gotop" href="#" class="gotop gotop-md"><i class="fa fa-chevron-up"></i></a>';
	$html .= '</div>';

	echo $html;
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
	$breadcrumbs = anva_get_option( 'breadcrumbs' );
	if ( 'show' == $breadcrumbs ) {
		?>
		<div id="breadcrumbs">
			<div class="breadcrumbs-content">
				<div class="container clearfix">
					<?php anva_get_breadcrumbs(); ?>
				</div><!-- .container (end) -->
			</div><!-- .breadcrumbs-content (end) -->
		</div><!-- #breadcrumbs (end) -->
		<?php
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
	if ( ! is_page() && ! is_single() || empty( $layout ) ) {
		$layout = anva_get_option( 'sidebar_layout', 'right' );
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
	<div class="above-header">
		<div class="ad-widget ad-widget-above-header">
			<div class="container clearfix">
				<?php anva_display_sidebar( 'above_header' ); ?>
			</div>
		</div>
	</div><!-- .above-header (end) -->
	<?php
}

function anva_sidebar_above_content() {
	?>
	<div class="above-content">
		<div class="ad-widget ad-widget-above-content clearfix">
			<?php anva_display_sidebar( 'above_content' ); ?>
		</div>
	</div><!-- .above-content (end) -->
	<?php
}

function anva_sidebar_below_content() {
	?>
	<div class="below-content">
		<div class="ad-widget ad-widget-below-content clearfix">
			<?php anva_display_sidebar( 'below_content' ); ?>
		</div>
	</div><!-- .below-content (end) -->
	<?php
}

function anva_sidebar_below_footer() {
	?>
	<div class="below-footer">
		<div class="ad-widget ad-widget-below-footer">
			<div class="container clearfix">
				<?php anva_display_sidebar( 'below_footer' ); ?>
			</div>
		</div>
	</div><!-- .below-footer (end) -->
	<?php
}

function anva_posts_meta_default() {
	if ( is_single() ) {
		if ( 'show' == anva_get_option( 'single_meta', 'show' ) ) {
			anva_posted_on();
		}
	} else {
		if ( 'show' == anva_get_option( 'prmary_meta', 'show' ) ) {
			anva_posted_on();
		}
	}
}

function anva_posts_content_default() {
	$primary_content = anva_get_option( 'primary_content', 'excerpt' );
	if ( 'excerpt' == $primary_content ) {
		anva_excerpt();
		echo '<a class="button button-mini" href="'. get_the_permalink() .'">'. anva_get_local( 'read_more' ) .'</a>';
	} else {
		the_content( anva_get_local( 'read_more' ) );
	}
}

if ( ! function_exists( 'anva_posts_comments_default' ) ) :
/*
 * Default comments
 */
function anva_posts_comments_default() {
	$single_comments = anva_get_option( 'single_comments', 'show' );
	if ( 'show' == $single_comments ) {
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template();
		}
	}
}
endif;

/*
 * Display debug information if WP_DEBUG is enabled
 * and current user is an adminsitrator 
 */
function anva_debug_info() {
	if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG ) :
	?>
		<div class="container clearfix">
			<div class="debug-info alert alert-info topmargin bottommargin">
				<ul class="resetlist">
					<li><strong>Debug Info</strong></li>
					<li><span>Queries:</span> Page generated in <?php timer_stop(1); ?> seconds with <?php echo get_num_queries(); ?> database queries.</li>
					<li><span>Theme Name:</span> <?php echo anva_get_theme( 'name' ); ?></li>
					<li><span>Theme Version:</span> <?php echo anva_get_theme( 'version' ); ?></li>
					<li><span>Framework Name:</span> <?php echo ANVA_FRAMEWORK_NAME; ?></li>
					<li><span>Framework Version:</span> <?php echo ANVA_FRAMEWORK_VERSION; ?></li>
				</ul>
			</div>
		</div>
	<?php
	endif;
}
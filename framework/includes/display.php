<?php

/*-----------------------------------------------------------------------------------*/
/* Display Functions
/*-----------------------------------------------------------------------------------*/

/**
 * Print favicon and apple touch icons in head.
 * 
 * @since 1.0.0
 */
function anva_head_apple_touch_icon() {
	
	$html  			= '';
	$sizes 			= '';
	$links 			= array();
	$favicon 		= anva_get_option( 'favicon' );
	$touch_icon		= anva_get_option( 'apple_touch_icon' );
	$touch_icon76	= anva_get_option( 'apple_touch_icon_76' );
	$touch_icon120	= anva_get_option( 'apple_touch_icon_120' );
	$touch_icon152	= anva_get_option( 'apple_touch_icon_152' );

	if ( $favicon ) {
		$links[] = array(
			'rel' => 'shortcut icon',
			'image' => $favicon,
			'size' => '16x16',
		);
	}

	if ( $touch_icon ) {
		$links[] = array(
			'rel' => 'apple-touch-icon',
			'image' => $touch_icon
		);
	}

	if ( $touch_icon76 ) {
		$links[] = array(
			'rel' => 'apple-touch-icon',
			'image' => $touch_icon76,
			'size' => '76x76',
		);
	}

	if ( $touch_icon120 ) {
		$links[] = array(
			'rel' => 'apple-touch-icon',
			'image' => $touch_icon120,
			'size' => '120x120',
		);
	}

	if ( $touch_icon152 ) {
		$links[] = array(
			'rel' => 'apple-touch-icon',
			'image' => $touch_icon152,
			'size' => '152x152',
		);
	}

	if ( $links ) {
		foreach ( $links as $link_id => $link ) {
			if ( isset( $link['size'] ) ) {
				$sizes = ' sizes="' . esc_attr( $link['size'] ) . '" ';
			}
			
			if ( isset( $link['image'] ) ) {
				$html .= '<link rel="' . esc_attr( $link['rel'] ) . '"' . $sizes . 'href="' . esc_url( $link['image'] ) . '" />';
				$sizes = ''; // Reset sizes
			}
		}
	}

	echo $html;
}

/**
 * Print meta viewport.
 * 
 * @since 1.0.0
 */
function anva_head_viewport() {
	if ( 'yes' == anva_get_option( 'responsive' ) ) :
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php
	endif;
}

/**
 * Top bar.
 * 
 * @since 1.0.0
 */
function anva_top_bar_default() {
	?>
	<!-- Top Bar -->
	<div id="top-bar">
		<div class="container clearfix">
			<div class="col_half nobottommargin">
				<!-- Top Links -->
				<div class="top-links">
					<?php do_action( 'anva_header_secondary_menu' ); ?>
				</div><!-- .top-links end -->
			</div>

			<div class="col_half fright col_last nobottommargin">

				<!-- Top Social -->
				<div id="top-social">
					<ul>
						<?php anva_social_icons( $style = '', $shape = '', $border = '', $size = '', $position = 'top-bar' ); ?>
					</ul>
				</div><!-- #top-social end -->
			</div>
		</div>
	</div><!-- #top-bar end -->
	<?php
}

function anva_secondary_menu_default() {
	wp_nav_menu( apply_filters( 'anva_secondary_menu_default', array(
		'theme_location'  => 'secondary',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => true,
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
	) ) );
}

/**
 * Display default header custom logo.
 * 
 * @since 1.0.0
 */
function anva_header_logo_default() {
	
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );
	$option             = anva_get_option( 'custom_logo' );
	$name               = get_bloginfo( 'name' );
	$classes            = array();
	$classes[]          = 'logo-' . $option['type'];
	
	if ( $option['type'] == 'custom' || $option['type'] == 'title' || $option['type'] == 'title_tagline' ) {
		$classes[] = 'logo-text';
	}

	if ( $option['type'] == 'custom' && ! empty( $option['custom_tagline'] ) ) {
		$classes[] = 'logo-has-tagline';
	}

	if ( $option['type'] == 'title_tagline' ) {
		$classes[] = 'logo-has-tagline';
	}

	if ( $option['type'] == 'image' ) {
		$classes[] = 'logo-has-image';
	}

	if ( $primary_menu_style == 'style_9' ) {
		$classes[] = 'divcenter';
	}

	$classes = implode( ' ', $classes );

	echo '<div id="logo" class="' . esc_attr( $classes ) . '">';
	
	if ( ! empty( $option['type'] ) ) {
		switch ( $option['type'] ) {

			case 'title' :
				echo '<div class="text-logo"><a href="' . home_url() . '">' . $name . '</a></div>';
				break;

			case 'title_tagline' :
				echo '<div class="text-logo"><a href="' . home_url() . '">' . $name . '</a></div>';
				echo '<span class="logo-tagline">' . get_bloginfo( 'description' ) . '</span>';
				break;

			case 'custom' :
				echo '<div class="text-logo"><a href="' . home_url() . '">' . $option['custom'] . '</a></div>';
				if ( $option['custom_tagline'] ) {
					echo '<span class="logo-tagline">' . $option['custom_tagline'] . '</span>';
				}
				break;

			case 'image' :
				$image_1x  = esc_url( $option['image'] );
				$image_2x  = '';
				$logo_2x   = '';
				$logo_alt  = '';
				$image_alt = '';
				$class     = '';

				if ( $primary_menu_style == 'style_9' ) {
					$class = 'class="divcenter"';
				}

				if ( ! empty( $option['image_2x'] ) ) {
					$image_2x = $option['image_2x'];
					$logo_2x = '<a class="retina-logo" href="' . home_url() . '"><img ' . $class . ' src="' . esc_url( $image_2x ) . '" alt="' . esc_attr( $name ) . '" /></a>';
				}

				if ( ! empty( $option['image_alternate'] ) ) {
					$image_alt = $option['image_alternate'];
					$logo_alt  = 'data-sticky-logo="' . esc_url( $image_alt ) . '"';
					$logo_alt .= 'data-mobile-logo="' . esc_url( $image_alt ) . '"';
				}

				echo '<a class="standard-logo" href="' . home_url() . '"' . $logo_alt . '><img ' . $class . ' src="' . esc_url( $image_1x ) . '" alt="' . esc_attr( $name ) . '" /></a>';
				echo $logo_2x;
				break;
		}
	}
	echo '</div><!-- #logo (end) -->';
}

function anva_header() {
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );

	switch ( $primary_menu_style ) :
		case 'style_7':
		case 'style_9':
			?>
			<div class="container clearfix">
				<?php do_action( 'anva_header_logo' ); ?>
				<?php do_action( 'anva_header_extras' ); ?>
			</div><!-- .container (end) -->
			<div id="header-wrap">
				<?php do_action( 'anva_header_primary_menu' ); ?>
			</div><!-- .header-wrap (end) -->
			<?php
			break;
		
		default:
			?>
			<div id="header-wrap">
				<div class="container clearfix">
					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
					<?php do_action( 'anva_header_logo' ); ?>
					<?php do_action( 'anva_header_extras' ); ?>
					<?php do_action( 'anva_header_primary_menu' ); ?>
				</div>
			</div><!-- .header-wrap (end) -->
			<?php
			break;
	endswitch;
}

/**
 * Display default extra header information.
 * 
 * @since 1.0.0
 */
function anva_header_extras_default() {
	$primary_menu_style = anva_get_option( 'primary_menu_style' );
	$header_extras      = anva_get_option( 'header_extras' );
	if ( 'show' != $header_extras || 'style_7' != $primary_menu_style ) {
		return;
	}
	?>	
	<ul class="header-extras">
		<li>
			<i class="i-plain icon-email3 nomargin"></i>
			<div class="he-text">Drop an Email <span>info@anvas.com</span></div>
		</li>
		<li id="header-search">
			<i class="i-plain icon-call nomargin"></i>
			<div class="he-text">Get in Touch <span>1800-1144-551</span></div>
		</li>
	</ul><!-- #header-extras (end) -->
	<?php
}

/**
 * Display default main navigation
 * 
 * @since 1.0.0
 */
function anva_header_primary_menu_default() {
	if ( has_nav_menu( 'primary' ) ) :
		$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' ); ?>
		<nav id="primary-menu" <?php anva_primary_menu_class(); ?>>

			<?php if ( 'style_7' == $primary_menu_style || 'style_9' == $primary_menu_style ) : ?>
				<div class="container clearfix">
					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
			<?php endif; ?>

			<?php
				wp_nav_menu( apply_filters( 'anva_primary_menu_default', array(
					'theme_location'  => 'primary',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
				) ) );
				do_action( 'anva_header_primary_menu_addon' );
			?>

			<?php if ( 'style_7' == $primary_menu_style || 'style_9' == $primary_menu_style ) : ?>
				</div><!-- .container (end) -->
			<?php endif; ?>

		</nav><!-- #primary-menu (end) -->
		
		<?php
		// Show social icons in side header
		$side_header_icons = anva_get_option( 'side_header_icons' );
		$header_type = anva_get_header_type();
		if (  'side' == $header_type && $side_header_icons ) : ?>
			<div class="clearfix visible-md visible-lg">
				<?php anva_social_icons( $style = '', $shape = '', $border = 'borderless', $size = 'small' ); ?>
			</div>
		<?php endif; ?>

	<?php else : ?>
		<div class="container clearfix">
			<div class="navigation-message well well-sm"><?php echo anva_get_local( 'menu_message' ); ?></div>
		</div>
	<?php endif;
}

/**
 * Display default menu addons
 * 
 * @since 1.0.0
 */
function anva_header_primary_menu_addon_default() {
	// Only show top cart, search and lang when header is not a side type.
	$header_type = anva_get_header_type();
	if ( 'side' == $header_type ) {
		return;
	}

	// get primary menu style
	$primary_menu_style = anva_get_option( 'primary_menu_style', 'default' );
	?>
	<!-- Top Cart -->
	<div id="top-cart">
		<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>
		<div class="top-cart-content">
			<div class="top-cart-title">
				<h4>Shopping Cart</h4>
			</div>
			<div class="top-cart-items">
				<div class="top-cart-item clearfix">
					<div class="top-cart-item-image">
						<a href="#"><img src="<?php echo anva_get_core_uri() . 'assets/images/shop/small/1.jpg'; ?>" alt="Blue Round-Neck Tshirt" /></a>
					</div>
					<div class="top-cart-item-desc">
						<a href="#">Blue Round-Neck Tshirt</a>
						<span class="top-cart-item-price">$19.99</span>
						<span class="top-cart-item-quantity">x 2</span>
					</div>
				</div>
				<div class="top-cart-item clearfix">
					<div class="top-cart-item-image">
						<a href="#"><img src="<?php echo anva_get_core_uri() . 'assets/images/shop/small/6.jpg'; ?>" alt="Light Blue Denim Dress" /></a>
					</div>
					<div class="top-cart-item-desc">
						<a href="#">Light Blue Denim Dress</a>
						<span class="top-cart-item-price">$24.99</span>
						<span class="top-cart-item-quantity">x 3</span>
					</div>
				</div>
			</div>
			<div class="top-cart-action clearfix">
				<span class="fleft top-checkout-price">$114.95</span>
				<button class="button button-3d button-small nomargin fright">View Cart</button>
			</div>
		</div>
	</div><!-- #top-cart end -->
	
	<!-- Top Lang -->
	<div id="top-lang">
		<a href="#" id="top-lang-trigger"><i class="icon-flag"></i></a>
		<div class="top-lang-content">
			<ul class="top-lang-switch">
				<li class="active"><a href="#">English</a></li>
				<li><a href="#">Spanish</a></li>
				<li><a href="#">Dutch</a></li>
			</ul>
		</div>
	</div><!-- #top-lang end -->

	<!-- Top Search -->
	<div id="top-search">
		<a href="#" id="top-search-trigger">
			<i class="icon-search3"></i>
			<i class="icon-line-cross"></i>
		</a>
		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="text" name="s" class="form-control" value="" placeholder="<?php _e( 'Type & Hit Enter..', 'anva' ); ?>">
		</form>
	</div><!-- #top-search end -->

	<?php if ( 'style_10' == $primary_menu_style ) : ?>
		<a href="#" id="overlay-menu-close" class="visible-lg-block visible-md-block"><i class="icon-line-cross"></i></a>
	<?php
	endif;
}

/**
 * Display footer widget locations.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_footer_content_default() {
	$footer_setup = anva_get_option( 'footer_setup' );
	if ( isset( $footer_setup['num'] ) && $footer_setup['num'] ) :
	?>
	<div class="footer-widgets-wrap clearfix">
		<?php anva_display_footer_sidebar_locations(); ?>
	</div>
	<?php
	endif;
}

/**
 * Display default footer text copyright
 * 
 * @since 1.0.0
 */
function anva_footer_copyrights_default() {
	
	$footer_copyright = anva_get_option( 'footer_copyright' );
	$footer_copyright = anva_footer_copyright_helpers( $footer_copyright );

	?>
	<div class="col_half">
		<div class="copyright-text"><?php echo $footer_copyright; ?></div>
		<div class="copyright-links">
			<!-- @todo footer links -->
		</div>
	</div>
	
	<div class="col_half col_last tright">
		<div class="fright clearfix"><?php anva_social_icons( $style = '', $shape = '', $border = 'borderless', $size = 'small' ); ?></div>
		<div class="clear"></div>
		<!-- @todo footer extra info -->
	</div>
	<?php
}

function anva_footer_ghost() {
	$ghost = 'PCEtLSBUaGlzIFRoZW1lIGlzIERlc2lnbmVkIGJ5IEFudGh1YW4gVmFzcXVlei4gTGVhcm4gbW9yZTogaHR0cDovL2FudGh1YW52YXNxdWV6Lm5ldC8gLS0+';
	echo base64_decode( $ghost );
}

/**
 * Display default featured slider
 * 
 * @since 1.0.0
 */
function anva_featured_default() {
	if ( anva_supports( 'featured', 'front' ) ) {
		$slider = anva_get_option( 'slider_id' );
		anva_sliders( $slider );
	}
}

/**
 * Display default featured before
 * 
 * @since 1.0.0
 */
function anva_featured_before_default() {
	
	$slider_id = anva_get_option( 'slider_id' );
	$slider_style = anva_get_option( 'slider_style' );
	$slider_parallax = anva_get_option( 'slider_parallax' );

	if ( 'swiper' != $slider_id && 'full-screen' != $slider_style ) {
		$classes[] = $slider_style;
	}
	
	if ( 'true' == $slider_parallax ) {
		$classes[] = 'slider-parallax';
	}

	if ( 'swiper' == $slider_id ) {
		$classes[] = 'swiper_wrapper has-swiper-slider';
	}

	if ( $slider_id ) {
		$classes[] = 'has-' . $slider_id . '-slider';
	}

	$classes = implode( ' ', $classes );

	?>
	<!-- SLIDER (start) -->
	<section id="slider" class="<?php echo esc_attr( $classes ); ?> clearfix">
		<?php if ( 'slider-boxed' == $slider_style ) : ?>
		<div class="container clearfix">
		<?php endif ?>
	<?php
}

/**
 * Display default featured after
 * 
 * @since 1.0.0
 */
function anva_featured_after_default() {
	$slider_style = anva_get_option( 'slider_style' );
	$slider_parallax = anva_get_option( 'slider_parallax' );
	?>
	<?php if ( 'slider-boxed' == $slider_style ) : ?>
	</div><!-- .container (end) -->
	<?php endif ?>
	</section><!-- FEATURED (end) -->
	<?php
}

/**
 * Page titles.
 *
 * @since  1.0.0
 * @return void
 */
function anva_page_title_default() {

	// Don't show page titles on front page.
	if ( is_front_page() ) {
		return;
	}

	// Hide page titles
	$hide_title = anva_get_post_meta( '_anva_hide_title' );

	// Show page description
	$page_desc = anva_get_post_meta( '_anva_page_desc' );
	
	?>
	<?php if ( ! empty ( 'show' != $hide_title ) ) : ?>
		<section id="page-title">
			<div class="container clearfix">
				<h1><?php anva_archive_title(); ?></h1>
				
				<?php if ( ! empty ( $page_desc ) ) : ?>
					<span><?php echo esc_html( $page_desc ); ?></span>
				<?php endif; ?>
				
				<?php do_action( 'anva_breadcrumbs' ); ?>
			</div>
		</section><!-- #page-title (end) -->
	<?php endif; ?>
	<?php
}
/**
 * Display breadcrumbs.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_breadcrumbs_default() {
	$breadcrumbs = anva_get_option( 'breadcrumbs', 'hide' );
	if ( 'show' == $breadcrumbs ) {
		anva_breadcrumbs();
	}
}

/**
 * Wrapper layout content start.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_above_layout_default() {
	?>
	<div id="sidebar-layout-wrap">
	<?php
}

/**
 * Wrapper layout content end.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_below_layout_default() {
	?>
	</div><!-- #sidebar-layout-wrap (end) -->
	<?php
}

/**
 * Display sidebars location.
 * 
 * @since  1.0.0
 * @param  string $position
 * @return void
 */
function anva_sidebars_default( $position ) {

	$layout = '';
	$sidebar_right = '';
	$sidebar_left = '';

	$right = apply_filters( 'anva_default_sidebar_right', 'sidebar_right' );
	$left = apply_filters( 'anva_default_sidebar_left', 'sidebar_left' );

	// Get sidebar layout meta
	$sidebar_layout = anva_get_post_meta( '_anva_sidebar_layout' );

	// Get sidebar locations
	if ( isset( $sidebar_layout['layout'] ) ) {
		$layout = $sidebar_layout['layout'];
		$sidebar_right = $sidebar_layout['right'];
		$sidebar_left = $sidebar_layout['left'];
	}

	// Set default layout
	if ( empty( $layout ) ) {
		$layout = anva_get_option( 'sidebar_layout', 'left' );
		$sidebar_right = $right;
		$sidebar_left = $left;
	}

	// Set default sidebar right
	if ( empty( $sidebar_right ) ) {
		$sidebar_right = $right;
	}

	// Set default sidebar left
	if ( empty( $sidebar_left ) ) {
		$sidebar_left = $left;
	}

	// Sidebar Left, Sidebar Right, Double Sidebars
	if ( $layout == $position || $layout == 'double' ) {

		do_action( 'anva_sidebar_before', $position  );
		
		if ( 'right' == $position ) {
			anva_display_sidebar( $sidebar_right );
		} elseif ( 'left' == $position ) {
			anva_display_sidebar( $sidebar_left );
		}

		do_action( 'anva_sidebar_after', $position );

	}

	// Double Left Sidebars
	if ( $layout == 'double_left' && $position == 'left' ) {

		// Left Sidebar
		do_action( 'anva_sidebar_before', 'left'  );
		anva_display_sidebar( $sidebar_left );
		do_action( 'anva_sidebar_after', 'left' );

		// Right Sidebar
		do_action( 'anva_sidebar_before', 'right'  );
		anva_display_sidebar( $sidebar_right );
		do_action( 'anva_sidebar_after', 'right' );

	}

	// Double Right Sidebars
	if ( $layout == 'double_right' && $position == 'right' ) {

		// Left Sidebar
		do_action( 'anva_sidebar_before', 'left'  );
		anva_display_sidebar( $sidebar_left );
		do_action( 'anva_sidebar_after', 'left' );

		// Right Sidebar
		do_action( 'anva_sidebar_before', 'right'  );
		anva_display_sidebar( $sidebar_right );
		do_action( 'anva_sidebar_after', 'right' );

	}
}

/**
 * Display sidebar location before.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_before_default( $side ) {
	?>
	<div class="sidebar-<?php echo esc_attr( $side ) .' '. esc_attr( anva_get_column_class( $side ) ); ?>">
		<div class="sidebar-widgets-wrap">
	<?php
}

/**
 * Display sidebar location after.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_after_default() {
	?>
		</div><!-- .sidebar-widgets-wrap (end) -->
	</div><!-- .sidebar (end) -->
	<?php
}

/**
 * Display sidebar above header.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_above_header() {
	?>
	<div id="above-header">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'above_header' ); ?>
		</div>
	</div><!-- #above-header (end) -->
	<?php
}

/**
 * Display sidebar above content.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_above_content() {
	?>
	<div id="above-content">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'above_content' ); ?>
		</div>
	</div><!-- #above-content (end) -->
	<?php
}

/**
 * Display sidebar below content.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_below_content() {
	?>
	<div id="below-content">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'below_content' ); ?>
		</div>
	</div><!-- #below-content (end) -->
	<?php
}

/**
 * Display sidebar below footer.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_sidebar_below_footer() {
	?>
	<div id="below-footer">
		<div class="container clearfix">
			<?php anva_display_sidebar( 'below_footer' ); ?>
		</div>
	</div><!-- #below-footer (end) -->
	<?php
}

/**
 * Display on single posts or primary posts.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_posts_meta_default() {
	if ( is_single() && 'show' == anva_get_option( 'single_meta', 'show' ) ) {
		anva_posted_on();
		return;
	}

	if ( 'show' == anva_get_option( 'prmary_meta', 'show' ) ) {
		anva_posted_on();
	}
}

/**
 * Display posts content default.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_posts_content_default() {

	if ( has_post_format( array( 'quote', 'link', 'status' ) ) ) {
		return;
	}
	
	$primary_content = anva_get_option( 'primary_content', 'excerpt' );
	
	if ( 'excerpt' == $primary_content ) {
		echo anva_get_excerpt();
		echo '<a class="more-link" href="' . get_the_permalink() . '">' . anva_get_local( 'read_more' ) . '</a>';
		return;
	}

	the_content( anva_get_local( 'read_more' ) );
}

/**
 * Display posts comments default.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_posts_comments_default() {
	$single_comments = anva_get_option( 'single_comments', 'show' );
	if ( 'show' == $single_comments ) {
		if ( comments_open() || '0' != get_comments_number() ) {
			comments_template();
		}
	}
}

/**
 * Post reading bar indicator.
 *
 * @since  1.0.0
 * @return void
 */
function anva_post_reading_bar() {
	$single_post_reading_bar = anva_get_option( 'single_post_reading_bar' );
	if ( 'show' != $single_post_reading_bar ) {
		return;
	}

	if ( is_singular( 'post' ) ) :
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
                            <h4><?php echo get_the_title(); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #post-reading-wrap (end) -->
    <?php
    endif;
}

/**
 * Display debug information.
 * 
 * Only if WP_DEBUG is enabled and current user is an administrator.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_debug() {
	$debug = anva_get_option( 'debug', 0 );
	if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG && current_user_can( 'manage_options' ) && $debug ) :
	?>
	<div id="debug-info">
		<div class="container clearfix">
			<div class="style-msg2 infomsg topmargin bottommargin">
				<div class="msgtitle"><i class="icon-info-sign"></i>Debug Info</div>
				<div class="sb-msg">
					<ul>
						<li><span>Queries:</span> <?php echo get_num_queries(); ?> database queries.</li>
						<li><span>Speed:</span> Page generated in <?php timer_stop(1); ?> seconds.</li>
						<li><span>Memory Usage:</span> <?php echo anva_convert_memory_use( memory_get_usage( true ) ); ?></li>
						<li><span>Theme Name:</span> <?php echo anva_get_theme( 'name' ); ?></li>
						<li><span>Theme Version:</span> <?php echo anva_get_theme( 'version' ); ?></li>
						<li><span>Framework Name:</span> <?php echo ANVA_FRAMEWORK_NAME; ?></li>
						<li><span>Framework Version:</span> <?php echo ANVA_FRAMEWORK_VERSION; ?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php
	endif;
}
<?php

/**
 * Print favicon and apple touch icons in head
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
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="faqs.html">FAQs</a></li>
						<li><a href="contact.html">Contact</a></li>
						<li><a href="login-register.html">Login</a>
							<div class="top-link-section">
								<form id="top-login" role="form">
									<div class="input-group" id="top-login-username">
										<span class="input-group-addon"><i class="icon-user"></i></span>
										<input type="email" class="form-control" placeholder="Email address" required="">
									</div>
									<div class="input-group" id="top-login-password">
										<span class="input-group-addon"><i class="icon-key"></i></span>
										<input type="password" class="form-control" placeholder="Password" required="">
									</div>
									<label class="checkbox">
									  <input type="checkbox" value="remember-me"> Remember me
									</label>
									<button class="btn btn-danger btn-block" type="submit">Sign in</button>
								</form>
							</div>
						</li>
					</ul>
				</div><!-- .top-links end -->
			</div>

			<div class="col_half fright col_last nobottommargin">

				<!-- Top Social
				============================================= -->
				<div id="top-social">
					<ul>
						<li><a href="#" class="si-facebook"><span class="ts-icon"><i class="icon-facebook"></i></span><span class="ts-text">Facebook</span></a></li>
						<li><a href="#" class="si-twitter"><span class="ts-icon"><i class="icon-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
						<li><a href="#" class="si-dribbble"><span class="ts-icon"><i class="icon-dribbble"></i></span><span class="ts-text">Dribbble</span></a></li>
						<li><a href="#" class="si-github"><span class="ts-icon"><i class="icon-github-circled"></i></span><span class="ts-text">Github</span></a></li>
						<li><a href="#" class="si-pinterest"><span class="ts-icon"><i class="icon-pinterest"></i></span><span class="ts-text">Pinterest</span></a></li>
						<li><a href="#" class="si-instagram"><span class="ts-icon"><i class="icon-instagram2"></i></span><span class="ts-text">Instagram</span></a></li>
						<li><a href="tel:+91.11.85412542" class="si-call"><span class="ts-icon"><i class="icon-call"></i></span><span class="ts-text">+91.11.85412542</span></a></li>
						<li><a href="mailto:info@canvas.com" class="si-email3"><span class="ts-icon"><i class="icon-email3"></i></span><span class="ts-text">info@canvas.com</span></a></li>
					</ul>
				</div><!-- #top-social end -->
			</div>
		</div>
	</div><!-- #top-bar end -->
	<?php
}

/**
 * Display default header custom logo.
 * 
 * @since 1.0.0
 */
function anva_header_logo_default() {
	
	$option 	= anva_get_option( 'custom_logo' );
	$name 		= get_bloginfo( 'name' );
	$classes 	= array();
	$classes[] 	= 'logo-' . $option['type'];
	
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
				$image_1x = esc_url( $option['image'] );
				$image_2x = '';
				$logo_2x  = '';

				if ( ! empty( $option['image_2x'] ) ) {
					$image_2x = $option['image_2x'];
					$logo_2x = '<a class="retina-logo" href="' . home_url() . '"><img src="' . $image_2x . '" alt="' . $name . '" /></a>';
				}

				echo '<a class="standard-logo" href="' . home_url() . '"><img src="' . $image_1x . '" alt="' . $name . '" /></a>';
				echo $logo_2x;
				break;
		}
	}
	echo '</div><!-- #logo (end) -->';
}

/**
 * Display default extra header information.
 * 
 * @since 1.0.0
 */
function anva_header_extras_default() {
	?>	
	<ul id="header-extras" class="header-extras">
		<li>
			<i class="fa fa-envelope"></i>
			<div class="text">Drop an Email <span>info@anvas.com</span></div>
		</li>
		<li id="header-search">
			<?php anva_site_search(); ?>
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
		$class = '';
		$primary_menu_color = anva_get_option( 'primary_menu_color', 'light' );
		if ( 'dark' == $primary_menu_color ) {
			$class = 'class="' . esc_attr( $primary_menu_color ) . '"';
		}
	?>
		<nav id="primary-menu" <?php echo $class; ?>>
			<?php
				wp_nav_menu( apply_filters( 'anva_main_navigation_default', array(
					'theme_location'  => 'primary',
					'container'       => '',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>'
				) ) );

				anva_header_primary_menu_addon();
			?>
		</nav><!-- #main-navigation (end) -->
		
		<?php
		$side_icons = anva_get_option( 'side_icons' );
		$header_style = anva_get_header_style();
		if (  'side' == $header_style && $side_icons ) : ?>
			<div class="clearfix visible-md visible-lg">
				<?php anva_social_icons(); ?>
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
	$header_classes = anva_get_header_class();
	if ( in_array( 'no-sticky', $header_classes ) ) {
		return;
	}
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

	<!-- Top Search -->
	<div id="top-search">
		<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
		<form action="search.html" method="get">
			<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
		</form>
	</div><!-- #top-search end -->
	<?php
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
	$html  = '';
	$html .= '<div class="col_half">';

	if ( $footer_copyright || ! empty( $footer_copyright ) ) {
		$html .= sprintf( $footer_copyright );
	} else {
		$html .= sprintf( 'Copyright %1$s <strong>%2$s</strong> %3$s %4$s.', '2016', get_bloginfo( 'name' ), __( 'Designed by', 'anva' ), '<a href="'. esc_url( 'http://anthuanvasquez.net/' ) .'">Anthuan Vasquez</a>' );
	}
	$html .= '<div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>';
	$html .= '</div>';
	
	$html .= '<div class="col_half col_last tright">
		<div class="fright clearfix">
			<a href="#" class="social-icon si-small si-borderless si-facebook">
				<i class="icon-facebook"></i>
				<i class="icon-facebook"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-twitter">
				<i class="icon-twitter"></i>
				<i class="icon-twitter"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-gplus">
				<i class="icon-gplus"></i>
				<i class="icon-gplus"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-pinterest">
				<i class="icon-pinterest"></i>
				<i class="icon-pinterest"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-vimeo">
				<i class="icon-vimeo"></i>
				<i class="icon-vimeo"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-github">
				<i class="icon-github"></i>
				<i class="icon-github"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-yahoo">
				<i class="icon-yahoo"></i>
				<i class="icon-yahoo"></i>
			</a>

			<a href="#" class="social-icon si-small si-borderless si-linkedin">
				<i class="icon-linkedin"></i>
				<i class="icon-linkedin"></i>
			</a>
		</div>

		<div class="clear"></div>

		<i class="icon-envelope2"></i> info@canvas.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> +91-11-6541-6369 <span class="middot">&middot;</span> <i class="icon-skype2"></i> CanvasOnSkype
	</div>';

	echo $html;
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


function anva_title_default() {

	if ( is_front_page() ) {
		return;
	}

	$hide_title = anva_get_field( 'hide_title' );
	$page_desc = anva_get_field( 'page_desc' );

	if ( is_404() ) {
		$page_desc = __( 'Page not found', '' );
	}

	?>
	<section id="page-title">
		<div class="container clearfix">
			<h1><?php anva_archive_title(); ?></h1>
			<?php if ( $page_desc ) : ?>
				<span><?php echo esc_html( $page_desc ); ?></span>
			<?php endif; ?>
			<?php anva_breadcrumbs(); ?>
		</div>
	</section><!-- #page-title (end) -->
	<?php
}
/**
 * Display breadcrumbs
 * 
 * @since 1.0.0
 */
function anva_breadcrumbs_default() {
	$breadcrumbs = anva_get_option( 'breadcrumbs', 'hide' );
	if ( 'show' == $breadcrumbs ) {
		anva_get_breadcrumbs();
	}
}

/**
 * Wrapper layout content start
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
 * Wrapper layout content end
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
 * Display sidebars location
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
	$sidebar_layout = anva_get_field( 'sidebar_layout' );

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
 * Display Ad above header
 * 
 * @since 1.0.0
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
 * Display Ad above content
 * 
 * @since 1.0.0
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
 * Display Ad below content
 * 
 * @since 1.0.0
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
 * Display Ad below footer
 * 
 * @since 1.0.0
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
 * Display on single posts or primary posts
 * 
 * @since 1.0.0
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
	
	$primary_content = anva_get_option( 'primary_content', 'excerpt' );
	
	if ( 'excerpt' == $primary_content ) {
		echo '<div class="entry-summary">';
		anva_excerpt();
		echo '</div>';
		echo '<a class="more-link" href="' . get_the_permalink() . '">' . anva_get_local( 'read_more' ) . '</a>';
		return;
	}

	the_content( anva_get_local( 'read_more' ) );
}

if ( ! function_exists( 'anva_posts_comments_default' ) ) :
/**
 * Display posts comments default
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
endif;

/**
 * Display debug information.
 * 
 * Only if WP_DEBUG is enabled and current user is an administrator.
 * 
 * @since 1.0.0
 */
function anva_debug() {
	if ( defined( 'WP_DEBUG' ) && true == WP_DEBUG && current_user_can( 'manage_options' ) ) :
	?>
	<div class="container clearfix">
		<div class="debug-info style-msg2 infomsg topmargin bottommargin">
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
	<?php
	endif;
}
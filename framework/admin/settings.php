<?php

/**
 * 3Mentes WordPress Framework
 * Admin Options Page
 *
 * @author		Anthuan Vasquez
 * @copyright	Copyright (c) 3Mentes
 * @link			http://anthuanvasquez.net
 * @package		3Mentes WordPress Framework
 */

 // Use options framework?
 
// Constants
define( 'TM_ADMIN_NAME', '3Mentes WordPress Framework' );
define( 'TM_ADMIN_VERSION', '1.0.0' );

// Default options
include_once( get_template_directory() . '/framework/admin/options.php' );

// Interface inputs
include_once( get_template_directory() . '/framework/admin/options-interface.php' );

// Hooks
add_action( 'init', 'tm_admin_init' );
add_action( 'admin_menu', 'tm_settings_page_init' );
add_action( 'admin_head', 'tm_admin_head' );
add_action( 'admin_enqueue_scripts', 'tm_settings_scripts' );

/**
 * Init options page.
 * @since 1.3.1
 */
function tm_admin_init() {
	
	global $options;
	
	$settings = unserialize(TM_THEME_SETTINGS);

	if( empty( $settings ) ) {

		foreach( $options as $value ) {
			if( isset( $value['id'] ) ) {
				$settings[$value['id']] = $value['std'];
			}
		}

		add_option( "tm_theme_settings", $settings, '', 'yes' );
	}

}

/**
 * Add theme page.
 * @since 1.3.1
 */
function tm_settings_page_init() {
	
	$settings_page = add_theme_page(
		__('Opciones', TM_THEME_DOMAIN),
		__('Opciones', TM_THEME_DOMAIN),
		'edit_theme_options',
		'theme-settings',
		'tm_settings_page'
	);
	add_action( "load-{$settings_page}", 'tm_load_settings_page' );

}

/**
 * Load settings.
 * @since 1.3.1
 */
function tm_load_settings_page() {

	if( isset( $_POST["settings-submit"] ) ) {
		
		check_admin_referer( "tm-settings-page" );
		
		tm_save_theme_settings();

		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('themes.php?page=theme-settings&'.$url_parameters));
		exit;
	}

}

/**
 * Load scripts.
 * @since 1.3.1
 */
function tm_settings_scripts() {

	global $pagenow;

	wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/js/admin.min.js', array('jquery'), false, false );
	
	if ( $pagenow == 'themes.php' && isset( $_GET['page'] ) && $_GET['page'] == 'theme-settings' ) {
		wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/admin.css');
		add_thickbox();
	}
}

/**
 * Fade update message.
 * @since 1.3.1
 */
function tm_admin_head() {
	echo '<script>jQuery(document).ready(function(){setTimeout(function(){jQuery("#updated").fadeOut("slow")},1600);});</script>';
}

/**
 * Save settings.
 * @since 1.3.1
 */
function tm_save_theme_settings() {
	
	global $pagenow;
	
	$settings = unserialize(TM_THEME_SETTINGS);
	
	if( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ) { 
		
		if ( isset ( $_GET['tab'] ) ) {
			$tab = $_GET['tab'];
		} else {
			$tab = 'layout';
		}

		switch( $tab ) {
			
			case 'layout':
				foreach ($_POST as $key => $value) {
					$settings[$key] = $value;
				}
			break;

			case 'content':
				foreach ($_POST as $key => $value) {
					$settings[$key] = $value;
				}
			break;

			case 'config':
				foreach ($_POST as $key => $value) {
					$settings[$key] = $value;
				}
			break;
			
		}
	}

	$updated = update_option( "tm_theme_settings", $settings );

}

/**
 * Add tabs.
 * @since 1.3.1
 */
function tm_admin_tabs( $current = 'layout' ) { 
		
		$tabs = array(
			'layout'	=> 'Layout',
			'content' => 'Content',
			'config' 	=> 'Configuration'
		);
		
		$links = array();
		
		echo '<div id="icon-themes" class="icon32"><br></div>';
		echo '<h2 class="nav-tab-wrapper">';
		
		foreach( $tabs as $tab => $name ) {
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=theme-settings&tab=$tab'>$name</a>";
		}

		echo '</h2>';
}

/**
 * Add options form.
 * @since 1.3.1
 */
function tm_settings_page() {
	
	global $pagenow, $options;
	
	?>
	
	<div class="wrap">
		
		<?php
			if( isset( $_GET['updated'] ) && 'true' == esc_attr( $_GET['updated'] ) ) {
				echo '<div id="updated" class="updated" ><p>'.__('Cambios Realizados.', TM_THEME_DOMAIN).'</p></div>';
			}
			
			if( isset ( $_GET['tab'] ) )
				tm_admin_tabs($_GET['tab']);
			else
				tm_admin_tabs('layout');
		?>

		<div id="poststuff" class="settings-wrapper">
			<form method="post" action="<?php admin_url( 'themes.php?page=theme-settings' ); ?>">
				<?php
				
				foreach ($_POST as $key => $value) {
					echo $key . '<br/>';
				}
				
				wp_nonce_field( "tm-settings-page" );

				$output = '';
				
				if( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ) {
				
					if( isset ( $_GET['tab'] ) ) {
						$tab = $_GET['tab'];
					} else {
						$tab = 'layout';
					} 
					
					echo '<div class="inner-form">';

					switch( $tab ) {

						case 'layout':
							echo tm_settings_inputs( $tab = 'layout' );
						break;

						case 'content':
							echo tm_settings_inputs( $tab = 'content' );
						break;
							
						case 'config':
							echo tm_settings_inputs( $tab = 'config' );
						break;
							
					}

					echo '</div>';

				}
				?>
				
				<div class="options-submit postbox">
					<p class="submit" style="clear:both;">
						<input type="submit" class="button-primary" name="settings-submit" value="<?php _e('Guardar Opciones', TM_THEME_DOMAIN); ?>" />
					</p>
					<p class="copyright-text">
						<?php echo TM_ADMIN_NAME. ' <strong>'.TM_ADMIN_VERSION.'</strong>'; ?>. Desarrollado por <a href="<?php echo esc_url('http://3mentes.com/'); ?>">3mentes.com</a>.
					</p>
				</div>
			</form>
			
		</div>

	</div>
<?php
}
<?php

/**
 * Anva WordPress Framework
 * Admin Options Page
 */

// Constants
define( 'ANVA_ADMIN_NAME', 'Anva WordPress Framework' );
define( 'ANVA_ADMIN_VERSION', '1.0.0' );

// Default options
include_once( get_template_directory() . '/framework/admin/options.php' );

// Interface inputs
include_once( get_template_directory() . '/framework/admin/options-interface.php' );

// Hooks
add_action( 'init', 'anva_admin_init' );
add_action( 'admin_menu', 'anva_settings_page_init' );
add_action( 'admin_head', 'anva_admin_head' );
add_action( 'admin_enqueue_scripts', 'anva_settings_scripts' );

/**
 * Init options page.
 * @since 1.3.1
 */
function anva_admin_init() {
	global $options;
	$settings = unserialize( ANVA_SETTINGS );
	if ( empty( $settings ) ) {
		foreach( $options as $value ) {
			if( isset( $value['id'] ) ) {
				$settings[$value['id']] = $value['std'];
			}
		}
		add_option( "anva_settings", $settings, '', 'yes' );
	}
}

/**
 * Add theme page.
 * @since 1.3.1
 */
function anva_settings_page_init() {
	$settings_page = add_theme_page(
		__( 'Opciones', ANVA_DOMAIN ),
		__( 'Opciones', ANVA_DOMAIN ),
		'edit_theme_options',
		'theme-settings',
		'anva_settings_page'
	);
	add_action( "load-{$settings_page}", 'anva_load_settings_page' );
}

/**
 * Load settings.
 */
function anva_load_settings_page() {

	if( isset( $_POST["settings-submit"] ) ) {
		
		check_admin_referer( "tm-settings-page" );
		
		anva_save_theme_settings();

		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('themes.php?page=theme-settings&'.$url_parameters));
		exit;
	}

}

/**
 * Load scripts.
 */
function anva_settings_scripts() {

	global $pagenow;

	wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/js/admin.min.js', array('jquery'), false, false );
	
	if ( $pagenow == 'themes.php' && isset( $_GET['page'] ) && $_GET['page'] == 'theme-settings' ) {
		wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/screen-admin.css');
		add_thickbox();
	}
}

/**
 * Fade update message.
 */
function anva_admin_head() {
	echo '<script>jQuery(document).ready(function(){setTimeout(function(){jQuery("#updated").fadeOut("slow")},1600);});</script>';
}

/**
 * Save settings.
 */
function anva_save_theme_settings() {
	
	global $pagenow;
	
	$settings = unserialize( ANVA_SETTINGS );
	
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

	$updated = update_option( "anva_settings", $settings );

}

/**
 * Add tabs.
 */
function anva_admin_tabs( $current = 'layout' ) { 
		
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
 */
function anva_settings_page() {
	
	global $pagenow, $options;
	
	?>
	
	<div class="wrap">
		
		<?php
			if( isset( $_GET['updated'] ) && 'true' == esc_attr( $_GET['updated'] ) ) {
				echo '<div id="updated" class="updated" ><p>'.__('Cambios Realizados.', ANVA_DOMAIN).'</p></div>';
			}
			
			if( isset ( $_GET['tab'] ) )
				anva_admin_tabs($_GET['tab']);
			else
				anva_admin_tabs('layout');
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
							echo anva_settings_inputs( $tab = 'layout' );
						break;

						case 'content':
							echo anva_settings_inputs( $tab = 'content' );
						break;
							
						case 'config':
							echo anva_settings_inputs( $tab = 'config' );
						break;
							
					}

					echo '</div>';

				}
				?>
				
				<div class="options-submit postbox">
					<p class="submit" style="clear:both;">
						<input type="submit" class="button-primary" name="settings-submit" value="<?php _e('Guardar Opciones', ANVA_DOMAIN); ?>" />
					</p>
					<p class="copyright-text">
					<?php
						printf(
							'%s <strong>%s</strong>. Desarrollado por <a href="%s">%s</a>.',
							ANVA_ADMIN_NAME,
							ANVA_ADMIN_VERSION,
							esc_url( 'http://anthuanvasquez.net/' ),
							'Anthuan Vasquez'
						);
					?>
					</p>
				</div>
			</form>
			
		</div>

	</div>
<?php
}
<?php
/**
 * Admin display functions.
 *
 * @package AnvaFramework
 */

/**
 * Show message when the theme is activated.
 *
 * @since  1.0.0
 * @return void
 */
function anva_admin_theme_activate() {
	if ( isset( $_GET['activated'] ) && true == $_GET['activated'] ) {

		$option_name = anva_get_option_name();
		$admin_url   = admin_url( 'themes.php?page=' . $option_name );

		printf(
			'<div class="updated updated fade settings-error notice is-dismissible"><p>%1$s %2$s</p></div>',
			sprintf(
				__( '%s is activated.', 'anva' ),
				esc_html( anva_get_theme( 'name' ) )
			),
			sprintf(
				__( 'Go to %s', 'anva' ),
				sprintf(
					'<a href="%1$s">%2$s</a>',
					esc_url( $admin_url ),
					__( 'Theme Options Page', 'anva' )
				)
			)
		);
	}
}

/**
 * Check if settings exists in the database.
 *
 * @since 1.0.0
 */
function anva_admin_check_settings() {
	if ( ! get_option( anva_get_option_name() ) ) {
		printf( '<div class="error fade settings-error notice is-dismissible"><p>%s</p></div>', esc_html__( 'Options don\'t exists in the database. Please configure and save your theme options page.', 'anva' ) );
	}
}

function anva_admin_random_messages() {
	$messages = array(
		__( 'Enjoy!', 'anva' ),
		__( 'Great go and see your website!', 'anva' ),
		__( 'You always can import old settings!', 'anva' ),
	);

	return $messages[ rand( 0, count( $messages ) - 1 ) ];
}

/**
 * Show flash message after update/reset settings.
 *
 * @since  1.0.0.
 * @return void
 */
function anva_add_settings_flash() {
	if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ) : ?>
		<script type="text/javascript">
		(function() {
			swal({
				title: "<?php echo esc_js( __( 'Done!', 'anva' ) ); ?>",
				text: "<?php echo sprintf( '%s <span>%s</span>', __( 'Options successfully updated!', 'anva' ), anva_admin_random_messages() ); ?>",
				type: "success",
				timer: 5000,
				confirmButtonColor: "#008ec2",
				showConfirmButton: true,
				html: true
			});
		})();
		</script>
	<?php endif;
}

/**
 * Show notice whan settings change in options page.
 *
 * @since 1.0.0
 */
function anva_admin_add_settings_change() {
	printf( '<div id="anva-options-change" class="anva-options-change section-info">%s</div>', esc_html__( 'Settings has changed.', 'anva' ) );
}

/**
 * Log option.
 *
 * @since 1.0.0
 */
function anva_admin_settings_last_save() {

	$html = '';

	// Get current info.
	$option_name      = anva_get_option_name();
	$option_last_save = get_option( $option_name . '_last_save' );

	// Check if field exists
	if ( $option_last_save ) {
		$time = strtotime( $option_last_save );
		$time = date( 'M d, Y @ g:i A', $time );

		printf(
			'<div class="log"><span class="dashicons dashicons-clock"></span> <strong>%s:</strong> %s</div>',
			__( 'Last changed', 'anva' ),
			$time
		);

		return;
	}

	printf(
		'<div class="log"><span class="dashicons dashicons-clock"></span> %s</div>',
		__( 'Your settings has not changed.', 'anva' )
	);

}

/**
 * Display framework and theme credits
 *
 * @since 1.0.0
 */
function anva_admin_footer_credits() {
	$theme_info 	= anva_get_theme( 'name' ) . ' ' . anva_get_theme( 'version' );
	$framework_info = Anva::$name . ' ' . Anva::$version;
	$author_info 	= '<a href="' . esc_url( 'https://anthuanvasquez.net/' ) . '">Anthuan Vásquez</a>';

	printf(
		'<div class="anva-options-page-credit">%1$s %2$s<div class="clear"></div></div>',
		sprintf(
			'<span class="alignleft">%2$s %1$s %3$s</span>',
			__( 'powered by', 'anva' ),
			esc_html( $theme_info ),
			esc_html( $framework_info )
		),
		sprintf(
			'<span class="alignright">%1$s %2$s</span>',
			__( 'Develop by', 'anva' ),
			esc_html( $author_info )
		)
	);
}

/**
 * Display footer links.
 *
 * @since 1.0.0
 */
function anva_admin_footer_links() {
	$id = anva_get_theme_id();
	printf(
		'<div class="anva-options-page-links">%1$s %2$s %3$s</div>',
		sprintf( '<a href="%1$s"><span class="dashicons dashicons-megaphone"></span> %2$s</a>', esc_url( 'https://themefores/user/oidoperfecto/porfolio' ), __( 'Support', 'anva' ) ),
		sprintf( '<a href="%1$s"><span class="dashicons dashicons-book"></span> %2$s</a>', esc_url( 'https://themes.anthuanvasquez.net/' . $id . '/docs' ), __( 'Theme Documentation', 'anva' ) ),
		sprintf( '<a href="%1$s"><span class="dashicons dashicons-cart"></span> %2$s</a>', esc_url( 'https://themefores/user/oidoperfecto/porfolio' ), __( 'Buy Themes', 'anva' ) )
	);
}

<?php

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
			'<div class="updated updated fade settings-error notice is-dismissible"><p>%s %s</p></div>',
			__( 'Anva theme is activated.', 'anva' ),
			sprintf(
				__( 'Go to %s', 'anva' ),
				'<a href="' . esc_url( $admin_url ) . '">' . __( 'Theme Options Page', 'anva' ) . '</a>'
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
	$option_name = anva_get_option_name();
	if ( ! get_option( $option_name ) ) {
		printf( '<div class="error fade settings-error notice is-dismissible"><p>%s</p></div>', __( 'Options don\'t exists in the database. Please configure and save your theme options page.', 'anva' ) );
	}
}

/**
 * Show flash message after update/reset settings.
 *
 * @since  1.0.0.
 * @return void
 */
function anva_add_settings_flash() {
	return;
	if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == true ) : ?>
		<script type="text/javascript">
		window.onload = function() {
			swal({
				title: "<?php echo esc_js( __( 'Done!', 'anva' ) ); ?>",
				text: "<?php echo esc_js( __( 'Options has been updated.', 'anva' ) ); ?>",
				type: "success",
				timer: 2000,
				showConfirmButton: false
			});
		};
		</script>
	<?php endif;
}

/**
 * Show notice whan settings change in options page.
 *
 * @since 1.0.0
 */
function anva_add_settings_change() {
	printf( '<div id="anva-options-change" class="anva-options-change section-info">%s</div>', __( 'Settings has changed.', 'anva' ) );
}

/**
 * Log option.
 *
 * @since 1.0.0
 */
function anva_admin_settings_log() {

	$html = '';

	// Get current info
	$option_name = anva_get_option_name();
	$option_log  = get_option( $option_name . '_log' );

	// Check if field exists
	if ( $option_log ) {
		$time = strtotime( $option_log );
		$time = date( 'M d, Y @ g:i A', $time );
		printf( '<div class="log"><span class="dashicons dashicons-clock"></span> <strong>%s:</strong> %s</div>', __( 'Last changed', 'anva' ), $time );
		return;
	}

	printf( '<div class="log"><span class="dashicons dashicons-clock"></span> %s</div>', __( 'Your settings has not changed.', 'anva' ) );

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

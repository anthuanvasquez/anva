<?php


function anva_admin_theme_activate() {
	if ( isset( $_GET['activated']) && true == $_GET['activated'] ) :
	?>
	<div class="section-info updated"><?php _e( 'The theme is activated.', anva_textdomain() ); ?></div>
	<?php
	endif;
}

function anva_admin_header_before() {
	
	$html = '';

	// Get current info
	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();
	$current_user = wp_get_current_user();
	$current_time = get_option( $option_name .'_log' );

	$html .= '<div id="optionsframework-log">';

	// Check if field exists
	if ( ! empty( $current_time ) ) {
		$html .= sprintf( __( 'You edited your last settings', anva_textdomain() ) . ': %s.', $current_time );
	} else {
		$html .= __( 'Your settings has not changed.', anva_textdomain() );
		$html .= '</div>';
	}

	echo $html;

}

/**
 * Display the theme credits.
 */
function anva_admin_footer_after() {
	$theme_info = THEME_NAME .' '. THEME_VERSION;
	$framework_info = ANVA_FRAMEWORK_NAME .' '. ANVA_FRAMEWORK_VERSION;
	printf(
		'<div id="optionsframework-credit"><span class="alignleft">%1$s powered by %2$s</span><span class="alignright">Develop by %3$s</span><div class="clear"></div></div>',
		$theme_info,
		$framework_info,
		'<a href="#">Anthuan Vasquez</a>'
	);
}

/**
 * Custom admin javascripts
 */
function anva_admin_head_scripts() {

	$options_framework = new Options_Framework;
	$option_name = $options_framework->get_option_name();
	$settings = get_option( $option_name );
	$options = & Options_Framework::_optionsframework_options();

	$val = '';
	?>
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		<?php foreach ( $options as $value ) : ?>
			<?php
				if ( isset( $value['id'] ) ) {
					// Set the id
					$id = $value['id'];

					// Set default value to $val
					if ( isset( $value['std'] ) ) {
						$val = $value['std'];
					}
					// If the option is already saved, override $val
					if ( isset( $settings[($value['id'])] ) ) {
						$val = $settings[($value['id'])];
						// Striping slashes of non-array options
						if ( ! is_array($val) ) {
							$val = stripslashes( $val );
						}
					}
				}
			?>
			// Typography
			<?php if ( 'typography' == $value['type'] ) : ?>
				// Update font stacks preview
				var <?php echo $id; ?> = {
					face: jQuery('#<?php echo $id; ?>_face'),
					sample: jQuery('#<?php echo $id; ?>_sample_text'),
					google: jQuery('#<?php echo $id; ?>_google')
				};

				if ( <?php echo $id; ?>.face.val() == 'google' ) { <?php echo $id; ?>.google.removeClass('hidden'); }
				<?php echo $id; ?>.face.change(function() {
					<?php echo $id; ?>.sample.css('font-family', jQuery(this).val());
					if ( jQuery(this).val() == 'google' ) {
						<?php echo $id; ?>.google.removeClass('hidden');
					} else {
						<?php echo $id; ?>.google.addClass('hidden');
					}
				});
			<?php endif; ?>
			// Range Slider
			<?php if ( 'range' == $value['type'] ) : ?>
				var <?php echo $id; ?> = {
					input: jQuery("#<?php echo $id; ?>"),
					slider: jQuery("#<?php echo $id; ?>_range")
				}

				<?php
					// Remove all formats from the value
					$val = strtr( $val, ['px' => '', 'em' => '', '%' => '', 'rem' => ''] );
					// $val = str_replace( $value['options']['format'], '', $val );
					$plus = '+';
					$format = '';
					if ( isset( $value['options']['format'] ) ) {
						$format = $value['options']['format'];
					}
				?>

				// Update input range slider
				<?php echo $id; ?>.slider.slider({
					min: <?php echo esc_js( $value['options']['min'] ); ?>,
					max: <?php echo esc_js( $value['options']['max'] ); ?>,
					step: <?php echo esc_js( $value['options']['step'] ); ?>,
					value: <?php echo esc_js( $val ); ?>,
					slide: function(e, ui) {
						<?php echo $id; ?>.input.val( ui.value <?php echo esc_js( $plus ); ?> '<?php echo esc_js( $format ); ?>' );
					}
				});
				<?php echo $id; ?>.input.val( <?php echo $id; ?>.slider.slider( "value" ) <?php echo esc_js( $plus ); ?> '<?php echo esc_js( $format ); ?>' );
				<?php echo $id; ?>.slider.slider("pips");
				<?php echo $id; ?>.slider.slider("float", { pips: true });
			<?php endif; ?>
		<?php endforeach; ?>

		setTimeout( function() {
			jQuery('#optionsframework-wrap .settings-error').fadeOut(500);
		}, 2000);

		jQuery('#logo_retina_check').click(function() {
			jQuery('#section-logo_retina').fadeToggle(400);
		});

		if (jQuery('#logo_retina_check:checked').val() !== undefined) {
			jQuery('#section-logo_retina').show();
		}

	});
	</script>
<?php
}

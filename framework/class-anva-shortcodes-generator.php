<?php

/**
 * Begin Create Shortcode Generator Options.
 */
class Anva_Shortcodes_Generator {

	/**
	 * A single instance of this class.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    object
	 */
	private static $instance = null;

	/**
	 * Arguments to pass to add_meta_box().
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $args = array();

	/**
	 * Options array.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    array
	 */
	private $options = array();

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Shortcode options.
		$this->options = anva_get_shortcode_options();

		// Arguments settings.
		$this->args = array(
			'id'       => 'anva_shortcode_options',
			'title'    => __( 'Shortcode Options', 'anva' ),
			'page'     => array( 'post', 'page', 'portfolio' ),
			'context'  => 'normal',
			'priority' => 'high',
			'desc'     => __( 'Please select short code from list below then enter short code attributes and click "Generate Shortcode".', 'anva' ),
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @global $typenow
	 *
	 * @since 1.0.0
	 */
	public function scripts() {
		global $typenow;

		// Add scripts only if page match with post type.
		foreach ( $this->args['page'] as $page ) {
			if ( $typenow == $page ) {
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'anva_shortcodes', ANVA_FRAMEWORK_ADMIN_JS . 'page-shortcodes.js', array( 'jquery' ), Anva::get_version(), false );
			}
		}
	}

	/**
	 * Metaboxes.
	 */
	public function add() {
		foreach ( $this->args['page'] as $page ) {
			add_meta_box(
				$this->args['id'],
				$this->args['title'],
				array( $this, 'display' ),
				$page,
				$this->args['context'],
				$this->args['priority']
			);
		}
	}

	/**
	 * Display UI.
	 *
	 * @param object $post
	 */
	public function display( $post ) {
	?>
	<div class="anva-shcg-wrap">
		<?php if ( ! empty( $this->options ) ) : ?>
			<div class="anva-shcg-description">
				<?php esc_html_e( $this->args['desc'] ); ?>
			</div>

			<div class="select-wrapper">
				<select id="shortcode-select">
					<option value="">
						<?php esc_html_e( '(no short code selected)', 'anva' ); ?>
					</option>
					<?php
					foreach ( $this->options as $shortcode_id => $shortcode ) :
						$shortcode_name = $shortcode['name'];
					?>
					<option value="<?php echo esc_attr( $shortcode_id ); ?>">
						<?php echo esc_html( $shortcode_name ); ?>
					</option>
					<?php endforeach; ?>
				</select>
			</div>

		<?php endif; ?>

		<?php if ( ! empty( $this->options ) ) : ?>
			<?php foreach ( $this->options as $shortcode_id => $shortcode ) : ?>

				<div id="anva-shcg-<?php echo esc_attr( $shortcode_id ); ?>" class="anva-shcg-section" style="display: none;">
					<div class="anva-shcg-col">

						<div class="anva-shcg-section-title">
							<h3><?php echo esc_html( $shortcode['name'] ); ?></h3>
							<div class="clearfix"></div>
						</div>

						<div class="anva-shcg-section-text">
							<div class="anva-shcg-section-inner" id="<?php echo esc_attr( $shortcode_id ); ?>-attr-option">
								<?php if ( isset( $shortcode['attr'] ) && ! empty( $shortcode['attr'] ) ) : ?>
									<?php foreach ( $shortcode['attr'] as $attr_id => $type ) : ?>
										<div class="anva-shcg-option">
											<div class="anva-shcg-title">
												<h4><?php echo $shortcode['title'][ $attr_id ]; ?>:</h4>
											</div>

											<div class="anva-shcg-explain">
												<?php echo $shortcode['desc'][ $attr_id ]; ?>
											</div>

											<?php
												$id = sprintf( '%s-%s', $shortcode_id, $attr_id );
											?>

											<div class="anva-shcg-control">
												<?php switch ( $type ) :
													case 'text': ?>
														<input type="text" id="<?php echo esc_attr( $id ); ?>" class="anva-shcg-attr anva-input" data-attr="<?php echo esc_attr( $attr_id ); ?>" />

													<?php break;
													case 'colorpicker':
													?>
														<input type="text" id="<?php echo esc_attr( $id ); ?>" class="anva-shcg-attr anva-input anva-color" data-attr="<?php echo esc_attr( $attr_id ); ?>" readonly />

													<?php break;
													case 'select':
													?>
														<div class="select-wrapper">
															<select id="<?php echo esc_attr( $id ); ?>" class="anva-shcg-attr anva-input anva-select" data-attr="<?php echo esc_attr( $attr ); ?>">
																<?php if ( isset( $shortcode['options'][ $attr_id ] ) && ! empty( $shortcode['options'][ $attr_id ] ) ) :
																	foreach ( $shortcode['options'][ $attr_id ] as $option_id => $option ) :
																	?>
																	<option value="<?php echo esc_attr( $option_id ); ?>">
																		<?php echo esc_html( $option ); ?>
																	</option>
																	<?php endforeach; ?>
																<?php endif; ?>
															</select>
														</div>

													<?php break;
													case 'textarea':
													?>
														<textarea id="<?php echo esc_attr( $id ); ?>" class="anva-shcg-attr anva-input anva-textarea" data-attr="<?php echo esc_attr( $attr_id ); ?>"></textarea>

												<?php
												endswitch;
												?>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>

								<?php
								if ( isset( $shortcode['content'] ) && $shortcode['content'] ) :
									if ( isset( $shortcode['content_text'] ) ) {
										$content_text = $shortcode['content_text'];
									} else {
										$content_text = __( 'Your Content', 'anva' );
									}
								?>

								<div class="anva-shcg-option">
									<div class="anva-shcg-title">
										<h4><?php echo esc_html( $content_text ); ?>:</h4>
									</div>
									<div class="anva-shcg-control">
										<?php if ( isset( $shortcode['repeat'] ) ) : ?>
											<input type="hidden" id="<?php echo esc_attr( $shortcode_id ); ?>-content-repeat" value="<?php echo esc_attr( $shortcode['repeat'] ); ?>" />
										<?php endif; ?>

										<div class="anva-textarea-wrap">
											<textarea id="<?php echo esc_attr( $shortcode_id ); ?>-content" rows="3"></textarea>
										</div>
									</div>
								</div>

								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="anva-shcg-col anva-shcg-col-last">
						<div class="anva-shcg-section-title">
							<h3><?php esc_html_e( 'Shortcode', 'anva' ); ?>:</h3>
						</div>
						<div class="anva-textarea-wrap">
							<textarea id="<?php echo esc_attr( $shortcode_id ); ?>-code" rows="3" readonly="readonly" class="anva-shcg-codearea" wrap="off"></textarea>
						</div>
						<div class="anva-shcg-footer">
							<button type="button" data-id="<?php echo esc_attr( $shortcode_id ); ?>" class="button button-primary button-shortcode">
								<?php esc_attr_e( 'Generate Shortcode' ); ?>
							</button>
						</div>
					</div>
				</div>

			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<?php
	}
}

function anva_asort( &$array, $key ) {
	$sorter = array();
	$ret    = array();

	reset( $array );

	foreach ( $array as $ii => $va ) {
		$sorter[ $ii ] = $va[ $key ];
	}

	asort( $sorter );

	foreach ( $sorter as $ii => $va ) {
		$ret[ $ii ] = $array[ $ii ];
	}

	$array = $ret;
}


/*
	End Create Shortcode Generator Options
*/

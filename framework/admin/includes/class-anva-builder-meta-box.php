<?php

if ( ! class_exists( 'Anva_Builder_Meta_Box' ) ) :
/**
 * Builder Meta Box
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/builder
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */
class Anva_Builder_Meta_Box {

	/**
	 * ID for meta box and post field saved
	 *
	 * @since 2.2.0
	 * @var   string
	 */
	public $id;
	
	/**
	 * Arguments to pass to add_meta_box()
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $args;

	/**
	 * Options array for page builder elements
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private $options;

	/**
	 * Constructor
	 * Hook in meta box to start the process.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id, $args, $options ) {

		$this->id = $id;
		$this->options = $options;

		$defaults = array(
			'page'				=> array( 'page' ),		// Can contain post, page, link, or custom post type's slug
			'context'			=> 'normal',					// Normal, advanced, or side
			'priority'		=> 'high'							// Priority
		);

		$this->args = wp_parse_args( $args, $defaults );

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'wp_ajax_anva_builder_get_fields', array( $this, 'ajax_get_fields' ) );
		add_action( 'wp_ajax_nopriv_anva_builder_get_fields', array( $this, 'ajax_get_fields' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ), 10 );

	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 */
	public function scripts( $hook ) {
		
		global $typenow;

		foreach ( $this->args['page'] as $page ) {
			
			// Add scripts only if page match with post type
			if ( $typenow == $page ) {
	
				$builder_dir = anva_get_core_uri() . '/admin/includes/builder';
				
				$wp_editor = array(
					'url' => get_home_url(),
					'includes_url'	=> includes_url()
				);

				/* ---------------------------------------------------------------- */
				/* WordPress
				/* ---------------------------------------------------------------- */

				wp_enqueue_style( 'wp-jquery-ui-dialog' );
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'jquery-ui-core' );
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script( 'jquery-ui-tabs' );
				wp_enqueue_script( 'jquery-effects-fade' );
				wp_enqueue_media();

				/* ---------------------------------------------------------------- */
				/* Builder
				/* ---------------------------------------------------------------- */

				wp_enqueue_style( 'jquery-ui-custom', anva_get_core_uri() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '1.11.4', 'all' );
				wp_enqueue_style( 'tooltipster', anva_get_core_uri() . '/assets/css/admin/tooltipster.min.css', array(), '3.3.0', 'all' );
				wp_enqueue_style( 'anva-animate',	anva_get_core_uri() . '/assets/css/admin/animate.min.css', array(), ANVA_FRAMEWORK_VERSION, 'all' );
				wp_enqueue_style( 'anva-builder', anva_get_core_uri() . '/assets/css/admin/builder.css', array( 'jquery-ui-custom', 'tooltipster' ), ANVA_FRAMEWORK_VERSION, 'all' );

				wp_register_script( 'tooltipster', anva_get_core_uri() . '/assets/js/admin/jquery.tooltipster.min.js', array( 'jquery' ), '3.3.0', true );
				wp_register_script( 'js-wp-editor', anva_get_core_uri() . '/assets/js/admin/js-wp-editor.min.js', array( 'jquery' ), '1.1', true );
				wp_register_script( 'anva-builder', anva_get_core_uri() . '/assets/js/admin/builder.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, true );
				
				wp_enqueue_script( 'tooltipster' );
				wp_enqueue_script( 'js-wp-editor' );
				wp_enqueue_script( 'anva-builder' );
				
				wp_localize_script( 'anva-builder', 'ANVA', anva_get_admin_locals( 'metabox_js' ) );
				wp_localize_script( 'js-wp-editor', 'ap_vars', $wp_editor );

			}
		}
	}

	/**
	 * Call WP's add_meta_box() for each post type
	 *
	 * @since 1.0.0
	 */
	public function add() {

		// Filters
		$this->args = apply_filters( 'anva_builder_args_' . $this->id, $this->args );

		foreach ( $this->args['page'] as $page ) {
			add_meta_box(
				$this->id,
				$this->args['title'],
				array( $this, 'display' ),
				$page,
				$this->args['context'],
				$this->args['priority']
			);
		}
	}

	/**
	 * Renders the content of the meta box
	 *
	 * @since 1.0.0
	 */
	public function display( $post ) {
		
		$enable			= '0';
		$shortcodes = $this->options;
		$settings 	= get_post_meta( $post->ID, $this->id, true );
		$items 			= array();

		if ( isset( $settings['enable'] ) ) {
			$enable = $settings['enable'];
		}

		if ( isset( $settings['order'] ) ) {
			$order = $settings['order'];
		}

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->id, $this->id . '_nonce' );

		?>
		<input type="hidden" id="anva_builder_id" name="anva_builder_id" value="<?php echo esc_attr( $this->id ); ?>" />
		<input type="hidden" id="anva_shortcode" name="anva_shortcode" value="" />
		<input type="hidden" id="anva_shortcode_title" name="anva_shortcode_title"  value="" />
		<input type="hidden" id="anva_shortcode_image" name="anva_shortcode_image" value="" />
		<input type="hidden" id="anva_shortcode_order" name="<?php echo esc_attr( $this->id . '[order]' ); ?>" value="" />
		<input type="hidden" id="anva_current_item" name="anva_current_item" value="" />

		<div class="anva-meta-box">

			<div class="anva-input-checkbox">
				<a id="anva-builder-button" href="#" class="button button-primary button-large" data-enable="<?php _e( 'Page Builder', 'anva' ); ?>" data-disable="<?php _e( 'Default Editor', 'anva' ); ?>"><?php _e( 'Page Builder' ); ?></a>
				<input type="checkbox" name="<?php echo esc_attr( $this->id . '[enable]' ); ?>" value="1" <?php checked( $enable, 1, true ); ?> class="anva-builder-enable hidden" />
				<div class="anva-tooltip-info-html hidden">
					<h3>Quick Info</h3>
					<p><?php _e( 'Select below the item you want to display and click "+ Add Item", it will add inline form for selected element once you finish customizing click "Apply" button. You can Drag & Drop each items to re order them.', 'anva' ); ?></p>
				</div>
				<a href="#" class="anva-tooltip-info"><span class="dashicons dashicons-info"></span></a>
			</div><!-- .anva-input-checkbox (end) -->
		
			<div class="anva-input-builder hidden">
				
				<div class="clear"></div>
				
				<div id="elements-wrapper">
					
					<?php	if ( ! empty ( $tabs ) ) : ?>
						<ul class="anva-tabs">
							<?php foreach ( $tabs as $key => $tab ) :	?>
								<li><a href="#elements-tab-<?php echo esc_attr( $key ); ?>"><?php echo $tab; ?></a></li>
							<?php	endforeach; ?>
						</ul><!-- .tabs (end) -->
					<?php endif; ?>
					
					<div id="elements-tabs">
						<ul class="builder-elements">
							<?php foreach ( $shortcodes as $key => $shortcode ) : ?>
								<?php if ( isset( $shortcode['icon'] ) && ! empty( $shortcode['icon'] ) ) : ?>
									<li class="tooltip" title="<?php echo esc_attr( $shortcode['desc'] ); ?>" data-element="<?php echo esc_attr( $key ); ?>" data-title="<?php echo esc_attr( $shortcode['title'] ); ?>">
										<div class="element">
											<img class="icon-thumbnail" src="<?php echo esc_url( $shortcode['icon'] ); ?>" alt="<?php echo esc_attr( $shortcode['title'] ); ?>" />
											<span class="icon-title"><?php echo $shortcode['title']; ?></span>
										</div>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div><!-- #elements-tab (end) -->
				</div><!-- #elements-tabs (end) -->
				
				<div class="anva-input-builder-action">
					
					<div class="anva-backup-container">
						<a href="#" class="button button-toggle"><?php _e( 'Backup', 'anva' ); ?></a>
						<div class="anva-backup-inner">
							<span class="anva-arrow"></span>
							<div class="anva-export-wrap">
								<input type="hidden" id="anva-export" name="anva_export" />
								<input type="submit" class="button button-primary button-export" value="<?php _e( 'Export', 'anva' ); ?>" />
							</div>
							<div class="anva-import-wrap">
								<input type="hidden" id="anva-import" name="anva_import" />
								<input type="submit" class="button button-secondary button-import" value="<?php _e( 'Import', 'anva' ); ?>" />
								<input type="file" id="anva-import-file" name="anva_import_file" />
							</div>
						</div>
					</div>
					
					<a id="remove-all-items" class="button button-secondary button-remove-all"><?php _e( 'Remove All Items', 'anva' ); ?></a>
					<a id="add-builder-item" class="button button-primary button-add-item"><?php _e( 'Add New Item', 'anva' ); ?></a>
				</div>
				
				<?php
					if ( isset( $order ) ) {
						$items = explode( ',', $order );
					}

					$empty = '';
					if ( ! isset( $items[0] ) || empty( $items[0] ) ) {
						$empty = 'empty';
					}
				?>
				
				<ul id="builder-sortable-items" class="builder-sortable-items sortable-items <?php echo $empty; ?>" rel="builder-sortable-items_data"> 
				<?php

					if ( isset( $items[0] ) && ! empty( $items[0] ) ) :
						
						foreach ( $items as $item_id => $item )	:

							$data = $settings[$item]['data'];
							$obj  = json_decode( $data );

							if ( isset( $item[0] ) && isset( $shortcodes[$obj->shortcode] ) ) :
								
								$shortcode_type = $shortcodes[$obj->shortcode]['title'];
								$shortocde_icon = $shortcodes[$obj->shortcode]['icon'];
								$shortcode = $obj->shortcode;
								$obj_title_name = '';

								if ( $obj->shortcode != 'divider' ) {
									$obj_title_name = $obj->shortcode . '_title';
									
									if ( property_exists( $obj, $obj_title_name ) ) {
										$obj_title_name = $obj->$obj_title_name;
										
									} else {
										$obj_title_name = '';
									}

								} else {
									$obj_title_name = '<span class="shortcode-type">' . __( 'Divider', 'anva' ) . '</span>';
									$shortcode_type = '';
								}
								?>
								<li id="<?php echo esc_attr( $item ); ?>" class="item item-<?php echo esc_attr( $item ); ?> ui-state-default <?php echo esc_attr( $shortcode ); ?>">
									<div class="actions">
										<a title="<?php esc_html_e( 'Move Item Up', 'anva' ); ?>" href="#" class="button-move-up"></a>
										<a title="<?php esc_html_e( 'Move Item Down', 'anva' ); ?>" href="#" class="button-move-down"></a>
										<a title="<?php esc_html_e( 'Edit Item', 'anva' ); ?>" href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=anva_builder_get_fields&shortcode=' . $shortcode . '&rel=' . $item ) ); ?>" class="button-edit" data-id="<?php echo esc_attr( $item ); ?>"></a>
										<a title="<?php esc_html_e( 'Remove Item', 'anva' )?>" href="#" class="button-remove"></a>
									</div>
									<div class="thumbnail">
										<img src="<?php echo esc_url( $shortocde_icon ); ?>" alt="<?php echo esc_attr( $shortcode_type ); ?>" />
									</div>
									<div class="title">
										<span class="shortcode-type"><?php echo $shortcode_type; ?></span>
										<span class="shortcode-title"><?php echo urldecode( $obj_title_name ); ?></span>
									</div>
									<span class="spinner spinner-<?php echo esc_attr( $item ); ?>"></span>
									<div class="clear"></div>
								</li>
								<?php
							endif;
						endforeach;
					endif;
				?>
				</ul><!-- .sortable (end) -->
				<div class="sortable-footer">
					<div class="message">
						<?php
							printf(
								'%s %s <span class="alignright">%s %s</span>',
								__( 'Anva Page Builder powered by Anva Framework', 'anva' ),
								ANVA_FRAMEWORK_VERSION,
								__( 'Develop by', 'anva' ),
								sprintf( '<a href="http://anthuanvasquez.net/">%s</a>', 'Anthuan Vasquez' )
							);
						?>
					</div>
				</div>
			</div><!-- .anva-input-builder (end) -->
		
			<?php
			$output  = "";
			$output .= "<script type='text/javascript'>\n";
			$output .= "jQuery(document).ready(function($) {\n";
			$output .= "/* <![CDATA[ */\n";
			
			foreach ( $items as $key => $item ) {
				if ( ! empty( $item ) ) {
					$item_data = $settings[$item]['data'];
					$output .= "$('#" . esc_js( $item ) . "').data('anva_builder_settings', '" . addslashes( $item_data ) . "');\n";
				}
			}
			
			$output .= "/* ]]> */\n";
			$output .= "});\n";
			$output .= "</script>";

			echo $output;
			?>
		
		</div><!-- .anva-meta-box (end) -->
	<?php
	}

	/**
	 * Save meta data sent from meta box
	 * 
	 * @since 1.0.0
	 * @param integer The post ID
	 */
	public function save( $post_id ) {

		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST[$this->id . '_nonce'] ) )
			return $post_id;

		$nonce = $_POST[$this->id . '_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, $this->id ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
		// so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/*
		 * OK, its safe!
		 */

		$this->backup_content();

		$data = array();
		
		if ( isset( $_POST[$this->id] ) && ! empty( $_POST[$this->id] ) ) {
			foreach ( $_POST[$this->id] as $id => $value ) {
				$data[$id] = $value;
			}
			update_post_meta( $post_id, $this->id, $data );

			return $post_id;
		}

		delete_post_meta( $post_id, $this->id );

	}
	
	/**
	 * Admin notices
	 *
	 * @since 1.0.0
	 */
	public function admin_notices() {
		if ( isset( $_GET['imported'] ) && $_GET['imported'] == 'true' ) {
			printf( '<div id="message" class="updated"><p>%s</p></div>', __( 'Content has successfully imported.', 'anva' ) );
		
		} else if ( isset( $_GET['error'] ) && $_GET['error'] == 'true' ) {
			echo '<div id="message" class="error"><p>' . __( 'There was a problem importing your content. Please Try again.' ) . '</p></div>';

		}
	}

	/**
	 * Export or Import builder content
	 *
	 * @since 1.0.0
	 */
	public function backup_content () {
		if ( isset( $_POST['anva_import'] ) && ( $_POST['anva_import'] == '1' ) ) {
			$this->import();
		}

		if ( isset( $_POST['anva_export'] ) && ( $_POST['anva_export'] == '1' ) ) {
			$this->export();
		}
	}

	/**
	 * Import builder content
	 *
	 * @since 1.0.0
	 */
	public function import() {

		global $post;
		
		if ( ! isset( $_FILES['anva_import_file'] ) || $_FILES['anva_import_file']['error'] > 0 ) {
			wp_redirect( admin_url( 'post.php?post=' . $post->ID . '&action=edit&error=true' ) );
			return;
		}

		// Check if zip file
		$import_filename 	= $_FILES['anva_import_file']['name'];
		$import_type 			= $_FILES['anva_import_file']['type'];
		$is_zip 					= false;
		$new_filename 		= basename( $import_filename, '_.zip' );
		$accepted_types 	= array(
			'application/zip', 
			'application/x-zip-compressed', 
			'multipart/x-zip', 
			'application/s-compressed'
		);

		foreach ( $accepted_types as $mime_type ) {
			if ( $mime_type == $import_type ) {
				$is_zip = true;
				break;
			}
		}
		
		// ZIP file
		if ( $is_zip ) {
			
			$option_name = anva_get_option_name();

			WP_Filesystem();
			$upload_dir = wp_upload_dir();
			$cache_dir 	= '';
			
			if ( isset( $upload_dir['basedir'] ) ) {
				$cache_dir = $upload_dir['basedir'] . '/' . $option_name;
			}
			
			move_uploaded_file( $_FILES['anva_import_file']['tmp_name'], $cache_dir . '/' . $import_filename );
			// $unzipfile = unzip_file( $cache_dir . '/' . $import_filename, $cache_dir );
			
			$zip = new ZipArchive();
			$x 	 = $zip->open( $cache_dir . '/' . $import_filename );
			
			for ( $i = 0; $i < $zip->numFiles; $i++ ) {
				$new_filename = $zip->getNameIndex($i);
				break;
			}  
			
			if ( $x === true ) {
				$zip->extractTo( $cache_dir ); 
				$zip->close();
			}

			$import_options = file_get_contents( $cache_dir . '/' . $new_filename );

			unlink( $cache_dir . '/' . $import_filename );
			unlink( $cache_dir . '/' . $new_filename );
		
		} else {
			$import_options = file_get_contents( $_FILES['anva_import_file']['tmp_name'] );
		}
		
		$import_options = json_decode( $import_options, true );
		
		update_post_meta( $post->ID, $this->id, $import_options );

		wp_redirect( admin_url( 'post.php?post=' . $post->ID . '&action=edit&imported=true' ) );
		
		exit;

	}

	/**
	 * Export builder content
	 *
	 * @since 1.0.0
	 */
	public function export() {

		global $post;
		
		$page_slug = get_the_title( $post->ID );
		$page_slug = sanitize_title( $page_slug );
		$option_name = anva_get_option_name();
		$filename = strtolower( $option_name ) . '_page_builder_' . $page_slug . '_' . date( 'Y-m-d_hia' );
		
		// Get current content
		$export_options = get_post_meta( $post->ID, $this->id, true );

		// Convert to JSON
		$output = json_encode( $export_options );
		
		header( 'Content-Description: File Transfer' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: application/json' );
		header( 'Content-Disposition: attachment; filename="' . $filename . '.json"' );
		header( 'Content-Length: ' . strlen( $output ) );
		echo $output;
		exit;

	}

	/**
	 * Get ajax fields
	 *
	 * @since 1.0.0
	 */
	function ajax_get_fields() {

		if ( isset( $_GET['shortcode'] ) && ! empty( $_GET['shortcode'] ) ) :
			
			$shortcodes = $this->options;

			if ( isset( $shortcodes[$_GET['shortcode']] ) ) :
				$id 					 = $_GET['rel'];
				$shortcode 		 = $_GET['shortcode'];
				$shortcode_arr = $shortcodes[$shortcode];
				?>

				<div id="item-inline-<?php echo esc_attr( $id ); ?>" data-shortcode="<?php echo esc_attr( $shortcode ); ?>" class="item-inline item-inline-<?php echo esc_attr( $id); ?>">
				
				<div class="wrap">
					<h2><?php echo $shortcode_arr['title']; ?></h2>
					<a id="save-<?php echo esc_attr( $id ); ?>" class="button button-primary button-save" href="#"><?php _e( 'Apply', 'anva' ); ?></a>
					<a id="cancel-<?php echo esc_attr( $id ); ?>" class="button button-secondary button-cancel" href="#"><?php _e( 'Cancel', 'anva' ); ?></a>
				</div><!-- .wrap (end) -->

				<?php
					if ( isset( $shortcode_arr['title'] ) && $shortcode_arr['title'] != 'Divider' ) :
					$title = $shortcode . '_title';
					$value = $shortcode_arr['title'];
				?>
					<div class="section section-title">
						<label for="<?php echo $title; ?>"><?php _e( 'Title', 'anva' ); ?></label>
						<div class="option">
							<div class="controls">
								<input type="text" id="<?php echo $title; ?>" name="<?php echo $title; ?>" data-attr="title" value="<?php echo $value; ?>" class="anva-input" />
							</div>
							<div class="explain"><?php _e( 'Enter title for this content.', 'anva' ); ?></div>
						</div>
					</div>
				<?php else : ?>
					<input type="hidden" id="<?php echo $title; ?>" name="<?php echo $title; ?>" data-attr="title" value="<?php echo $value; ?>" class="anva-input" />
				<?php endif;

				foreach ( $shortcode_arr['attr'] as $attr_id => $attr ) :

					$title = ucfirst( $attr_id );
					$name  = $shortcode . '_' . $attr_id;
					$desc  = $attr['desc'];
					$value = '';

					if ( isset( $attr['std'] ) ) {
						$value = $attr['std'];
					}

					if ( isset( $attr['title'] ) ) {
						$title = $attr['title'];
					}

					switch ( $attr['type'] ) :
						
						case "slider": ?>
							<div class="section section-slider">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $name; ?>" id="<?php echo $name; ?>" type="range" class="rangeslider anva-input" min="<?php echo $attr['min']; ?>" max="<?php echo $attr['max']; ?>" step="<?php echo $attr['step']; ?>" value="<?php echo $value; ?>" />
										<output for="<?php echo $name; ?>" onforminput="value = foo.valueAsNumber;"></output>
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
							
						case 'file': ?>
							<div class="section section-file">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $name; ?>" id="<?php echo $name; ?>" type="text"  class="anva-input anva-file" />
										<a id="<?php echo $name; ?>_button" name="<?php echo $name; ?>_button" type="button" class="button anva-upload-button" rel="<?php echo $name; ?>"><?php _e( 'Upload', 'anva' ); ?></a>
										<div class="screenshot" id="<?php echo $name; ?>_image"></div>
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'select': ?>
							<div class="section section-select">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<select name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="anva-input">
											<?php foreach ( $attr['options'] as $key => $value ) : ?>
												<option value="<?php echo $key; ?>"><?php echo ucfirst( $value ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'select_multiple': ?>
							<div class="section section-select-multiple">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<select name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="anva-input" multiple="multiple">
											<?php foreach ( $attr['options'] as $key => $value ) : ?>
												<?php if ( ! empty( $value ) ) : ?>
													<option value="<?php echo $key; ?>"><?php echo ucfirst( $value ); ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'text': ?>
							<div class="section section-text">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $name; ?>" id="<?php echo $name; ?>" type="text" class="anva-input" />
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'colorpicker': ?>
							<div class="section section-colorpicker">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $name; ?>" id="<?php echo $name; ?>" type="text" class="anva-input colorpicker" value="<?php echo esc_attr( $value ); ?>" readonly />
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;

						case 'textarea': ?>
							<div class="section section-textarea">
								<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
								<div class="option">
									<div class="controls">
										<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" rows="3" class="anva-input"></textarea>
									</div>
									<div class="explain"><?php echo $desc; ?></div>
								</div>
							</div>
							<?php break;
					endswitch;	
				endforeach; ?>
				
				<?php if ( isset ( $shortcode_arr['content'] ) && $shortcode_arr['content'] ) : ?>
				<?php
					$editor_id = $shortcode . '_content';
				?>
				<div class="section section-content">
					<label for="<?php echo $editor_id; ?>"><?php _e( 'Content', 'anva' ); ?></label>
					<div class="explain"><?php printf( '%s <strong>%s</strong>.', __( 'Enter text/HTML content to display in this item', 'anva' ), $shortcode_arr['title'] ); ?></div>
					<div class="controls">
						<textarea id="<?php echo esc_attr( $editor_id ); ?>" name="<?php echo esc_attr( $editor_id ); ?>" rows="10" class="anva-input anva-textarea anva-wp-editor"></textarea>
					</div>
				</div>
				<?php endif; ?>

			</div><!-- .item-inline (end) -->
			
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready( function($) {

				var currentItemData = $('#<?php echo esc_js( $id ); ?>').data('anva_builder_settings');
				var currentItemOBJ = $.parseJSON( currentItemData );

				$.each( currentItemOBJ, function( index, value ) {
					if ( typeof $('#' + index) != 'undefined' ) {
						$('#' + index).val( decodeURI( value ) );
					}
				});

				// Cancel Changes
				$("#cancel-<?php echo esc_js( $id ); ?>").on( 'click', function(e) {
					e.preventDefault();
					var itemInner = $('#item-inner-<?php echo esc_js( $id ); ?>');
					var parentEle = $('#<?php echo esc_js( $id ); ?>');
					if ( parentEle.hasClass('has-inline-content') ) {
						parentEle.removeClass('has-inline-content');
					}
					if ( itemInner.length > 0 ) {
						itemInner.slideToggle();
						setTimeout( function() {
							itemInner.remove();
						}, 600);
					}
				});
				
				// Apply Changes
				$("#save-<?php echo esc_js( $id ); ?>").on( 'click', function(e) {
					e.preventDefault();

					// Validate title
					var title = $(this).closest('.item-inline').find(".section-title input");
					if ( title.val() == '' ) {
						alert( 'The title field is required.' );
						return false;
					}
					
					// WP Editor
					// tinyMCE.triggerSave();
			
					var targetItem = $('#anva_current_item').val();
					var currentShortcode = $('#item-inline-<?php echo esc_js( $id ); ?>').attr('data-shortcode');
					var itemData = {};

					itemData.id = targetItem;
					itemData.shortcode = currentShortcode;
					
					$('#item-inline-<?php echo esc_js( $id ); ?> :input.anva-input').each( function() {
						if ( typeof $(this).attr('id') != 'undefined' ) {
							itemData[$(this).attr('id')] = encodeURI( $(this).val() );
							
							if ( $(this).attr('data-attr') == 'title' ) {
								$('#' + targetItem).find('.title .shortcode-title').html( decodeURI( $(this).val() ) );
								
								if ( $('#' + targetItem).find('.unsave').length == 0 ) {
									$('<span class="unsave">' + ANVA.builder_unsaved + '</span>').appendTo( $('#' + targetItem).find('.title .shortcode-type') );
									$('#' + targetItem).addClass('item-unsaved');
								}
							}
						}
					});
					
					var currentItemDataJSON = JSON.stringify( itemData );
					var itemInner = $('#item-inner-<?php echo esc_js( $id ); ?>');

					$('#' + targetItem).data( 'anva_builder_settings', currentItemDataJSON );

					var parentEle = $('#<?php echo esc_js( $id ); ?>');
					
					if ( parentEle.hasClass('has-inline-content') ) {
						parentEle.removeClass('has-inline-content');
					}

					if ( itemInner.length > 0 ) {
						itemInner.slideToggle();
						setTimeout( function() {
							itemInner.remove();
						}, 600);
					}
				});
			});
			/* ]]> */
			</script>
		<?php endif; ?>
	<?php endif; ?>	
	<?php die(); // Exit
	}
}
endif;
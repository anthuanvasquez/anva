<?php
/**
 * Builder Meta Box
 *
 * @since 		 1.0.0
 * @package    Anva
 * @subpackage Anva/builder
 * @author     Anthuan Vasquez <eigthy@gmail.com>
 */

class Anva_Page_Builder_Meta_Box {

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
		add_action( 'wp_ajax_pp_ppb', array( $this, 'fields' ) );
		add_action( 'wp_ajax_nopriv_pp_ppb', array( $this, 'fields' ) );
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
			if ( $typenow != $page )
				return;
	
			$builder_dir = anva_get_core_url() . '/admin/includes/builder';
			
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
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'wplink' );
			wp_enqueue_script( 'wpdialogs-popup' );

			/* ---------------------------------------------------------------- */
			/* Custom
			/* ---------------------------------------------------------------- */

			wp_enqueue_style( 'jquery-ui-custom', 		anva_get_core_url() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '1.11.4', 'all' );
			wp_enqueue_style( 'tooltipster', 					anva_get_core_url() . '/assets/css/admin/tooltipster.min.css', array(), '3.3.0', 'all' );
			wp_enqueue_style( 'anva-builder', 				anva_get_core_url() . '/assets/css/admin/builder.css', array( 'jquery-ui-custom', 'tooltipster' ), ANVA_FRAMEWORK_VERSION, 'all' );

			wp_register_script( 'tooltipster', 			anva_get_core_url() . '/assets/js/admin/jquery.tooltipster.min.js', array( 'jquery' ), '3.3.0', true );
			wp_register_script( 'js-wp-editor', 			anva_get_core_url() . '/assets/js/admin/js-wp-editor.min.js', array( 'jquery' ), '1.1', true );
			wp_register_script( 'anva-builder', 			anva_get_core_url() . '/assets/js/admin/builder.js', array( 'jquery', 'wp-color-picker' ), ANVA_FRAMEWORK_VERSION, true );
			
			wp_enqueue_script( 'tooltipster' );
			wp_enqueue_script( 'js-wp-editor' );
			wp_enqueue_script( 'anva-builder' );
			
			wp_localize_script( 'anva-builder', 'ANVA', anva_get_admin_locals( 'metabox_js' ) );
			wp_localize_script( 'js-wp-editor', 'ap_vars', $wp_editor );
			
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
	public function display() {
		
		$enable								= 0;
		$shortcodes 					= $this->options;
		$settings 						= anva_get_page_builder_field();
		$items 								= array();

		if ( isset( $settings['enable'] ) ) {
			$enable = $settings['enable'];
		}

		if ( isset( $settings['order'] ) ) {
			$ppb_form_data_order = $settings['order'];
		}

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->id, $this->id . '_nonce' );

		?>
		
		<div class="anva-meta-box anva-meta-context-normal">

			<div class="meta field-checkbox">
				<h4 class="heading"><?php _e( 'Enable', 'anva' ); ?></h4>
				<div class="meta-option">
					<div class="meta-controls">
						<input type="checkbox" class="enable-builder" name="ppb_enable" value="1" <?php checked( $enable, 1, true ); ?> />
					</div>
					<div class="meta-explain description">
						<?php _e( 'To use page builder, please enable this option.', 'anva' ); ?>
					</div>
				</div>
			</div><!-- .meta (end) -->
		
			<div class="meta meta-content-builder hidden">

				<h4 class="heading"><?php _e( 'Content Builder', 'anva' ); ?></h4>
				<div class="meta-option">
					<div class="meta-explain description">
						<?php _e( 'Select below the item you want to display and click "+ Add Item", it will add inline form for selected element once you finish customizing click "Apply" button. You can Drag & Drop each items to re order them.', 'anva' ); ?>
					</div>
				</div>
			
				<input type="hidden" id="anva_post_type" name="ppb_post_type" value="page" />
				<input type="hidden" id="anva_options" name="ppb_options" value="" />
				<input type="hidden" id="anva_options_title" name="ppb_options_title"  value="" />
				<input type="hidden" id="anva_options_image" name="ppb_options_image" value="" />
				<input type="hidden" id="anva_inline_current" name="ppb_inline_current" value="" />
				<input type="hidden" id="anva_form_data_order" name="ppb_form_data_order" value="" />
			
				<?php
					// Tabs
					$tabs = array();
					//foreach ( $shortcodes as $key => $shortcode ) {
						//if ( is_numeric( $key ) && $shortcode['title'] != 'Close' ) {
						//	$tabs[$key] = $shortcode['title'];
						//}
					//}

					//var_dump(anva_get_elements());
					// var_dump(anva_is_block_element( 'box', 'subtitle' ));
					// $args_block = array(
					// 	'title' => 'Font Color (Optional)',
					// 	'type' => 'colorpicker',
					// 	"std" => "#444444",
					// 	'desc' => 'Select font color for this content',
					// );
					// anva_add_block_builder_element( 'box', 'fontcolor', $args_block );
				?>

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
										<img class="icon-thumbnail" src="<?php echo esc_url( $shortcode['icon'] ); ?>" alt="<?php echo esc_attr( $shortcode['title'] ); ?>" />
										<span class="icon-title"><?php echo $shortcode['title']; ?></span>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul><!-- .builder-elements (end) -->
						<div class="clear"></div>
					</div><!-- #elements-tab (end) -->	
					
				</div><!-- #elements-tabs (end) -->

				<a id="add-builder-item" class="button button-primary button-add-item"><?php _e( '+ Add Item', 'anva' ); ?></a>
				
				<div class="sortable-header">
					<div class="message"><?php _e( 'Drag and drop to reorder', 'anva' ); ?></div>
				</div>
				
				<div class="clear"></div>

				<?php
					if ( isset( $ppb_form_data_order ) ) {
						$items = explode( ',', $ppb_form_data_order );
					}

					$empty = '';
					if ( ! isset( $items[0] ) || empty( $items[0] ) ) {
						$empty = 'empty';
					}
				?>
				
				<ul id="builder-sortable-items" class="builder-sortable-items sortable-items <?php echo $empty; ?>" rel="builder-sortable-items_data"> 
				<?php

					if ( isset( $items[0] ) && ! empty( $items[0] ) ) :
						
						foreach ( $items as $key => $item )	:

							$item_data = $settings[$item]['data'];
							$item_size = $settings[$item]['size'];
							$item_obj  = json_decode( $item_data );
						
							if ( isset( $item[0] ) && isset( $shortcodes[$item_obj->shortcode] ) ) :
								$shortcode_type = $shortcodes[$item_obj->shortcode]['title'];
								$shortocde_icon = $shortcodes[$item_obj->shortcode]['icon'];
								
								$shortcode = $item_obj->shortcode;

								if ( $item_obj->shortcode != 'ppb_divider' ) {
									$obj_title_name = $item_obj->shortcode . '_title';
									
									if ( property_exists( $item_obj, $obj_title_name ) ) {
										$obj_title_name = $item_obj->$obj_title_name;
									} else {
										$obj_title_name = '';
									}

								} else {
									$obj_title_name = '<span class="shortcode-type">' . __( 'Divider', 'anva' ) . '</span>';
									$shortcode_type = '';
								}
								?>
								<li id="<?php echo esc_attr( $item ); ?>" class="item item-<?php echo esc_attr( $item ); ?> ui-state-default <?php echo esc_attr( $shortcode ); ?>" data-current-size="<?php echo esc_attr( $item_size ); ?>">
									<div class="actions">
										<a title="<?php esc_html_e( 'Edit Item', 'anva' ); ?>" href="<?php echo esc_url( admin_url( 'admin-ajax.php?action=pp_ppb&ppb_post_type=page&shortcode=' . $shortcode . '&rel=' . $item ) ); ?>" class="button-edit" data-rel="<?php echo esc_attr( $item ); ?>"></a>
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
									<input type="hidden" class="ppb_setting_columns" value="<?php echo esc_attr( $item_size ); ?>" />
									<div class="clear"></div>
								</li>
								<?php
							endif;
						endforeach;
					endif;
				?>
				</ul><!-- .sortable (end) -->
			</div><!-- .meta-content-builder (end) -->
			
			<div class="meta meta-content-builder-export hidden">
				<div id="export-tabs">
					<ul>
						<li><a href="#meta-tabs-1"><?php _e( 'Import', 'anva' ); ?></a></li>
						<li><a href="#meta-tabs-2"><?php _e( 'Export', 'anva' ); ?></a></li>
					</ul>

					<div id="meta-tabs-1" class="meta-import">
						<h4><?php _e( 'Import Page Content Builder', 'anva' ); ?></h4>
						<div class="meta-option">
							<div class="meta-controls">
								<input type="file" id="ppb_import_current_file" name="ppb_import_current_file" value="0" />
								<input type="hidden" id="ppb_import_current" name="ppb_import_current" value="1"/>
								<input type="submit" id="ppb_import_current_button" class="button" value="<?php _e( 'Import', 'anva' ); ?>" />
							</div>
							<div class="meta-description">
								<div class="pp_widget_description">
									<?php _e( 'Choose the import file. *Note: Your current content builder content will be overwritten by imported data', 'anva' ); ?>
								</div>
							</div>
						</div>
						
					</div><!-- .meta-import (end) -->
				
					<div id="meta-tabs-2" class="meta-export">
						<h4><?php _e( 'Export Page Content Builder', 'anva' ); ?></h4>
						<div class="meta-option">
							<div class="meta-controls">
								<input type="hidden" id="ppb_export_current" name="ppb_export_current" value="1" />
								<input type="submit" id="ppb_export_current_button" name="ppb_export_current_button" class="button" value="<?php _e( 'Export', 'anva' ); ?>" />
							</div>
							<div class="meta-description">
								<div class="pp_widget_description">
									<?php _e( 'Click to export current content builder data. Note: Please make sure you save all changes and no "unsaved" module', 'anva' ); ?>
								</div>
							</div>
						</div>
					</div><!-- .meta-export (end) -->
				</div><!-- #meta_tab (end) -->
			</div><!-- .meta-content-builder-export (end) -->
		
			<?php
			$output  = "";
			$output .= "<script type='text/javascript'>\n";
			$output .= "jQuery(document).ready(function() {\n";
			$output .= "/* <![CDATA[ */\n";
			
			foreach ( $items as $key => $item ) {
				if ( ! empty( $item ) ) {
					$item_data = $settings[$item]['data'];
					$output .= "jQuery('#" . esc_js( $item ) . "').data('anva_builder_settings', '" . addslashes( $item_data ) . "');\n";
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

		$id  = $this->id;
		$old = get_post_meta( $post_id, $id, true );

		/* ---------------------------------------------------------------- */
		/* Import page content builder
		/* ---------------------------------------------------------------- */

		// if ( isset( $_POST['ppb_import_current'] ) && ! empty( $_POST['ppb_import_current_file'] ) ) {
		// 	// Check if zip file
		// 	$import_filename 	= $_FILES['ppb_import_current_file']['name'];
		// 	$import_type 			= $_FILES['ppb_import_current_file']['type'];
		// 	$is_zip 					= FALSE;
		// 	$new_filename 		= basename( $import_filename, '_.zip' );
		// 	$accepted_types 	= array(
		// 		'application/zip', 
		// 		'application/x-zip-compressed', 
		// 		'multipart/x-zip', 
		// 		'application/s-compressed'
		// 	);
 
		// 	foreach ( $accepted_types as $mime_type ) {
		// 		if ( $mime_type == $import_type ) {
		// 			$is_zip = true;
		// 			break;
		// 		}
		// 	}
			
		// 	if ( $is_zip ) {
		// 		WP_Filesystem();
		// 		$upload_dir = wp_upload_dir();
		// 		$cache_dir 	= '';
				
		// 		if ( isset( $upload_dir['basedir'] ) ) {
		// 			$cache_dir = $upload_dir['basedir'] . '/meteors';
		// 		}
				
		// 		move_uploaded_file( $_FILES["ppb_import_current_file"]["tmp_name"], $cache_dir . '/' . $import_filename );
		// 		// $unzipfile = unzip_file( $cache_dir . '/' . $import_filename, $cache_dir );
				
		// 		$zip = new ZipArchive();
		// 		$x = $zip->open( $cache_dir . '/' . $import_filename );
				
		// 		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
		// 			$new_filename = $zip->getNameIndex($i);
		// 			break;
		// 		}  
				
		// 		if ( $x === true ) {
		// 			$zip->extractTo( $cache_dir ); 
		// 			$zip->close();
		// 		}

		// 		$import_options_json = file_get_contents( $cache_dir . '/' . $new_filename );
		// 		unlink( $cache_dir . '/' . $import_filename );
		// 		unlink( $cache_dir . '/' . $new_filename );
			
		// 	} else {
		// 		//If .json file then import
		// 		$import_options_json = file_get_contents( $_FILES["ppb_import_current_file"]["tmp_name"] );
		// 	}
			
		// 	$import_options_arr = json_decode( $import_options_json, true );
			
		// 	if ( isset( $import_options_arr['ppb_form_data_order'][0] ) && ! empty( $import_options_arr['ppb_form_data_order'][0] ) ) {
		// 		page_update_custom_meta( $post_id, $import_options_arr['ppb_form_data_order'][0], 'ppb_form_data_order' );
		// 	}
			
		// 	$ppb_item_arr = explode( ',', $import_options_arr['ppb_form_data_order'][0] );
			
		// 	if ( is_array( $ppb_item_arr ) && !empty( $ppb_item_arr ) ) {
		// 		foreach ( $ppb_item_arr as $key => $ppb_item_arr ) {
					
		// 			if ( isset( $import_options_arr[$ppb_item_arr . '_data'][0] ) && ! empty( $import_options_arr[$ppb_item_arr . '_data'][0] ) ) {
		// 				page_update_custom_meta( $post_id, $import_options_arr[$ppb_item_arr.'_data'][0], $ppb_item_arr . '_data' );
		// 			}
					
		// 			if ( isset( $import_options_arr[$ppb_item_arr . '_size'][0] ) && ! empty( $import_options_arr[$ppb_item_arr . '_size'][0] ) ) {
		// 				page_update_custom_meta( $post_id, 'one', $ppb_item_arr . '_size' );
		// 			}
		// 		}
		// 	}
			
		// 	header( "Location: " . $_SERVER['HTTP_REFERER'] );
		// 	exit;
		// }

		/* ---------------------------------------------------------------- */
		/* Export page content builder
		/* ---------------------------------------------------------------- */

		// if ( isset( $_POST['ppb_export_current'] ) && ! empty( $_POST['ppb_export_current'] ) ) {
			
		// 	$page_slug = get_the_title( $post_id );
		// 	$page_slug = sanitize_title( $page_slug );
		// 	$option_name = anva_get_option_name();
		// 	$json_file_name = strtolower( $option_name ) . '_page_builder_' . $page_slug . '_' . date( 'Y-m-d_hia' );
	
		// 	header( 'Content-disposition: attachment; filename=' . $json_file_name . '.json' );
		// 	header( 'Content-type: application/json' );
			
		// 	//Get current content builder data
		// 	$ppb_form_data_order = $old['order'];
		// 	$export_options_arr = array();
			
		// 	if ( ! empty( $ppb_form_data_order ) ) {
		// 		$export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

		// 		//Get each builder module data
		// 		$ppb_form_item_arr = explode( ',', $ppb_form_data_order );
			
		// 		foreach ( $ppb_form_item_arr as $key => $ppb_form_item ) {
		// 			$ppb_form_item_data = $old[$ppb_form_item]['data'];
		// 			$export_options_arr[$ppb_form_item]['data'] = $ppb_form_item_data;
					
		// 			$ppb_form_item_size = $old[$ppb_form_item]['size'];
		// 			$export_options_arr[$ppb_form_item]['size'] = $ppb_form_item_size;
		// 		}
		// 	}
			
		// 	echo json_encode( $export_options_arr );
			
		// 	exit;
		// }

		/* ---------------------------------------------------------------- */
		/* Saving Page Builder Data
		/* ---------------------------------------------------------------- */

		$builder_data = array();
		$enable = 0;

		if ( isset( $_POST['ppb_enable'] ) && ! empty( $_POST['ppb_enable'] ) ) {
			$enable = $_POST['ppb_enable'];
		}

		$builder_data['enable'] = $enable;

		if ( isset( $_POST['ppb_form_data_order'] ) && ! empty( $_POST['ppb_form_data_order'] ) ) {
			
			$builder_data['order'] = $_POST['ppb_form_data_order'];

			$ppb_item_arr = explode( ',', $_POST['ppb_form_data_order'] );

			if ( is_array( $ppb_item_arr ) && ! empty( $ppb_item_arr ) ) {
				foreach ( $ppb_item_arr as $key => $ppb_item_arr ) {

					if ( isset( $_POST[$ppb_item_arr . '_data'] ) && ! empty( $_POST[$ppb_item_arr . '_data'] ) ) {
						$builder_data[$ppb_item_arr]['data'] = $_POST[$ppb_item_arr . '_data'];
					}
					
					if ( isset( $_POST[$ppb_item_arr . '_size'] ) && ! empty( $_POST[$ppb_item_arr . '_size'] ) ) {
						$builder_data[$ppb_item_arr]['size'] = $_POST[$ppb_item_arr . '_size'];
					}

				}

				update_post_meta( $post_id, $id, $builder_data );

			} else {
				update_post_meta( $post_id, $id, '' );
			}
		}

	}

	/**
	 * UI Fields
	 *
	 * @since 1.0.0
	 */
	function fields() {

		if ( isset( $_GET['shortcode'] ) && ! empty( $_GET['shortcode'] ) ) :
			
			$shortcodes = $this->options;
			
			if ( isset( $shortcodes[$_GET['shortcode']] ) && ! empty( $shortcodes[$_GET['shortcode']] ) ) :
				$selected_shortcode = $_GET['shortcode'];
				$selected_shortcode_arr = $shortcodes[$_GET['shortcode']];
				?>

				<div id="ppb_inline_<?php echo $selected_shortcode; ?>" data-shortcode="<?php echo $selected_shortcode; ?>" class="item-inline item-inline-<?php echo esc_attr( $_GET['rel'] ); ?>">

				<div class="wrap">
					<h2><?php echo $selected_shortcode_arr['title']; ?></h2>
					<a id="save-<?php echo $_GET['rel']; ?>" data-parent="ppb_inline_<?php echo $selected_shortcode; ?>" class="button button-primary button-save ppb_inline_save" href="#"><?php _e( 'Apply', 'anva' ); ?></a>
					<a id="cancel-<?php echo $_GET['rel']; ?>" class="button button-secondary button-cancel" href="#"><?php _e( 'Cancel', 'anva' ); ?></a>
				</div><!-- .wrap (end) -->

				<?php if ( isset( $selected_shortcode_arr['title'] ) && $selected_shortcode_arr['title'] != 'Divider' ) : ?>
					<div class="anva-field anva-field-title">
						<label for="<?php echo $selected_shortcode; ?>_title"><?php _e( 'Title', 'anva' ); ?></label>
						<div class="option">
							<div class="controls">
								<input type="text" id="<?php echo $selected_shortcode; ?>_title" name="<?php echo $selected_shortcode; ?>_title" data-attr="title" value="Title" class="ppb_input" />
							</div>
							<div class="description"><?php _e( 'Enter title for this content.', 'anva' ); ?></div>
						</div>
					</div>
				<?php else : ?>
					<input type="hidden" id="<?php echo $selected_shortcode; ?>_title" name="<?php echo $selected_shortcode; ?>_title" data-attr="title" value="<?php echo $selected_shortcode_arr['title']; ?>" class="ppb_input"/>
				<?php endif; ?>
				
				<?php foreach ( $selected_shortcode_arr['attr'] as $attr_name => $attr_item ) : ?>

					<?php
						if ( ! isset( $attr_item['title'] ) ) {
							$attr_title = ucfirst( $attr_name );
						} else {
							$attr_title = $attr_item['title'];
						}
					?>

					<?php switch ( $attr_item['type'] ) :
					
						case "slider": ?>
							<div class="anva-field anva-field-slider">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="range" class="rangeslider ppb_input" min="<?php echo $attr_item['min']; ?>" max="<?php echo $attr_item['max']; ?>" step="<?php echo $attr_item['step']; ?>" value="<?php echo $attr_item['std']; ?>" />
										<output for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" onforminput="value = foo.valueAsNumber;"></output>
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;
							
						case 'file': ?>
							<div class="anva-field anva-field-file">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text"  class="ppb_input ppb_file" />
										<a id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>_button" name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>_button" type="button" class="metabox_upload_btn button" rel="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php _e( 'Upload', 'anva' ); ?></a>
										<div class="screenshot" id="<?php echo $selected_shortcode; ?>_image"></div>
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'select': ?>
							<div class="anva-field anva-field-select">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<select name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" class="ppb_input">
											<?php foreach ( $attr_item['options'] as $attr_key => $attr_item_option ) : ?>
												<option value="<?php echo $attr_key; ?>"><?php echo ucfirst( $attr_item_option ); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'select_multiple': ?>
							<div class="anva-field anva-field-select-multiple">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<select name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" class="ppb_input" multiple="multiple">
											<?php foreach ( $attr_item['options'] as $attr_key => $attr_item_option ) : ?>
												<?php if ( ! empty( $attr_item_option ) ) : ?>
													<option value="<?php echo $attr_key; ?>"><?php echo ucfirst( $attr_item_option ); ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'text': ?>
							<div class="anva-field anva-field-text">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text" class="ppb_input" />
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;
									
						case 'colorpicker': ?>
							<div class="anva-field anva-field-colorpicker">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text" class="ppb_input colorpicker" readonly />
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;

						case 'textarea': ?>
							<div class="anva-field anva-field-textarea">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<div class="option">
									<div class="controls">
										<textarea name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" rows="3" class="ppb_input"></textarea>
									</div>
									<div class="description"><?php echo $attr_item['desc']; ?></div>
								</div>
							</div>
							<?php break;

					endswitch; ?>
					
				<?php endforeach; ?>
				
				<?php if ( isset ( $selected_shortcode_arr['content'] ) && $selected_shortcode_arr['content'] ) : ?>
				<div class="anva-field anva-field-content">
					<label for="<?php echo $selected_shortcode; ?>_content"><?php _e( 'Content', 'anva' ); ?></label>
					<div class="description"><?php printf( '%s %s', _e( 'Enter text/HTML content to display in this item', 'anva' ), $selected_shortcode_arr['title'] ); ?></div>
					<div class="controls">
						<textarea id="<?php echo $selected_shortcode; ?>_content" name="<?php echo $selected_shortcode; ?>_content" cols="" rows="7" class="ppb_input"></textarea>
					</div>
				</div>
				<?php endif; ?>

			</div><!-- .item-inline (end) -->
			
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready( function() {
				
				var currentItemData = jQuery('#<?php echo $_GET['rel']; ?>').data('anva_builder_settings');
				var currentItemOBJ = jQuery.parseJSON( currentItemData );
				
				jQuery.each( currentItemOBJ, function( index, value ) {
					if ( typeof jQuery('#' + index) != 'undefined' ) {
						jQuery('#' + index).val( decodeURI( value ) );
						
						if ( jQuery('#' + index).is( 'textarea' ) ) {
							jQuery('#' + index).wp_editor();
							jQuery('#' + index).val( decodeURI( value ) );
						}
					}
				});

				// Cancel Changes
				jQuery("#cancel-<?php echo $_GET['rel']; ?>").on( 'click', function(e) {
					e.preventDefault();
					var itemInner = jQuery('#item-inner-<?php echo $_GET['rel']; ?>');
					var parentEle = jQuery('#<?php echo $_GET['rel']; ?>');
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
				jQuery("#save-<?php echo $_GET['rel']; ?>").on( 'click', function(e) {
					e.preventDefault();

					// Validate title
					var title = jQuery(this).closest('.item-inline').find(".field-title input");
					if ( title.val() == '' ) {
						alert( 'The title field is required.' );
						return false;
					}
					
					// WP Editor
					tinyMCE.triggerSave();
			
					var targetItem = jQuery('#anva_inline_current').attr('value');
					var parentInline = jQuery(this).attr('data-parent');
					var currentShortcode = jQuery('#' + parentInline).attr('data-shortcode');
					var itemData = {};

					itemData.id = targetItem;
					itemData.shortcode = currentShortcode;
					
					jQuery("#" + parentInline + " :input.ppb_input").each( function() {
						if ( typeof jQuery(this).attr('id') != 'undefined' ) {	
							itemData[jQuery(this).attr('id')] = encodeURI( jQuery(this).attr('value') );
							
							if ( jQuery(this).attr('data-attr') == 'title' ) {
								jQuery('#' + targetItem).find('.title .shortcode-title').html( decodeURI( jQuery(this).attr('value') ) );
								
								if ( jQuery('#' + targetItem).find('.unsave').length == 0 ) {
									jQuery('<span class="unsave">Unsaved</span>').appendTo( jQuery('#' + targetItem).find('.title .shortcode-type') );
									jQuery('#' + targetItem).addClass('item-unsaved');
								}
							}
						}
					});
					
					var currentItemDataJSON = JSON.stringify( itemData );
					var itemInner = jQuery('#item-inner-<?php echo $_GET['rel']; ?>');

					jQuery('#' + targetItem).data( 'anva_builder_settings', currentItemDataJSON );

					var parentEle = jQuery('#<?php echo $_GET['rel']; ?>');
					
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

} // End Class
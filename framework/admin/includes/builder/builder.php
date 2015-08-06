<?php

require_once( ANVA_FRAMEWORK . '/admin/includes/builder/elements.php' );
require_once( ANVA_FRAMEWORK . '/admin/includes/builder/options.php' );
require_once( ANVA_FRAMEWORK . '/admin/includes/builder/helpers.php' );

/**
 * Add page and post meta boxes
 *
 * @since 1.0.0
 * @return class Anva_Meta_box
 */
function anva_add_builder_meta_box() {

	// Page meta box
	$builder_meta = anva_setup_page_builder_options();
	$builder_meta_box = new Anva_Builder_Meta_Box( $builder_meta['args']['id'], $builder_meta['args'] );

}

/**
 * Page meta setup array
 *
 * @since 1.0.0
 * @return array $setup
 */
function anva_setup_page_builder_options() {
	$setup = array(
		'args' => array(
			'id' 				=> 'anva_page_builder_options',
			'title' 		=> __( 'Page Builder', anva_textdomain() ),
			'page'			=> array( 'page' ),
			'context' 	=> 'normal',
			'priority'	=> 'default'
		)
	);
	return apply_filters( 'anva_page_buider_meta', $setup );
}

class Anva_Builder_Meta_Box {

	/**
	 * ID for meta box and post field saved
	 *
	 * @since 2.2.0
	 * @var string
	 */
	public $id;
	
	/**
	 * Arguments to pass to add_meta_box()
	 *
	 * @since 1.0.0
	 */
	private $args;

	/**
	 * Constructor
	 * Hook in meta box to start the process.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $id, $args ) {

		$this->id = $id;

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
			$params 		 = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
			$ap_vars 		 = array( 'url' => get_home_url(), 'includes_url' => includes_url() );

			/* ---------------------------------------------------------------- */
			/* WordPress
			/* ---------------------------------------------------------------- */

			wp_enqueue_style( 'wp-jquery-ui-dialog' );
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'wplink' );
			wp_enqueue_script( 'wpdialogs-popup' );

			/* ---------------------------------------------------------------- */
			/* Custom
			/* ---------------------------------------------------------------- */

			wp_enqueue_style( 'jquery-ui-custom', 		anva_get_core_url() . '/assets/css/admin/jquery-ui-custom.min.css', array(), '1.11.4', 'all' );
			wp_enqueue_style( 'fancybox', 						$builder_dir . "/assets/fancybox215/jquery.fancybox.min.css", array(), '2.1.5', 'all' );
			wp_enqueue_style( 'builder', 							$builder_dir . "/assets/css/builder.css", array(), ANVA_FRAMEWORK_VERSION, 'all' );

			wp_register_script( 'js-wp-editor', 			$builder_dir . '/assets/js/js-wp-editor.js', array( 'jquery' ), '1.1', true );
			wp_register_script( 'anva-builder', 			$builder_dir . "/assets/js/builder.js", array( 'jquery', 'wp-color-picker', 'fancybox' ), ANVA_FRAMEWORK_VERSION, true );
			
			wp_enqueue_script( 'fancybox', 						$builder_dir . "/assets/fancybox215/jquery.fancybox.min.js", array( 'jquery' ), '2.1.5' );
			wp_enqueue_script( 'jslider-depend', 			$builder_dir . "/assets/js/jquery.dependClass.min.js", array(), ANVA_FRAMEWORK_VERSION );
			wp_enqueue_script( 'jslider', 						$builder_dir . "/assets/js/jquery.slider.min.js", array(), ANVA_FRAMEWORK_VERSION );

			wp_enqueue_script( 'js-wp-editor' );
			wp_enqueue_script( 'builder_script' );
			
			wp_localize_script( 'anva-builder', 'tgAjax', $params );
			wp_localize_script( 'js-wp-editor', 'ap_vars', $ap_vars );
			
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

	static public function get_id() {
		$id = $this->id;
		return $id;
	}

	/**
	 * Renders the content of the meta box
	 *
	 * @since 1.0.0
	 */
	public function display() {

		global $post;
		
		$ppb_enable						= 0;
		$ppb_shortcodes 			= anva_get_builder_options();
		$dd 									= anva_get_builder_field();
		$ppb_form_item_arr 		= array();
		$image_path 					= anva_get_core_url() . '/admin/includes/builder/assets/images/builder/';

		if ( isset( $dd['enable'] ) ) {
			$ppb_enable = $dd['enable'];
		}

		if ( isset( $dd['order'] ) ) {
			$ppb_form_data_order = $dd['order'];
		}

		// Add an nonce field so we can check for it later.
		wp_nonce_field( $this->id, $this->id . '_nonce' );

		?>
		
		<div class="anva-meta-box anva-meta-context-normal">

			<div class="meta field-checkbox">
				<h4 class="heading"><?php _e( 'Enable', anva_textdomain() ); ?></h4>
				<div class="meta-option">
					<div class="meta-controls">
						<input type="checkbox" class="enable-builder" name="ppb_enable" id="ppb_enable" value="1" <?php checked( $ppb_enable, 1, true ); ?> />
					</div>
					<div class="meta-explain description">
						<?php _e( 'To build this page using content builder, please enable this option.', anva_textdomain() ); ?>
					</div>
				</div>
			</div><!-- .meta (end) -->
		
			<div class="meta meta-content-builder hidden">

				<h4 class="heading"><?php _e( 'Content Builder', anva_textdomain() ); ?></h4>
				<div class="meta-option">
					<div class="meta-explain description">
						<?php _e( 'Select below content builder element you want to display and click "Add", it will open popup option for selected element once you finish customizing click "Update" button. You can drag&drop each elements to re order them.', anva_textdomain() ); ?>
					</div>
				</div>
			
				<input type="hidden" id="ppb_post_type" name="ppb_post_type" value="page" />
				<input type="hidden" id="ppb_options" name="ppb_options" value="" />
				<input type="hidden" id="ppb_options_title" name="ppb_options_title"  value="" />
				<input type="hidden" id="ppb_options_image" name="ppb_options_image" value="" />
				<input type="hidden" id="ppb_inline_current" name="ppb_inline_current" value="" />
				<input type="hidden" id="ppb_form_data_order" name="ppb_form_data_order" value="" />
			
				<?php
					// Find all tabs
					$ppb_tabs = array();
					foreach ( $ppb_shortcodes as $key => $ppb_shortcode ) {
						if ( is_numeric( $key ) && $ppb_shortcode['title'] != 'Close' ) {
							$ppb_tabs[$key] = $ppb_shortcode['title'];
						}
					}
				?>

				<?php	if ( ! empty ( $ppb_tabs ) ) : ?>
					<div id="ppb_tab">
					<ul>
					<?php foreach ( $ppb_tabs as $tab_key => $ppb_tab ) :	?>
						<li><a href="#tabs-<?php echo esc_attr( $tab_key ); ?>"><?php echo $ppb_tab; ?></a></li>
					<?php	endforeach; ?>
					</ul><!-- .tabs (end) -->
				<?php endif; ?>
				
				<?php foreach ( $ppb_shortcodes as $key => $ppb_shortcode ) : ?>
					
					<?php if ( is_numeric( $key ) && $ppb_shortcode['title'] != 'Close' ) : ?>
						<div id="tabs-<?php echo esc_attr($key); ?>">
							<ul id="ppb_module_wrapper">
					<?php endif; ?>
						
					<?php if ( isset( $ppb_shortcode['icon'] ) && ! empty( $ppb_shortcode['icon'] ) ) : ?>
						<li data-module="<?php echo esc_attr( $key ); ?>" data-title="<?php echo esc_attr( $ppb_shortcode['title'] ); ?>">
							<img src="<?php echo esc_url( $image_path . $ppb_shortcode['icon'] ); ?>" alt="" title="<?php echo esc_attr( $ppb_shortcode['title'] ); ?>" class="builder_thumb" />
							<span class="builder_title"><?php echo $ppb_shortcode['title']; ?></span>
						</li>
					<?php endif; ?>

					<?php if ( is_numeric( $key ) && $ppb_shortcode['title'] == 'Close' ) : ?>
							</ul><!-- #ppb_module_wrapper (end) -->
						</div><!-- #tabs (end) -->
					<?php endif; ?>

				<?php endforeach; ?>
					
				<?php if ( ! empty( $ppb_tabs ) ) : ?>
					</div><!-- #ppb_tab (end) -->
				<?php endif; ?>

				<a id="ppb_sortable_add_button" class="button button-primary"><?php _e( 'Add', anva_textdomain() ); ?></a>

				<?php
					if ( isset( $ppb_form_data_order ) ) {
						$ppb_form_item_arr = explode( ',', $ppb_form_data_order );
					}

					$empty = '';
					if ( ! isset( $ppb_form_item_arr[0] ) || empty( $ppb_form_item_arr[0] ) ) {
						$empty = 'empty';
					}
				?>
				
				<ul id="content_builder_sort" class="ppb_sortable <?php echo $empty; ?>" rel="content_builder_sort_data"> 
				<?php
					if ( isset( $ppb_form_item_arr[0] ) && ! empty( $ppb_form_item_arr[0] ) ) :
						
						foreach ( $ppb_form_item_arr as $key => $ppb_form_item )	:

							$ppb_form_item_data = $dd[$ppb_form_item]['data'];
							$ppb_form_item_size = $dd[$ppb_form_item]['size'];
							$ppb_form_item_data_obj = json_decode( $ppb_form_item_data );
						
							if ( isset( $ppb_form_item[0] ) && isset( $ppb_shortcodes[$ppb_form_item_data_obj->shortcode] ) ) :
								$ppb_shortocde_title = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode]['title'];
								$ppb_shortocde_icon = $ppb_shortcodes[$ppb_form_item_data_obj->shortcode]['icon'];
								
								if ( $ppb_form_item_data_obj->shortcode != 'ppb_divider' ) {
									$obj_title_name = $ppb_form_item_data_obj->shortcode . '_title';
									
									if ( property_exists( $ppb_form_item_data_obj, $obj_title_name ) ) {
										$obj_title_name = $ppb_form_item_data_obj->$obj_title_name;
									} else {
										$obj_title_name = '';
									}

								} else {
									$obj_title_name = '<span class="shortcode_title">' . __( 'Paragraph Break', anva_textdomain() ) . '</span>';
									$ppb_shortocde_title = '';
								}
								?>
								<li id="<?php echo esc_attr( $ppb_form_item ); ?>" class="ui-state-default <?php echo esc_attr( $ppb_form_item_size ); ?> <?php echo esc_attr( $ppb_form_item_data_obj->shortcode ); ?>" data-current-size="<?php echo esc_attr( $ppb_form_item_size ); ?>">
									<!-- <div class="anva-hndle">
										<span class="dashicons dashicons-edit"></span>
										<span class="dashicons dashicons-trash"></span>
									</div> -->
									<div class="thumb">
										<img src="<?php echo esc_url( $image_path . $ppb_shortocde_icon ); ?>" alt="<?php echo esc_attr( $ppb_shortocde_title ); ?>" />
									</div>
									<div class="title">
										<span class="shortcode_title"><?php echo $ppb_shortocde_title; ?></span>
										<?php echo urldecode( $obj_title_name ); ?>
									</div>
									<a href="javascript:;" class="ppb_remove">x</a>
									<a data-rel="<?php echo esc_attr( $ppb_form_item ); ?>" href="<?php echo esc_url( admin_url('admin-ajax.php?action=pp_ppb&ppb_post_type=page&shortcode='.$ppb_form_item_data_obj->shortcode.'&rel='.$ppb_form_item.'&width=800&height=900' ) ); ?>" class="ppb_edit"></a>
									<input type="hidden" class="ppb_setting_columns" value="<?php echo esc_attr( $ppb_form_item_size ); ?>" />
								</li>
								<?php
							endif;
						endforeach;
					endif;
				?>
				</ul><!-- .sortable (end) -->
			</div><!-- .meta-content-builder -->
			
			<div class="meta meta-content-builder-export hidden">
				<div id="meta_tab">
					<ul>
						<li><a href="#meta-tabs-1"><?php _e( 'Import', anva_textdomain() ); ?></a></li>
						<li><a href="#meta-tabs-2"><?php _e( 'Export', anva_textdomain() ); ?></a></li>
					</ul>

					<div id="meta-tabs-1" class="meta-import">
						<h4><?php _e( 'Import Page Content Builder', anva_textdomain() ); ?></h4>
						<div class="pp_widget_description">
							<?php _e( 'Choose the import file. *Note: Your current content builder content will be overwritten by imported data', anva_textdomain() ); ?>
						</div>
						<input type="file" id="ppb_import_current_file" name="ppb_import_current_file" value="0" size="25"/>
						<input type="hidden" id="ppb_import_current" name="ppb_import_current"/>
						<input type="submit" id="ppb_import_current_button" class="button" value="Import"/>
					</div><!-- .meta-import (end) -->
				
					<div id="meta-tabs-2" class="meta-export">
						<h4><?php _e( 'Export Page Content Builder', anva_textdomain() ); ?></h4>
						<div class="pp_widget_description">
							<?php _e( 'Click to export current content builder data. Note: Please make sure you save all changes and no "unsaved" module', anva_textdomain() ); ?>
						</div>
						<input type="hidden" id="ppb_export_current" name="ppb_export_current"/>
						<input type="submit" id="ppb_export_current_button" name="ppb_export_current_button" class="button" value="Export"/>
					</div><!-- .meta-export (end) -->
				</div><!-- #meta_tab (end) -->
			</div><!-- .meta-content-builder-export (end) -->
		
			<script type="text/javascript">
			jQuery(document).ready(function() {
			/* <![CDATA[ */
			<?php foreach ( $ppb_form_item_arr as $key => $ppb_form_item ) : ?>
				<?php if ( ! empty( $ppb_form_item ) ) : ?>
					<?php $ppb_form_item_data = $dd[$ppb_form_item]['data']; ?>
					jQuery('#<?php echo esc_js( $ppb_form_item ); ?>').data('ppb_setting', '<?php echo addslashes( $ppb_form_item_data ); ?>');
				<?php endif; ?>
			<?php endforeach; ?>
			/* ]]> */
			});
			</script>
		
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
		$old = get_post_meta( $post_id, $this->id, true );

		/* ---------------------------------------------------------------- */
		/* Import page content builder
		/* ---------------------------------------------------------------- */

		if ( isset( $_POST['ppb_import_current'] ) && ! empty( $_POST['ppb_import_current_file'] ) ) {
			//Check if zip file
			$import_filename 	= $_FILES['ppb_import_current_file']['name'];
			$import_type 			= $_FILES['ppb_import_current_file']['type'];
			$is_zip 					= FALSE;
			$new_filename 		= basename( $import_filename, '_.zip' );
			$accepted_types 	= array(
				'application/zip', 
				'application/x-zip-compressed', 
				'multipart/x-zip', 
				'application/s-compressed'
			);
 
			foreach ( $accepted_types as $mime_type ) {
				if ( $mime_type == $import_type ) {
					$is_zip = TRUE;
					break;
				}
			}
			
			if ( $is_zip ) {
				WP_Filesystem();
				$upload_dir = wp_upload_dir();
				$cache_dir 	= '';
				
				if ( isset( $upload_dir['basedir'] ) ) {
					$cache_dir = $upload_dir['basedir'] . '/meteors';
				}
				
				move_uploaded_file( $_FILES["ppb_import_current_file"]["tmp_name"], $cache_dir . '/' . $import_filename );
				// $unzipfile = unzip_file( $cache_dir.'/'.$import_filename, $cache_dir);
				
				$zip = new ZipArchive();
				$x = $zip->open( $cache_dir . '/' . $import_filename );
				
				for ( $i = 0; $i < $zip->numFiles; $i++ ) {
					$new_filename = $zip->getNameIndex($i);
					break;
				}  
				
				if ( $x === true ) {
					$zip->extractTo( $cache_dir ); 
					$zip->close();
				}

				$import_options_json = file_get_contents( $cache_dir . '/' . $new_filename );
				unlink( $cache_dir .'/' . $import_filename );
				unlink( $cache_dir .'/' . $new_filename );
			
			} else {
				//If .json file then import
				$import_options_json = file_get_contents( $_FILES["ppb_import_current_file"]["tmp_name"] );
			}
			
			$import_options_arr = json_decode( $import_options_json, true );
			
			if ( isset( $import_options_arr['ppb_form_data_order'][0] ) && ! empty( $import_options_arr['ppb_form_data_order'][0] ) ) {
				page_update_custom_meta( $post_id, $import_options_arr['ppb_form_data_order'][0], 'ppb_form_data_order' );
			}
			
			$ppb_item_arr = explode( ',', $import_options_arr['ppb_form_data_order'][0] );
			
			if ( is_array( $ppb_item_arr ) && !empty( $ppb_item_arr ) ) {
				foreach ( $ppb_item_arr as $key => $ppb_item_arr ) {
					
					if ( isset( $import_options_arr[$ppb_item_arr . '_data'][0] ) && ! empty( $import_options_arr[$ppb_item_arr . '_data'][0] ) ) {
						page_update_custom_meta( $post_id, $import_options_arr[$ppb_item_arr.'_data'][0], $ppb_item_arr . '_data' );
					}
					
					if ( isset( $import_options_arr[$ppb_item_arr . '_size'][0] ) && ! empty( $import_options_arr[$ppb_item_arr . '_size'][0] ) ) {
						page_update_custom_meta( $post_id, 'one', $ppb_item_arr . '_size' );
					}
				}
			}
			
			header( "Location: " . $_SERVER['HTTP_REFERER'] );
			exit;
		}

		/* ---------------------------------------------------------------- */
		/* Export page content builder
		/* ---------------------------------------------------------------- */

		if ( isset( $_POST['ppb_export_current'] ) && ! empty( $_POST['ppb_export_current'] ) ) {
			
			$page_slug = get_the_title( $post_id );
			$page_slug = sanitize_title( $page_slug );
			$option_name = anva_get_option_name();
			$json_file_name = strtolower( $option_name ) . '_page_builder_' . $page_slug . '_' . date( 'Y-m-d_hia' );
	
			header( 'Content-disposition: attachment; filename=' . $json_file_name . '.json' );
			header( 'Content-type: application/json' );
			
			//Get current content builder data
			$ppb_form_data_order = $old['order'];
			$export_options_arr = array();
			
			if ( ! empty( $ppb_form_data_order ) ) {
				$export_options_arr['ppb_form_data_order'] = $ppb_form_data_order;

				//Get each builder module data
				$ppb_form_item_arr = explode( ',', $ppb_form_data_order );
			
				foreach ( $ppb_form_item_arr as $key => $ppb_form_item ) {
					// $ppb_form_item_data = get_post_meta( $post_id, $ppb_form_item . '_data' );
					$ppb_form_item_data = $old[$ppb_form_item]['data'];
					$export_options_arr[$ppb_form_item]['data'] = $ppb_form_item_data;
					
					// $ppb_form_item_size = get_post_meta( $post_id, $ppb_form_item . '_size');
					$ppb_form_item_size = $old[$ppb_form_item]['size'];
					$export_options_arr[$ppb_form_item]['size'] = $ppb_form_item_size;
				}
			}
			
			echo json_encode( $export_options_arr );
			
			exit;
		}

		/* ---------------------------------------------------------------- */
		/* Saving Page Builder Data
		/* ---------------------------------------------------------------- */

		$builder = array();
		$builder_ids = array();
		$enable = 0;

		if ( isset( $_POST['ppb_enable'] ) && ! empty( $_POST['ppb_enable'] ) ) {
			$enable = $_POST['ppb_enable'];
		}

		$builder_ids['enable'] = $enable;

		if ( isset( $_POST['ppb_form_data_order'] ) && ! empty( $_POST['ppb_form_data_order'] ) ) {
			
			// page_update_custom_meta( $post_id, $_POST['ppb_form_data_order'], 'ppb_form_data_order' );
			
			$builder_ids['order'] = $_POST['ppb_form_data_order'];

			$ppb_item_arr = explode( ',', $_POST['ppb_form_data_order'] );

			if ( is_array( $ppb_item_arr ) && ! empty( $ppb_item_arr ) ) {
				foreach ( $ppb_item_arr as $key => $ppb_item_arr ) {

					if ( isset( $_POST[$ppb_item_arr . '_data'] ) && ! empty( $_POST[$ppb_item_arr . '_data'] ) ) {
						// page_update_custom_meta( $post_id, $_POST[$ppb_item_arr . '_data'], $ppb_item_arr.'_data' );

						$builder_ids[$ppb_item_arr]['data'] = $_POST[$ppb_item_arr . '_data'];
					}
					
					if ( isset( $_POST[$ppb_item_arr . '_size'] ) && ! empty( $_POST[$ppb_item_arr . '_size'] ) ) {
						// page_update_custom_meta($post_id, $_POST[$ppb_item_arr . '_size'], $ppb_item_arr.'_size');

						$builder_ids[$ppb_item_arr]['size'] = $_POST[$ppb_item_arr . '_size'];
					}

					// $builder_ids[$key][$ppb_item_arr] = $builder;

				}
			}

		} else {
			// Is empty
			page_update_custom_meta( $post_id, '', $this->id );
		}
		
		// Save Array Options
		update_post_meta( $post_id, $this->id, $builder_ids );
	
	}

	/**
	 * Fancy Box Fields
	 *
	 * @since 1.0.0
   */
	function fields() {

		if ( is_admin() && isset( $_GET['shortcode'] ) && ! empty( $_GET['shortcode'] ) ) :
			$ppb_shortcodes = anva_get_builder_options();
			
			if ( isset( $ppb_shortcodes[$_GET['shortcode']] ) && ! empty( $ppb_shortcodes[$_GET['shortcode']] ) ) :
				$selected_shortcode = $_GET['shortcode'];
				$selected_shortcode_arr = $ppb_shortcodes[$_GET['shortcode']];
				// var_dump($selected_shortcode_arr);
				?>

				<div id="ppb_inline_<?php echo $selected_shortcode; ?>" data-shortcode="<?php echo $selected_shortcode; ?>" class="ppb_inline">
				
				<div class="wrap">
					<h2><?php echo $selected_shortcode_arr['title']; ?></h2>
					<a id="save_<?php echo $_GET['rel']; ?>" data-parent="ppb_inline_<?php echo $selected_shortcode; ?>" class="button-primary ppb_inline_save" href="#"><?php _e( 'Update', anva_textdomain() ); ?></a>
					<a class="button" href="javascript:;" onClick="jQuery.fancybox.close();"><?php _e( 'Cancel', anva_textdomain() ); ?></a>
				</div><!-- .wrap (end) -->

				<?php if ( isset( $selected_shortcode_arr['title'] ) && $selected_shortcode_arr['title'] != 'Divider' ) : ?>
					<div class="field-title">
						<label for="<?php echo $selected_shortcode; ?>_title"><?php _e( 'Title', anva_textdomain() ); ?></label>
						<span class="label_desc"><?php _e( 'Enter Title for this content', anva_textdomain() ); ?></span>
						<input type="text" id="<?php echo $selected_shortcode; ?>_title" name="<?php echo $selected_shortcode; ?>_title" data-attr="title" value="Title" class="ppb_input" />
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

					<?php switch ($attr_item['type']) :
						
					case "jslider": ?>
						<div class="field-slider">
							<div style="position:relative">
								<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
								<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
								<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="range" class="ppb_input" min="<?php echo $attr_item['min']; ?>" max="<?php echo $attr_item['max']; ?>" step="<?php echo $attr_item['step']; ?>" value="<?php echo $attr_item['std']; ?>" />
								<output for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" onforminput="value = foo.valueAsNumber;"></output>
							</div>
						</div>
						<?php break;
						
						case 'file': ?>
						<div class="field-file">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text"  class="ppb_input ppb_file" />
							<a id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>_button" name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>_button" type="button" class="metabox_upload_btn button" rel="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>">Upload</a>
						</div>
						<?php break;
								
						case 'select': ?>
						<div class="field-select">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<select name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" class="ppb_input">
								<?php foreach ( $attr_item['options'] as $attr_key => $attr_item_option ) : ?>
									<option value="<?php echo $attr_key; ?>"><?php echo ucfirst($attr_item_option); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php break;
								
						case 'select_multiple': ?>
						<div class="field-select-multiple">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<select name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" class="ppb_input" multiple="multiple">
								<?php foreach($attr_item['options'] as $attr_key => $attr_item_option) : ?>
									<?php if(!empty($attr_item_option)) : ?>
										<option value="<?php echo $attr_key; ?>"><?php echo ucfirst($attr_item_option); ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						</div>
						<?php break;
								
						case 'text': ?>
						<div class="field-text">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text" class="ppb_input" />
						</div>
						<?php break;
								
						case 'colorpicker': ?>
						<div class="field-colorpicker">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<input name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" type="text" class="ppb_input color_picker" readonly />
						</div>
						<?php break;

						case 'textarea': ?>
						<div class="field-textarea">
							<label for="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>"><?php echo $attr_title; ?></label>
							<span class="label_desc"><?php echo $attr_item['desc']; ?></span>
							<textarea name="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" id="<?php echo $selected_shortcode; ?>_<?php echo $attr_name; ?>" cols="" rows="3" class="ppb_input"></textarea>
						</div>
						<?php break;

					endswitch; ?>
					
				<?php endforeach; ?>
				
				<?php if ( isset ( $selected_shortcode_arr['content'] ) && $selected_shortcode_arr['content'] ) : ?>
				<div class="field-content">
					<label for="<?php echo $selected_shortcode; ?>_content"><?php _e( 'Content', anva_textdomain() ); ?></label>
					<span class="label_desc"><?php _e( 'Enter text/HTML content to display in this', anva_textdomain() ); ?> "<?php echo $selected_shortcode_arr['title']; ?>"</span>
					<textarea id="<?php echo $selected_shortcode; ?>_content" name="<?php echo $selected_shortcode; ?>_content" cols="" rows="7" class="ppb_input"></textarea>
				</div>
				<?php endif; ?>

			</div><!-- .ppb_inline (end) -->
			
			<script type="text/javascript">
			jQuery(document).ready(function(){
				var formfield = '';
		
				jQuery('.metabox_upload_btn').click(function() {
						jQuery('.fancybox-overlay').css('visibility', 'hidden');
						jQuery('.fancybox-wrap').css('visibility', 'hidden');
						formfield = jQuery(this).attr('rel');
						
						var send_attachment_bkp = wp.media.editor.send.attachment;
						wp.media.editor.send.attachment = function(props, attachment) {
							jQuery('#'+formfield).attr('value', attachment.url);
				
								wp.media.editor.send.attachment = send_attachment_bkp;
								jQuery('.fancybox-overlay').css('visibility', 'visible');
							jQuery('.fancybox-wrap').css('visibility', 'visible');
						}
				
						wp.media.editor.open();
						return false;
					});
			
				jQuery("#ppb_inline :input").each(function(){
					if(typeof jQuery(this).attr('id') != 'undefined')
					{
						 jQuery(this).attr('value', '');
					}
				});
				
				var currentItemData = jQuery('#<?php echo $_GET['rel']; ?>').data('ppb_setting');
				var currentItemOBJ = jQuery.parseJSON(currentItemData);
				
				jQuery.each(currentItemOBJ, function(index, value) { 
						if(typeof jQuery('#'+index) != 'undefined')
					{
						jQuery('#'+index).val(decodeURI(value));
						
						//If textarea then convert to visual editor
						if(jQuery('#'+index).is('textarea'))
						{
							jQuery('#'+index).wp_editor();
							jQuery('#'+index).val(decodeURI(value));
							//switchEditors.go(index, 'tmce');
						}
					}
				});

				jQuery('.color_picker').wpColorPicker();
				
				var el, newPoint, newPlace, offset;
	 
				 jQuery("input[type='range']").change(function() {
				 
					 el = jQuery(this);
					 
					 width = el.width();
					 newPoint = (el.val() - el.attr("min")) / (el.attr("max") - el.attr("min"));
					 
					 el
						 .next("output")
						 .text(el.val());
				 })
				 .trigger('change');
				
				jQuery("#save_<?php echo $_GET['rel']; ?>").click(function(){
					tinyMCE.triggerSave();
				
						var targetItem = jQuery('#ppb_inline_current').attr('value');
						var parentInline = jQuery(this).attr('data-parent');
						var currentItemData = jQuery('#'+targetItem).find('.ppb_setting_data').attr('value');
						var currentShortcode = jQuery('#'+parentInline).attr('data-shortcode');
						
						var itemData = {};
						itemData.id = targetItem;
						itemData.shortcode = currentShortcode;
						
						jQuery("#"+parentInline+" :input.ppb_input").each(function(){
							if(typeof jQuery(this).attr('id') != 'undefined')
							{	
								itemData[jQuery(this).attr('id')] = encodeURI(jQuery(this).attr('value'));
								
								 if(jQuery(this).attr('data-attr') == 'title')
								 {
										jQuery('#'+targetItem).find('.title').html(decodeURI(jQuery(this).attr('value')));
										if(jQuery('#'+targetItem).find('.ppb_unsave').length==0)
										{
											jQuery('<a href="javascript:;" class="ppb_unsave">Unsaved</a>').insertAfter(jQuery('#'+targetItem).find('.title'));
										}
								 }
							}
						});
						
						var currentItemDataJSON = JSON.stringify(itemData);
						jQuery('#'+targetItem).data('ppb_setting', currentItemDataJSON);
						
						jQuery.fancybox.close();
				});
				
				jQuery.fancybox.hideLoading();
			});
			</script>
	<?php
			endif;
		endif;
		
		die();
	}

} // End Class
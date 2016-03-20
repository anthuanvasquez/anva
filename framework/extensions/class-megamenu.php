<?php

// Include WP Walker Nav Menu Edit Class.
require_once( ABSPATH . 'wp-admin/includes/class-walker-nav-menu-edit.php' );

/**
 * Anva Menu Item Fields.
 *
 * @since 1.0.0
 */
class Anva_Menu_Item_Fields {

	/**
	 * A single instance of this class
 	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Options array.
	 *
	 * @access public
	 * @var array
	 */
	public $options = array();

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( self::$instance == null ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Constructor Hook everything in.
	 */
	public function __construct()
	{
		$this->set_fields();
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_filter( 'anva_menu_item_additional_fields', array( $this, 'add_fields' ), 10, 5 );
	}

	/**
	 * Set fields.
	 *
	 * @return void
	 */
	public function set_fields()
	{
		// Get columns
		$columns = array();
		$columns[''] = __( 'Select Columns', 'anva' );
		foreach ( anva_get_grid_columns() as $key => $column ) {
			$columns[ $column['class'] ] = $column['name'];
		}

		// Get sidebar locations
		$locations = array();
		$locations[''] = __( 'Select Sidebar', 'anva' );
		foreach ( anva_get_sidebar_locations() as $key => $sidebar ) {
			$locations[ $key ] = $sidebar['args']['name'];
		}

		$this->options['fields'] = array(
			'mega_menu' 		  => array(
				'name' 			  => 'mega_menu',
				'label' 		  => __( 'Active Mega Menu', 'anva' ),
				'container_class' => '',
				'input_type' 	  => 'checkbox',
			),
			'mega_menu_columns'   => array(
				'name' 			  => 'mega_menu_columns',
				'label' 		  => __( 'Display Columns', 'anva' ),
				'container_class' => '',
				'input_type'	  => 'select',
				'options' 		  => $columns,
			),
			'mega_menu_sidebar'   => array(
				'name' 			  => 'mega_menu_sidebar',
				'label' 		  => __( 'Display Sidebar Location', 'anva' ),
				'container_class' => '',
				'input_type'	  => 'select',
				'options' 		  => $locations,
			),
		);
	}

	public function get_fields()
	{
		$fields = array();

		foreach ( $this->options['fields'] as $name => $field ) {
			if ( empty( $field['name'] ) ) {
				$field['name'] = $name;
			}
			$fields[] = $field;
		}
		return $fields;
	}

	public function get_menu_item_meta( $name )
	{
		return 'anva_menu_item_' . esc_html( $name );
	}

	/**
	 * Inject the
	 * @hook {action} save_post
	 */
	public function add_fields( $new_fields, $item_output, $item, $depth, $args )
	{

		$schema = $this->get_fields( $item->ID );

		$new_fields = '';

		foreach ( $schema as $field ) {

			$field['value'] = get_post_meta( $item->ID, $this->get_menu_item_meta( $field['name'] ), true );
			$field['id'] = $item->ID;

			switch ( $field['input_type'] ) {

				case 'checkbox':

					$new_fields .= '<p class="additional-menu-field-'. $field['name'] .' description description-wide">';
					$new_fields .= '<input type="checkbox" id="edit-menu-item-'. $field['name'] .'-'. $field['id'] .'" class="edit-menu-item-'. $field['name'] .'" name="menu-item-'. $field['name']. '['. $field['id'] .']" value="1"';

					if ( ! empty( $field['value'] ) ) {
						$new_fields .= 'checked';
					}

					$new_fields .= '>';
					$new_fields .= '<label for="edit-menu-item-'. $field['name'] .'-'. $field['id'] .'">'. $field['label'] .'</label></p>';

					break;

				case 'select':

					$new_fields .= '<p class="additional-menu-field-'. $field['name'] .' description description-thin">';
					$new_fields .= '<label for="edit-menu-item-'. $field['name']. '-'. $field['id'] .'">'. $field['label'] .'</label>';
					$new_fields .= '<select id="edit-menu-item-'. $field['name']. '-'. $field['id'] .'" class="edit-menu-item-'. $field['name'] .' widefat" name="menu-item-'. $field['name'] .'['. $field['id'] .']">';

					if ( ! empty( $field['options'] ) ) {

						foreach ( $field['options'] as $key => $option ) {

							$new_fields .= '<option value="'. $key .'" ';

							if ( $key == $field['value'] ) {
								$new_fields .= 'selected';
							}

							$new_fields .= '>'. $option .'</option>';
						}
					}

					$new_fields .= '</select></p>';

					break;
			}
		}

		return $new_fields;
	}

	/**
	 * Save the newly submitted fields.
	 */
	public function save_post( $post_id )
	{

		if ( get_post_type( $post_id ) !== 'nav_menu_item' ) {
			return;
		}

		$fields_schema = $this->get_fields( $post_id );

		foreach ( $fields_schema as $field_schema ) {

			$form_field_name = 'menu-item-' . esc_html( $field_schema['name'] );

			$key = $this->get_menu_item_meta( $field_schema['name'] );

			if ( isset( $_POST[ $form_field_name ][ $post_id ] ) && ! empty( $_POST[ $form_field_name ][ $post_id ] ) ) {
				$value = stripslashes( $_POST[ $form_field_name ][ $post_id ] );
				update_post_meta( $post_id, $key, $value );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}
}

/**
 * Extend the Walker_Nav_Menu_Edit class to use it.
 *
 * @since 1.0.0
 */
class Anva_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

	/**
	 * Start the element output.
	 *
	 * @since 1.0.0
	 * @param string $output
	 * @param object $item
	 * @param int    $depth
	 * @param array  $args
	 * @param int    $id
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$item_output = '';

		parent::start_el( $item_output, $item, $depth, $args, $id );

		$new_fields = apply_filters( 'anva_menu_item_additional_fields', '', $item_output, $item, $depth, $args, $id );

		if ( $new_fields ) {
			$item_output = preg_replace( '/(?=<div[^>]+class="[^"]*submitbox)/', $new_fields, $item_output );
		}

		$output .= $item_output;
	}
}

/**
 * Extend the Walker_Nav_Menu class to use it.
 *
 * @since 1.0.0
 */
class Anva_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Current item ID.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string
	 */
	private $item_id;

	/**
	 * Current item post meta value.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var string
	 */
	private $item_meta;

	/**
	 * Start the element output.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. Includes the element output also.
	 *
	 * @since 1.0.0
	 * @param string $output
	 * @param object $item
	 * @param int    $depth
	 * @param array  $args
	 * @param int    $current_object_id
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 )
	{

		// Set item ID for start_lvl() and end_lvl() functions
		$this->item_id = $item->ID;

		$menu_item = Anva_Menu_Item_Fields::instance();
		$mega_menu = get_post_meta( $item->ID, $menu_item->get_menu_item_meta( 'mega_menu' ), true );
		$mega_menu_column = get_post_meta( $item->menu_item_parent, $menu_item->get_menu_item_meta( 'mega_menu_columns' ), true );

		$this->item_meta = $mega_menu;

		$mega_menu_classes = '';
		$mega_menu_column_class = '';

		if ( $mega_menu ) {
			$mega_menu_classes = ' mega-menu';
		}

		if ( $mega_menu_column ) {
			$mega_menu_column_class = ' ' . $mega_menu_column;
		}

		$indent       = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes      = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names  = '';
		$class_names  = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names  = $class_names . $mega_menu_classes;
		$class_names  = ' class="' . esc_attr( $class_names ) . '"';

		if ( $depth == 1 ) {
			$output .= '<ul class="mega-menu-column' . esc_attr( $mega_menu_column_class )  . '">';
		}

		$output      .= $indent . '<li id="menu-item-' . esc_attr( $item->ID ) . '"' . $class_names . '>';

		$attributes   = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes  .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes  .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes  .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';

		$item_output .= '<div>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</div>';

		if ( ! empty( $item->description ) ) {
			$item_output .= '<span>' . $item->description . '</span>';
		}

		$item_output .= '</a>';
		$item_output .= $args->after;

		if ( $mega_menu ) {
			$mega_menu_sidebar = get_post_meta( $item->ID, $menu_item->get_menu_item_meta( 'mega_menu_sidebar' ), true );

			if ( $mega_menu_sidebar ) {
				ob_start();
				dynamic_sidebar( $mega_menu_sidebar );
				$widget = ob_get_contents();
				ob_end_clean();
				$item_output .= '<div class="widget clearfix">';
				$item_output .= $widget;
				$item_output .= '</div>';
			}
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * The $args parameter holds additional values that may be used with the child class methods.
	 *
	 * @since 1.0.0
	 * @param string $output
	 * @param object $object
	 * @param int    $depth
	 * @param array  $args
	 */
	public function end_el( &$output, $object, $depth = 0, $args = array() )
	{
		$output .= "</li>";

		if ( $depth == 1 ) {
			$output .= '</ul>';
		}
	}

	/**
	 * Starts the list before the elements are added.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. This method is called at the start of the output list.
	 *
	 * @since 1.0.0
	 * @param string $output
	 * @param int    $depth
	 * @param array  $args
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() )
	{
		if ( $this->item_meta && $depth == 0 ) {
			$output .= '<div class="mega-menu-content clearfix">';
			return;
		}

		// $output .= '<ul class="sub-menu">';
		parent::start_lvl( $output, $depth, $args );
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * The $args parameter holds additional values that may be used with the child
	 * class methods. This method finishes the list at the end of output of the elements.
	 *
	 * @since 1.0.0
	 * @param string $output
	 * @param int    $depth
	 * @param array  $args
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() )
	{
		// $output .= '</ul>';
		
		if ( $this->item_meta && $depth == 0 ) {
			$output .= '</div>';
			return;
		}

		parent::end_lvl( $output, $depth, $args );
	}
}

/**
 * Return class Walker_Nav_Menu_Edit.
 *
 * @since  1.0.0
 * @param  string $class
 * @param  string $menu_id
 * @return string Anva_Walker_Nav_Menu_Edit
 */
function anva_edit_nav_menu_walker( $class, $menu_id ) {
	return 'Anva_Walker_Nav_Menu_Edit';
}
add_filter( 'wp_edit_nav_menu_walker', 'anva_edit_nav_menu_walker', 10, 2 );

/**
 * Init menu item fields.
 *
 * @since 1.0.0
 */
function anva_menu_item_fields_init() {
	Anva_Menu_Item_Fields::instance();
}
add_action( 'admin_init', 'anva_menu_item_fields_init' );
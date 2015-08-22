<?php

/**
 * Get all theme locals
 *
 * @since 1.0.0
 */
function anva_get_text_locals() {
	
	$localize = array(
		'asc'											=> __( 'ASC', 'anva' ),
		'desc'										=> __( 'DESC', 'anva' ),
		'posts_number'						=> __( 'Posts Number', 'anva' ),
		'order'										=> __( 'Order', 'anva' ),
		'order_by'								=> __( 'Order by', 'anva' ),
		'date'										=> __( 'Date', 'anva' ),
		'rand'										=> __( 'Random', 'anva' ),
		'show_thumbnails'					=> __( 'Show Thumbnails', 'anva' ),
		'menu'										=> __( 'Menu', 'anva' ),
		'menu_primary' 						=> __( 'Primary Menu', 'anva' ),
		'menu_secondary' 					=> __( 'Secondary Menu', 'anva' ),
		'menu_message'						=> __( 'Please set the menu in Administration / Appearance / Menus', 'anva' ),
		'404_title'								=> __( 'Whoops! page not found', 'anva' ),
		'404_description'					=> __( 'Sorry, but the page you requested could not be found. Try doing a search on the site or return to the home page.', 'anva' ),
		'not_found'								=> __( 'No posts found', 'anva' ),
		'not_found_content'				=> __( 'No posts found.', 'anva' ),
		'read_more'								=> __( 'Read More', 'anva' ),
		'prev'										=> __( '&larr; Anterior', 'anva' ),
		'next'										=> __( 'Siguiente &rarr;', 'anva' ),
		'comment_prev'						=> __( '&larr; Comentarios Anteriores', 'anva' ),
		'comment_next'						=> __( 'Comentarios Siguientes &rarr;', 'anva' ),
		'no_comment'							=> __( 'Comentarios cerrado.', 'anva' ),
		'search_for' 							=> __( 'Search for:', 'anva' ),
		'search_result'						=> __( 'Search Results for:', 'anva' ),
		'search'		 							=> __( 'Search', 'anva' ),
		'video'										=> __( 'Video', 'anva'),
		'page'										=> __( 'Page', 'anva' ),
		'pages'										=> __( 'Pages', 'anva' ),
		'edit_post'								=> __( 'Edit Post', 'anva' ),
		'page_options'						=> __( 'Page Options', 'anva'),
		'page_title'							=> __( 'Page Title' ),
		'page_title_show'					=> __( 'Show Title' ),
		'page_title_hide'					=> __( 'Hide Title' ),
		'sidebar_title'						=> __( 'Columna del Sidebar', 'anva' ),
		'sidebar_left'						=> __( 'Sidebar Left', 'anva' ),
		'sidebar_right'						=> __( 'Sidebar Right', 'anva' ),
		'sidebar_fullwidth'				=> __( 'Sidebar Full Width', 'anva' ),
		'sidebar_double'					=> __( 'Double Sidebar', 'anva' ),
		'sidebar_double_left'			=> __( 'Double Sidebar Left', 'anva' ),
		'sidebar_double_right'		=> __( 'Double Sidebar Right', 'anva' ),
		'post_grid'								=> __( 'Post Grid' ),
		'grid_2_columns'					=> __( '2 Columns', 'anva' ),
		'grid_3_columns'					=> __( '3 Columns', 'anva' ),
		'grid_4_columns'					=> __( '4 Columns', 'anva' ),
		'posted_on'								=> __( 'Posted on', 'anva' ),
		'by'											=> __( 'by', 'anva' ),
		'day' 										=> __( 'Day', 'anva' ),
		'month' 									=> __( 'Month', 'anva' ),
		'year' 										=> __( 'Year', 'anva' ),
		'author' 									=> __( 'Author', 'anva' ),
		'asides' 									=> __( 'Asides', 'anva' ),
		'galleries' 							=> __( 'Galleries', 'anva'),
		'images' 									=> __( 'Images', 'anva'),
		'videos' 									=> __( 'Videos', 'anva' ),
		'quotes' 									=> __( 'Quotes', 'anva' ),
		'links'										=> __( 'Links', 'anva' ),
		'status'									=> __( 'Estatus', 'anva' ),
		'audios'									=> __( 'Audios', 'anva' ),
		'chats'										=> __( 'Chats', 'anva' ),
		'archives'								=> __( 'Archivos', 'anva' ),
		'name' 										=> __( 'Name', 'anva' ),
		'name_place' 							=> __( 'Complete Name', 'anva' ),
		'name_required'						=> __( 'Por favor entre su nombre.', 'anva' ),
		'email' 									=> __( 'Email', 'anva' ),
		'email_place' 						=> __( 'Correo Electrónico', 'anva' ),
		'email_required'					=> __( 'Por favor entre un correo electrónico válido.', 'anva'),
		'email_error'							=> __( 'El correo electrónico debe tener un formato válido ej. nombre@email.com.', 'anva' ),
		'subject' 								=> __( 'Asunto', 'anva' ),
		'subject_required'				=> __( 'Por favor entre un asunto.', 'anva' ),
		'message' 								=> __( 'Mensaje', 'anva' ),
		'message_place' 					=> __( 'Mensaje', 'anva' ),
		'message_required'				=> __( 'Por favor entre un mensaje.', 'anva' ),
		'message_min'							=> __( 'Debe introducir un mínimo de 10 caracteres.', 'anva' ),
		'captcha_place'						=> __( 'Entre el resultado', 'anva' ),
		'captcha_required'				=> __( 'Por favor entre el resultado.', 'anva' ),
		'captcha_number'					=> __( 'La respuesta debe ser un numero entero.', 'anva' ),
		'captcha_equalto'					=> __( 'No es la repuesta correcta.', 'anva' ),
		'submit' 									=> __( 'Enviar Mensaje', 'anva' ),
		'submit_message'					=> __( 'Gracias, su email fue enviado con éxito.', 'anva' ),
		'submit_error'						=> __( '<strong>Lo sentimos</strong>, ha ocurrido un error, verfica que no haya campos en blanco.', 'anva' ),
		'footer_copyright'				=> __( 'Todos los Derechos Reservados' , 'anva' ),
		'footer_text'							=> __( 'Design by', 'anva' ),
		'get_in_touch'						=> __( 'Ponte en Contacto', 'anva' ),
		'main_sidebar_title'			=> __( 'Principal', 'anva' ),
		'main_sidebar_desc'				=> __( 'Area de widgets principal. Por defecto en el lado derecho.', 'anva' ),
		'home_sidebar_title'			=> __( 'Portada', 'anva' ),
		'home'										=> __( 'Home', 'anva' ),
		'home_sidebar_desc'				=> __( 'Area de widgets en la portada.', 'anva' ),
		'sidebar_left_title'			=> __( 'Left', 'anva' ),
		'sidebar_left_desc'				=> __( 'Area de widgets en el lado izquierdo.', 'anva' ),
		'sidebar_right_title'			=> __( 'Right', 'anva' ),
		'sidebar_right_desc'			=> __( 'Area de widgets en el lado derecho.', 'anva' ),
		'footer_sidebar_title'		=> __( 'Footer', 'anva' ),
		'footer_sidebar_desc'			=> __( 'Area de widgets en el footer.', 'anva' ),
		'shop_sidebar_title'			=> __( 'Tienda', 'anva' ),
		'shop_sidebar_desc'				=> __( 'Area de widgets para la tienda de los productos de woocommerce.', 'anva' ),
		'product_sidebar_title'		=> __( 'Productos', 'anva' ),
		'product_sidebar_desc'		=> __( 'Area de widgets para los productos individuales de woocommerce.', 'anva' ),
		'product_featured'				=> __( 'Productos Destacados', 'anva' ),
		'product_latest'					=> __( 'Productos Recientes', 'anva' ),
		'add_autop'								=> __( 'A&ntilde;adir p&aacute;rrafos autom&aacute;ticamente', 'anva' ),
		'featured_image'					=> __( 'Imagen Destacada', 'anva' ),
		'options'									=> __( 'Opciones', 'anva' ),
		'browsehappy'							=> __( 'Estas utilizando un navegador obsoleto. Actualiza tu navegador para <a href="%s">mejorar tu experiencia</a> en la web.' ),
		'skype'										=> __( 'Skype', 'anva' ),
		'phone'										=> __( 'Telefono', 'anva' ),
		'title'										=> __( 'Título', 'anva' ),
		'date'										=> __( 'Fecha', 'anva' ),
		'order'										=> __( 'Orden', 'anva' ),
		'image'										=> __( 'Imagen', 'anva' ),
		'link'										=> __( 'Enlace', 'anva' ),
		'image_url'								=> __( 'URL de la Imagen', 'anva' ),
		'url'											=> __( 'URL', 'anva' ),
		'slide_id'								=> __( 'Slide ID', 'anva' ),
		'slide_area'							=> __( 'Selecciona el Area del Slide', 'anva' ),
		'slide_content'						=> __( 'Ocultar o Mostrar Contenido', 'anva' ),
		'slide_shortcode'					=> __( 'Por favor incluye un slug como parámetro por e.j. [slideshows slug="homepage"]', 'anva' ),
		'slide_message'						=> __( 'No se han configurado rotadores para los slideshows. Contacta con tu Desarrollador.', 'anva' ),
		'slide_title' 						=> __( 'Mostrar solo el título', 'anva' ),
		'slide_desc' 							=> __( 'Mostrar solo la descripción', 'anva' ),
		'slide_show' 							=> __( 'Mostrar título y descripción', 'anva' ),
		'slide_hide' 							=> __( 'Ocultar ambos', 'anva' ),
		'slide_meta'							=> __( 'Opciones de Slide', 'anva' )
	);

	return apply_filters( 'anva_get_text_locals', $localize );

}

/**
 * Get separate local
 *
 * @since 1.0.0
 */
function anva_get_local( $id ) {

	$text = null;
	$localize = anva_get_text_locals();

	if ( isset( $localize[$id] ) ) {
		$text = $localize[$id];
	}

	return $text;
}

/**
 * Get all js locals
 *
 * @since 1.0.0
 */
function anva_get_js_locals() {

	$foodlist = 0;
	$woocommerce = 0;

	if ( defined( 'FOODLIST_VERSION' ) ) {
		$foodlist = 1;
	}

	if ( class_exists( 'Woocommerce' ) ) {
		$woocommerce = 1;
	}
	
	$localize = array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'themeUrl' => get_template_directory_uri(),
		'themeImages' => get_template_directory_uri() . '/assets/images',
		'pluginFoodlist' => $foodlist,
		'pluginWoocommerce' => $woocommerce
	);

	return apply_filters( 'anva_get_js_locals', $localize );
}
<?php

/**
 * Get all theme locals
 */
function anva_get_text_locals() {
	
	$localize = array(
		'menu'										=> __( 'Menu', anva_textdomain() ),
		'menu_primary' 						=> __( 'Primary Menu', anva_textdomain() ),
		'menu_secondary' 					=> __( 'Secondary Menu', anva_textdomain() ),
		'menu_message'						=> __( 'Por favor configura el menú en Administración _> Apariencia _> Menús', anva_textdomain() ),
		'404_title'								=> __( 'Whoops! page not found', anva_textdomain() ),
		'404_description'					=> __( 'Disculpa, pero la página solicitada no se pudo encontrar. Prueba haciendo una búsqueda en el sitio o regresa a la página principal.', anva_textdomain() ),
		'not_found'								=> __( 'No hay publicaciones', anva_textdomain() ),
		'not_found_content'				=> __( 'No se encontraron publicaciones.', anva_textdomain() ),
		'read_more'								=> __( 'Leer Más', anva_textdomain() ),
		'prev'										=> __( '&larr; Anterior', anva_textdomain() ),
		'next'										=> __( 'Siguiente &rarr;', anva_textdomain() ),
		'comment_prev'						=> __( '&larr; Comentarios Anteriores', anva_textdomain() ),
		'comment_next'						=> __( 'Comentarios Siguientes &rarr;', anva_textdomain() ),
		'no_comment'							=> __( 'Comentarios cerrado.', anva_textdomain() ),
		'search_for' 							=> __( 'Buscar para:', anva_textdomain() ),
		'search_result'						=> __( 'Resultados de búsqueda para:', anva_textdomain() ),
		'search'		 							=> __( 'Search', anva_textdomain() ),
		'video'										=> __( 'Video', anva_textdomain()),
		'page'										=> __( 'Page', anva_textdomain() ),
		'pages'										=> __( 'Pages', anva_textdomain() ),
		'edit_post'								=> __( 'Edit Post', anva_textdomain() ),
		'page_options'						=> __( 'Page Options', anva_textdomain()),
		'page_title'							=> __( 'Page Title' ),
		'page_title_show'					=> __( 'Mostrar Titulo' ),
		'page_title_hide'					=> __( 'Ocultar Titulo' ),
		'sidebar_title'						=> __( 'Columna del Sidebar', anva_textdomain() ),
		'sidebar_left'						=> __( 'Sidebar Left', anva_textdomain() ),
		'sidebar_right'						=> __( 'Sidebar Right', anva_textdomain() ),
		'sidebar_fullwidth'				=> __( 'Sidebar Full Width', anva_textdomain() ),
		'sidebar_double'					=> __( 'Double Sidebar', anva_textdomain() ),
		'sidebar_double_left'			=> __( 'Double Sidebar Left', anva_textdomain() ),
		'sidebar_double_right'		=> __( 'Double Sidebar Right', anva_textdomain() ),
		'post_grid'								=> __( 'Post Grid' ),
		'grid_2_columns'					=> __( '2 Columns', anva_textdomain() ),
		'grid_3_columns'					=> __( '3 Columns', anva_textdomain() ),
		'grid_4_columns'					=> __( '4 Columns', anva_textdomain() ),
		'posted_on'								=> __( 'Posted on', anva_textdomain() ),
		'by'											=> __( 'by', anva_textdomain() ),
		'day' 										=> __( 'Day', anva_textdomain() ),
		'month' 									=> __( 'Month', anva_textdomain() ),
		'year' 										=> __( 'Year', anva_textdomain() ),
		'author' 									=> __( 'Author', anva_textdomain() ),
		'asides' 									=> __( 'Asides', anva_textdomain() ),
		'galleries' 							=> __( 'Galeries', anva_textdomain()),
		'images' 									=> __( 'Images', anva_textdomain()),
		'videos' 									=> __( 'Videos', anva_textdomain() ),
		'quotes' 									=> __( 'Citas', anva_textdomain() ),
		'links'										=> __( 'Enlaces', anva_textdomain() ),
		'status'									=> __( 'Estados', anva_textdomain() ),
		'audios'									=> __( 'Audios', anva_textdomain() ),
		'chats'										=> __( 'Chats', anva_textdomain() ),
		'archives'								=> __( 'Archivos', anva_textdomain() ),
		'name' 										=> __( 'Nombre', anva_textdomain() ),
		'name_place' 							=> __( 'Nombre Completo', anva_textdomain() ),
		'name_required'						=> __( 'Por favor entre su nombre.', anva_textdomain() ),
		'email' 									=> __( 'Email', anva_textdomain() ),
		'email_place' 						=> __( 'Correo Electrónico', anva_textdomain() ),
		'email_required'					=> __( 'Por favor entre un correo electrónico válido.', anva_textdomain()),
		'email_error'							=> __( 'El correo electrónico debe tener un formato válido ej. nombre@email.com.', anva_textdomain() ),
		'subject' 								=> __( 'Asunto', anva_textdomain() ),
		'subject_required'				=> __( 'Por favor entre un asunto.', anva_textdomain() ),
		'message' 								=> __( 'Mensaje', anva_textdomain() ),
		'message_place' 					=> __( 'Mensaje', anva_textdomain() ),
		'message_required'				=> __( 'Por favor entre un mensaje.', anva_textdomain() ),
		'message_min'							=> __( 'Debe introducir un mínimo de 10 caracteres.', anva_textdomain() ),
		'captcha_place'						=> __( 'Entre el resultado', anva_textdomain() ),
		'captcha_required'				=> __( 'Por favor entre el resultado.', anva_textdomain() ),
		'captcha_number'					=> __( 'La respuesta debe ser un numero entero.', anva_textdomain() ),
		'captcha_equalto'					=> __( 'No es la repuesta correcta.', anva_textdomain() ),
		'submit' 									=> __( 'Enviar Mensaje', anva_textdomain() ),
		'submit_message'					=> __( 'Gracias, su email fue enviado con éxito.', anva_textdomain() ),
		'submit_error'						=> __( '<strong>Lo sentimos</strong>, ha ocurrido un error, verfica que no haya campos en blanco.', anva_textdomain() ),
		'footer_copyright'				=> __( 'Todos los Derechos Reservados' , anva_textdomain() ),
		'footer_text'							=> __( 'Design by', anva_textdomain() ),
		'get_in_touch'						=> __( 'Ponte en Contacto', anva_textdomain() ),
		'main_sidebar_title'			=> __( 'Principal', anva_textdomain() ),
		'main_sidebar_desc'				=> __( 'Area de widgets principal. Por defecto en el lado derecho.', anva_textdomain() ),
		'home_sidebar_title'			=> __( 'Portada', anva_textdomain() ),
		'home'										=> __( 'Home', anva_textdomain() ),
		'home_sidebar_desc'				=> __( 'Area de widgets en la portada.', anva_textdomain() ),
		'sidebar_left_title'			=> __( 'Left', anva_textdomain() ),
		'sidebar_left_desc'				=> __( 'Area de widgets en el lado izquierdo.', anva_textdomain() ),
		'sidebar_right_title'			=> __( 'Right', anva_textdomain() ),
		'sidebar_right_desc'			=> __( 'Area de widgets en el lado derecho.', anva_textdomain() ),
		'footer_sidebar_title'		=> __( 'Footer', anva_textdomain() ),
		'footer_sidebar_desc'			=> __( 'Area de widgets en el footer.', anva_textdomain() ),
		'shop_sidebar_title'			=> __( 'Tienda', anva_textdomain() ),
		'shop_sidebar_desc'				=> __( 'Area de widgets para la tienda de los productos de woocommerce.', anva_textdomain() ),
		'product_sidebar_title'		=> __( 'Productos', anva_textdomain() ),
		'product_sidebar_desc'		=> __( 'Area de widgets para los productos individuales de woocommerce.', anva_textdomain() ),
		'product_featured'				=> __( 'Productos Destacados', anva_textdomain() ),
		'product_latest'					=> __( 'Productos Recientes', anva_textdomain() ),
		'add_autop'								=> __( 'A&ntilde;adir p&aacute;rrafos autom&aacute;ticamente', anva_textdomain() ),
		'featured_image'					=> __( 'Imagen Destacada', anva_textdomain() ),
		'options'									=> __( 'Opciones', anva_textdomain() ),
		'browsehappy'							=> __( 'Estas utilizando un navegador obsoleto. Actualiza tu navegador para <a href="%s">mejorar tu experiencia</a> en la web.' ),
		'skype'										=> __( 'Skype', anva_textdomain() ),
		'phone'										=> __( 'Telefono', anva_textdomain() ),
		'title'										=> __( 'Título', anva_textdomain() ),
		'date'										=> __( 'Fecha', anva_textdomain() ),
		'order'										=> __( 'Orden', anva_textdomain() ),
		'image'										=> __( 'Imagen', anva_textdomain() ),
		'link'										=> __( 'Enlace', anva_textdomain() ),
		'image_url'								=> __( 'URL de la Imagen', anva_textdomain() ),
		'url'											=> __( 'URL', anva_textdomain() ),
		'slide_id'								=> __( 'Slide ID', anva_textdomain() ),
		'slide_area'							=> __( 'Selecciona el Area del Slide', anva_textdomain() ),
		'slide_content'						=> __( 'Ocultar o Mostrar Contenido', anva_textdomain() ),
		'slide_shortcode'					=> __( 'Por favor incluye un slug como parámetro por e.j. [slideshows slug="homepage"]', anva_textdomain() ),
		'slide_message'						=> __( 'No se han configurado rotadores para los slideshows. Contacta con tu Desarrollador.', anva_textdomain() ),
		'slide_title' 						=> __( 'Mostrar solo el título', anva_textdomain() ),
		'slide_desc' 							=> __( 'Mostrar solo la descripción', anva_textdomain() ),
		'slide_show' 							=> __( 'Mostrar título y descripción', anva_textdomain() ),
		'slide_hide' 							=> __( 'Ocultar ambos', anva_textdomain() ),
		'slide_meta'							=> __( 'Opciones de Slide', anva_textdomain() )
	);

	return apply_filters( 'anva_get_text_locals', $localize );

}

/**
 * Get separate local
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
 */
function anva_get_js_locals() {

	$foodlist = 0;
	$woocommerce = 0;

	if ( defined( 'FOODLIST_VERSION' )) {
		$foodlist = 1;
	}

	if ( class_exists( 'Woocommerce' )) {
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
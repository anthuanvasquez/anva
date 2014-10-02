<?php

/**
 * Get all theme locals
 */
function tm_get_text_locals() {
	
	$domain = TM_THEME_DOMAIN;
	$localize = array(
		'menu_nav_off'						=> __( 'Por favor configura el menú en Administración _> Apariencia _> Menús', $domain ),
		'404_title'								=> __( 'Whoops! página no encontrada', $domain ),
		'404_description'					=> __( 'Disculpa, pero la página solicitada no se pudo encontrar. Prueba haciendo una búsqueda en el sitio o regresa a la página principal.', $domain ),
		'not_found'								=> __( 'No hay publicaciones', $domain ),
		'not_found_content'				=> __( 'No se encontraron publicaciones.', $domain ),
		'read_more'								=> __( 'Leer Más', $domain ),
		'prev'										=> __( '&larr; Anterior', $domain ),
		'next'										=> __( 'Siguiente &rarr;', $domain ),
		'search_for' 							=> __( 'Buscar para:', $domain ),
		'search'		 							=> __( 'Buscar', $domain ),
		'video'										=> __( 'Video', $domain),
		'menu'										=> __( 'Menú;', $domain ),
		'page'										=> __( 'Página', $domain ),
		'name' 										=> __( 'Nombre', $domain ),
		'name_place' 							=> __( 'Nombre Completo', $domain ),
		'name_required'						=> __( 'Porfavor entre su nombre.', $domain ),
		'email' 									=> __( 'Email', $domain ),
		'email_place' 						=> __( 'Correo Electrónico', $domain ),
		'email_required'					=> __( 'Porfavor entre un correo electrónico válido.', $domain),
		'email_error'							=> __( 'El correo electrónico debe tener un formato válido ej. nombre@email.com.', $domain ),
		'subject' 								=> __( 'Asunto', $domain ),
		'subject_required'				=> __( 'Porfavor entre un asunto.', $domain ),
		'message' 								=> __( 'Mensaje', $domain ),
		'message_place' 					=> __( 'Mensaje', $domain ),
		'message_required'				=> __( 'Porfavor entre un mensaje.', $domain ),
		'message_min'							=> __( 'Debe introducir un mínimo de 10 caracteres.', $domain ),
		'captcha_place'						=> __( 'Entre el resultado', $domain ),
		'captcha_required'				=> __( 'Porfavor entre el resultado.', $domain ),
		'captcha_number'					=> __( 'La respuesta debe ser un numero entero.', $domain ),
		'captcha_equalto'					=> __( 'No es la repuesta correcta.', $domain ),
		'submit' 									=> __( 'Enviar Mensaje', $domain ),
		'submit_message'					=> __( 'Gracias, su email fue enviado con éxito.', $domain ),
		'submit_error'						=> __( '<strong>Lo sentimos</strong>, ha ocurrido un error, verfica que no haya campos en blanco.', $domain ),
		'footer_copyright'				=> __( 'Todos los Derechos Reservados.' , $domain ),
		'footer_text'							=> __( 'Diseño y Programación Web por:', $domain ),
		'get_in_touch'						=> __( 'Ponte en Contacto', $domain ),
		'main_sidebar_title'			=> __( 'Principal', $domain ),
		'main_sidebar_desc'				=> __( 'Area de widgets principal.', $domain ),
		'home_sidebar_title'			=> __( 'Portada', $domain ),
		'home_sidebar_desc'				=> __( 'Area de widgets en la portada.', $domain ),
		'footer_sidebar_title'		=> __( 'Footer', $domain ),
		'footer_sidebar_desc'			=> __( 'Area de widgets en el footer.', $domain ),
		'shop_sidebar_title'			=> __( 'Tienda', $domain ),
		'shop_sidebar_desc'				=> __( 'Area de widgets para la tienda de los productos de woocommerce.', $domain ),
		'product_sidebar_title'		=> __( 'Productos', $domain ),
		'product_sidebar_desc'		=> __( 'Area de widgets para los productos individuales de woocommerce.', $domain ),
		'product_featured'				=> __( 'Productos Destacados', $domain ),
		'product_latest'					=> __( 'Productos Recientes', $domain ),
		'add_autop'								=> __( 'A&ntilde;adir p&aacute;rrafos autom&aacute;ticamente', $domain ),
		'featured_image'					=> __( 'Imagen Destacada', $domain ),
		'skype'										=> __( 'Skype', $domain ),
		'title'										=> __( 'Título', $domain ),
		'date'										=> __( 'Fecha', $domain ),
		'order'										=> __( 'Orden', $domain ),
		'image'										=> __( 'Imagen', $domain ),
		'link'										=> __( 'Enlace', $domain ),
		'image_url'								=> __( 'URL de la Imagen', $domain ),
		'url'											=> __( 'URL', $domain ),
		'slide_id'								=> __( 'Slide ID', $domain ),
		'slide_area'							=> __( 'Elege el Area del Slide', $domain ),
		'slide_content'						=> __( 'Ocultar o Mostrar Contenido', $domain ),
		'slide_shortcode'					=> __( 'Porfavor incluye un slug como parámetro por e.j. [slideshows slug="homepage"]', $domain ),
		'slide_message'						=> __( 'No se han configurado rotadores para los slideshows. Contacta con tu Desarrollador.', $domain )
	);

	return apply_filters( 'tm_text_locals', $localize );

}

/**
 * Get separate local
 */
function tm_get_local( $id ) {

	$text = null;
	$localize = tm_get_text_locals();

	if ( isset( $localize[$id] ) ) {
		$text = $localize[$id];
	}

	return $text;
}

/**
 * Get all js locals
 */
function tm_get_js_locals() {
	
	$localize = array(
		'themeurl' => get_template_directory_uri()
	);

	return apply_filters( 'tm_js_locals', $localize );
}
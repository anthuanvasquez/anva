<?php

function tm_get_text_locals() {
	
	$domain = TM_THEME_DOMAIN;
	$localize = array(
		'menu_nav_off'							=> __( 'Por favor configura el menú en Administración _> Apariencia _> Menús', $domain ),
		'404_title'									=> __( 'Whoops! p&aacute;gina no encontrada', $domain ),
		'404_description'						=> __( 'Disculpa, pero la p&aacute;gina solicitada no se pudo encontrar. Prueba haciendo una b&uacute;squeda en el sitio o regresa a la p&aacute;gina principal.', $domain ),
		'not_found'									=> __( 'No hay publicaciones', $domain ),
		'not_found_content'					=> __( 'No se encontraron publicaciones.', $domain ),
		'read_more'									=> __( 'Leer Más', $domain ),
		'prev'											=> __( '&larr; Anterior', $domain ),
		'next'											=> __( 'Siguiente &rarr;', $domain ),
		'search_for' 								=> __( 'Buscar para:', $domain ),
		'search'		 								=> __( 'Buscar', $domain ),
		'video'											=> __( 'Video', $domain),
		'menu'											=> __( 'Men&uacute;', $domain ),
		'page'											=> __( 'Pagina', $domain ),
		'name' 											=> __( 'Nombre', $domain ),
		'name_place' 								=> __( 'Nombre Completo', $domain ),
		'name_required'							=> __( 'Porfavor entre su nombre.', $domain ),
		'email' 										=> __( 'Email', $domain ),
		'email_place' 							=> __( 'Correo Electronico', $domain ),
		'email_required'						=> __( 'Porfavor entre un correo electr&oacute;nico v&aacute;lido.', $domain),
		'email_error'								=> __( 'El correo electr&oacute;nico debe tener un formato v&aacute;lido ej. nombre@email.com.', $domain ),
		'subject' 									=> __( 'Asunto', $domain ),
		'subject_required'					=> __( 'Porfavor entre un asunto.', $domain ),
		'message' 									=> __( 'Mensaje', $domain ),
		'message_place' 						=> __( 'Mensaje', $domain ),
		'message_required'					=> __( 'Porfavor entre un mensaje.', $domain ),
		'captcha_place'							=> __( 'Entre el resultado', $domain ),
		'captcha_required'					=> __( 'Porfavor entre el resultado.', $domain ),
		'captcha_number'						=> __( 'La respuesta debe ser un n&uacute;mero entero.', $domain ),
		'captcha_equalto'						=> __( 'No es la repuesta correcta.', $domain ),
		'submit' 										=> __( 'Enviar Mensaje', $domain ),
		'submit_message'						=> __( 'Gracias, su email fue enviado con &eacute;xito.', $domain ),
		'submit_erorr'							=> __( '<strong>Lo sentimos</strong>, ha ocurrido un error, verfica que los campos marcados con * no est&eacute;n en blanco.', $domain ),
		'footer_copyright'					=> __( 'Todos los Derechos Reservados.' , $domain ),
		'footer_text'								=> __( 'Diseño y Programación Web por:', $domain ),

		// Admin texts
		'main_sidebar_title'				=> __( 'Sidebar', $domain ),
		'main_sidebar_desc'					=> __( 'Area de widgets principal.', $domain ),
		'home_sidebar_title'				=> __( 'Home Sidebar', $domain ),
		'home_sidebar_desc'					=> __( 'Area de widgets en la portada.', $domain ),
		'footer_sidebar_title'			=> __( 'Footer Sidebar', $domain ),
		'footer_sidebar_desc'				=> __( 'Area de widgets del footer.', $domain )

	);

	return apply_filters( 'tm_text_locals', $localize );

}

function tm_get_local( $id ) {

	$text = null;
	$localize = tm_get_text_locals();

	if ( isset( $localize[$id] ) ) {
		$text = $localize[$id];
	}

	return $text;
}

function tm_get_js_locals() {
	
	$localize = array(
		'themeurl' => get_template_directory_uri()
	);

	return apply_filters( 'tm_js_locals', $localize );
}
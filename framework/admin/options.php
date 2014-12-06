<?php
/**
 * 3Mentes WordPress Base Template
 *
 * @author		Anthuan Vasquez
 * @copyright	Copyright (c) 3Mentes
 * @link		http://anthuanvasquez.webcindario.com
 * @package		3Mentes WordPress Base Template
 */
 
// Options Array
$options = array(

	// Section Tab Layout
	array(
		"type" 		=> "open",
		"title"		=> "Header",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Logo",  
		"desc" 		=> __("Introduzca la URL del logo que desea mostrar.", ANVA_DOMAIN),  
		"id" 			=> "logo",
		"type" 		=> "image",
		"std" 		=> ANVA_LOGO,
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "CSS Personalizado",
		"desc" 		=> __("Si necesitas realizar algunos cambios menores con estilos CSS, puedes ponerlos aqui para anular los estilos por omision del tema. Sin embargo, si vas a hacer muchos cambios de estilos CSS, lo mejor seria crear un archivo adicional de CSS o crear un Child Theme.", ANVA_DOMAIN),  
		"id" 			=> "custom_css",
		"type" 		=> "textarea",
		"std" 		=> "",
		"tab"			=> "layout"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "layout"
	),

	array(
		"type" 		=> "open",
		"title"		=> "Slider",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Slider Speed",  
		"desc" 		=> __("Introduzca un valor en milisegundos para determinar el tiempo de cada slide.", ANVA_DOMAIN),  
		"id" 			=> "slider_speed",
		"type" 		=> "text",
		"std" 		=> '7000',
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Slider Control",  
		"desc" 		=> __("Seleccione si desea ocultar la navegación manual slider.", ANVA_DOMAIN),  
		"id" 			=> "slider_control",
		"type" 		=> "radio",
		"std" 		=> '1',
		"options" => array(
			'1' => "Mostrar control.",
			'0' => "Ocultar control."
		),
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Slider Direction",  
		"desc" 		=> __("Seleccione si desea ocultar la navegación de dirección del slider.", ANVA_DOMAIN),  
		"id" 			=> "slider_direction",
		"type" 		=> "radio",
		"std" 		=> '1',
		"options" => array(
			'1' => "Mostrar dirección.",
			'0' => "Ocultar dirección."
		),
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Slider Play",  
		"desc" 		=> __("Seleccione si desea ocultar el botón de play y pausa.", ANVA_DOMAIN),  
		"id" 			=> "slider_play",
		"type" 		=> "radio",
		"std" 		=> '1',
		"options" => array(
			'1' => "Mostrar play/pausa.",
			'0' => "Ocultar play/pausa."
		),
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Footer Columns",  
		"desc" 		=> __("Selecciona la cantidad de columnas que deseas mostrar en el footer.", ANVA_DOMAIN),  
		"id" 			=> "footer_cols",
		"type" 		=> "radio",
		"std" 		=> '4',
		"options" => array(
			'12' => "1 Columna.",
			'6'  => "2 Columnas.",
			'4'  => "3 Columnas.",
			'3'  => "4 Columnas."
		),
		"tab"			=> "layout"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "layout"
	),

	array(
		"type" 		=> "open",
		"title"		=> "Social Media",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Facebook",  
		"desc" 		=> __("Introduzca la URL de su perfil o pagina de facebook.", ANVA_DOMAIN),  
		"id" 			=> "social_facebook",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout",
	),

	array(
		"name" 		=> "Twitter",  
		"desc" 		=> __("Introduzca la URL de su perfil de twitter.", ANVA_DOMAIN),  
		"id" 			=> "social_twitter",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Instagram",  
		"desc" 		=> __("Introduzca la URL de su perfil de instagram.", ANVA_DOMAIN),  
		"id" 			=> "social_instagram",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Google+",  
		"desc" 		=> __("Introduzca la URL de su perfil de google+.", ANVA_DOMAIN),  
		"id" 			=> "social_gplus",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "LinkedIn",  
		"desc" 		=> __("Introduzca la URL de su perfil de linkedin.", ANVA_DOMAIN),  
		"id" 			=> "social_linkedin",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Youtube",  
		"desc" 		=> __("Introduzca la URL de su perfil de youtube.", ANVA_DOMAIN),  
		"id" 			=> "social_youtube",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Vimeo",  
		"desc" 		=> __("Introduzca la URL de su perfil de vimeo.", ANVA_DOMAIN),  
		"id" 			=> "social_vimeo",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Pinterest",  
		"desc" 		=> __("Introduzca la URL de su perfil de pinterest.", ANVA_DOMAIN),  
		"id" 			=> "social_pinterest",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Digg",  
		"desc" 		=> __("Introduzca la URL de su perfil de digg.", ANVA_DOMAIN),  
		"id" 			=> "social_digg",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Dribbble",  
		"desc" 		=> __("Introduzca la URL de su perfil de dribbble.", ANVA_DOMAIN),  
		"id" 			=> "social_dribbble",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "RSS",  
		"desc" 		=> __("Introduzca la URL de su feed.", ANVA_DOMAIN),  
		"id" 			=> "social_rss",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "layout"
	),

	// Tab Content
	// Single Post
	array(
		"type" 		=> "open",
		"title"		=> "Single Post",
		"msg"			=> __("Estos ajustes solo se aplicaran a los posts individuales. Lo que quiere decir que no afectaran a los posts que se muestran en la parte frontal del blog.", ANVA_DOMAIN),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar informacion meta en la parte superior de los posts?",  
		"desc" 		=> __("Seleccione si desea que la informacion meta (fecha de publicacion, autor, etc) se muestre en la parte superior del post.", ANVA_DOMAIN),  
		"id" 			=> "single_meta",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"1" => "Mostrar meta.",
			"0" => "Ocultar meta."
		),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar imagenes destacadas en la parte superior de los posts?",  
		"desc" 		=> __("Elija como desea que se muestren las imagenes destacadas en la parte superior de los posts.", ANVA_DOMAIN),  
		"id" 			=> "single_thumb",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"0" => "Mostrar miniaturas.",
			"1" => "Mostrar miniaturas con un ancho completo.",
			"2" => "Ocultar miniaturas."
		),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar comentarios debajo de los posts?",  
		"desc" 		=> __("Seleccione si desea ocultar completamente los comentarios o no debajo de los posts.", ANVA_DOMAIN),  
		"id" 			=> "single_comment",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"1" => "Mostrar comentarios.",
			"0" => "Ocultar comentarios."
		),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar breadcrumbs?",  
		"desc" 		=> __("Seleccione si desea ocultar o mostrar los breadcrumbs.", ANVA_DOMAIN),  
		"id" 			=> "single_breadcrumb",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"1" => "Mostrar breadcrumbs.",
			"0" => "Ocultar breadcrumbs."
		),
		"tab"			=> "content"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "content"
	),

	// Primary Posts
	array(
		"type" 		=> "open",
		"title"		=> "Primary Posts",
		"msg"			=> __("Estos ajustes solo se aplicaran a los posts que se muestran en la parte frontal del blog.", ANVA_DOMAIN),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar informacion meta en la parte superior de los posts?",  
		"desc" 		=> __("Seleccione si desea que la informacion de meta (fecha de publicacion, autor, etc) se muestre en la parte superior del post.", ANVA_DOMAIN),  
		"id" 			=> "posts_meta",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"1" => "Mostrar meta.",
			"0" => "Ocultar meta."
		),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar imagenes destacadas en la parte superior de los posts?",  
		"desc" 		=> __("Elija como desea que muestren las imagenes destacadas en la parte superior de los posts.", ANVA_DOMAIN),  
		"id" 			=> "posts_thumb",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"0" => "Mostrar miniaturas.",
			"1" => "Mostrar miniaturas con un ancho completo.",
			"2" => "Ocultar miniaturas."
		),
		"tab"			=> "content"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "content"
	),

	// Tab Configuration
	array(
		"type" 		=> "open",
		"title"		=> "Reponsive",
		"tab"			=> "config"
	),
	
	array(
		"name" 		=> "Tabletas y Moviles",
		"desc" 		=> __("Este tema viene con una hoja de estilo especial que se centrara en la resolucion de la pantalla de sus visitantes para mostrarles un diseno ligeramente modificado si su resolucion de pantalla coincide con tamanos comunes de una tableta o un dispositivo movil.", ANVA_DOMAIN),  
		"id" 			=> "responsive",
		"type" 		=> "radio",
		"std" 		=> "1",
		"options" => array(
			"1" => "Si, aplicar estilos para tabletas y dispositivos moviles.",
			"0" => "No, mostrar el sitio normal."
		),
		"tab"			=> "config"
	),

	array(
		"name" 		=> "Navegacion",
		"desc" 		=> __("Seleccione como desea mostrar la navegacion principal en los dispositivos moviles.", ANVA_DOMAIN),  
		"id" 			=> "navigation",
		"type" 		=> "radio",
		"std" 		=> "toggle_navigation",
		"options" => array(
			"toggle_navigation" => "Navegacion Toggle (Mostrar / Ocultar).",
			"off_canvas_navigation" => "Navegacion Off-Canvas."
		),
		"tab"			=> "config"
	),

	array(
		"type" 		=> "close",
		"tab"			=> "config"
	)

);
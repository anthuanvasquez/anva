<?php
/**
 * 3Mentes WordPress Base Template
 *
 * @author		Anthuan Vasquez
 * @copyright	Copyright (c) 3Mentes
 * @link		http://anthuanvasquez.webcindario.com
 * @package		3Mentes WordPress Base Template
 */
 
$domain = TM_THEME_DOMAIN;

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
		"desc" 		=> __("Introduzca la URL del logo que desea mostrar.", $domain),  
		"id" 			=> "logo",
		"type" 		=> "image",
		"std" 		=> TM_THEME_LOGO,
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "CSS Personalizado",
		"desc" 		=> __("Si necesitas realizar algunos cambios menores con estilos CSS, puedes ponerlos aqui para anular los estilos por omision del tema. Sin embargo, si vas a hacer muchos cambios de estilos CSS, lo mejor seria crear un archivo adicional de CSS o crear un Child Theme.", $domain),  
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
		"title"		=> "Social Media",
		"msg"			=> __("These settings will only apply to vewing single posts. This means that any settings you set here will not effect any posts that appear in a post list or post grid.", $domain),
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Facebook",  
		"desc" 		=> __("Introduzca la URL de su perfil o pagina de facebook.", $domain),  
		"id" 			=> "social_facebook",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout",
	),

	array(
		"name" 		=> "Twitter",  
		"desc" 		=> __("Introduzca la URL de su perfil de twitter.", $domain),  
		"id" 			=> "social_twitter",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Instagram",  
		"desc" 		=> __("Introduzca la URL de su perfil de instagram.", $domain),  
		"id" 			=> "social_instagram",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Google+",  
		"desc" 		=> __("Introduzca la URL de su perfil de google+.", $domain),  
		"id" 			=> "social_gplus",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "LinkedIn",  
		"desc" 		=> __("Introduzca la URL de su perfil de linkedin.", $domain),  
		"id" 			=> "social_linkedin",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Youtube",  
		"desc" 		=> __("Introduzca la URL de su perfil de youtube.", $domain),  
		"id" 			=> "social_youtube",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Vimeo",  
		"desc" 		=> __("Introduzca la URL de su perfil de vimeo.", $domain),  
		"id" 			=> "social_vimeo",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Pinterest",  
		"desc" 		=> __("Introduzca la URL de su perfil de pinterest.", $domain),  
		"id" 			=> "social_pinterest",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Digg",  
		"desc" 		=> __("Introduzca la URL de su perfil de digg.", $domain),  
		"id" 			=> "social_digg",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "Dribbble",  
		"desc" 		=> __("Introduzca la URL de su perfil de dribbble.", $domain),  
		"id" 			=> "social_dribbble",
		"type" 		=> "text",
		"std" 		=> "#",
		"tab"			=> "layout"
	),

	array(
		"name" 		=> "RSS",  
		"desc" 		=> __("Introduzca la URL de su feed.", $domain),  
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
		"msg"			=> __("Estos ajustes solo se aplicaran a los posts individuales. Lo que quiere decir que no afectaran a los posts que se muestran en la parte frontal del blog.", $domain),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar informacion meta en la parte superior de los posts?",  
		"desc" 		=> __("Seleccione si desea que la informacion meta (fecha de publicacion, autor, etc) se muestre en la parte superior del post.", $domain),  
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
		"desc" 		=> __("Elija como desea que se muestren las imagenes destacadas en la parte superior de los posts.", $domain),  
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
		"desc" 		=> __("Seleccione si desea ocultar completamente los comentarios o no debajo de los posts.", $domain),  
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
		"desc" 		=> __("Seleccione si desea ocultar o mostrar los breadcrumbs.", $domain),  
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
		"msg"			=> __("Estos ajustes solo se aplicaran a los posts que se muestran en la parte frontal del blog.", $domain),
		"tab"			=> "content"
	),

	array(
		"name" 		=> "Mostrar informacion meta en la parte superior de los posts?",  
		"desc" 		=> __("Seleccione si desea que la informacion de meta (fecha de publicacion, autor, etc) se muestre en la parte superior del post.", $domain),  
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
		"desc" 		=> __("Elija como desea que muestren las imagenes destacadas en la parte superior de los posts.", $domain),  
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
		"desc" 		=> __("Este tema viene con una hoja de estilo especial que se centrara en la resolucion de la pantalla de sus visitantes para mostrarles un diseno ligeramente modificado si su resolucion de pantalla coincide con tamanos comunes de una tableta o un dispositivo movil.", $domain),  
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
		"desc" 		=> __("Seleccione como desea mostrar la navegacion principal en los dispositivos moviles.", $domain),  
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
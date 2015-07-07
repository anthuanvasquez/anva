<?php

/* Social Icons Widget */
class Anva_Social_Media extends WP_Widget {

	/* Create Widget Function */
	function Anva_Social_Media() {

		$widget_ops = array(
			'classname' => 'widget_social_media',
			'description' => __( 'Muestra los iconos de las redes mas populares y una descripcion.', anva_textdomain() )
		);

		$this->WP_Widget( 'Anva_Social_Media', 'Anva Social Media', $widget_ops );
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract( $args );

		$title 	= apply_filters( 'widget_title', $instance['title'] );
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
		$autop 	= $instance['autop'] ? 'true' : 'false';
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
 
		/* Text */
		echo '<div class="textwidget">';
			if ( 'true' == $autop ) {				
				echo wpautop( $text );
			} else {
				echo $text;
			}
		echo '</div>';
		
		/* Show Social Media Icons */
		echo anva_social_media();

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
		$instance['title'] 	= $new_instance['title'];
		$instance['text'] 	= $new_instance['text'];
		$instance['autop'] 	= $new_instance['autop'];
		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => 'Social Media',
			'text' 	=> '',
			'autop' => false
		));
		
		/* Inputs */
		$title 	 = $instance['title'];
		$text 	 = format_to_edit( $instance['text'] );
		$autop 	 = $instance['autop'];

		$html 	 = '';
		$html 	.= '<p>';
		$html 	.= '<label for="'. $this->get_field_id('title') .'">'. anva_get_local( 'title' ) . ':</label>';
		$html 	.= '<input type="text" class="widefat" id="'. $this->get_field_id('title') .'" name="'. $this->get_field_name('title') .'" value="'. esc_attr($title) .'" />';
		$html 	.= '</p>';
		$html 	.= '<p><textarea class="widefat" rows="8" cols="10" id="'. $this->get_field_id('text') .'" name="'. $this->get_field_name('text') .'">'. $text .'</textarea></p>';
		$html 	.= '<p>';
		$html 	.= '<input class="widefat" '. checked( $autop, 'on') .' id="'. $this->get_field_id('autop') .'" name="'. $this->get_field_name('autop') .'" type="checkbox" />';
		$html 	.= '<label for="'. $this->get_field_id('autop') .'">'. __( 'Añadir párrafos automáticamente', anva_textdomain() ) .'</label>';
		$html 	.= '</p>';

		echo $html;
	}
}
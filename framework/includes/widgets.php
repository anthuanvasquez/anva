<?php

/* Social Icons Widget */
class Custom_Social_Media extends WP_Widget {

	/* Create Widget Function */
	function Custom_Social_Media() {

		$widget_ops = array(
			'classname' => 'widget_social_media',
			'description' => __('Muestra los Iconos de las redes más populares y una descripción.', TM_THEME_DOMAIN)
		);

		$this->WP_Widget('Custom_Social_Media', 'Custom Social Media', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 	= '';
		$title 	= apply_filters('widget_title', $instance['title']);
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
		$autop 	= $instance['autop'] ? 'true' : 'false';
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;;
 
		/* Text */
		echo '<div class="textwidget">';
			if ( 'true' == $autop ) {				
				echo wpautop($text);
			} else {
				echo $text;
			}
		echo '</div>';
		
		/* Show Social Media Icons */
		tm_social_icons();

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];
		$instance['autop'] 			= $new_instance['autop'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'text' 	=> '',
			'autop' => false
		));
		
		/* Inputs */
		$title 				= $instance['title'];
		$text 				= format_to_edit($instance['text']);
		$autop 				= $instance['autop'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<!-- Text -->
		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>
		
		<!-- Auto P -->
		<p>			
			<input class="widefat" <?php checked( $autop, 'on'); ?> id="<?php echo $this->get_field_id('autop'); ?>" name="<?php echo $this->get_field_name('autop'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('autop'); ?>">Añadir parrafos automaticamente</label>
		</p>

		<?php
	}
}

/* Services Widget */
class Custom_Services extends WP_Widget {

	/* Create Widget Function */
	function Custom_Services() {

		$widget_ops = array(
			'classname' => 'widget_services',
			'description' => 'Muestra servicios o un texto personalizado con una imagen y una descripci&oacute;n.'
		);

		$this->WP_Widget('Custom_Services', 'Custom Services', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$title 	= apply_filters('widget_title', $instance['title']);
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
 		$image 	= $instance['image'];
 		$link 	= $instance['link'];
		$autop 	= $instance['autop'] ? 'true' : 'false';
 	
		echo $before_widget;

		/* Image */
		if ( ! empty( $image ) )
			echo '<div class="service__icon"><img src="'. $image .'" alt="'. $title .'" /></div>';

 		/* Title */
		if ( ! empty( $title ) ) {
			if ( ! empty( $link ) )
				echo $before_title . '<a href="'. esc_url( $link ) .'">' . $title . '</a>' . $after_title;
			else
				echo $before_title . $title . $after_title;
 		}

		/* Text */
		echo '<div class="textwidget">';
			if ( 'true' == $autop ) {				
				echo wpautop($text);
			} else {
				echo $text;
			}
		echo '</div>';
			
		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];
		$instance['image'] 			= $new_instance['image'];
		$instance['link'] 			= $new_instance['link'];
		$instance['autop'] 			= $new_instance['autop'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' 		=> '',
			'text' 			=> '',
			'image' 		=> '',
			'link'			=> '',
			'autop'			=> false
		));
		
		/* Inputs */
		$title 				= $instance['title'];
		$text 				= format_to_edit($instance['text']);
		$image 				= $instance['image'];
		$link 				= $instance['link'];
		$autop 				= $instance['autop'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				Titulo: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>

		<!-- Text -->
		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $text ); ?></textarea>
		</p>

		<!-- Image -->
		<p>
			<label for="<?php echo $this->get_field_id('image'); ?>">Image URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="url" value="<?php echo esc_attr($image); ?>" />
		</p>

		<!-- Link -->
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>">URL:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="url" value="<?php echo esc_attr($link); ?>" />
		</p>
		
		<!-- Auto P -->
		<p>			
			<input class="widefat" <?php checked( $instance['autop'], 'on'); ?> id="<?php echo $this->get_field_id('autop'); ?>" name="<?php echo $this->get_field_name('autop'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('autop'); ?>">Añadir parrafos automaticamente</label>
		</p>

		<?php
	}
}

/*
 * Contact Widget
 */
class Custom_Contact extends WP_Widget {

	/* Create Widget Function */
	function Custom_Contact() {

		$widget_ops = array(
			'classname' => 'widget_custom_contact',
			'description' => __('Muestra informacion de contacto.', TM_THEME_DOMAIN)
		);

		$this->WP_Widget('Custom_Contact', 'Custom Contact', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 	= '';
		$title 	= apply_filters('widget_title', $instance['title']);
 		$text 	= apply_filters( 'widget_text', $instance['text'], $instance );
 		$phone 	= $instance['phone'];
 		$email 	= $instance['email'];
 		$link 	= $instance['link'];
 		$skype 	= $instance['skype'];
		$autop 	= $instance['autop'] ? 'true' : 'false';
		$output = '';
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;;
 
		/* Text */
		echo '<div class="textwidget">';

			if ( 'true' == $autop ) {				
				echo wpautop($text);
			} else {
				echo $text;
			}

		echo '</div>';
		
		$output.= '<ul class="widget-contact">';
		$output.= '<li class="contact-phone"><i class="fa fa-phone"></i> '.$phone.'</li>';
		$output.= '<li class="contact-email"><i class="fa fa-envelope"></i> <a href="mailto:'.$email.'">'.$email.'</a></li>';
		$output.= '<li class="contact-link"><i class="fa fa-reply"></i> <a href="'.$link.'">Ponte en Contacto</a></li>';
		$output.= '<li class="contact-skype"><i class="fa fa-skype"></i> '.$skype.'</li>';
		$output.= '<li class="contact-icons">';
		$output.= '<ul class="social-media social-style-color">'. tm_social_media() .'</ul>';
		$output.= '</li>';
		$output.= '</ul>';

		echo $output;

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 					= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];
		$instance['phone'] 			= $new_instance['phone'];
		$instance['email'] 			= $new_instance['email'];
		$instance['link'] 			= $new_instance['link'];
		$instance['skype'] 			= $new_instance['skype'];
		$instance['autop'] 			= $new_instance['autop'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'text' 	=> '',
			'phone'	=> '',
			'email'	=> '',
			'link' 	=> '',
			'skype' => '',
			'autop' => false
		));
		
		/* Inputs */
		$title 		= $instance['title'];
		$text 		= format_to_edit($instance['text']);
		$phone 		= $instance['phone'];
 		$email 		= $instance['email'];
 		$link 		= $instance['link'];
 		$skype 		= $instance['skype'];
		$autop 		= $instance['autop'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<!-- Text -->
		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
		</p>


		
		<!-- Auto P -->
		<p>			
			<input class="widefat" <?php checked( $autop, 'on'); ?> id="<?php echo $this->get_field_id('autop'); ?>" name="<?php echo $this->get_field_name('autop'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('autop'); ?>">Añadir parrafos automaticamente</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e('Telefono:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" type="text" value="<?php echo esc_attr($phone); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e('Skype:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo esc_attr($skype); ?>" />
		</p>

		<?php
	}
}

/* Register Widgets */
function tm_register_widgets() {
	register_widget( 'Custom_Social_Media' );
	register_widget( 'Custom_Services' );
	register_widget( 'Custom_Contact' );
}
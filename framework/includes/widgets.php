<?php

/* Social Icons Widget */
class Custom_Social_Media extends WP_Widget {

	/* Create Widget Function */
	function Custom_Social_Media() {

		$widget_ops = array(
			'classname' => 'widget_social_media',
			'description' => __('Muestra los Iconos de las redes más populares y una descripción.', TM_THEME_DOMAIN)
		);

		$this->WP_Widget('Custom_Social_Media', 'Custom Social Icons', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html = '';

		$title = apply_filters('widget_title', $instance['title']);
 		$text = apply_filters( 'widget_text', $instance['text'], $instance );
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;;
 
		/* Text */
		echo '<div class="textwidget">'. $text .'</div>';

		echo '<ul class="social-media-icons social-media-icons--widget">';
		echo tm_social_media();
		echo '</ul>';

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['text'] 			= $new_instance['text'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'text' => ''
		));
		
		/* Inputs */
		$title 				= $instance['title'];
		$text 				= format_to_edit($instance['text']);

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Titulo:', TM_THEME_DOMAIN); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>

		<p>
			<textarea class="widefat" rows="8" cols="10" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
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

/* Register Widgets */
function tm_register_widgets() {
	register_widget( 'Custom_Social_Media' );
	register_widget( 'Custom_Services' );
}
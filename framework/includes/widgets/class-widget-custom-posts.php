<?php

/* Social Icons Widget */
class Custom_Posts extends WP_Widget {

	/* Create Widget Function */
	function Custom_Posts() {

		$widget_ops = array(
			'classname' => 'widget_custom_posts',
			'description' => __('Muestra una lista de los posts mas recientes con una imagen destacada.', TM_THEME_DOMAIN)
		);

		$this->WP_Widget('Custom_Posts', 'Custom Posts', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 			= '';
		$title 			= apply_filters('widget_title', $instance['title']);
		$number 		= $instance['number'];
		$order 			= $instance['order'];
		$thumbnail	= $instance['thumbnail'];
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		tm_get_widget_posts( $number, $order, $thumbnail );

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['number'] 		= $new_instance['number'];
		$instance['order'] 			= $new_instance['order'];
		$instance['thumbnail']	= $new_instance['thumbnail'];

		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance = wp_parse_args( (array) $instance, array(
			'title' => __( 'Posts Recientes', TM_THEME_DOMAIN ),
			'number' 	=> '3',
			'order' => 'date',
			'thumbnail' => true
		));
		
		/* Inputs */
		$title 			= $instance['title'];
		$number 		= $instance['number'];
		$order 			= $instance['order'];
		$thumbnail	= $instance['thumbnail'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<!-- Number -->
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Numero de Posts:', TM_THEME_DOMAIN); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo esc_attr($number); ?>" />
		</p>

		<!-- Number -->
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Numero de Posts:', TM_THEME_DOMAIN); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option value="date">Fecha</option>
				<option value="rand">Random</option>
				<option value="title">Titulo</option>
			</select>
		</p>

		<p>			
			<input class="widefat" id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="<?php echo esc_attr($thumbnail); ?>" />
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Usar imagenes Destacadas', TM_THEME_DOMAIN); ?></label>
		</p>

		<?php
	}
}
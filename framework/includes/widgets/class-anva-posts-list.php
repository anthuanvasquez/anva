<?php

/* Social Icons Widget */
class Anva_Posts_List extends WP_Widget {

	/* Create Widget Function */
	function Anva_Posts_List() {

		$widget_ops = array(
			'classname' => 'widget_anva_posts_list',
			'description' => __( 'Muestra una lista de los posts mas recientes con una imagen destacada.', anva_textdomain()  )
		);

		$this->WP_Widget('Anva_Posts_List', 'Anva Posts List', $widget_ops);
	}

	/* Call Widget */
	function widget( $args, $instance ) {
		
		extract($args);

		$html 			= '';
		$title 			= apply_filters('widget_title', $instance['title']);
		$number 		= $instance['number'];
		$order 			= $instance['order'];
		$orderby 		= $instance['orderby'];
		$thumbnail	= $instance['thumbnail'];
 
		echo $before_widget;		

 		/* Title */
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		anva_widget_posts_list( $number, $orderby, $order, $thumbnail );

		echo $after_widget;
	}

	/* Update Data for Widgets */
	function update( $new_instance, $old_instance ) {
		$instance 							= $old_instance;
		$instance['title'] 			= $new_instance['title'];
		$instance['number'] 		= $new_instance['number'];
		$instance['order'] 			= $new_instance['order'];
		$instance['orderby'] 		= $new_instance['orderby'];
		$instance['thumbnail']	= $new_instance['thumbnail'];
		return $instance;
	}

	/* Widget Form */
	function form( $instance ) {
		
		/* Default Value */
		$instance 		= wp_parse_args( (array) $instance, array(
			'title' 		=> __( 'Artículos Recientes', anva_textdomain()  ),
			'number' 		=> '3',
			'order' 		=> 'desc',
			'orderby' 	=> 'date',
			'thumbnail' => true
		));
		
		/* Inputs */
		$title 				= $instance['title'];
		$number 			= $instance['number'];
		$order 				= $instance['order'];
		$orderby 			= $instance['orderby'];
		$thumbnail		= $instance['thumbnail'];

		?>
		
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:', anva_textdomain() ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<!-- Number -->
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Numero de Posts:', anva_textdomain() ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="number" value="<?php echo esc_attr($number); ?>" />
		</p>

		<!-- Order -->
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Orden:', anva_textdomain() ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
				<option <?php if ( 'asc' == $order ) echo 'selected="selected"'; ?> value="asc">ASC</option>
				<option <?php if ( 'desc' == $order ) echo 'selected="selected"'; ?> value="desc">DESC</option>
			</select>
		</p>
		
		<!-- Orderby -->
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Ordenar Por:', anva_textdomain() ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option <?php if ( 'date' == $orderby ) echo 'selected="selected"'; ?> value="date">Fecha</option>
				<option <?php if ( 'rand' == $orderby ) echo 'selected="selected"'; ?> value="rand">Random</option>
				<option <?php if ( 'title' == $orderby ) echo 'selected="selected"'; ?> value="title">Titile</option>
			</select>
		</p>
		
		<!-- Thumbnail -->
		<p>			
			<input class="widefat" <?php checked( $thumbnail, 'on'); ?> id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" />
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Mostrar miniaturas', anva_textdomain() ); ?></label>
		</p>

		<?php
	}
}
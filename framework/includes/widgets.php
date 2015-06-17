<?php

include_once( ANVA_FRAMEWORK . '/widgets/class-widget-social-media.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-widget-custom-services.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-widget-custom-contact.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-anva-posts-list.php' );

/* Register Widgets */
function anva_register_widgets() {
	register_widget( 'Custom_Services' );
	register_widget( 'Custom_Contact' );
	register_widget( 'Anva_Posts_List' );
	register_widget( 'Anva_Social_Icons' );
}
<?php

include_once( ANVA_FRAMEWORK . '/widgets/class-widget-social-media.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-widget-custom-services.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-widget-custom-contact.php' );
include_once( ANVA_FRAMEWORK . '/widgets/class-widget-custom-posts.php' );

/* Register Widgets */
function anva_register_widgets() {
	register_widget( 'Custom_Social_Media' );
	register_widget( 'Custom_Services' );
	register_widget( 'Custom_Contact' );
	register_widget( 'Custom_Posts' );
}
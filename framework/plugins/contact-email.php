<?php

function tm_contact_send_email() {
	
	global $email_sended_message;

	// Submit form
	if ( isset( $_POST['contact-submission'] ) && 1 == $_POST['contact-submission'] ) {

		// Fields
		$name 		= $_POST['cname'];
		$email 		= $_POST['cemail'];
		$subject 	= $_POST['csubject'];
		$message 	= $_POST['cmessage'];
		$captcha 	= $_POST['ccaptcha'];
		
		// Validate name
		if ( empty( $name ) || sanitize_text_field( $name ) == '' ) {
			$hasError = true;
		}

		// Validate email
		if ( empty( $email ) || ! is_email( $email ) ) {
			$hasError = true;
		}

		// Validate subject
		if ( empty( $subject ) || sanitize_text_field( $subject ) == '' ) {
			$hasError = true;
		}

		// Validate message
		if ( empty( $message ) || sanitize_text_field( $message ) == '' ) {
			$hasError = true;
		}

		// Validate answer
		if ( empty( $captcha ) || sanitize_text_field( $captcha ) == '' ) {
			$hasError = true;
		}
		
		// Body Mail
		if ( ! isset( $hasError ) ) {

			// Change to dynamic
			$email_to = '';
			if ( ! isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}
			
			$email_subject 	= '[Contacto - '. $subject .'] De '. $name;
			$email_body 		= "<strong>Nombre:</strong> $name\n\n<strong>Email:</strong> $email\n\n<strong>Mensaje:</strong> \n\n$message";
			$headers 				= 'De: '. $name .' <'. $email_to .'>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $email_to, $email_subject, $email_body, $headers );
			$email_sent = true;
		}

	}

	if ( isset( $email_sent ) && $email_sent == true ) :

		$email_sended_message = tm_get_local( 'submit_message' );
		
		// Clear form after submit
		unset(
			$_POST['cname'],
			$_POST['cemail'],
			$_POST['csubject'],
			$_POST['cmessage'],
			$_POST['ccaptcha']
		);
		
	else :
		if ( isset( $hasError ) ) :
			$email_sended_message = tm_get_local( 'submit_error' );
		endif;
	endif;
}
add_action( 'init', 'tm_contact_send_email' );
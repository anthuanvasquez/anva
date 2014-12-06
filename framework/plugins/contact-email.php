<?php

function anva_contact_send_email() {
	
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
			$has_error = true;
		}

		// Validate email
		if ( empty( $email ) || sanitize_email( $email ) == '' || ! is_email( $email ) ) {
			$has_error = true;
		}

		// Validate subject
		if ( empty( $subject ) || sanitize_text_field( $subject ) == '' ) {
			$has_error = true;
		}

		// Validate message
		if ( empty( $message ) || sanitize_text_field( $message ) == '' ) {
			$has_error = true;
		}

		// Validate answer
		if ( empty( $captcha ) || sanitize_text_field( $captcha ) == '' ) {
			$has_error = true;
		}
		
		// Body Mail
		if ( ! isset( $has_error ) ) {

			// Change to dynamic
			$email_to = '';
			if ( ! isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}
			
			$email_subject 	= '[Contacto - '. $subject .'] De '. $name;
			$email_body 		= "Nombre: $name\n\nEmail: $email\n\nMensaje: \n\n$message";
			$headers 				= 'De: '. $name .' <'. $email_to .'>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $email_to, $email_subject, $email_body, $headers );
			$email_sent = true;
		}

	}

	if ( isset( $email_sent ) && $email_sent == true ) :

		$email_sended_message = anva_get_local( 'submit_message' );
		
		// Clear form after submit
		unset(
			$_POST['cname'],
			$_POST['cemail'],
			$_POST['csubject'],
			$_POST['cmessage'],
			$_POST['ccaptcha']
		);
		
	else :
		if ( isset( $has_error ) ) :
			$email_sended_message = anva_get_local( 'submit_error' );
		endif;
	endif;
}
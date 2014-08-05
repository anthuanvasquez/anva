<?php
	// Set random values
	$a = rand(1, 9);
	$b = rand(1, 9);
	$s = $a + $b;
	$answer = $s;

	if ( isset( $_POST['contact-submission'] ) && 1 == $_POST['contact-submission'] ) {

		// Fields
		$name 				= $_POST['cname'];
		$email 				= $_POST['cemail'];
		$subject 			= $_POST['csubject'];
		$message 			= $_POST['cmessage'];
		$captcha 			= $_POST['ccaptcha'];
		
		if ( empty( $name ) || sanitize_text_field( $name ) == '' ) {
			$hasError = true;
		}

		if ( empty( $email ) || ! is_email( $email ) ) {
			$hasError = true;
		}

		if ( empty( $subject ) || sanitize_text_field( $subject ) == '' ) {
			$hasError = true;
		}

		if ( empty( $message ) || sanitize_text_field( $message ) == '' ) {
			$hasError = true;
		}

		if ( empty( $captcha ) || sanitize_text_field( $captcha ) == '' ) {
			$hasError = true;
		}
		
		// Body Mail
		if ( ! isset( $hasError ) ) {

			// Change to dynamic
			$email_to = '';
			if ( !isset( $email_to ) || ( $email_to == '' ) ) {
				$email_to = get_option( 'admin_email' );
			}
			
			$email_subject 	= '[Contacto - '. $subject .'] De '. $name;
			$email_body 		= "Nombre: $name\n\nEmail: $email\n\nMensaje: $message";
			$headers 				= 'De: '. $name .' <'. $email_to .'>' . "\r\n" . 'Reply-To: ' . $email;

			wp_mail( $email_to, $email_subject, $email_body, $headers );
			$email_sent = true;
		}

	}

	if( isset( $email_sent ) && $email_sent == true ) {
		echo '<div id="success" class="alert alert--success">'. tm_get_local( 'submit_message' ) .'</div>';
		echo '<script>jQuery(document).ready(function(){
							setTimeout(function(){
								jQuery("#success").fadeOut("slow");
							}, 3000);
							});</script>';
		
		// Clear form after submit
		unset(
			$_POST['cname'],
			$_POST['cemail'],
			$_POST['csubject'],
			$_POST['cmessage'],
			$_POST['ccaptcha']
		);
	} else {

		if ( isset( $hasError ) )
			echo '<div class="alert alert--error">'. tm_get_local( 'submit_error' ) .'</div>';

	}
?>

<div class="contact-form-wrapper">
	<form id="contactform" class="contact-form" method="post" action="<?php the_permalink(); ?>#contactform">

		<div class="form-name">
			<label for="cname" class="control-label"><?php echo tm_get_local( 'name' ); ?>:</label>
			<input type="text" placeholder="<?php echo tm_get_local( 'name_place' ); ?>" name="cname" class="full-width requiredField" value="<?php if ( isset($_POST['cname'] ) ) echo esc_attr( $name ); ?>">
		</div>
		
		<div class="form-email">
			<label for="cemail" class="control-label"><?php echo tm_get_local( 'email' ); ?>:</label>
			<input type="email" placeholder="<?php _e('Correo Electr&oacute;nico', TM_THEME_DOMAIN); ?>" name="cemail" class="full-width requiredField" value="<?php if(isset($_POST['cemail'])) echo esc_attr( $email );?>">
		</div>

		<div class="form-subject">						
			<label for="csubject" class="control-label"><?php echo tm_get_local( 'subject' ); ?>:</label>
			<input id="subject" type="text" placeholder="<?php echo tm_get_local( 'subject' ); ?>" name="csubject" class="full-width requiredField" value="<?php if ( isset($_POST['csubject'] ) ) echo esc_attr( $subject ); ?>">
		</div>
		
		<div class="form-comments">
			<label for="cmessage" class="control-label"><?php echo tm_get_local( 'message' ); ?>:</label>
			<textarea id="message" name="cmessage" class="full-width" placeholder="<?php echo tm_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $message ); ?></textarea>
		</div>
		
		<div class="form-captcha">
			<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
			<input type="text" name="ccaptcha" placeholder="<?php echo tm_get_local( 'captcha_place' ); ?>" class="full-width requiredField" value="<?php if(isset($_POST['ccaptcha'])) echo $_POST['ccaptcha'];?>">
			<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
		</div>
		
		<div class="form-submit">
			<input type="hidden" id="submitted" name="contact-submission" value="1">
			<input id="submit-contact-form" type="submit" class="button button--contact" value="<?php echo tm_get_local( 'submit' ); ?>">
		</div>
	</form>
</div><!-- .contact-form-wrapper -->

<script>
jQuery(document).ready(function(){ 
	jQuery('#contactform').validate({
		rules: {
			cname: "required",
			csubject: "required",
			cemail: {
				required: true,
				email: true
			},
			cmessage: {
				required: true,
				minlength: 10
			},
			ccaptcha: {
				required: true,
				number: true,
				equalTo: "#answer"
			}
		},
		messages: {			
			cname: "<?php echo tm_get_local( 'name_required' ); ?>",
			csubject: "<?php echo tm_get_local( 'subject_required' ); ?>",
			cemail: {
				required: "<?php echo tm_get_local( 'email_required' ); ?>",
				email: "<?php echo tm_get_local( 'email_error' );  ?>"
			},
			cmessage: {
				required: "<?php echo tm_get_local( 'message_required' ); ?>",
				minlength: "<?php echo tm_get_local( 'message_min' ); ?>"
			},
			ccaptcha: {
				required: "<?php echo tm_get_local( 'captcha_required' ); ?>",
				number: "<?php echo tm_get_local( 'captcha_number' ); ?>",
				equalTo: "<?php echo tm_get_local( 'captcha_equalto' );  ?>"
			}
		}
	});
});
</script>
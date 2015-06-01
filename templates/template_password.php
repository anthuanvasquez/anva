<?php

$notice = '';
$id			= get_the_ID();

if ( isset( $_POST['password-submit'] ) && 1 == $_POST['password-submit']  ) {
	
	// Check gallery password
	$gallery_password = anva_get_post_meta( '_gallery_password' );
	$gallery_password = base64_decode( $gallery_password );
	
	if ( isset( $_POST['password'] ) && sanitize_text_field( $_POST['password'] ) != $gallery_password  ) {

		$notice = __( '<strong>Error!</strong> Password is incorrect.', ANVA_DOMAIN );
	
	} else {

		$_SESSION['gallery_page_' . $id] = $id;
		
		$permalink = get_permalink( $id );
		
		header( "Location: " . $permalink );
		exit;
	}
}
?>

<div class="password-container">
	<div class="password-inner">
		<div class="password-content">
			
			<div class="lock-icon">
				<i class="fa fa-lock"></i>
			</div>
				
			<p class="lead"><?php _e( 'This gallery is password protected. Please enter password.<br/>To view it please enter your password below', ANVA_DOMAIN ); ?></p>
				
			<?php if ( ! empty ( $notice ) ) : ?>
				<div class="alert alert-danger password-error" role="alert"><?php echo $notice; ?></div>
			<?php endif; ?>

			<form class="form-inline" role="form" method="post" action="<?php echo esc_url( get_permalink( $id ) ); ?>">
				<div class="form-group">
					<p class="lead">
						<input type="password" class="form-control" name="password" placeholder="<?php _e( 'Password', ANVA_DOMAIN ); ?>" />
						<input type="hidden" name="password-submit" value="1" />
						<input type="submit" class="btn btn-default" value="Login" />
					</p>
				</div>
			</form>
				
		</div>
	</div>
</div>
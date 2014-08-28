<?php

function tm_archive_title() {

	if ( is_category() ) :
		single_cat_title();

	elseif ( is_tag() ) :
		single_tag_title();

	elseif ( is_author() ) :
		printf( __( 'Autor: %s', TM_THEME_DOMAIN ), '<span class="vcard">' . get_the_author() . '</span>' );

	elseif ( is_day() ) :
		printf( __( 'Dia: %s', TM_THEME_DOMAIN ), '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		printf( __( 'Mes: %s', TM_THEME_DOMAIN ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', TM_THEME_DOMAIN ) ) . '</span>' );

	elseif ( is_year() ) :
		printf( __( 'Ano: %s', TM_THEME_DOMAIN ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', TM_THEME_DOMAIN ) ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		_e( 'Asides', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
		_e( 'Galerias', TM_THEME_DOMAIN);

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		_e( 'Imagenes', TM_THEME_DOMAIN);

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		_e( 'Videos', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		_e( 'Citas', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		_e( 'Enlaces', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
		_e( 'Estados', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
		_e( 'Audios', TM_THEME_DOMAIN );

	elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
		_e( 'Chats', TM_THEME_DOMAIN );

	else :
		_e( 'Archivos', TM_THEME_DOMAIN );

	endif;

}

function tm_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Navegaci&oacute;n', 'tm' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Anterior', 'tm' ) );
				next_post_link( '<div class="nav-next">%link</div>', _x( '%title <span class="meta-nav">&rarr;</span>', 'Siguiente', 'tm' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}

function tm_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="posted-on">Publicado en %1$s</span><span class="byline"> por %2$s</span>', '_s' ),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		)
	);
}

function tm_social_media() {
	
	$html 			= '';
	$facebook 	= tm_get_option('social_facebook');
	$twitter 		= tm_get_option('social_twitter');
	$instagram 	= tm_get_option('social_instagram');
	$gplus 			= tm_get_option('social_gplus');
	$youtube 		= tm_get_option('social_youtube');
	$linkedin 	= tm_get_option('social_linkedin');	
	$vimeo 			= tm_get_option('social_vimeo');
	$pinterest 	= tm_get_option('social_pinterest');
	$digg 			= tm_get_option('social_digg');
	$dribbble 	= tm_get_option('social_dribbble');
	$rss 				= tm_get_option('social_rss');

	if( ! empty( $facebook ) ) {
		$html .= '<li><a href="'. esc_url( $facebook ) .'" class="social social-facebook"><span class="screen-reader-text">Facebook</span></a></li>';
	}

	if( ! empty( $twitter ) ) {
		$html .= '<li><a href="'. esc_url( $twitter ) .'" class="social social-twitter"><span class="screen-reader-text">Twitter</span></a></li>';
	}

	if( ! empty( $instagram ) ) {
		$html .= '<li><a href="'. esc_url( $instagram ) .'" class="social social-instagram"><span class="screen-reader-text">Instagram</span></a></li>';
	}

	if( ! empty( $gplus ) ) {
		$html .= '<li><a href="'. esc_url( $gplus ) .'" class="social social-gplus"><span class="screen-reader-text">Google+</span></a></li>';
	}

	if( ! empty( $youtube ) ) {
		$html .= '<li><a href="'. esc_url( $youtube ) .'" class="social social-youtube"><span class="screen-reader-text">Youtube</span></a></li>';
	}

	if( ! empty( $linkedin ) ) {
		$html .= '<li><a href="'. esc_url( $linkedin ) .'" class="social social-linkedin"><span class="screen-reader-text">LinkedIn</span></a></li>';
	}

	if( ! empty( $vimeo ) ) {
		$html .= '<li><a href="'. esc_url( $vimeo ) .'" class="social social-vimeo"><span class="screen-reader-text">Vimeo</span></a></li>';
	}

	if( ! empty( $pinterest ) ) {
		$html .= '<li><a href="'. esc_url( $pinterest ) .'" class="social social-pinterest"><span class="screen-reader-text">Pinterest</span></a></li>';
	}

	if( ! empty( $digg ) ) {
		$html .= '<li><a href="'. esc_url( $digg ) .'" class="social social-digg"><span class="screen-reader-text">Digg</span></a></li>';
	}

	if( ! empty( $dribbble ) ) {
		$html .= '<li><a href="'. esc_url( $dribbble ) .'" class="social social-dribbble"><span class="screen-reader-text">Dribbble</span></a></li>';
	}

	if( ! empty( $rss ) ) {
		$html .= '<li><a href="'. esc_url( $rss ) .'" class="social social-rss"><span class="screen-reader-text">RSS</span></a></li>';
	}

	return $html;

}

function tm_site_search() {
	if ( class_exists( 'Woocommerce' ) ) :
		get_product_search_form();
	else :
		get_search_form( true );
	endif;
}

function tm_pagination( $query = '' ) {

	if ( empty( $query ) ) :
	?>
	<ul id="nav-posts" class="nav-posts group">
		<li class="prev alignleft"><?php previous_posts_link( tm_get_local( 'prev' ) ); ?></li>
		<li class="next alignright"><?php next_posts_link( tm_get_local( 'next' ) ); ?></li>
	</ul>
	<?php
	else : ?>
	<ul id="nav-posts" class="nav-posts group">
		<li class="prev alignleft"><?php previous_posts_link( tm_get_local( 'prev'  ), $query->max_num_pages ); ?></li>
		<li class="next alignright"><?php next_posts_link( tm_get_local( 'next'  ), $query->max_num_pages ); ?></li>
	</ul>
	<?php
	endif;
}

function tm_num_pagination( $pages = '', $range = 2 ) {
	
	$showitems = ( $range * 2) + 1;  
	
	global $paged;
	
	if ( empty( $paged ) ) $paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) {
			$pages = 1;
		}
	}
	
	if ( 1 != $pages ) {
		echo "<div class='pagination group'>";
			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
				echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
			
			if ( $paged > 1 && $showitems < $pages )
				echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages &&( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
					echo ($paged == $i) ? "<span class='current'>".$i."</span>" : "<a href='".get_pagenum_link( $i )."' class='inactive' >".$i."</a>";
				}
			}

			if ( $paged < $pages && $showitems < $pages )
				echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
			
			if ( $paged < $pages - 1 &&  $paged+$range - 1 < $pages && $showitems < $pages )
				echo "<a href='".get_pagenum_link( $pages )."'>&raquo;</a>";
		echo "</div>\n";
	}
}

function tm_contact_form() {
	
	global $email_sended_message;

	// Set random values to set random questions
	$a = rand(1, 9);
	$b = rand(1, 9);
	$s = $a + $b;
	$answer = $s;
	
	?>
	<div class="contact-form-container">
		
		<?php if ( ! empty( $email_sended_message ) ) : ?>
			<div id="email_message" class="alert alert-block"><?php echo $email_sended_message; ?></div>
		<?php endif; ?>

		<form id="contactform" class="contact-form" method="post" action="<?php the_permalink(); ?>#contactform">

			<div class="form-name">
				<label for="cname" class="control-label"><?php echo tm_get_local( 'name' ); ?>:</label>
				<input id="name" type="text" placeholder="<?php echo tm_get_local( 'name_place' ); ?>" name="cname" class="full-width requiredField" value="<?php if ( isset( $_POST['cname'] ) ) echo esc_attr( $_POST['cname'] ); ?>">
			</div>
			
			<div class="form-email">
				<label for="cemail" class="control-label"><?php echo tm_get_local( 'email' ); ?>:</label>
				<input id="email" type="email" placeholder="<?php _e('Correo Electr&oacute;nico', TM_THEME_DOMAIN); ?>" name="cemail" class="full-width requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) echo esc_attr( $_POST['cemail'] );?>">
			</div>

			<div class="form-subject">						
				<label for="csubject" class="control-label"><?php echo tm_get_local( 'subject' ); ?>:</label>
				<input id="subject" type="text" placeholder="<?php echo tm_get_local( 'subject' ); ?>" name="csubject" class="full-width requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) echo esc_attr( $_POST['csubject'] ); ?>">
			</div>
			
			<div class="form-comments">
				<label for="cmessage" class="control-label"><?php echo tm_get_local( 'message' ); ?>:</label>
				<textarea id="message" name="cmessage" class="full-width" placeholder="<?php echo tm_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $_POST['cmessage'] ); ?></textarea>
			</div>
			
			<div class="form-captcha">
				<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
				<input type="text" name="ccaptcha" placeholder="<?php echo tm_get_local( 'captcha_place' ); ?>" class="full-width requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) echo $_POST['ccaptcha'];?>">
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
		
		setTimeout(function(){
			jQuery("#email_message").fadeOut("slow");
		}, 3000);
		
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
	<?php
}
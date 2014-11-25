<?php

function tm_archive_title() {

	if ( is_category() ) :
		single_cat_title();

	elseif ( is_tag() ) :
		single_tag_title();

	elseif ( is_author() ) :
		printf( tm_get_local( 'author' ) . ' %s', '<span class="vcard">' . get_the_author() . '</span>' );

	elseif ( is_day() ) :
		printf( tm_get_local( 'day' ) . ' %s', '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		printf( tm_get_local( 'month' ) . ' %s', '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		printf( tm_get_local( 'year' ) . ' %s', '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		echo tm_get_local( 'asides' );

	elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
		echo tm_get_local( 'galleries' );

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		echo tm_get_local( 'images' );

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		echo tm_get_local( 'videos' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		echo tm_get_local( 'quotes' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		echo tm_get_local( 'links' );

	elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
		echo tm_get_local( 'status' );

	elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
		echo tm_get_local( 'audios' );

	elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
		echo tm_get_local( 'chats' );

	else :
		echo tm_get_local( 'archives' );

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
	<nav class="post-navigation" role="navigation">
		<div class="post-navigation-inner">
			<div class="navigation-links">
				<?php
					previous_post_link( '<div class="nav-previous">%link</div>', tm_get_local( 'prev' ) );
					next_post_link( '<div class="nav-next">%link</div>', tm_get_local( 'next' ) );
				?>
			</div>
		</div>
	</nav><!-- .post-navigation (end) -->
	<?php
}

function tm_posted_on() {

	// Get the time
	$time_string = '<time class="entry-date published" datetime="%1$s"><i class="fa fa-calendar"></i> %2$s</time>';
	
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s"><i class="fa fa-calendar"></i> %4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	// Get comments number
	$num_comments = get_comments_number();

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __( 'No hay Comentarios', TM_THEME_DOMAIN );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __( ' Comentarios', TM_THEME_DOMAIN );
		} else {
			$comments = __( '1 Comentario', TM_THEME_DOMAIN );
		}
		$write_comments = '<a href="' . get_comments_link() .'"><span class="leave-reply">'.$comments.'</span></a>';
	} else {
		$write_comments =  __( 'Comentarios cerrado', TM_THEME_DOMAIN );
	}

	$sep = ' / ';

	printf(
		'<div class="entry-meta">
			<span class="posted-on">%1$s</span>
			<span class="sep">%5$s</span>
			<span class="byline"><i class="fa fa-user"></i> %2$s</span>
			<span class="sep">%5$s</span>
			<span class="category"><i class="fa fa-bars"></i> %3$s</span>
			<span class="sep">%5$s</span>
			<span class="comments-link"><i class="fa fa-comments"></i> %4$s</span>
		</div><!-- .entry-meta (end) -->',
		sprintf(
			'%1$s', $time_string
		),
		sprintf(
			'<span class="author vcard"><a class="url fn" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		),
		sprintf(
			'%1$s', get_the_category_list( ', ' )
		),
		sprintf(
			'%1$s', $write_comments
		),
		sprintf( '%1$s', $sep )
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

	if ( ! empty( $facebook ) ) {
		$html .= '<li><a href="'. esc_url( $facebook ) .'" class="social social-facebook"><span class="sr-only">Facebook</span></a></li>';
	}

	if ( ! empty( $twitter ) ) {
		$html .= '<li><a href="'. esc_url( $twitter ) .'" class="social social-twitter"><span class="sr-only">Twitter</span></a></li>';
	}

	if ( ! empty( $instagram ) ) {
		$html .= '<li><a href="'. esc_url( $instagram ) .'" class="social social-instagram"><span class="sr-only">Instagram</span></a></li>';
	}

	if ( ! empty( $gplus ) ) {
		$html .= '<li><a href="'. esc_url( $gplus ) .'" class="social social-gplus"><span class="sr-only">Google+</span></a></li>';
	}

	if ( ! empty( $youtube ) ) {
		$html .= '<li><a href="'. esc_url( $youtube ) .'" class="social social-youtube"><span class="sr-only">Youtube</span></a></li>';
	}

	if ( ! empty( $linkedin ) ) {
		$html .= '<li><a href="'. esc_url( $linkedin ) .'" class="social social-linkedin"><span class="sr-only">LinkedIn</span></a></li>';
	}

	if ( ! empty( $vimeo ) ) {
		$html .= '<li><a href="'. esc_url( $vimeo ) .'" class="social social-vimeo"><span class="sr-only">Vimeo</span></a></li>';
	}

	if ( ! empty( $pinterest ) ) {
		$html .= '<li><a href="'. esc_url( $pinterest ) .'" class="social social-pinterest"><span class="sr-only">Pinterest</span></a></li>';
	}

	if ( ! empty( $digg ) ) {
		$html .= '<li><a href="'. esc_url( $digg ) .'" class="social social-digg"><span class="sr-only">Digg</span></a></li>';
	}

	if ( ! empty( $dribbble ) ) {
		$html .= '<li><a href="'. esc_url( $dribbble ) .'" class="social social-dribbble"><span class="sr-only">Dribbble</span></a></li>';
	}

	if ( ! empty( $rss ) ) {
		$html .= '<li><a href="'. esc_url( $rss ) .'" class="social social-rss"><span class="sr-only">RSS</span></a></li>';
	}

	return $html;

}

function tm_site_search() {
	if ( class_exists( 'Woocommerce' ) ) :
		tm_get_product_search_form();
	else :
		tm_get_search_form();
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
		echo "<nav id='pagination'>";
		echo "<ul class='pagination group'>";
			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
			
			if ( $paged > 1 && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

			for ( $i = 1; $i <= $pages; $i++ ) {
				if ( 1 != $pages &&( !($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) ) {
					echo ($paged == $i) ? "<li class='active'><a href='#'>".$i."<span class='sr-only'>(current)</span></a></li>" : "<li><a href='".get_pagenum_link( $i )."'>".$i."</a></li>";
				}
			}

			if ( $paged < $pages && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";  
			
			if ( $paged < $pages - 1 &&  $paged+$range - 1 < $pages && $showitems < $pages )
				echo "<li><a href='".get_pagenum_link( $pages )."'>&raquo;</a></li>";
		echo "</ul>\n";
		echo "</nav>";
	}
}

function tm_comment_pagination() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav id="comment-nav" class="comment-navigation" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( tm_get_local( 'comment_prev' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( tm_get_local( 'comment_next' ) ); ?></div>
	</nav><!-- #comment-nav-above (end) -->
	<?php
	endif;
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

		<form id="contactform" class="contact-form"  role="form" method="post" action="<?php the_permalink(); ?>#contactform">

			<div class="form-name form-group">
				<label for="cname" class="control-label"><?php echo tm_get_local( 'name' ); ?>:</label>
				<input id="name" type="text" placeholder="<?php echo tm_get_local( 'name_place' ); ?>" name="cname" class="form-control requiredField" value="<?php if ( isset( $_POST['cname'] ) ) echo esc_attr( $_POST['cname'] ); ?>">
			</div>
			
			<div class="form-email form-group">
				<label for="cemail" class="control-label"><?php echo tm_get_local( 'email' ); ?>:</label>
				<input id="email" type="email" placeholder="<?php _e('Correo Electr&oacute;nico', TM_THEME_DOMAIN); ?>" name="cemail" class="form-control requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) echo esc_attr( $_POST['cemail'] );?>">
			</div>

			<div class="form-subject form-group">						
				<label for="csubject" class="control-label"><?php echo tm_get_local( 'subject' ); ?>:</label>
				<input id="subject" type="text" placeholder="<?php echo tm_get_local( 'subject' ); ?>" name="csubject" class="form-control requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) echo esc_attr( $_POST['csubject'] ); ?>">
			</div>
			
			<div class="form-message form-group">
				<label for="cmessage" class="control-label"><?php echo tm_get_local( 'message' ); ?>:</label>
				<textarea id="message" name="cmessage" class="form-control" placeholder="<?php echo tm_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $_POST['cmessage'] ); ?></textarea>
			</div>
			
			<div class="form-captcha form-group">
				<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
				<input type="text" name="ccaptcha" placeholder="<?php echo tm_get_local( 'captcha_place' ); ?>" class="form-control requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) echo $_POST['ccaptcha'];?>">
				<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
			</div>
			
			<div class="form-submit form-group">
				<input type="hidden" id="submitted" name="contact-submission" value="1">
				<input id="submit-contact-form" type="submit" class="btn btn-primary" value="<?php echo tm_get_local( 'submit' ); ?>">
			</div>
		</form>
	</div><!-- .contact-form-wrapper -->

	<script>
	jQuery(document).ready(function(){ 
		
		setTimeout(function(){
			jQuery("#email_message").fadeOut("slow");
		}, 3000);

		jQuery('#contactform input[type="text"]').attr('autocomplete', 'off');
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

function tm_get_search_form() {
	?>
	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
		<div class="input-group">
			<input type="search" class="search-field form-control" placeholder="<?php echo tm_get_local( 'search' ); ?>" value="" name="s" title="<?php echo tm_get_local( 'search_for' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo tm_get_local( 'search_for' ); ?></span>
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	</form>
	<?php
}

function tm_get_product_search_form() {
	?>
	<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<div class="input-group">
		<input type="text" id="s" name="s" class="form-control" value="<?php echo get_search_query(); ?>"  placeholder="<?php _e( 'Search for products', 'woocommerce' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo esc_attr__( 'Search' ); ?></span>
					<i class="fa fa-search"></i>
				</button>
				<input type="hidden" name="post_type" value="product" />
			</span>
		</div>
	</form>
	<?php
}

function tm_comment_list( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	
	<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-wrapper">
			<div class="row">
	<?php endif; ?>
	
	<div class="comment-avatar col-xs-3 col-sm-2">
		<a href="<?php echo get_comment_author_link(); ?>">
			<?php
				if ( $args['avatar_size'] != 0 )
					echo get_avatar( $comment, 64 );
			?>
		</a>
	</div>

	<div class="comment-body col-xs-9 col-sm-10">
		<h4 class="comment-author vcard">
		<?php
			printf(
				'<cite class="fn">%s</cite> <span class="says">says:</span>',
				get_comment_author_link()
			);
		?>
		</h4>

		<div class="comment-meta">
			<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
				<?php edit_comment_link( __( '(Edit)' ), '  ', '' ); ?>
			</a>
		</div>

		<?php if ( $comment->comment_approved == '0' ) : ?>
		<em class="comment-awaiting-moderation well well-sm"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
		<?php endif; ?>
		
		<div class="comment-text">
			<?php comment_text(); ?>
		</div>
		
		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	
	</div>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	</div>
	<?php endif; ?>

<?php
}

function replace_reply_link_class( $class ){
	$class = str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-default btn-sm", $class );
	return $class;
}
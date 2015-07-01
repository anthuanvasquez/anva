<?php

/**
 * Archive titles
 */
function anva_archive_title() {

	if ( is_category() ) :
		single_cat_title();

	elseif ( is_tag() ) :
		single_tag_title();

	elseif ( is_author() ) :
		printf( anva_get_local( 'author' ) . ' %s', '<span class="vcard">' . get_the_author() . '</span>' );

	elseif ( is_day() ) :
		printf( anva_get_local( 'day' ) . ' %s', '<span>' . get_the_date() . '</span>' );

	elseif ( is_month() ) :
		printf( anva_get_local( 'month' ) . ' %s', '<span>' . get_the_date( 'F Y' ) . '</span>' );

	elseif ( is_year() ) :
		printf( anva_get_local( 'year' ) . ' %s', '<span>' . get_the_date( 'Y' ) . '</span>' );

	elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
		echo anva_get_local( 'asides' );

	elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
		echo anva_get_local( 'galleries' );

	elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
		echo anva_get_local( 'images' );

	elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
		echo anva_get_local( 'videos' );

	elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
		echo anva_get_local( 'quotes' );

	elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
		echo anva_get_local( 'links' );

	elseif ( is_tax( 'post_format', 'post-format-status' ) ) :
		echo anva_get_local( 'status' );

	elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
		echo anva_get_local( 'audios' );

	elseif ( is_tax( 'post_format', 'post-format-chat' ) ) :
		echo anva_get_local( 'chats' );

	else :
		echo anva_get_local( 'archives' );
	endif;

}

/**
 * Meta posted on
 */
function anva_posted_on() {
	// Get the time
	$time_string = '<time class="entry-date published" datetime="%1$s"><i class="fa fa-calendar"></i> %2$s</time>';
	
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="entry-date-updated updated" datetime="%3$s"><i class="fa fa-calendar"></i> %4$s</time>';
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
			$comments = __( 'No hay Comentarios', ANVA_DOMAIN );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __( ' Comentarios', ANVA_DOMAIN );
		} else {
			$comments = __( '1 Comentario', ANVA_DOMAIN );
		}
		$write_comments = '<a href="' . get_comments_link() .'"><span class="leave-reply">'.$comments.'</span></a>';
	} else {
		$write_comments =  __( 'Comentarios cerrado', ANVA_DOMAIN );
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

/**
 * Social media icons
 */
function anva_social_icons( $size = '', $style = '', $color = '' ) {
	
	$html 			= '';
	$classes 		= array();
	$facebook 	= anva_get_option('social_facebook');
	$twitter 		= anva_get_option('social_twitter');
	$instagram 	= anva_get_option('social_instagram');
	$gplus 			= anva_get_option('social_gplus');
	$youtube 		= anva_get_option('social_youtube');
	$linkedin 	= anva_get_option('social_linkedin');	
	$vimeo 			= anva_get_option('social_vimeo');
	$pinterest 	= anva_get_option('social_pinterest');
	$digg 			= anva_get_option('social_digg');
	$dribbble 	= anva_get_option('social_dribbble');
	$rss 				= anva_get_option('social_rss');

	$profiles = array(
		'facebook' => array(
			'name' => 'Facebook',
			'url'  => $facebook
		),
		'twitter' => array(
			'name' => 'Twitter',
			'url'  => $twitter
		),
		'instagram' => array(
			'name' => 'Instagram',
			'url'  => $instagram
		),
		'google-plus' => array(
			'name' => 'Google+',
			'url'  => $gplus
		),
		'youtube' => array(
			'name' => 'Youtube',
			'url'  => $youtube
		),
		'linkedin' => array(
			'name' => 'LinkedIn',
			'url'  => $linkedin
		),
		'vimeo-square' => array(
			'name' => 'Vimeo',
			'url'  => $vimeo
		),
		'pinterest' => array(
			'name' => 'Pinterest',
			'url'  => $pinterest
		),
		'digg' => array(
			'name' => 'Digg',
			'url'  => $digg
		),
		'dribbble' => array(
			'name' => 'Dribbble',
			'url'  => $dribbble
		),
		'rss' => array(
			'name' => 'RSS',
			'url'  => $rss
		),
	);

	if ( ! empty( $size ) ) {
		$classes[] = $size;
	}

	if ( ! empty( $color ) ) {
		$classes[] = $color;
	}

	if ( ! empty( $style ) ) {
		$classes[] = $style;
	}

	$classes = implode( ' ', $classes );

	$html .= '<ul class="social-icons">';
	
	foreach ( $profiles as $key => $value ) {

		if ( isset( $value['url'] ) && ! empty( $value['url'] ) ) {

			$name  = $value['name'];
			$url 	 = $value['url'];
			$html .= '<li>';
			$html .= '<a href="'. esc_url( $url ) .'" class="social-icon social-'. esc_attr( $key ) . ' '. esc_attr( $classes ) . '" data-toggle="tooltip" data-placement="top" title="'. $name .'"><i class="fa fa-'. esc_attr( $key ) .'"></i>';
			$html .= '</a>';
			$html .= '</li>';

		}
	}

	$html .= '</ul>';

	return $html;

}

/**
 * Display default social media profiles.
 *
 * @return html output
 */

function anva_social_media( $buttons = array(), $style = null ) {

	// Set up buttons
	if ( ! $buttons ) {
		$buttons = anva_get_option( 'social_media' );
	}

	// Set up style
	if ( ! $style ) {
		$style = anva_get_option( 'social_media_style', 'normal' );
	}

	// Social media sources
	$profiles = anva_get_social_media_profiles();

	// Start output
	$output = '';
	if ( is_array( $buttons ) && ! empty ( $buttons ) ) {

		$output .= '<div class="social-media">';
		$output .= '<div class="social-inner">';
		$output .= '<ul class="social-icons">';

		foreach ( $buttons as $id => $url ) {

			// Link target
			$target = '_blank';
			
			// Link Title
			$title = '';
			if ( isset( $profiles[$id] ) ) {
				$title = $profiles[$id];
			}

			$output .= sprintf( '<li><a href="%1$s" title="%2$s" class="social-icon social-%3$s" target="%4$s"><i class="fa fa-%3$s"></i><span class="sr-only">%2$s</span></a></li>', $url, $title, $id, $target );
		}

		$output .= '</ul><!-- .social-icons (end) -->';
		$output .= '</div><!-- .social-inner (end) -->';
		$output .= '</div><!-- .social-media (end) -->';
	}
	
	return apply_filters( 'of_social_media_buttons', $output );

}

/**
 * Header search
 */
function anva_site_search() {
	if ( class_exists( 'Woocommerce' ) ) :
		anva_get_product_search_form();
	else :
		anva_get_search_form();
	endif;
}

/**
 * Post navigation
 */
function anva_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="post-navigation" role="navigation">
		<div class="post-navigation-inner">
			<div class="pager navigation-content clearfix">
				<?php
					previous_post_link( '<div class="previous">%link</div>', anva_get_local( 'prev' ) );
					next_post_link( '<div class="next">%link</div>', anva_get_local( 'next' ) );
				?>
			</div>
		</div>
	</nav><!-- .post-navigation (end) -->
	<div class="line"></div>
	<?php
}

/**
 * Pagination
 */
function anva_pagination( $query = '' ) {

	if ( empty( $query ) ) :
	?>
	<ul id="nav-posts" class="pager clearfix">
		<li class="previous"><?php previous_posts_link( anva_get_local( 'prev' ) ); ?></li>
		<li class="next"><?php next_posts_link( anva_get_local( 'next' ) ); ?></li>
	</ul>
	<?php
	else : ?>
	<ul id="nav-posts" class="pager clearfix">
		<li class="previous"><?php previous_posts_link( anva_get_local( 'prev'  ), $query->max_num_pages ); ?></li>
		<li class="next"><?php next_posts_link( anva_get_local( 'next'  ), $query->max_num_pages ); ?></li>
	</ul>
	<?php
	endif;
}

/**
 * Num pagination
 */
function anva_num_pagination( $pages = '', $range = 2 ) {
	
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
		echo "<ul class='pagination clearfix'>";
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

/**
 * Comment pagination
 */
function anva_comment_pagination() {
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav id="comment-nav" class="pager comment-navigation" role="navigation">
		<div class="previous nav-previous"><?php previous_comments_link( anva_get_local( 'comment_prev' ) ); ?></div>
		<div class="next nav-next"><?php next_comments_link( anva_get_local( 'comment_next' ) ); ?></div>
	</nav><!-- #comment-nav-above (end) -->
	<?php
	endif;
}

/**
 * Contact form
 */
function anva_contact_form() {
	
	global $email_sended_message;

	// Set random values to set random questions
	$a = rand(1, 9);
	$b = rand(1, 9);
	$s = $a + $b;
	$answer = $s;
	
	?>
	<div class="contact-form-container">
		
		<?php if ( ! empty( $email_sended_message ) ) : ?>
			<div id="email_message" class="alert alert-warning"><?php echo $email_sended_message; ?></div>
		<?php endif; ?>

		<form id="contactform" class="contact-form"  role="form" method="post" action="<?php the_permalink(); ?>#contactform">

			<div class="form-name form-group">
				<label for="cname" class="control-label"><?php echo anva_get_local( 'name' ); ?>:</label>
				<input id="name" type="text" placeholder="<?php echo anva_get_local( 'name_place' ); ?>" name="cname" class="form-control requiredField" value="<?php if ( isset( $_POST['cname'] ) ) echo esc_attr( $_POST['cname'] ); ?>">
			</div>
			
			<div class="form-email form-group">
				<label for="cemail" class="control-label"><?php echo anva_get_local( 'email' ); ?>:</label>
				<input id="email" type="email" placeholder="<?php _e('Correo Electr&oacute;nico', ANVA_DOMAIN); ?>" name="cemail" class="form-control requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) echo esc_attr( $_POST['cemail'] );?>">
			</div>

			<div class="form-subject form-group">						
				<label for="csubject" class="control-label"><?php echo anva_get_local( 'subject' ); ?>:</label>
				<input id="subject" type="text" placeholder="<?php echo anva_get_local( 'subject' ); ?>" name="csubject" class="form-control requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) echo esc_attr( $_POST['csubject'] ); ?>">
			</div>
			
			<div class="form-message form-group">
				<label for="cmessage" class="control-label"><?php echo anva_get_local( 'message' ); ?>:</label>
				<textarea id="message" name="cmessage" class="form-control" placeholder="<?php echo anva_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $_POST['cmessage'] ); ?></textarea>
			</div>
			
			<div class="form-captcha form-group">
				<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
				<input type="text" name="ccaptcha" placeholder="<?php echo anva_get_local( 'captcha_place' ); ?>" class="form-control requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) echo $_POST['ccaptcha'];?>">
				<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
			</div>
			
			<div class="form-submit form-group">
				<input type="hidden" id="submitted" name="contact-submission" value="1">
				<input id="submit-contact-form" type="submit" class="button button-3d" value="<?php echo anva_get_local( 'submit' ); ?>">
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
				cname: "<?php echo anva_get_local( 'name_required' ); ?>",
				csubject: "<?php echo anva_get_local( 'subject_required' ); ?>",
				cemail: {
					required: "<?php echo anva_get_local( 'email_required' ); ?>",
					email: "<?php echo anva_get_local( 'email_error' );  ?>"
				},
				cmessage: {
					required: "<?php echo anva_get_local( 'message_required' ); ?>",
					minlength: "<?php echo anva_get_local( 'message_min' ); ?>"
				},
				ccaptcha: {
					required: "<?php echo anva_get_local( 'captcha_required' ); ?>",
					number: "<?php echo anva_get_local( 'captcha_number' ); ?>",
					equalTo: "<?php echo anva_get_local( 'captcha_equalto' );  ?>"
				}
			}
		});
	});
	</script>
	<?php
}

/**
 * Search form
 */
function anva_get_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="input-group">
			<input type="search" id="s" class="search-field form-control" placeholder="<?php echo anva_get_local( 'search' ); ?>" value="" name="s" title="<?php echo anva_get_local( 'search_for' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo anva_get_local( 'search_for' ); ?></span>
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	</form>
	<?php
}

/**
 * Woocommerce search product form
 */
function anva_get_product_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<div class="input-group">
		<input type="text" id="s" name="s" class="search-field form-control" value="<?php echo get_search_query(); ?>"  placeholder="<?php _e( 'Search for products', 'woocommerce' ); ?>" />
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

/**
 * Get comment list
 */
function anva_comment_list( $comment, $args, $depth ) {
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
		<a href="<?php echo comment_author_url( $comment->comment_ID ); ?>">
			<?php
				if ( $args['avatar_size'] != 0 ) {
					echo get_avatar( $comment, 64 );
				}
			?>
		</a>
	</div>

	<div class="comment-body col-xs-9 col-sm-10">
		<h4 class="comment-author vcard">
		<?php
			printf(
				'<cite class="fn">%s</cite> <span class="says sr-only">says:</span>',
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

/**
 * Replace reply link class in comment form
 */
function anva_comment_reply_link_class( $class ){
	$class = str_replace( "class='comment-reply-link", "class='comment-reply-link btn btn-default btn-sm", $class );
	return $class;
}

/**
 * Display a breadcrumb menu after header
 */
function anva_get_breadcrumbs() {  
	
	$text['home']   		= anva_get_local( 'home' );
	$text['category'] 	= anva_get_local( 'category_archive' ) . ' "%s"';
	$text['search']  		= anva_get_local( 'search_results' ) . ' "%s"';
	$text['tag']   			= anva_get_local( 'tag_archive' ) . ' "%s"';
	$text['author']  		= anva_get_local( 'author_archive' ) . ' "%s"';
	$text['404']   			= anva_get_local( '404' );
	
	$show_current  			= 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show  
	$show_on_home  			= 0; // 1 - show breadcrumbs on the homepage, 0 - don't show  
	$show_home_link			= 1; // 1 - show the 'Home' link, 0 - don't show  
	$show_title   			= 1; // 1 - show the title for the links, 0 - don't show  
	$delimiter   				= '<span class="separator"> / </span>'; // delimiter between crumbs  
	$before     				= '<span class="current">'; // tag before the current crumb  
	$after     					= '</span>'; // tag after the current crumb   
	
	global $post;

	$home_link  				= home_url( '/' );  
	$link_before 				= '<span typeof="v:Breadcrumb">';  
	$link_after  				= '</span>';  
	$link_attr  				= ' rel="v:url" property="v:title"';  
	$link     					= $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;  
	$parent_id  				= $parent_id_2 = $post->post_parent;  
	$frontpage_id 			= get_option( 'page_on_front' );  
	
	// Home or Front Page
	if ( is_home() || is_front_page() ) {
	
		if ( $show_on_home == 1 ) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';  
	
	} else {
	
		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		
		if ( $show_home_link == 1 ) {
			
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';  
			
			if ( $frontpage_id == 0 || $parent_id != $frontpage_id )
				echo $delimiter;
		} 
	
		// Category Navigation
		if ( is_category() ) {
			
			$this_cat = get_category(get_query_var('cat'), false);

			if ( $this_cat->parent != 0 ) {  
				
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);

				if ( $show_current == 0 ) {
					$cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				}
				
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				
				if ( $show_title == 0 ) {
					$cats = preg_replace('/ title="(.*?)"/', '', $cats);
				}
				
				echo $cats;
			}
			
			if ( $show_current == 1 )
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
		
		// Search Navigation
		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;  
		
		// Archive: Day
		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;  
			echo $before . get_the_time('d') . $after;  
		
		// Archive: Month
		} elseif ( is_month() ) {  
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
			echo $before . get_the_time('F') . $after;  
		
		// Archive: Year
		} elseif ( is_year() ) {  
			echo $before . get_the_time('Y') . $after;  
		
		// Single Post
		} elseif ( is_single() && ! is_attachment() ) {  
			
			if ( get_post_type() != 'post' ) {
				
				$post_type = get_post_type_object(get_post_type());  
				
				$slug = $post_type->rewrite;  
				
				printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);  
				
				if ( $show_current == 1) {
					echo $delimiter . $before . get_the_title() . $after;  
				}
			
			} else {  
				$cat = get_the_category(); $cat = $cat[0];  
				$cats = get_category_parents($cat, TRUE, $delimiter);  
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);  
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
				echo $cats;  
				if ($show_current == 1) echo $before . get_the_title() . $after;  
			}  
	
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {  
			$post_type = get_post_type_object(get_post_type());  
			echo $before . $post_type->labels->singular_name . $after;  
		
		// Single Attachment
		} elseif ( is_attachment() ) {  
			$parent = get_post($parent_id);  
			$cat = get_the_category($parent->ID); $cat = $cat[0];  
			if ($cat) {  
				$cats = get_category_parents($cat, TRUE, $delimiter);  
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);  
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);  
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);  
				echo $cats;  
			}  
			printf($link, get_permalink($parent), $parent->post_title);  
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;  
		
		// Single Page
		} elseif ( is_page() && !$parent_id ) {  
			if ($show_current == 1) echo $before . get_the_title() . $after;  
	
		} elseif ( is_page() && $parent_id ) {  
			if ($parent_id != $frontpage_id) {  
				$breadcrumbs = array();  
				while ($parent_id) {  
					$page = get_page($parent_id);  
					if ($parent_id != $frontpage_id) {  
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
					}  
					$parent_id = $page->post_parent;  
				}  
				$breadcrumbs = array_reverse($breadcrumbs);  
				for ($i = 0; $i < count($breadcrumbs); $i++) {  
					echo $breadcrumbs[$i];  
					if ($i != count($breadcrumbs)-1) echo $delimiter;  
				}  
			}  
			if ($show_current == 1) {  
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;  
				echo $before . get_the_title() . $after;  
			}  
		
		// Tag Navigation
		} elseif ( is_tag() ) {  
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;  
		
		// Single Author Navigation
		} elseif ( is_author() ) {
			global $author;  
			$userdata = get_userdata($author);  
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;  
		
		// 404 Page
		} elseif ( is_404() ) {  
			echo $before . $text['404'] . $after;  
		
		// Single Page
		} elseif ( has_post_format() && !is_singular() ) {  
			echo get_post_format_string( get_post_format() );  
		}  
		
		// Is Paged
		// if ( get_query_var('paged') ) {  
		// 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';  
		// 	echo __('Page') . ' ' . get_query_var('paged');  
		// 	if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';  
		// }
	
		echo '</div><!-- .breadcrumbs (end) -->';
	
	}
}

/*
 * Custom Password Form
 */
function anva_the_password_form() {
	global $post;
	$label = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
	$html  = '';
	$html .= '<p class="lead">' . __( "To view this protected post, enter the password below", anva_textdomain() ) . ':</p>';
	$html .= '<form class="form-inline" role="form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$html .= '<div class="form-group">';
	$html .= '<input class="form-control" name="post_password" id="' . esc_attr( $label ) . '" type="password" maxlength="20" />';
	$html .= '<input type="submit" class="btn btn-default" name="Submit" value="' . esc_attr__( "Submit", anva_textdomain() ) . '" />';
	$html .= '</div>';
	$html .= '</form>';
	return $html;
}

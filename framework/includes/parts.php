<?php

/**
 * Archive pages titles.
 * 
 * @since  1.0.0
 * @return void
 */
function anva_archive_title() {

	if ( is_front_page() )
		return;

	if ( is_single() || is_page() ) :
		the_title();

	elseif ( is_category() ) :
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

	elseif ( is_tax( 'gallery_cat' ) ) :
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		echo esc_html( $term->name );

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

	elseif ( is_404() ) :
		echo anva_get_local( '404_title' );
	else :
		echo anva_get_local( 'archives' );
	endif;

}

/**
 * Posted on
 * 
 * @since 1.0.0
 */
function anva_posted_on() {
	
	// Get the time
	$time_string = '<time class="entry-date published" datetime="%1$s"><i class="icon-calendar3"></i> %2$s</time>';
	
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="entry-date-updated updated" datetime="%3$s"><i class="icon-calendar3"></i> %4$s</time>';
	}

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'jS F Y' ) ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date( 'jS F Y' ) )
	);

	// Get comments number
	$num_comments = get_comments_number();

	if ( comments_open() ) {
		if ( $num_comments == 0 ) {
			$comments = __( 'No Comments', 'anva' );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __( ' Comments', 'anva' );
		} else {
			$comments = __( '1 Comment', 'anva' );
		}
		$write_comments = '<a href="' . get_comments_link() . '"><span class="leave-reply">' . $comments . '</span></a>';
	} else {
		$write_comments =  __( 'Comments closed', 'anva' );
	}

	printf(
		'<ul class="entry-meta clearfix">
			<li class="posted-on">%1$s</li>
			<li class="byline"><i class="icon-user"></i> %2$s</li>
			<li class="category"><i class="icon-folder-open"></i> %3$s</li>
			<li class="comments-link"><i class="icon-comments"></i> %4$s</li>
		</ul><!-- .entry-meta (end) -->',
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
		)
	);
}

/**
 * Display social media profiles
 * 
 * @since 1.0.0
 */
function anva_social_icons( $style = '', $shape = '', $border = '', $size = '', $icons = array() ) {

	$classes = array();

	// Set up buttons
	if ( ! $icons ) {
		$icons = anva_get_option( 'social_icons_profiles' );
	}

	// If buttons haven't been sanitized return nothing
	if ( is_array( $icons ) && isset( $icons['includes'] ) ) {
		return;
	}
	
	if ( ! $style ) {
		$style = anva_get_option( 'social_icons_style', 'default' );		
	}

	if ( ! $shape ) {
		$shape = anva_get_option( 'social_icons_shape', 'default' );
	}

	if ( ! $border ) {
		$border = anva_get_option( 'social_icons_border', 'default' );
	}

	if ( ! $size ) {
		$size = anva_get_option( 'social_icons_size', 'default' );
	}	

	// Set up style
	if ( 'default' != $style ) {
		$classes[] = 'si-' . $style;
	}

	// Set up shape
	if ( 'default' != $shape ) {
		$classes[] = 'si-' . $shape;
	}

	// Set up border
	if ( 'default' != $border ) {
		$classes[] = 'si-' . $border;
	}

	// Set up size
	if ( 'default' != $size ) {
		$classes[] = 'si-' . $size;
	}

	$classes = implode( ' ', $classes );

	// Social media sources
	$profiles = anva_get_social_icons_profiles();

	// Start output
	$output = '';
	if ( is_array( $icons ) && ! empty ( $icons ) ) {

		foreach ( $icons as $id => $url ) {

			// Link target
			$target = '_blank';
			
			// Link Title
			$title = '';
			if ( isset( $profiles[ $id ] ) ) {
				$title = $profiles[ $id ];
			}

			$output .= sprintf(
				'<a href="%1$s" class="social-icon si-%3$s %5$s" target="%4$s" title="%2$s"><i class="icon-%3$s"></i><i class="icon-%3$s"></i></a>',
				esc_url( $url ),
				esc_attr( $title ),
				esc_attr( $id ),
				esc_attr( $target ),
				esc_attr( $classes )
			);
		}
	}
	$output = apply_filters( 'anva_social_icons', $output );

	echo $output;
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
 * Post navigation.
 * 
 * @since 1.0.0
 */
function anva_post_nav() {
	
	$single_navigation = anva_get_option( 'single_navigation', 'show' );
	if ( 'show' != $single_navigation ) {
		return;
	}

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	
	if ( ! $next && ! $previous ) {
		return;
	}

	$class = '';

	// Align to right
	if ( ! $previous ) {
		$class = ' fright';
	}

	?>
	<div class="post-navigation clearfix">
		<?php
			if ( $previous ) {
				$previous_title = $previous->post_title;
				previous_post_link( '<div class="post-previous col_half nobottommargin">%link</div>', '&lArr; ' . $previous_title );
			}
			
			if ( $next ) {
				$next_title = $next->post_title;
				next_post_link( '<div class="post-next col_half col_last nobottommargin tright' . esc_attr( $class ) . '">%link</div>', $next_title . ' &rArr;' );
			}
		?>
	</div><!-- .post-navigation (end) -->
	<div class="line"></div>
	<?php
}

/**
 * Mini posts list
 * 
 * @since 1.0.0
 */
function anva_mini_posts_list( $number = 3, $orderby = 'date', $order = 'date', $thumbnail = true ) {
	
	global $post;

	$output = '';

	$args = array(
		'posts_per_page' => $number,
		'post_type' 	 => array( 'post' ),
		'orderby'		 => $orderby,
		'order'			 => $order
	);

	$query = anva_get_query_posts( $args );
	
	$output .= '<ul class="widget-posts-list">';

	while ( $query->have_posts() ) {
		$query->the_post();

		if ( $thumbnail ) {
			$output .= '<li class="sm-post small-post clearfix">';
			$output .= '<div class="entry-image">';
			$output .= '<a href="'. get_permalink() .'">' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</a>';
			$output .= '</div><!-- .entry-image (end) -->';
		} else {
			$output .= '<li class="sm-post small-post clearfix">';
		}

		$output .= '<div class="entry-c">';
		$output .= '<div class="entry-title">';
		$output .= '<h4><a href="'. get_permalink() .'">' . get_the_title() . '</a></h4>';
		$output .= '</div><!-- .entry-title (end) -->';
		$output .= '<div class="entry-meta">';
		$output .= '<span class="date">' . get_the_time( 'jS F Y' ) . '</span>';
		$output .= '</div><!-- .entry-meta (end) -->';
		$output .= '</div><!-- .entry-c (end) -->';
		$output .= '</li><!-- .mini-posts (end) -->';
	}

	wp_reset_postdata();

	$output .= '</ul>';

	echo $output;
	
}

/**
 * Blog post author
 * 
 * @since 1.0.0
 */
function anva_post_author() {
	
	$single_author = anva_get_option( 'single_author', 'hide' );
	
	if ( 'show' != $single_author ) {
		return;
	}

	global $post;
	$id 	= $post->post_author;
	$avatar = get_avatar( $id, '96' );
	$url 	= get_the_author_meta( 'user_url', $id );
	$name 	= get_the_author_meta( 'display_name', $id );
	$desc 	= get_the_author_meta( 'description', $id );
	?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php printf( '%1$s <span><a href="%2$s">%3$s</a></span>', __( 'Posted by', 'anva' ), esc_url( $url ), esc_html( $name ) ); ?>
			</h3>
		</div>
		<div class="panel-body">
			<div class="author-image">
				<?php echo $avatar ; ?>
			</div>
			<div class="author-description">
				<?php echo wpautop( esc_html( $desc ) ); ?>
			</div>
		</div>
	</div><!-- .panel (end) -->
	<div class="line"></div>
	<?php
}

function anva_post_tags() {
	$classes = 'tagcloud clearfix';
	if ( is_single() )
		$classes .= ' bottommargin';
	?>

	<div class="<?php echo esc_attr( $classes ); ?>">
		<?php the_tags( '', ' ' ); ?>
	</div><!-- .tagcloud (end) -->
	<?php
}

/**
 * Blog post share
 * 
 * @since 1.0.0
 */
function anva_post_share() {
	
	$single_share = anva_get_option( 'single_share', 'show' );
	if ( 'show' != $single_share ) {
		return;
	}

	$twitter = anva_get_option( 'social_media' );

	$url = get_permalink();
	$title = get_the_title();
	$thumbnail_url = anva_get_featured_image( get_the_ID(), 'medium' );

	if ( is_single() ) :
	?>
	<div class="clear"></div>
	<div class="si-share noborder clearfix">
		<span><?php _e( 'Share this Post:', 'anva' ); ?></span>
		<div>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( $url ); ?>&t=<?php echo esc_attr( $title ); ?>"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank" title="<?php _e( 'Share on Facebook', 'anva' ); ?>" class="social-icon si-borderless si-facebook">
				<i class="icon-facebook"></i>
				<i class="icon-facebook"></i>
			</a>
			<a href="https://twitter.com/share?url=<?php echo esc_url( $url ); ?>&via=TWITTER_HANDLE&text=<?php echo esc_attr( $title ); ?>"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
   target="_blank" title="<?php _e( 'Share on Twitter', 'anva' ); ?>" class="social-icon si-borderless si-twitter">
				<i class="icon-twitter"></i>
				<i class="icon-twitter"></i>
			</a>
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( $url ); ?>&media=<?php echo esc_url( $thumbnail_url ); ?>&description=<?php echo esc_attr( $title ); ?>" target="_blank" class="social-icon si-borderless si-pinterest">
				<i class="icon-pinterest"></i>
				<i class="icon-pinterest"></i>
			</a>
			<a href="https://plus.google.com/share?url=<?php echo esc_url( $url ); ?>"
   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480');return false;"
   target="_blank" title="<?php _e( 'Share on Google+', 'anva' ); ?>" class="social-icon si-borderless si-gplus">
				<i class="icon-gplus"></i>
				<i class="icon-gplus"></i>
			</a>
			<a href="<?php echo get_feed_link( 'rss2' ); ?>" class="social-icon si-borderless si-rss">
				<i class="icon-rss"></i>
				<i class="icon-rss"></i>
			</a>
			<a href="#" class="social-icon si-borderless si-email3">
				<i class="icon-email3"></i>
				<i class="icon-email3"></i>
			</a>
		</div>
	</div><!-- .si-share (end) -->
	<?php
	endif;
}

/**
 * Blog post related.
 *
 * @global $post
 * 
 * @since  1.0.0
 * @return Realated posts
 */
function anva_post_related() {
	
	$single_related = anva_get_option( 'single_related', 'hide' );
	if ( 'hide' == $single_related ) {
		return;
	}

	?>
	<h3><?php _e( 'Related Posts', 'anva' ); ?></h3>
	<div class="related-posts clearfix">
	<?php
		$limit         = 4;
		$count         = 1;
		$column        = 2;
		$open_row      = '<div class="col_half nobottommargin">';
		$open_row_last = '<div class="col_half nobottommargin col_last">';
		$close_row     = '</div><!-- .col_half (end) -->';

		// IDs
		$ids = array();
		
		// Query arguments
		$query_args = array(
			'post__not_in'        => array( get_queried_object_id() ),
			'posts_per_page'      => $limit,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'rand',
		);

		// Set by categories
		if ( 'cat' == $single_related ) {
			$categories = wp_get_post_terms( get_queried_object_id(), 'category', array( 'fields' => 'ids' ) );
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'terms'    => $categories
				)
			);
		}

		// Set by tag
		if ( 'tag' == $single_related ) {
			$tags = wp_get_post_terms( get_queried_object_id(), 'post_tag', array( 'fields' => 'ids') );
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'post_tag',
					'terms'    => $tags
				)
			);
		}
		
		$query = anva_get_query_posts( $query_args );
		
		if ( $query->have_posts() ) : ?>
			
			<?php while ( $query->have_posts() ) :
				$query->the_post(); ?>

				<?php if ( 1 == $count ) : echo $open_row; endif ?>
				
				<div class="mpost clearfix">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="entry-image">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'blog_md' ); ?>
							</a>
						</div>
					<?php endif; ?>
					<div class="entry-c">
						<div class="entry-title">
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> <?php the_time( 'jS F Y' ); ?></li>
							<li><a href="<?php the_permalink(); ?>/#comments"><i class="icon-comments"></i> <?php echo get_comments_number(); ?></a></li>
						</ul>
						<div class="entry-content">
							<?php anva_excerpt( 90 ); ?>
						</div>
					</div>
				</div><!-- .md-post (end) -->

				<?php if ( 0 == $count % $column ) : echo $close_row; endif ?>
				<?php if ( $count % $column == 0 && $limit != $count ) : echo $open_row_last; endif; ?>

				<?php $count++; ?>

			<?php endwhile; ?>
			
			<?php if ( ( $count - 1 ) != $limit ) : echo $close_row; endif; ?>

		<?php else :

			_e( 'Not Posts Found', 'anva' );
		
		endif;

		wp_reset_postdata();
	
	?>
	</div><!-- .related-posts (end) -->
	<?php
}

/**
 * Blog post pagination.
 * 
 * @since 1.0.0
 * @param string $query
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
 * Blog post number pagination.
 * 
 * @since 1.0.0
 * @param string  $pages
 * @param integer $range
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
 * Blog comment pagination.
 * 
 * @since 1.0.0
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
 * Contact form.
 *
 * @global $email_sended_message
 *
 * @since  1.0.0
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
		
		<?php wp_nonce_field( 'contact_form', 'contact_form_nonce' ); ?>
		
		<div id="contactmap"></div>
		
		<form id="contactform" class="contact-form"  role="form" method="post" action="<?php the_permalink(); ?>#contactform">
			
			<?php
				$contact_fields = anva_get_option( 'contact_fields', array( 'name', 'email', 'message' ) );
				$captcha = anva_get_option( 'contact_captcha' );
				if ( ! empty( $contact_fields ) ) :
					foreach ( $contact_fields as $field ) :
						switch ( $field ) :
							
							case 'name':
								?>
								<div class="form-name form-group">
									<label for="cname" class="control-label"><?php echo anva_get_local( 'name' ); ?>:</label>
									<input id="name" type="text" placeholder="<?php echo anva_get_local( 'name_place' ); ?>" name="cname" class="form-control requiredField" value="<?php if ( isset( $_POST['cname'] ) ) echo esc_attr( $_POST['cname'] ); ?>">
								</div>
								<?php
								break;

							case 'email':
								?>
								<div class="form-email form-group">
									<label for="cemail" class="control-label"><?php echo anva_get_local( 'email' ); ?>:</label>
									<input id="email" type="email" placeholder="<?php _e('Correo Electr&oacute;nico', 'anva'); ?>" name="cemail" class="form-control requiredField" value="<?php if ( isset( $_POST['cemail'] ) ) echo esc_attr( $_POST['cemail'] );?>">
								</div>
								<?php
								break;

							case 'subject':
								?>
								<div class="form-subject form-group">						
									<label for="csubject" class="control-label"><?php echo anva_get_local( 'subject' ); ?>:</label>
									<input id="subject" type="text" placeholder="<?php echo anva_get_local( 'subject' ); ?>" name="csubject" class="form-control requiredField" value="<?php if ( isset( $_POST['csubject'] ) ) echo esc_attr( $_POST['csubject'] ); ?>">
								</div>
								<?php
								break;

							case 'message':
								?>
								<div class="form-message form-group">
									<label for="cmessage" class="control-label"><?php echo anva_get_local( 'message' ); ?>:</label>
									<textarea id="message" name="cmessage" class="form-control" placeholder="<?php echo anva_get_local( 'message_place' ); ?>"><?php if ( isset( $_POST['cmessage'] ) ) echo esc_textarea( $_POST['cmessage'] ); ?></textarea>
								</div>
								<?php
								break;

							case 'phone':
								?>
								<div class="form-phone form-group">
									<label for="cphone" class="control-label"><?php echo anva_get_local( 'phone' ); ?>:</label>
									<input id="phone" type="tel" placeholder="<?php echo anva_get_local( 'phone' ); ?>" name="cphone" class="form-control requiredField" value="<?php echo anva_get_local( 'phone_place' ); ?>"><?php if ( isset( $_POST['cphone'] ) ) echo esc_html( $_POST['cphone'] ); ?>">
								</div>
								<?php
								break;

								case 'mobile':
								?>
								<div class="form-mobile form-group">
									<label for="cmobile" class="control-label"><?php echo anva_get_local( 'mobile' ); ?>:</label>
									<input id="mobile" type="tel" placeholder="<?php echo anva_get_local( 'mobile_place' ); ?>" name="cmobile" class="form-control requiredField" value="<?php if ( isset( $_POST['cmobile'] ) ) echo esc_html( $_POST['cmobile'] ); ?>">
								</div>
								<?php
								break;

								case 'company_name':
								?>
								<div class="form-company_name form-group">
									<label for="ccompany_name" class="control-label"><?php echo anva_get_local( 'company_name'  ); ?>:</label>
									<input id="company_name" type="text" placeholder="<?php echo anva_get_local( 'company_name_place' ); ?>" name="ccompany_name" class="form-control requiredField" value="<?php if ( isset( $_POST['ccompany_name'] ) ) echo esc_html( $_POST['ccompany_name'] ); ?>">
								</div>
								<?php
								break;

								case 'country':
								?>
								<div class="form-country form-group">
									<label for="ccountry" class="control-label"><?php echo anva_get_local( 'country'  ); ?>:</label>
									<input id="ccountry" type="text" placeholder="<?php echo anva_get_local( 'country'  ); ?>" name="ccountry" class="form-control requiredField" value="<?php echo anva_get_local( 'country_place' ); ?>"><?php if ( isset( $_POST['ccountry'] ) ) echo esc_html( $_POST['ccountry'] ); ?>">
								</div>
								<?php
								break;

						endswitch;
					endforeach;
				else :
					$name = anva_get_option_name();
					printf( '<div class="alert alert-info">' . __( 'The contact fields are not defined, verified on the %s.', 'anva' ) . '</div>', sprintf( '<a href="' . esc_url( admin_url('/themes.php?page=' . $name ) ) . '">%s</>', __( 'theme options', 'anva' ) ) );
				endif;
			?>
			
			<?php if ( 'yes' == $captcha ) : ?>
				<div class="form-captcha form-group">
					<label for="captcha" class="control-label"><?php echo $a . ' + '. $b . ' = ?'; ?>:</label>
					<input type="text" name="ccaptcha" placeholder="<?php echo anva_get_local( 'captcha_place' ); ?>" class="form-control requiredField" value="<?php if ( isset( $_POST['ccaptcha'] ) ) echo $_POST['ccaptcha'];?>">
					<input type="hidden" id="answer" name="canswer" value="<?php echo esc_attr( $answer ); ?>">
				</div>
			<?php endif; ?>
			
			<div class="form-submit form-group">
				<input type="hidden" id="submitted" name="contact-submission" value="1">
				<input id="submit-contact-form" type="submit" class="button button-3d" value="<?php echo anva_get_local( 'submit' ); ?>">
			</div>
		</form>
	</div><!-- .contact-form-wrapper -->
	
	<?php
		$latitude = 0;
		$longitude = 0;
		$zoom = anva_get_option( 'contact_map_zoom', 10 );
		$html = anva_get_option( 'contact_map_html' );
		$contact_map_type = anva_get_option( 'contact_map_type', 'ROADMAP' );
		$contact_map_address = anva_get_option( 'contact_map_address' );

		if ( isset( $contact_map_address[0] ) && ! empty( $contact_map_address[0] )  ) {
			$latitude = $contact_map_address[0];
		}
		
		if ( isset( $contact_map_address[1] ) && ! empty( $contact_map_address[1] )  ) {
			$longitude = $contact_map_address[1];
		}
	?>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			var options = {
				controls: {
					panControl: true,
			zoomControl: false,
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: true
				},
				scrollwheel: false,
				maptype: '<?php echo esc_js( $contact_map_type ); ?>',
				markers: [{
					latitude: <?php echo esc_js( $latitude ); ?>,
					longitude: <?php echo esc_js( $longitude ); ?>,
					html: "<?php echo esc_js( $html ); ?>",
					popup: true
				}],
				zoom: <?php echo esc_js( $zoom ); ?>
			}
			if ( $('#contactmap').length > 0 ) {
				$('#contactmap').gMap( options );
			}
		});
	</script>
	<script type="text/javascript">
	jQuery(document).ready( function($) { 
		setTimeout( function() {
			$("#email_message").fadeOut("slow");
		}, 3000);
		$('#contactform input[type="text"]').attr('autocomplete', 'off');
		$('#contactform').validate({
			rules: {
				cname: "required",
				cmobile: "required",
				cphone: "required",
				ccompany_name: "required",
				ccountry: "required",
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
 * Password form.
 *
 * @global $post
 * 
 * @since  1.0.0
 * @return string|html $o
 */
function anva_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$o  = '<form class="form-inline password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
	$o .= '<span class="glyphicon glyphicon-lock"></span>';
	$o .= '<p class="lead">' . __( "To view this protected post, enter the password below:", 'anva' ) . '</p>';
	$o .= '<div class="form-group">';
	$o .= '<label for="' . $label . '">' . __( "Password", 'anva' ) . ' </label>';
	$o .= '<input class="form-control" name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" />';
	$o .= '</div>';
	$o .= '<input class="btn btn-default" type="submit" name="Submit" value="' . esc_attr__( "Submit", 'anva' ) . '" />';
	$o .= '</form>';
	return $o;
}

/**
 * Search form.
 *
 * @since 1.0.0
 */
function anva_get_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<div class="input-group">
			<input type="search" id="s" class="search-field form-control" placeholder="<?php echo anva_get_local( 'search' ); ?>" value="" name="s" title="<?php echo anva_get_local( 'search_for' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo anva_get_local( 'search_for' ); ?></span>
					<i class="icon-search"></i>
				</button>
			</span>
		</div>
	</form>
	<?php
}

/**
 * Woocommerce search product form.
 *
 * @since 1.0.0
 */
function anva_get_product_search_form() {
	?>
	<form role="search" method="get" id="searchform" class="form-inline search-form" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
		<div class="input-group">
		<input type="text" id="s" name="s" class="search-field form-control" value="<?php echo get_search_query(); ?>"  placeholder="<?php _e( 'Search for products', 'anva' ); ?>" />
			<span class="input-group-btn">
				<button type="submit" id="searchsubmit" class="btn btn-default search-submit">
					<span class="sr-only"><?php echo esc_attr__( 'Search', 'anva' ); ?></span>
					<i class="icon-search"></i>
				</button>
				<input type="hidden" name="post_type" value="product" />
			</span>
		</div>
	</form>
	<?php
}

/**
 * Get comment list.
 *
 * @global $comment
 * 
 * @since  1.0.0
 * @param  $comment
 * @param  $args
 * @param  $depth
 */
function anva_comment_list( $comment, $args, $depth ) {
	
	$GLOBALS['comment'] = $comment;
	
	extract( $args, EXTR_SKIP );

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
	<div id="comment-<?php comment_ID() ?>" class="comment-wrap clearfix">
	<?php endif; ?>
	
	<div class="comment-meta">
		<div class="comment-author vcard">
			<div class="comment-avatar clearfix">
				<a href="<?php echo comment_author_url( $comment->comment_ID ); ?>">
					<?php
						if ( $args['avatar_size'] != 0 ) {
							echo get_avatar( $comment, 64 );
						}
					?>
				</a>
			</div>
		</div>
	</div>

	<div class="comment-content clearfix">
		<div class="comment-author">
			<?php echo get_comment_author_link(); ?>

			<?php
				if ( $comment->user_id === $GLOBALS['post']->post_author ) {
					printf( '<cite>%s</cite>', __( 'Post Author', 'anva' ) );
				}
			?>

			<span>
				<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php printf( '%1$s %2$s %3$s', get_comment_date(), __( 'at', 'anva' ),  get_comment_time() ); ?>
					<?php edit_comment_link( __( 'Edit', 'anva' ), ' - ', '' ); ?>
				</a>
			</span>
		</div>

		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation well well-sm"><?php _e( 'Your comment is awaiting moderation.', 'anva' ); ?></em>
		<?php endif; ?>
		
		<?php comment_text(); ?>

		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="icon-reply"></i>' ) ) ); ?>
	
	</div>

	<?php if ( 'div' != $args['style'] ) : ?>
	</div><!-- .comment-wrap (end) -->
	<?php endif; ?>

<?php
}

/**
 * Display breadcrumbs.
 *
 * @global $post
 * 
 * @since  1.0.0.
 * @param  array  $args
 * @return string $html
 */
function anva_breadcrumbs( $args = array() ) {

	if ( is_front_page() ) {
		return;
	}

	global $post;

	$defaults = array(
		'separator_icon'      => '/',
		'breadcrumbs_id'      => 'breadcrumb',
		'breadcrumbs_classes' => 'breadcrumb',
		'home_title'          => __( 'Home', 'anva' )
	);

	$args      = apply_filters( 'anva_get_breadcrumbs_args', wp_parse_args( $args, $defaults ) );
	$separator = '<li class="separator hidden"> ' . esc_attr( $args['separator_icon'] ) . ' </li>';
	

	// Open the breadcrumbs
	$html = '<ol id="' . esc_attr( $args['breadcrumbs_id'] ) . '" class="' . esc_attr( $args['breadcrumbs_classes'] ) . '">';
	
	// Add Homepage link & separator (always present)
	$html .= '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . esc_attr( $args['home_title'] ) . '">' . esc_attr( $args['home_title'] ) . '</a></li>';
	$html .= $separator;
	
	// Post
	if ( is_singular( 'post' ) ) {
		
		$category = get_the_category();
		$category_values = array_values( $category );
		$last_category = end( $category_values );
		$cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',' );
		$cat_parents = explode( ',', $cat_parents );

		foreach ( $cat_parents as $parent ) {
			$html .= '<li class="item-cat">' . wp_kses( $parent, wp_kses_allowed_html( 'a' ) ) . '</li>';
			$html .= $separator;
		}

		$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';
	
	} elseif ( is_singular( 'page' ) ) {

		if ( $post->post_parent ) {

			$parents = get_post_ancestors( $post->ID );
			$parents = array_reverse( $parents );

			foreach ( $parents as $parent ) {
				$html .= '<li class="item-parent item-parent-' . esc_attr( $parent ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent ) . '" href="' . esc_url( get_permalink( $parent ) ) . '" title="' . get_the_title( $parent ) . '">' . get_the_title( $parent ) . '</a></li>';
				$html .= $separator;
			}

		}

		$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';

	} elseif ( is_singular( 'attachment' ) ) {

		$parent_id        = $post->post_parent;
		$parent_title     = get_the_title( $parent_id );
		$parent_permalink = esc_url( get_permalink( $parent_id ) );
		
		$html .= '<li class="item-parent"><a class="bread-parent" href="' . esc_url( $parent_permalink ) . '" title="' . esc_attr( $parent_title ) . '">' . esc_attr( $parent_title ) . '</a></li>';
		$html .= $separator;
		$html .= '<li class="active item-' . $post->ID . '">' . get_the_title() . '</li>';

	} elseif ( is_singular() ) {

		$post_type         = get_post_type();
		$post_type_object  = get_post_type_object( $post_type );
		$post_type_archive = get_post_type_archive_link( $post_type );

		$html .= '<li class="item-cat item-custom-post-type-' . esc_attr( $post_type ) . '"><a class="bread-cat bread-custom-post-type-' . esc_attr( $post_type ) . '" href="' . esc_url( $post_type_archive ) . '" title="' . esc_attr( $post_type_object->labels->name ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></li>';

		$html .= $separator;

		$html .= '<li class="active item-' . $post->ID . '">' . $post->post_title . '</li>';

	} elseif ( is_category() ) {

		$parent = get_queried_object()->category_parent;

		if ( $parent !== 0 ) {

			$parent_category = get_category( $parent );
			$category_link   = get_category_link( $parent );

			$html .= '<li class="item-parent item-parent-' . esc_attr( $parent_category->slug ) . '"><a class="bread-parent bread-parent-' . esc_attr( $parent_category->slug ) . '" href="' . esc_url( $category_link ) . '" title="' . esc_attr( $parent_category->name ) . '">' . esc_attr( $parent_category->name ) . '</a></li>';
			$html .= $separator;

		}
		
		$html .= '<li class="active item-cat">' . single_cat_title( '', false ) . '</li>';

	} elseif ( is_tag() ) {
		$html .= '<li class="active item-tag">' . single_tag_title( '', false ) . '</li>';

	} elseif ( is_author() ) {
		$html .= '<li class="active item-author">' . get_queried_object()->display_name . '</li>';

	} elseif ( is_day() ) {
		$html .= '<li class="active item-day">' . get_the_date() . '</li>';

	} elseif ( is_month() ) {
		$html .= '<li class="active item-month">' . get_the_date( 'F Y' ) . '</li>';

	} elseif ( is_year() ) {
		$html .= '<li class="active item-year">' . get_the_date( 'Y' ) . '</li>';

	} elseif ( is_archive() ) {
		$custom_tax_name = get_queried_object()->name;
		$html .= '<li class="active item-archive">' . esc_attr( $custom_tax_name ) . '</li>';

	} elseif ( is_search() ) {
		$html .= '<li class="active item-search">' . __( 'Search results for', 'anva' ) . ': ' . get_search_query() . '</li>';

	} elseif ( is_404() ) {
		$html .= '<li class="item-404">' . __( 'Error 404', 'anva' ) . '</li>';

	} elseif ( is_home() ) {
		$html .= '<li class="item-home">' . get_the_title( get_option( 'page_for_posts' ) ) . '</li>';
	}

	$html .= '</ol>';
	
	$html = apply_filters( 'anva_breadcrumbs_html', $html );
	
	echo wp_kses_post( $html );
}


/**
 * Display gallery grid.
 * 
 * @since 1.0.0
 */
function anva_get_gallery_grid( $post_id, $columns, $thumbnail ) {
	
	$classes 	 	= array();
	$gallery 	 	= anva_get_gallery_field();
	$gallery 	 	= anva_sort_gallery( $gallery );
	$animate 	 	= anva_get_option( 'gallery_animate' );
	$delay 	 		= anva_get_option( 'gallery_delay' );
	$highlight 		= anva_get_post_meta( '_anva_gallery_highlight' );
	$html 			= '';

	$classes[] = $columns;
	$classes = implode( ' ', $classes );
	
	$query_args = array(
		'post_type'   	 => 'attachment',
		'post_status' 	 => 'inherit',
		'post_mime_type' => 'image/jpeg',
		'posts_per_page' => -1,
		'post__in'		 => $gallery,
		'orderby'		 => 'post__in',
	);

	$query = anva_get_query_posts( $query_args );

	if ( $query->have_posts() ) {

		$html .= '<div class="gallery-container">';
		$html .= '<div class="masonry-thumbs ' . esc_attr( $classes ) . '" data-lightbox="gallery" data-big="' . esc_attr( $highlight ) . '">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$title 		= get_the_title();
			$thumb_full = anva_get_attachment_image_src( get_the_ID(), 'full' );
			$thumb_size = anva_get_attachment_image_src( get_the_ID(), $thumbnail );
		
			$html .= '<a href="' . esc_url( $thumb_full ) . '" title="' . esc_attr( $title ) . '" data-animate="' . esc_attr( $animate ) . '" data-delay="' . esc_attr( $delay ) . '" data-lightbox="gallery-item">';
			$html .= '<img class="gallery-image" src="' . esc_attr( $thumb_size ) . '" alt="' . esc_attr( $title ) . '" />';
			$html .= '</a>';

		}

		wp_reset_postdata();

		$html .= '</div><!-- .masonry-thumbs (end) -->';
		$html .= '</div><!-- .gallery-container (end) -->';

	}

	return $html;
	
}

/**
 * Display slider
 *
 * @since 1.0.0
 */
function anva_sliders( $slider ) {

	// Kill it if there's no slider
	if ( ! $slider ) {
		printf( '<div class="alert alert-warning"><p>%s</p></div>', __( 'No slider selected.', 'anva' ) );
		return;
	}

	if ( anva_slider_exists( $slider ) ) {

		// Get sliders data
		$sliders = anva_get_sliders();

		// Get Slider ID
		$slider_id = $slider;

		// Gather settings
		$settings = $sliders[ $slider_id ]['options'];

		// Display slider based on its slider type
		do_action( 'anva_slider_' . $slider_id, $slider, $settings );

	} elseif ( 'revslider' == $slider ) {
		anva_revolution_slider_default();
	
	} elseif ( 'layerslider' == $slider ) {
		/**
		 * anva_layer_slider_default()
		 * @todo create function to support Layer Slider.
		 */
	} else {
		printf( '<div class="alert alert-warning">%s</div>', __( 'No slider found.', 'anva' ) );
		return;
	}

}

/**
 * Get Revolution Slider ID.
 *
 * @since  1.0.0
 * @return void
 */
function anva_revolution_slider_default() {
	
	if ( ! class_exists( 'RevSliderFront' ) ) {
		printf( '<div class="alert alert-warning">%s.</div>', __( 'Revolution Slider not found, make sure the plugin is installed and activated', 'anva' ) );
		return;
	}

	$revslider_id = anva_get_option( 'revslider_id' );

	if ( ! empty( $revslider_id ) ) {
		putRevSlider( $revslider_id );
	}
}

/**
 * Standard slider type.
 *
 * @since  1.0.0
 * @param  string $slider
 * @param  array  $settings
 * @return string $html
 */
function anva_slider_standard_default( $slider, $settings ) {

	// Global Options
	$pause 		= anva_get_option( 'standard_pause' );
	$arrows 	= anva_get_option( 'standard_arrows' );
	$animation 	= anva_get_option( 'standard_fx' );
	$speed 		= anva_get_option( 'standard_speed' );
	$thumbs 	= anva_get_option( 'standard_thumbs' );
	$grid 		= anva_get_option( 'standard_grid' );
	$thumbnail 	= 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 		=> array( 'slideshows' ),
		'order' 			=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html  = '';
	$data  = '';
	$data .= 'data-animation="' . esc_attr( $animation ) . '"';
	$data .= 'data-thumbs="' . esc_attr( $thumbs ) . '"';
	$data .= 'data-arrows="' . esc_attr( $arrows ) . '"';
	$data .= 'data-speed="' . esc_attr( $speed ) . '"';
	$data .= 'data-pause="' . esc_attr( $pause ) . '"';
	
	$classes[] = 'fslider';

	if ( 'true' == $thumbs ) {
		$classes[] = 'flex-thumb-grid';
		$classes[] = $grid;
	}

	$classes = implode( ' ', $classes );
	
	if ( $query->have_posts() ) {
		
		$html .= '<div class="' . esc_attr( $classes ) . '" ' . $data . '>';
		$html .= '<div class="flexslider">';
		$html .= '<div class="slider-wrap">';
		
		while ( $query->have_posts() ) {

			$query->the_post();
			
			$id 	 = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_post_meta( '_anva_description' );
			$url 	 = anva_get_post_meta( '_anva_url' );
			$content = anva_get_post_meta( '_anva_content' );
			$image   = anva_get_featured_image( $id, 'anva_sm' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';
			
			$html .= '<div class="slide slide-'. esc_attr( $id ) . '" data-thumb="'. esc_attr( $image ) .'">';
			
			if ( has_post_thumbnail() ) {
				
				// Open anchor
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array( 'class' => 'slide-image' ) );

				// Close anchor
				if ( $url ) {
					$html .= '</a>';
				}

			}
			
			switch ( $content ) {
				case 'title':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '</div>';
					break;

				case 'desc':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $desc );
					$html .= '</div>';
					break;

				case 'both':
					$html .= '<div class="flex-caption slider-caption-bg slider-caption-top-left">';
					$html .= esc_html( $title );
					$html .= '<span>' . esc_html( $desc ) . '</span>';
					$html .= '</div>';
					break;
			}
			
			$html .= '</div>';
		}

		wp_reset_postdata();

		$html .= '</div><!-- .slider-wrap (end) -->';
		$html .= '</div><!-- .flexslider (end) -->';
		$html .= '</div><!-- .fslider (end) -->';
	}

	echo $html;
}

/**
 * OWL slider type
 *
 * @since 1.0.0
 */
function anva_slider_owl_default( $slider, $settings ) {

	$margin 		= anva_get_option( 'owl_margin', 0 );
	$items 			= anva_get_option( 'owl_items', 1 );
	$pagi 			= anva_get_option( 'owl_pagi', 'false' );
	$loop 			= anva_get_option( 'owl_loop', 'true' );
	$animate_in 	= anva_get_option( 'owl_animate_in' );
	$animate_out 	= anva_get_option( 'owl_animate_out' );
	$speed 			= anva_get_option( 'owl_speed', 450 );
	$autoplay 		= anva_get_option( 'owl_autoplay', 5000 );
	$thumbnail 		= 'anva_lg';

	$data = '';

	// Query arguments
	$query_args = array(
		'post_type' 		=> array( 'slideshows' ),
		'order' 			=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html  = '';
	$data  = '';
	$data .= 'data-margin="' . esc_attr( $margin ) . '"';
	$data .= 'data-items="' . esc_attr( $items ) . '"';
	$data .= 'data-pagi="' . esc_attr( $pagi ) . '"';
	$data .= 'data-loop="' . esc_attr( $loop ) . '"';
	$data .= 'data-animate-in="' . esc_attr( $animate_in ) . '"';
	$data .= 'data-animate-out="' . esc_attr( $animate_out ) . '"';
	$data .= 'data-speed="' . esc_attr( $speed ) . '"';
	$data .= 'data-autoplay="' . esc_attr( $autoplay ) . '"';

	$classes[] = 'owl-carousel';
	$classes[] = 'carousel-widget';

	$classes = implode( ' ', $classes );
	
	if ( $query->have_posts() ) {
		
		$html .= '<div id="oc-slider" class="' . esc_attr( $classes ) . '" ' . $data . '>';

		while ( $query->have_posts() ) {

			$query->the_post();

			$id 	 = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_post_meta( '_anva_description' );
			$url 	 = anva_get_post_meta( '_anva_url' );
			$a_tag   = '<a href="' . esc_url( $url ) . '">';

			if ( has_post_thumbnail() ) {
				
				if ( $url ) {
					$html .= $a_tag;
				}

				$html .= get_the_post_thumbnail( $id, $thumbnail , array( 'class' => 'slide-image' ) );

				if ( $url ) {
					$html .= '</a>';
				}
			}
		
		}

		wp_reset_postdata();

		$html .= '</div><!-- #oc-slider (end) -->';
		
	}
	
	echo $html;

}

/**
 * Nivo slider type
 *
 * @since 1.0.0
 */
function anva_slider_nivo_default( $slider, $settings ) {
	
	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	$caption = '';
	
	if ( $query->have_posts() ) {

		$count = 0;
		$html .= '<div class="nivoSlider">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title 	 = get_the_title();
			
			$count++;

			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail , array( 'class' => 'slide-image', 'title' => '#nivocaption' . $count ) );
			}

			$caption .= '<div id="nivocaption' . $count . '" class="nivo-html-caption">' . $title .' </div>';
			
		}

		wp_reset_postdata();
	
		$html .= '</div><!-- .nivoSlider (end) -->';
		$html .= $caption;

	}

	echo $html;
}

/**
 * Boostrap carousel slider type
 *
 * @since 1.0.0
 */
function anva_slider_bootstrap_default( $slider, $settings ) {

	$thumbnail = 'anva_lg';

	// Query arguments
	$query_args = array(
		'post_type' 			=> array( 'slideshows' ),
		'order' 					=> 'ASC',
		'posts_per_page' 	=> -1,
	);

	$query_args = apply_filters( 'anva_slideshows_query_args', $query_args );
	
	$query = anva_get_query_posts( $query_args );

	// Output
	$html = '';
	$count = 0;
	$li = '';
	$class = '';

	$post_count = count( $query->posts );
	for ( $i = 0; $i < $post_count; $i++ ) {
		if ( 0 == $i ) {
			$class = 'class="' . esc_attr( $class ) . '"';
		}
		$li .= '<li data-target="#bootstrap-carousel" data-slide-to="' . esc_attr( $i ) . '" ' . $class . '></li>';
	}

	// Reset class
	$class = '';
	
	if ( $query->have_posts() ) {

		$html .= '<div id="bootstrap-carousel" class="boostrap-carousel carousel slide" data-ride="carousel">';
		
		$html .= '<ol class="carousel-indicators">';
		$html .= $li;
		$html .= '</ol><!-- .carousel-indicators (end) -->';

		$html .= '<div class="carousel-inner" role="listbox">';

		while ( $query->have_posts() ) {

			$query->the_post();

			$post_id = get_the_ID();
			$title 	 = get_the_title();
			$desc 	 = anva_get_post_meta( '_anva_description' );

			if ( 0 == $count ) {
				$class = 'active';
			}

			$html .= '<div class="item ' . esc_attr( $class ) . '">';
			
			if ( has_post_thumbnail() ) {
				$html .= get_the_post_thumbnail( $post_id, $thumbnail );
			}

			// $html .= '<div class="carousel-caption">';
			// $html .= '<h3>' . $title . '</h3>';
			
			// if ( ! empty( $desc ) ) {
			// 	$html .= '<p>' . $desc . '</p>';
			// }

			// $html .= '</div>';
			$html .= '</div>';

			// Reset class
			$class = '';
			
			$count++;

		}

		wp_reset_postdata();

		$html .= '</div><!-- .carousel-inner (end) -->';

		$html .= '<a class="left carousel-control" href="#bootstrap-carousel" role="button" data-slide="prev">';
		$html .= '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Previous</span>';
		$html .= '</a>';
		$html .= '<a class="right carousel-control" href="#bootstrap-carousel" role="button" data-slide="next">';
		$html .= '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
		$html .= '<span class="sr-only">Next</span>';
		$html .= '</a>';
		
		$html .= '</div><!-- .boostrap-carousel (end) -->';

	}

	echo $html;

}

function anva_slider_swiper_default() {
	?>
	
	<div class="swiper-container swiper-parent">
		<!-- Additional required wrapper -->
		<div class="swiper-wrapper">
			<!-- Slides -->
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')"></div>
			<div class="swiper-slide" style="background-image: url('/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg')">
				<div class="slide-container clearfix">
					<div class="slider-caption slider-caption-center">
						<h2 data-caption-animate="fadeInUp">Welcome to Canvas</h2>
						<p data-caption-animate="fadeInUp" data-caption-delay="200">Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on our Canvas.</p>
					</div>
				</div>
			</div>
		</div>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
		
		<!-- If we need navigation buttons -->
		<div id="slider-arrow-left"><i class="icon-angle-left"></i></div>
		<div id="slider-arrow-right"><i class="icon-angle-right"></i></div>
		
	</div>
	<?php
}

function anva_slider_camera_default() {
	?>
	 <div class="camera_wrap" id="camera_wrap_1">
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Powerful Layout with Responsive functionality that can be adapted to any screen size.</div>
					</div>
			</div>
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Looks beautiful &amp; ultra-sharp on Retina Screen Displays.</div>
					</div>
			</div>
			<div data-thumb="/wp-content/uploads/2015/08/photographer_girl_2-wallpaper-1600x900.jpg">
					<div class="camera_caption fadeFromBottom flex-caption slider-caption-bg" style="left: 0; border-radius: 0; max-width: none;">
							<div class="container">Included 20+ custom designed Slider Pages with Premium Sliders like Layer, Revolution, Swiper &amp; others.</div>
					</div>
			</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#camera_wrap_1').camera();
	});
	</script>
	<?php
}

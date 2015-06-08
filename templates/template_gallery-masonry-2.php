<?php
	// Get gallery images
	$gallery_arr = anva_get_post_meta( 'anva_gallery_gallery' );

	// Sort gallery images
	$gallery_arr = anva_sort_gallery( $gallery_arr );
?>

<div id="gallery-container" class="gallery-container gallery-masonry gallery-masonry-2-col">
	<div class="gallery-inner">
		<div class="gallery-content clearfix" data-lightbox="gallery">
			<?php
			foreach( $gallery_arr as $id ) :
				$gallery_image_url 				= '';
				$gallery_image_desc 			= '';
				$gallery_image_title 			= get_the_title( $id );
				$gallery_image_desc 			= get_post_field( 'post_content', $id );
				
				if ( ! empty( $id ) ) :
					$gallery_image_ori = wp_get_attachment_image_src( $id, 'original', true );
					$gallery_image_url = wp_get_attachment_image_src( $id, 'gallery_masonry', true );
				endif;
			?>
				
				<div class="gallery-item">
					<div class="gallery-image">
						<a href="<?php echo $gallery_image_ori[0]; ?>" title="<?php echo $gallery_image_title; ?>" data-lightbox="gallery-item" data-desc="<?php echo $gallery_image_desc; ?>">
							<img src="<?php echo $gallery_image_url[0]; ?>" alt="<?php echo $gallery_image_title; ?>" />
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
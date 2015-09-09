jQuery(document).ready(function($) {

	// WP Media Frame
	var file_frame;
	var anvaGallery = {
		
		thumb_ul: '',
		thumb_ul_li: '',

		init: function() {

			this.thumb_ul = $('#anva_gallery_thumbs');
			this.thumb_ul_li = $('#anva_gallery_thumbs li');
			
			if ( this.thumb_ul.length > 0 ) {
				this.thumb_ul.sortable({
					placeholder: 'anva_gallery_placeholder'
				});
			}
			
			// Remove thumb
			this.thumb_ul.on( 'click', '.anva_gallery_remove', function() {

				$(this).parent().fadeOut( 100, function() {
					$(this).remove();
				});

				setTimeout(function() {
					anvaGallery.emptyGallery();
				}, 500);

				return false;
			});
			
			// Open WP Media		
			$('#anva_gallery_upload_button').on( 'click', function(e) {
				e.preventDefault();
				
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				file_frame = wp.media.frames.file_frame = wp.media({
					title: $(this).data('uploader_title'),
					button: {
						text: $(this).data('uploader_button_text'),
					},
					multiple: true
				});

				file_frame.on( 'select', function() {
					var images = file_frame.state().get('selection').toJSON();
					var length = images.length;	
					for ( var i = 0; i < length; i++ ) {
						anvaGallery.getThumbnail( images[i]['id'] );
					}
				});

				file_frame.open();
			});

			// Delete all images
			$('#anva_gallery_remove_all_buttons').on( 'click', function() {

				if ( $('#anva_gallery_thumbs li').length == 0 ) {
					alert( ANVA.gallery_empty );
					return;
				}

				if ( confirm( ANVA.gallery_confirm ) ) {
					anvaGallery.thumb_ul.empty();
				}

				anvaGallery.emptyGallery();
				
				return false;
			});

			anvaGallery.emptyGallery();
			
		},

		getThumbnail: function(id, cb) {
			cb = cb || function() {};
			
			var data = {
				action: 'anva_gallery_get_thumbnail',
				imageid: id
			};

			$('#anva_gallery_spinner').css('display', 'block');
			
			$.post(ajaxurl, data, function( response ) {
				anvaGallery.thumb_ul.append( response );
				cb();
			}).done( function() {
				$('#anva_gallery_spinner').hide();
			});
		},

		emptyGallery: function() {
			this.thumb_ul = $('#anva_gallery_thumbs');
			this.thumb_ul_li = $('#anva_gallery_thumbs li');
			if ( this.thumb_ul_li.length == 0 ) {
				this.thumb_ul.find('span').remove();
				this.thumb_ul.append('<span>' + ANVA.gallery_selected + '<span>');
			} else {
				this.thumb_ul.find('span').remove();
			}
		}

	};
	
	anvaGallery.init();

});
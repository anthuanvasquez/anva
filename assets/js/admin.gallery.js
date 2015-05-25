jQuery(function($) {
	if ( typeof plupload !== 'undefined' && typeof WPSGwpUploaderInit !== 'undefined' ) {
		
		var uploader = new plupload.Uploader(WPSGwpUploaderInit);
		
		uploader.init();
		uploader.bind('FilesAdded', function(up) {
			up.start();
			jQuery('#anva_gallery_spinner').show();
		});
		
		uploader.bind('FileUploaded', function(up, file, res) {
			var hidespinner = (uploader.total.queued < 1) ? function() {
				jQuery('#anva_gallery_spinner').hide();
			} : function() {};

			if ( typeof res.response !== 'undefined' ) {
				anva_gallery.get_thumbnail(res.response, hidespinner);
			}
		});
	
	} else {
		jQuery('#wpsg-plupload-browse-button').hide();
	}

	var file_frame;
	var anva_gallery = {
		admin_thumb_ul: '',
		admin_thumb_ul_li: '',

		init: function() {
			this.admin_thumb_ul = jQuery('#anva_gallery_thumbs');
			this.admin_thumb_ul.sortable({
				placeholder: 'anva_gallery_placeholder'
			});
			
			// Remove thumb
			this.admin_thumb_ul.on('click', '.anva_gallery_remove', function() {
				jQuery(this).parent().fadeOut(100, function() {
					jQuery(this).remove();
				});

				setTimeout(function(){
					alert("Boom!");
				}, 2000);

				anva_gallery.empty_gallery();

				return false;
			});
						
			jQuery('#anva_gallery_upload_button').on('click', function(e) {
				e.preventDefault();
				
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery(this).data('uploader_title'),
					button: {
						text: jQuery(this).data('uploader_button_text'),
					},
					multiple: true
				});

				file_frame.on('select', function() {
					var images = file_frame.state().get('selection').toJSON();
					var length = images.length;
					
					for ( var i = 0; i < length; i++ ) {
						anva_gallery.get_thumbnail( images[i]['id'] );
					}
				});

				file_frame.open();
			});

			jQuery('#anva_gallery_add_attachments_button').on('click', function() {
				var included = [];
				jQuery('#anva_gallery_thumbs input[type=hidden]').each(function(i, e) {
					included.push($(this).val());
				});
				anva_gallery.get_all_thumbnails( POST_ID, included );
			});

			jQuery('#anva_gallery_delete_all_button').on('click', function() {
				if ( confirm( 'Are you sure you want to delete all the images in the gallery?' ) ) {
					anva_gallery.admin_thumb_ul.empty();
				}
				anva_gallery.empty_gallery();
				return false;
			});

			anva_gallery.empty_gallery();

		},

		get_thumbnail: function(id, cb) {
			cb = cb || function() {};
			var data = {
				action: 'anva_gallery_get_thumbnail',
				imageid: id
			};
			jQuery.post(ajaxurl, data, function( response ) {
				anva_gallery.admin_thumb_ul.append( response );
				cb();
				anva_gallery.empty_gallery();
			});
		},

		get_all_thumbnails: function( post_id, included ) {
			var data = {
				action: 'anva_gallery_get_all_thumbnail',
				post_id: post_id,
				included: included
			};

			jQuery('#anva_gallery_spinner').show();
			jQuery.post( ajaxurl, data, function( response ) {
				anva_gallery.admin_thumb_ul.append(response);
				jQuery('#anva_gallery_spinner').hide();
				anva_gallery.empty_gallery();
			});
		},

		empty_gallery: function() {
			this.admin_thumb_ul = jQuery('#anva_gallery_thumbs');
			this.admin_thumb_ul_li = jQuery('#anva_gallery_thumbs li');
			if ( this.admin_thumb_ul_li.length == 0 ) {
				this.admin_thumb_ul.find('span').remove();
				this.admin_thumb_ul.append('<span>No images have been selected yet.<span>');
			} else {
				this.admin_thumb_ul.find('span').remove();
			}
		}
	};
	
	anva_gallery.init();
});
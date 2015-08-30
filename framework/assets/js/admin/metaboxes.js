var ANVAMETA = ANVAMETA || {};

(function($) {

	"use strict";

	ANVAMETA.initialize = {
		init: function() {
			ANVAMETA.initialize.change();
			ANVAMETA.initialize.enable();
			ANVAMETA.initialize.tabs();
		},

		change: function() {
			var $template = $("#page_template");
			if ( $template.length > 0 ) {
				ANVAMETA.initialize.validate( $template.val() );
				$template.live( "change", function() {
					ANVAMETA.initialize.validate( $(this).val() );
				});
			}
		},

		enable: function() {
			var $active = $('.enable-builder');
			if ( $active.length > 0 ) {
				ANVAMETA.initialize.enableCheck($active);
				$active.live( 'change', function() {
					ANVAMETA.initialize.enableCheck($active);
				});
			}
		},

		enableCheck: function( target ) {
			if ( target.is(':checked') ) {
				$('.meta-content-builder, .meta-content-builder-export').fadeIn();
				$('#postdivrich').fadeOut();

			} else {
				$('.meta-content-builder, .meta-content-builder-export').fadeOut();
				$('#postdivrich').fadeIn();
			}
		},

		validate: function( val ) {
			var $inputGrid = $("#meta-grid_column"),
			 		$inputSidebar = $("#meta-sidebar_layout");

			if ( 'template_grid.php' == val ) {
				$inputGrid.show();
			} else {
				$inputGrid.hide();
			}
			
			if ( 'default' == val || 'template_list.php' == val || 'template_archives.php' == val || 'template_grid.php' == val ) {
				$inputSidebar.show();
			} else {
				$inputSidebar.hide();
			}
		},

		tabs: function() {
			if ( $('.nav-tab-wrapper').length > 0 ) {
				ANVAMETA.initialize.navTabs();
			}
		},

		navTabs: function() {
			var $group = $('.meta-group'),
				$navtabs = $('.nav-tab-wrapper a'),
				active_tab = '';

			// Hides all the .meta-group sections to start
			$group.hide();

			// Find if a selected tab is saved in localStorage
			if ( typeof(localStorage) != 'undefined' ) {
				active_tab = localStorage.getItem('meta_active_tab');
			}

			// If active tab is saved and exists, load it's .meta-group
			if ( active_tab != '' && $(active_tab).length ) {
				$(active_tab).fadeIn();
				$(active_tab + '-tab').addClass('nav-tab-active');
			} else {
				$('.meta-group:first').fadeIn();
				$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
			}

			// Bind tabs clicks
			$navtabs.click(function(e) {
				e.preventDefault();

				// Remove active class from all tabs
				$navtabs.removeClass('nav-tab-active');

				$(this).addClass('nav-tab-active').blur();

				if (typeof(localStorage) != 'undefined' ) {
					localStorage.setItem('meta_active_tab', $(this).attr('href') );
				}

				var selected = $(this).attr('href');

				$group.hide();
				$(selected).fadeIn();
			});
		}
	};

	ANVAMETA.widgets = {

		init: function() {
			ANVAMETA.widgets.picker();
		},

		picker: function() {
			if ( $(".meta-date-picker").length > 0 ) {
				$(".meta-date-picker").datepicker();
			}
		}
	};

	ANVAMETA.documentOnReady = {
		init: function() {
			ANVAMETA.initialize.init();
			ANVAMETA.widgets.init();
		}
	};

	$(document).ready( ANVAMETA.documentOnReady.init );

})(jQuery);

jQuery( function($) {
	
	if ( typeof plupload !== 'undefined' && typeof ANVAUploaderInit !== 'undefined' ) {
		
		var uploader = new plupload.Uploader(ANVAUploaderInit);
		
		uploader.init();
		uploader.bind('FilesAdded', function(up) {
			up.start();
			jQuery('#anva_gallery_spinner').css('display', 'block');
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
		jQuery('#anva-plupload-browse-button').hide();
	}

	var file_frame;
	var anva_gallery = {
		admin_thumb_ul: '',
		admin_thumb_ul_li: '',

		init: function() {
			this.admin_thumb_ul = jQuery('#anva_gallery_thumbs');
			this.admin_thumb_ul_li = jQuery('#anva_gallery_thumbs li');
			
			if ( this.admin_thumb_ul.length > 0 ) {
				this.admin_thumb_ul.sortable({
					placeholder: 'anva_gallery_placeholder'
				});
			}
			
			// Remove thumb
			this.admin_thumb_ul.on( 'click', '.anva_gallery_remove', function() {

				jQuery(this).parent().fadeOut(100, function() {
					jQuery(this).remove();
				});

				setTimeout(function(){
					anva_gallery.empty_gallery();
				}, 500);

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

				file_frame.on( 'select', function() {
					var images = file_frame.state().get('selection').toJSON();
					var length = images.length;
					
					for ( var i = 0; i < length; i++ ) {
						anva_gallery.get_thumbnail( images[i]['id'] );
					}
				});

				file_frame.open();
			});


			jQuery('#anva_gallery_add_attachments_button').on( 'click', function() {
				var included = [];
				jQuery('#anva_gallery_thumbs input[type=hidden]').each( function(i, e) {
					included.push( jQuery(this).val() );
				});
				anva_gallery.get_all_thumbnails( POST_ID, included );
			});

			// Delete all images
			jQuery('#anva_gallery_delete_all_button').on( 'click', function() {

				if ( jQuery('#anva_gallery_thumbs li').length == 0 ) {
					alert( 'The box is empty, add some image first.' );
					return;
				}

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
			jQuery('#anva_gallery_spinner').css('display', 'block');
			jQuery.post(ajaxurl, data, function( response ) {
				anva_gallery.admin_thumb_ul.append( response );
				cb();
				anva_gallery.empty_gallery();
			}).done( function() {
				jQuery('#anva_gallery_spinner').hide();
			});
		},

		get_all_thumbnails: function( post_id, included ) {
			var data = {
				action: 'anva_gallery_get_all_thumbnail',
				post_id: post_id,
				included: included
			};

			jQuery('#anva_gallery_spinner').css('display', 'block');
			jQuery.post( ajaxurl, data, function( response ) {
				anva_gallery.admin_thumb_ul.append(response);
				anva_gallery.empty_gallery();
			}).done( function() {
				jQuery('#anva_gallery_spinner').hide();
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
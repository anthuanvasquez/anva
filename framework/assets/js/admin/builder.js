// Implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {
	var t = typeof (obj);
	
	if ( t != "object" || obj === null ) {
		
		// Simple data type
		if ( t == "string" ) {
			obj = '"' + obj + '"';
		}
		
		return String( obj );
	
	} else {
		
		// Recurse array or object
		var n, v, json = [], arr = ( obj && obj.constructor == Array );
		
		for ( n in obj ) {
			v = obj[n];
			t = typeof(v);

			if ( t == "string" ) {
				v = '"'+v+'"';
			} else if ( t == "object" && v !== null ) {
				v = JSON.stringify( v );
			}
			
			json.push( ( arr ? "" : '"' + n + '":' ) + String( v ) );
		}
		return ( arr ? "[" : "{" ) + String( json ) + ( arr ? "]" : "}" );
	}
};

jQuery(document).ready(function($) {

	var anvaBuilder = {

		init: function() {
			anvaBuilder.enable();
			anvaBuilder.sortItems();
			anvaBuilder.addItem();
			anvaBuilder.editItem();
			anvaBuilder.moveItem();
			anvaBuilder.removeItem();
			anvaBuilder.removeAllItems();
			anvaBuilder.itemData();
			anvaBuilder.publish();
			anvaBuilder.tabs();
			anvaBuilder.tooltip();
			anvaBuilder.importExport();
			anvaBuilder.extras();
		},

		enable: function() {
			var $checked = $('.anva-builder-enable');
			if ( $checked.length > 0 ) {
				anvaBuilder.checked( $checked );
				$checked.live( 'change', function() {
					anvaBuilder.checked( $checked );
				});
			}

			$('#anva-builder-button').on( 'click', function(e) {
				e.preventDefault();
				$checked.trigger('click');
			});
		},

		checked: function( $target ) {
			var $button = $('#anva-builder-button'),
				$enable = $button.data('enable'),
				$disable = $button.data('disable');

			if ( $target.is(':checked') ) {
				$button.text( $disable );
				$button.toggleClass('anva-builder-active', true);
				// $target.val('0');
				$('.anva-input-builder').slideDown();
				$('#postdivrich').fadeOut( 'fast', function() {
					$(this).css('paddingTop', '80px');
				});;

			} else if ( ! $target.is(':checked') ) {
				$button.text( $enable );
				$button.toggleClass('anva-builder-active', false);
				// $target.val('1');
				$('.anva-input-builder').slideUp();
				$('#postdivrich').fadeIn( 'fast', function() {
					$(this).css('paddingTop', '0px');
				});
			}
		},

		sortItems: function() {
			var $sortable = $('.builder-sortable-items');
			$sortable.sortable({
				handle: '.thumbnail',
				placeholder: 'ui-state-highlight',
				revert: true
			});
			$sortable.find('.thumbnail').disableSelection();
		},

		addItem: function() {
			$('#add-builder-item').on( 'click', function(e) {
				e.preventDefault();

				$(this).attr('disabled','disabled');

				if ( '' == $('#anva_shortcode').val() ) {
					alert( ANVA.builder_empty );
					return false;
				}
				
				var $randomId 	= $.now();
				var $shortcode 	= $('#anva_shortcode').val();
				var $title 			= $('#anva_shortcode_title').val();
				var $image 			= $('#anva_shortcode_image').val();
				
				if ( $shortcode != '' ) {
					
					var builderItemData = {};
					
					builderItemData.id 							= $randomId;
					builderItemData.shortcode 			= $shortcode;
					builderItemData.text_title 			= $title;
					builderItemData.text_content 		= '';
					builderItemData.header_content 	= '';
					
					var builderItemDataJSON = JSON.stringify( builderItemData );
					var ajaxEditURL  = ANVA.ajaxurl + '?action=anva_builder_get_fields&&shortcode=' + $shortcode + '&rel=' + $randomId;

					builderItem  = '<li id="' + $randomId + '" class="item item-' + $randomId + ' ' + $shortcode + ' ui-state-default animated bounceIn">';
					builderItem += '<div class="actions">';
					builderItem += '<a href="' + ajaxEditURL + '" class="button-edit" data-id="' + $randomId + '"></a>';
					builderItem += '<a href="#" class="button-remove"></a>';
					builderItem += '</div>';
					builderItem += '<div class="thumbnail">';
					builderItem += '<img src="' + $image + '" alt="' + $title + '" />';
					builderItem += '</div>';
					builderItem += '<div class="title">';
					builderItem += '<span class="shortcode-type">' + $title + '</span>';
					builderItem += '<span class="shortcode-title"></span>';
					builderItem += '</div>';
					builderItem += '<span class="spinner spinner-' + $randomId + '"></span>';
					builderItem += '<input type="hidden" class="anva_setting_columns" value="one_fourth"/>';
					builderItem += '<div class="clear"></div>';
					builderItem += '</li>';

					$('#builder-sortable-items').append( builderItem );
					$('#builder-sortable-items').removeClass('empty');
					
					$('#' + $randomId).data( 'anva_builder_settings', builderItemDataJSON );
					
					// Divider dont have attributes
					if ( $shortcode != 'divider' ) {
						$('#' + $randomId).find('.button-edit').trigger('click');
					}

					// Reset selected item
					$('.builder-elements li').removeClass('selected');
					$('#anva_shortcode').val('');
					$('#anva_shortcode_title').val('');
					$('#anva_shortcode_image').val('');

					// Scroll to item
					$('html, body').animate({
						scrollTop: $('#' + $randomId).offset().top - 32
					}, 1000);
										
				}
			});
		},

		editItem: function() {
			$(document).on( 'click', '#builder-sortable-items li .actions a.button-edit', function(e) {
				e.preventDefault();

				var $ele = $(this).parent('.actions').parent('li'), $id = $ele.attr('id'), $itemInner = $('#item-inner-' + $id);
				
				if ( $itemInner.length == 0 ) {
					$('#anva_current_item').val( $(this).attr('data-id') );

					var $actionURL = $(this).attr('href');

					$ele.find('span.spinner').css('visibility', 'visible');
					
					var $ajaxCall = $.ajax({
						type: "GET",
						cache: false,
						url: $actionURL,
						data: '',
						success: function (data) {
							$ele.append('<div id="item-inner-' + $id + '" class="item-inner item-inner-'+ $id +'" style="display:none;">' + data + '</div>');
							$('#' + $id).addClass('has-inline-content');
						} 
					});

					$.when( $ajaxCall ).then( function() {
						$('#item-inner-' + $id).slideToggle();
						$ele.find('span.spinner').css('visibility', 'hidden');

						// Remove disable button
						$('#add-builder-item').removeAttr('disabled');
						
						// Color Picker
						$('.colorpicker').wpColorPicker();

						// WP Editor
						var options = { 'mceInit' : { "height": 200 } };
						$('.anva-wp-editor').wp_editor( options );

						// HTML5 Range
						$('.rangeslider').change( function() {
							var $ele, newPoint, newPlace, offset;
							$ele = $(this);
							width = $ele.width();
							newPoint = ( $ele.val() - $ele.attr("min") ) / ( $ele.attr("max") - $ele.attr("min") );
							$ele.next("output").text( $ele.val() );
						}).trigger('change');

						// Scroll to item
						$('html, body').animate({
							scrollTop: $('#' + $id).offset().top - 32
						}, 1000);
					});

				} else {
					$('#item-inner-' + $id).slideToggle();
				}
			});
		},

		moveItem: function() {
			$('#builder-sortable-items li a.button-move-down').on( 'click', function(e) {
				e.preventDefault();
				var $curr = $(this).parent('.actions').parent('li').attr('id');
				var $next = $('#' + $curr).next().attr('id');
				$('#' + $next).insertBefore('#' + $curr);
			});

			$('#builder-sortable-items li a.button-move-up').on( 'click', function(e) {
				e.preventDefault();
				var $curr = $(this).parent('.actions').parent('li').attr('id'); 
				var $prev = $('#' + $curr).prev().attr('id'); 
				$('#' + $prev).insertAfter('#' + $curr);
			});
		},

		removeItem: function() {
			$(document).on( 'click', '#builder-sortable-items li a.button-remove', function(e) {
				e.preventDefault();
				var $parentEle = $(this).parent('.actions').parent('li');
				if ( confirm( 'Are you sure you want to delete this item?' ) ) {
					$parentEle.remove();
					setTimeout( function() {
						if ( $('#builder-sortable-items li').length == 0 ) {
							$('#builder-sortable-items').addClass('empty');
						}
					}, 500 );
				}
			});
		},

		removeAllItems: function() {
			$(document).on( 'click', '#remove-all-items', function(e) {
				e.preventDefault();
				var $itemsEle = $('#builder-sortable-items li');
				if ( confirm( 'Are you sure you want to delete all items?' ) ) {
					$itemsEle.remove();	
					setTimeout( function() {
						if ( $('#builder-sortable-items li').length == 0 ) {
							$('#builder-sortable-items').addClass('empty');
						}
					}, 500 );
				}
			});
		},

		itemData: function() {
			var $element = $('.builder-elements li');
			$element.on( 'click', function(e) {
				e.preventDefault();
				$element.removeClass('selected');
				$(this).addClass('selected');
				var $elementId = $(this).data('element');
				var $elementTitle = $(this).data('title');
				var $elementImage = $(this).find('img').attr('src');
				$('#anva_shortcode').val( $elementId );
				$('#anva_shortcode_title').val( $elementTitle );
				$('#anva_shortcode_image').val( $elementImage );
			});
		},

		publish: function() {
			$('#publish').on( 'click', function() {
				
				// Add fields for items
				if ( $('#builder-sortable-items li').length > 0 ) {
					var $id = $('#anva_builder_id').val(), $itemOrder = $('#builder-sortable-items').sortable('toArray');
					$('#builder-sortable-items li').each( function() {
						$(this).append( '<textarea style="display:none" name="' + $id + '[' + $(this).attr('id') + ']' + '[data]">' + $(this).data('anva_builder_settings') + '</textarea>' );
					});
					$('#anva_shortcode_order').val( $itemOrder );
				}
				
				// Disable Import/Export buttons
				$('#anva-import').val('');
				$('#anva-export').val('');
			});
		},

		tabs: function() {
			$('#elements-tabs').tabs({
				hide: {
					effect: "fade",
					duration: 400
				},
				show: {
					effect: "fade",
					duration: 400
				}
			});
		},

		tooltip: function() {
			$('.tooltip').tooltipster({
				animation: 'grow',
				delay: 200,
				maxWidth: 200,
				theme: 'tooltipster-light',
				touchDevices: true,
				trigger: 'hover'
			});

			$('.anva-tooltip-info').on( 'click', function(e) {
				$(this).tooltipster({
					animation: 'fade',
					delay: 200,
					maxWidth: 400,
					theme: 'tooltipster-white',
					touchDevices: true,
					trigger: 'hover',
					position: 'bottom-right',
					content: $('.anva-tooltip-info-html').html(),
					contentAsHTML: true
				});
				e.preventDefault();
			});
		},

		importExport: function() {
			$('.anva-backup-container > a').on( 'click', function(e) {
				e.preventDefault();
				$('.anva-backup-container').toggleClass('active');
			});

			// Export Content
			$(document).on( 'click', '.button-export', function(e) {
				$('#builder-sortable-items li').each( function() {
					if ( $(this).hasClass('item-unsaved') ) {
						alert( ANVA.builder_unsave );
						e.preventDefault();
					}
				});
				
				$('#anva-export').val(1);
			});
			
			// Import content
			$(document).on( 'click', '.button-import', function(e) {
				if ( $('#anva-import-file').val() == '' ) {
					alert( ANVA.builder_import );
					e.preventDefault();
				}
				$('.wrap > form').attr('enctype', 'multipart/form-data');
				$('#anva-import').val(1);
			});
		},

		extras: function() {
			var $builderId = $('#anva_builder_id').val();
			$('#' + $builderId).addClass('anva-builder');

			$(document).on( 'click', '#builder-sortable-items li', function() {
				$('#anva_current_item').val( $(this).attr('id') );
			});

			$(document).on( 'click', 'anva-upload-button', function(e) {
				var form_field = $(this).attr('rel');
				var send_attachment_bkp = wp.media.editor.send.attachment;
				wp.media.editor.send.attachment = function( props, attachment ) {
					$('#' + form_field).attr( 'value', attachment.url );
					$('<img src="' + attachment.url + '" />').insertAfter('#' + form_field + '_button');
					wp.media.editor.send.attachment = send_attachment_bkp;
				}
				wp.media.editor.open();
				return false;
			});
		}

	}

	anvaBuilder.init();

});
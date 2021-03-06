// Implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function ( obj ) {

	var t = typeof (obj);

	if ( t !== "object" || obj === null ) {

		// Simple data type
		if ( t === "string" ) {
			obj = '"' + obj + '"';
		}

		return String( obj );

	} else {

		// Recurse array or object
		var n, v, json = [], arr = ( obj && obj.constructor === Array );

		for ( n in obj ) {
			v = obj[ n ];
			t = typeof( v );

			if ( t === "string" ) {
				v = '"'+v+'"';
			} else if ( t === "object" && v !== null ) {
				v = JSON.stringify( v );
			}

			json.push( ( arr ? "" : '"' + n + '":' ) + String( v ) );
		}
		return ( arr ? "[" : "{" ) + String( json ) + ( arr ? "]" : "}" );
	}
};

jQuery( document ).ready( function( $ ) {

	'use strict';

	// WP Media Frame
	var frame;

	// Settings
	var s;

	// Anva Builder Object
	var ANVA_BUILDER = {

		// Default Settings
		settings: {
			ID: 				$('#anva_builder_id').val(),
			button: 			$('#anva-builder-button'),
			checked: 			$('.anva-builder-enable'),
			fields: 			$('.anva-input-builder'),
			itemUl: 			$('#builder-sortable-items'),
			itemLi: 			$('#builder-sortable-items li'),
			element: 			$('.builder-elements li .element-shortcode'),
			root:				$('html, body'),
			editorHeight: 		200
		},

		/**
		 * Initialize the object.
		 */
		init: function() {

			// Set Settings
			s = this.settings;

			// Initialize functions
			ANVA_BUILDER.active();
			// ANVA_BUILDER.dragItems();
			ANVA_BUILDER.sortItems();
			ANVA_BUILDER.addRow();
			ANVA_BUILDER.addItem();
			ANVA_BUILDER.editItem();
			ANVA_BUILDER.moveItem();
			ANVA_BUILDER.addColumns();
			ANVA_BUILDER.removeItem();
			ANVA_BUILDER.removeAllItems();
			ANVA_BUILDER.itemData();
			ANVA_BUILDER.publish();
			ANVA_BUILDER.tooltip();
			ANVA_BUILDER.importExport();
			ANVA_BUILDER.extras();

		},

		/**
		 * Active content builder when select the page template.
		 */
		active: function() {
			var $template = $('#page_template');
			ANVA_BUILDER.checkTemplate( $template.val() );
			$template.on( 'change', function() {
				ANVA_BUILDER.checkTemplate( $template.val() );
			});
		},

		/**
		 * Check if the page template is selected.
		 *
		 * @param object $target
		 */
		checkTemplate: function( $target ) {
			if ( 'template_builder.php' === $target ) {
				$('#' + s.ID).addClass('anva-builder-active');
			} else {
				$('#' + s.ID).removeClass('anva-builder-active');
			}
		},

		/**
		 * Drag and drop items.
		 */
		dragItems: function() {
			s.element.draggable({
				connectToSortable: '#builder-sortable-items',
				revert: 'invalid',
				zIndex: 199,
				helper: function(e) {
					var item = ANVA_BUILDER.buildItem();
					return $( item.html ).addClass('block').css('minWidth','300px');
				},
				start: function( e, ui ) {

				},
				stop: function( e, ui ) {

				}
			});
		},

		/**
		 * Sort items in the list.
		 */
		sortItems: function() {
			s.itemUl.sortable({
				handle: '.thumbnail',
				placeholder: 'ui-state-highlight',
				revert: 20,
				cursor: 'move',
				helper: 'clone',
				sort: function( e, ui ) {
					ui.item.removeClass('animated');
				},
				receive: function( e, ui ) {

				},
				update: function ( e, ui ) {

				}
			});
			s.itemUl.find('.thumbnail').disableSelection();
		},

		/**
		 * Create the item.
		 */
		buildItem: function() {

			var $randomId 	= $.now(),
				$shortcode 	= $('#anva_shortcode').val(),
				$title 		= $('#anva_shortcode_title').val(),
				$image 		= $('#anva_shortcode_image').val();

			if ( $shortcode !== '' ) {

				// Item Data Object
				var builderItemData = {};

				builderItemData.id = $randomId;
				builderItemData.shortcode = $shortcode;

				// Builder JSON Object
				var builderItemDataJSON = JSON.stringify( builderItemData );

				// Get ajax URL
				var ajaxEditURL = anvaBuilderJs.ajaxurl + '?action=anva_builder_get_fields&shortcode=' + $shortcode + '&rel=' + $randomId;

				// Generate Item HTML
				var builderItem;

				builderItem  = '<li id="' + $randomId + '" class="item item-' + $randomId + ' ' + $shortcode + ' animated fadeIn">';
				builderItem += '<div class="actions">';
				builderItem += '<a href="#" class="button-move-up"></a>';
				builderItem += '<a href="#" class="button-move-down"></a>';
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
				builderItem += '<div class="clear"></div>';
				builderItem += '</li>';

				// Return
				return {
					id:        $randomId,
					shortcode: $shortcode,
					title:     $title,
					image:     $image,
					ajax:      ajaxEditURL,
					html:      builderItem,
					data:      builderItemData,
					json:      builderItemDataJSON
				};
			}

			return false;
		},

		addRow: function() {
			$('#add-builder-row').on( 'click', function(e) {
				e.preventDefault();

				var row = '<div class="anva-row"></div>';

				s.itemUl.append( row );

				$('.anva-row').resizable({
      				grid: 20,
      				containment: '#builder-sortable-items'
    			}).selectable();

			});
		},

		/**
		 * Add item to the list.
		 */
		addItem: function() {
			$('#add-builder-item').on( 'click', function(e) {
				e.preventDefault();

				// Return if button is disabled
				if ( $(this).attr('disabled') ) {
					return false;
				}

				// Return if dont item select
				if ( '' === $('#anva_shortcode').val() ) {
					swal({
						title: 'Builder',
						text: anvaBuilderJs.builder_empty,
						type: "info",
						showConfirmButton: true,
						confirmButtonColor: "#0085ba",
					});
					return false;
				}

				var item = ANVA_BUILDER.buildItem();

				// Return if not element selected
				if ( ! item ) {
					return false;
				}

				// Disabled button
				$(this).attr('disabled', 'disabled');

				// Append item into Sortable List
				s.itemUl.append( item.html );
				s.itemUl.removeClass('empty');

				// Save data
				$('#' + item.id).data( 'anva_builder_settings', item.json );

				// Divider dont have attributes
				if ( item.shortcode !== 'divider' ) {
					$('#' + item.id).find('.button-edit').trigger('click');

					// Scroll to item
					s.root.animate({
						scrollTop: $('#' + item.id).offset().top - 32
					}, 1000);
				}

				// Remove disabled if not trigger click
				if ( item.shortcode === 'divider' ) {
					$(this).removeAttr('disabled');
				}

				// Reset selected item
				s.element.removeClass('selected');
				$('#anva_shortcode').val('');
				$('#anva_shortcode_title').val('');
				$('#anva_shortcode_image').val('');

			});
		},

		/**
		 * Edit an item in the list.
		 */
		editItem: function() {
			$(document).on( 'click', '#builder-sortable-items .actions a.button-edit', function(e) {
				e.preventDefault();

				var $parentEle = $(this).parent('.actions').parent('li'),
					$itemId = $parentEle.attr('id'),
					$itemInner = $('#item-inner-' + $itemId);

				// If item don't has inline form
				if ( $itemInner.length === 0 ) {

					// Get current item ID
					$('#anva_current_item').val( $(this).attr('data-id') );

					// Get Ajax URL
					var $actionURL = $(this).attr('href');

					// Show spinner
					$parentEle.find('span.spinner').css('visibility', 'visible');

					// Ajax Call
					var $ajaxCall = $.ajax({
						type: 'GET',
						cache: false,
						url: $actionURL,
						data: '',
						success: function ( data ) {
							$parentEle.append('<div id="item-inner-' + $itemId + '" class="item-inner item-inner-'+ $itemId +'" style="display:none;">' + data + '</div>');
							$('#' + $itemId).addClass('has-inline-content');
						}
					});

					// When Ajax Call is Done
					$.when( $ajaxCall ).then( function() {

						// Hide inline form
						$('#item-inner-' + $itemId).slideToggle();

						// Hide spinner
						$parentEle.find('span.spinner').css('visibility', 'hidden');

						// Remove disable button
						$('#add-builder-item').removeAttr('disabled');

						// Color Picker
						$('.anva-color').wpColorPicker();

						$('.section-range, .section-typography .font-range').each(function() {
			                var el = $(this),
				                value = el.find('.anva-input-range').val(),
				                id = el.find('.anva-input-range').attr('id'),
				                min = el.find('.anva-input-range').data('min'),
				                max = el.find('.anva-input-range').data('max'),
				                step = el.find('.anva-input-range').data('step'),
				                units = el.find('.anva-input-range').data('units');
			                $('#' + id + '_range').slider({
			                    min: min,
			                    max: max,
			                    step: step,
			                    value: value,
			                    slide: function( e, ui ) {
			                        $('#' + id).val( ui.value );
			                    }
			                });
			                $('#' + id).val( $('#' + id + '_range').slider( "value" ) );
			                $('#' + id + '_range').slider("pips");
			                $('#' + id + '_range').slider("float", { pips: true, suffix: "" + units });
			            });

						// WP Editor
						if ( $('.anva-wp-editor').length > 0) {
							var options = { 'mceInit' : { "height": s.editorHeight } };
							$('.anva-wp-editor').wp_editor( options );
						}

						// HTML5 Range Input
						$('.rangeslider').on( 'mousemove', function() {
							var $ele = $(this);
							$ele.next('output').text( $ele.val() );
						}).trigger('mousemove');

						// Scroll to item
						s.root.animate({
							scrollTop: $('#' + $itemId).offset().top - 32
						}, 1000 );
					});

				} else {
					$('#item-inner-' + $itemId).slideToggle();
				}
			});
		},

		/**
		 * Move item.
		 */
		moveItem: function() {
			s.itemLi.find('a.button-move-down').on( 'click', function(e) {
				e.preventDefault();
				var $curr = $(this).parent('.actions').parent('li').attr('id');
				var $next = $('#' + $curr).next().attr('id');
				$('#' + $next).insertBefore('#' + $curr);
			});

			s.itemLi.find('a.button-move-up').on( 'click', function(e) {
				e.preventDefault();
				var $curr = $(this).parent('.actions').parent('li').attr('id');
				var $prev = $('#' + $curr).prev().attr('id');
				$('#' + $prev).insertAfter('#' + $curr);
			});
		},

		/**
		 * Add columns to elements.
		 */
		addColumns: function() {

			// Increment columns
			$("#builder-sortable-items li .actions .button-col-up").on( 'click', function(e) {
				e.preventDefault();

				var el = $(this).parent('div').parent('li'), size = el.attr('data-size'), prev1Li = el.prev(), prev2Li = prev1Li.prev(), prev3Li = prev2Li.prev();

				if ( size === 'col_one_fourth' || size === 'col_one_fourth col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_one_third' && prev2Li.attr('data-size') === 'col_one_third' ) {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third col_last');
						el.find('.anva_element_columns').val('col_one_third col_last');
					} else if ( prev1Li.attr('data-size') === 'col_two_third' ) {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third col_last');
						el.find('.anva_element_columns').val('col_one_third col_last');
					} else {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third');
						el.find('.anva_element_columns').val('col_one_third');
					}

					el.removeClass('col_one_fourth');
				}

				if ( size === 'col_one_third' || size === 'col_one_third col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_half' ) {
						el.addClass('col_half');
						el.attr('data-size', 'col_half col_last');
						el.find('.anva_element_columns').val('col_half col_last');
					} else {
						el.addClass('col_half');
						el.attr('data-size', 'col_half');
						el.find('.anva_element_columns').val('col_half');
					}

					el.removeClass('col_one_third');
				}

				if ( size === 'col_half' || size === 'col_half col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_one_third' ) {
						el.addClass('col_two_third');
						el.attr('data-size', 'col_two_third col_last');
						el.find('.anva_element_columns').val('col_two_third col_last');
					} else {
						el.addClass('col_two_third');
						el.attr('data-size', 'col_two_third');
						el.find('.anva_element_columns').val('col_two_third');
					}

					el.removeClass('col_half');
				}

				if ( size === 'col_two_third' || size === 'col_two_third col_last' ) {
					el.addClass('col_full');
					el.attr('data-size', 'col_full');
					el.find('.anva_element_columns').val('col_full');
					el.removeClass('col_two_third');
				}

				if ( size === 'col_full' ) {
					return false;
				}

				return false;
			});

			$("#builder-sortable-items li .actions .button-col-down").on( 'click', function(e) {
				e.preventDefault();

				var el = $(this).parent('div').parent('li'), size = el.attr('data-size'), prev1Li = el.prev(), prev2Li = prev1Li.prev(), prev3Li = prev2Li.prev();

				if ( size === 'col_col_one_fourth' || size === 'col_one_fourth col_last' ) {
					return false;
				}

				if ( size === 'col_one_third' || size === 'col_one_third col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_one_fourth' && prev2Li.attr('data-size') === 'col_one_fourth' && prev3Li.attr('data-size') === 'col_one_fourth') {
						el.addClass('col_one_fourth');
						el.attr('data-size', 'col_one_fourth col_last');
						el.find('.anva_element_columns').val('col_one_fourth col_last');
					} else {
						el.addClass('col_one_fourth');
						el.attr('data-size', 'col_one_fourth');
						el.find('.anva_element_columns').val('col_one_fourth');
					}

					el.removeClass('col_one_third');
				}

				if ( size === 'col_half' || size === 'col_half col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_one_third' && prev2Li.attr('data-size') === 'col_one_third' ) {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third col_last');
						el.find('.anva_element_columns').val('col_one_third col_last');
					} else if ( prev1Li.attr('data-size') === 'col_two_third' ) {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third col_last');
						el.find('.anva_element_columns').val('col_one_third col_last');
					} else {
						el.addClass('col_one_third');
						el.attr('data-size', 'col_one_third');
						el.find('.anva_element_columns').val('col_one_third');
					}

					el.removeClass('col_half');
				}

				if ( size === 'col_two_third' || size === 'col_two_third col_last' ) {

					if ( prev1Li.attr('data-size') === 'col_half' ) {
						el.addClass('col_half col_last');
						el.attr('data-size', 'col_half col_last');
						el.find('.anva_element_columns').val('col_half col_last');
					} else {
						el.addClass('col_half');
						el.attr('data-size', 'col_half');
						el.find('.anva_element_columns').val('col_half');
					}

					el.removeClass('col_two_third');
				}

				if ( size === 'col_full' ) {

					if ( prev1Li.attr('data-size') === 'col_one_third' ) {
						el.addClass('col_two_third');
						el.attr('data-size', 'col_two_third col_last');
						el.find('.anva_element_columns').val('col_two_third col_last');
					} else {
						el.addClass('col_two_third');
						el.attr('data-size', 'col_two_third');
						el.find('.anva_element_columns').val('col_two_third');
					}

					el.removeClass('col_full');
				}

				return false;
			});
		},

		/**
		 * Remove item from sortable list.
		 */
		removeItem: function() {
			$(document).on( 'click', '#builder-sortable-items a.button-remove', function(e) {
				e.preventDefault();
				var $parentEle = $(this).parent('.actions').parent('li');
				if ( confirm( anvaBuilderJs.builder_remove ) ) {
					$parentEle.fadeOut();
					setTimeout( function() {
						$parentEle.remove();
						if ( $('#builder-sortable-items li').length === 0 ) {
							$('#builder-sortable-items').addClass('empty');
						}
					}, 500 );
				}
			});
		},

		/**
		 * Remove all items from sortable list.
		 */
		removeAllItems: function() {
			$(document).on( 'click', '#remove-all-items', function(e) {
				e.preventDefault();

				if ( $('#builder-sortable-items li').length === 0 ) {
					swal({
						title: 'Builder',
						text: anvaBuilderJs.builder_remove_empty,
						type: "info",
						showConfirmButton: true,
						confirmButtonColor: "#0085ba",
					});
					return false;
				}

				swal({
					title: 'Builder',
					text: anvaBuilderJs.builder_remove_all,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaBuilderJs.confirm,
					cancelButtonText: anvaBuilderJs.cancel,
					cancelButtonColor: "#f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {

					if ( isConfirm ) {
						$('#builder-sortable-items li').remove();
						setTimeout( function() {
							if ( $('#builder-sortable-items li').length === 0 ) {
								$('#builder-sortable-items').addClass('empty');
							}
						}, 500 );
					}

				});
			});
		},

		/**
		 * Get item data when select an element.
		 */
		itemData: function() {
			s.element.on( 'click', function(e) {
				e.preventDefault();
				s.element.removeClass('selected');
				$(this).addClass('selected');
				var $id = $(this).data('element');
				var $title = $(this).data('title');
				var $image = $(this).find('img').attr('src');
				$('#anva_shortcode').val( $id );
				$('#anva_shortcode_title').val( $title );
				$('#anva_shortcode_image').val( $image );
			});
		},

		/**
		 * Pusblish or Update the items list.
		 */
		publish: function() {
			$('#publish').on( 'click', function() {

				// Add fields for items
				if ( $('#builder-sortable-items li').length > 0 ) {
					$('#builder-sortable-items li').each( function() {
						$(this).append( '<textarea style="display:none" name="' + s.ID + '[' + $(this).attr('id') + ']' + '[data]">' + $(this).data('anva_builder_settings') + '</textarea>' );
					});
					$('#anva_shortcode_order').val( s.itemUl.sortable('toArray') );
				}

				// Disable Import/Export buttons
				$('#anva-import').val('');
				$('#anva-export').val('');
			});
		},

		/**
		 * Tooltip popups.
		 */
		tooltip: function() {

			// Tooltip element description
			$('.tooltip').tooltipster({
				animation: 'grow',
				delay: 200,
				maxWidth: 200,
				theme: 'tooltipster-light',
				touchDevices: true,
				trigger: 'hover'
			});

			// Tooltip popup buttons
			$('.item .actions > a').tooltipster({
				touchDevices: true,
				trigger: 'hover'
			});

			// Tooltip content builder quick info
			$('.anva-tooltip-info').tooltipster({
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
		},

		/**
		 * Import or Export the item list.
		 */
		importExport: function() {
			$('.anva-backup-container > a').on( 'click', function(e) {
				e.preventDefault();
				$('.anva-backup-container').toggleClass('active');
			});

			// Export Content
			$(document).on( 'click', '.button-export', function(e) {
				$('#builder-sortable-items li').each( function() {
					if ( $(this).hasClass('item-unsaved') ) {
						alert( anvaBuilderJs.builder_unsave );
						e.preventDefault();
					}
				});
				$('#anva-export').val(1);
			});

			// Import Content
			$(document).on( 'click', '.button-import', function(e) {
				if ( $('#anva-import-file').val() === '' ) {
					alert( anvaBuilderJs.builder_import );
					e.preventDefault();
				}
				$('.wrap > form').attr('enctype', 'multipart/form-data');
				$('#anva-import').val(1);
			});
		},

		/**
		 * Extras.
		 */
		extras: function() {

			// Add class to meta box
			$('#' + s.ID).addClass('anva-builder');

			// Get current item ID on click
			$(document).on( 'click', '#builder-sortable-items li', function() {
				$('#anva_current_item').val( $(this).attr('id') );
			});

			// Remove Image from upload option
			$(document).on( 'click', '.anva-remove-image', function(e) {
				e.preventDefault();
				$(this).parent('.screenshot').prev().trigger('click');
			});

			// Upload
			$(document).on( 'click', '.anva-upload-button', function(e) {
				e.preventDefault();

				var $file 	= $(this).data('id'),
					$button = $('#' + $file + '_button'),
					$image  = $('#' + $file + '_image'),
					$remove = $button.data('remove'),
					$upload = $button.data('upload');

				if ( $remove === $button.text() ) {
					$('#' + $file).val('');
					$image.slideUp('fast');
					$button.text( $upload );
					$button.removeClass('remove-image');

					setTimeout( function() {
						$image.find('img').remove();
						$image.find('a').remove();
					}, 500 );

				} else if ( $upload === $button.text() ) {

					if ( frame ) {
						frame.open();
						return;
					}

					// Create the media frame
					frame = wp.media({
						title: anvaBuilderJs.builder_upload,
						button: {
							text: anvaBuilderJs.builder_select_image,
							close: false
						},
						multiple: false
					});

					// When an image is selected, run a callback
					frame.on( 'select', function() {
						var attachment = frame.state().get('selection').first().toJSON();
						$('#' + $file).val( attachment.url );
						$image.append('<img src="' + attachment.url + '" /><a href="#" class="anva-remove-image">X</a>').slideDown('fast');
						$button.text( $remove );
						$button.addClass('remove-image');
						frame.close();
					});

					frame.open();
				}
			});
		}

	};

	ANVA_BUILDER.init();

});

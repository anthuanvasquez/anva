jQuery(document).ready(function($) {
	
	var anvaMeta = anvaMeta || {};
	
	anvaMeta.initialize = {

		init: function() {
			anvaMeta.initialize.pageTemplate();
			anvaMeta.initialize.tabs();
		},

		pageTemplate: function() {
			var $template = $("#page_template");
			if ( $template.length > 0 ) {
				anvaMeta.initialize.checkTemplate( $template.val() );
				$template.live( "change", function() {
					anvaMeta.initialize.checkTemplate( $(this).val() );
				});
			}
		},

		checkTemplate: function( val ) {
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
				anvaMeta.initialize.navTabs();
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

	anvaMeta.widgets = {

		init: function() {
			anvaMeta.widgets.picker();
		},

		picker: function() {
			if ( $(".meta-date-picker").length > 0 ) {
				$(".meta-date-picker").datepicker();
			}
		}
	};

	anvaMeta.documentOnReady = {
		init: function() {
			anvaMeta.initialize.init();
			anvaMeta.widgets.init();
		}
	};

	anvaMeta.documentOnReady.init();

});
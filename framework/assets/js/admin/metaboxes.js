jQuery(document).ready(function($) {
	
	// Settings
	var s;
	
	// Anva Meta Object
	var AnvaMeta = {

		// Default Settings
		settings: {
			template: $('#page_template'),
			grid: 		$('#meta-grid_column'),
			sidebar: 	$('#meta-sidebar_layout')
		},

		init: function() {

			// Set Settings
			s = this.settings;

			AnvaMeta.pageTemplate();
			AnvaMeta.tabs();
			AnvaMeta.datePicker();
			AnvaMeta.spinner();

		},

		pageTemplate: function() {
			if ( s.template.length > 0 ) {
				AnvaMeta.checkTemplate( s.template.val() );
				s.template.live( 'change', function() {
					AnvaMeta.checkTemplate( $(this).val() );
				});
			}
		},

		checkTemplate: function( val ) {

			var templates = [
				'default', // Default template
				'template_archives.php',
				'template_list.php'
			];

			// Show grid option
			if ( 'template_grid.php' == val ) {
				s.grid.show();
			} else {
				s.grid.hide();
			}

			// Show sidebar layout option
			if ( -1 != $.inArray( val, templates ) ) {
				s.sidebar.show();
			} else {
				s.sidebar.hide();
			}
		},

		tabs: function() {
			if ( $('.nav-tab-wrapper').length > 0 ) {
				AnvaMeta.navTabs();
			}
		},

		spinner: function() {
			if ( $('.anva-spinner').length > 0 ) {
				$('.anva-spinner').spinner();
			}
		},

		datePicker: function() {
			if ( $('.anva-datepicker').length > 0 ) {
				$('.anva-datepicker').datepicker({
					showAnim: 'slideDown',
					dateFormat: 'd MM, yy'
				});
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

	AnvaMeta.init();

});
<?php

function anva_api_init() {

	// Setup Framework Stylesheets
	Anva_Stylesheets::instance();

	// Setup Framework JavaScripts
	Anva_Scripts::instance();

	// Setup Framework Sidebars
	Anva_Sidebars::instance();

	// Setup Framework Widgets
	Anva_Widgets::instance();

	// Setup Framework Options
	Anva_Options_API::instance();
}

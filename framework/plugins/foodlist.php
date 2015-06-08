<?php

add_action( 'after_setup_theme', 'anva_foodlist_setup' );

/*
 * Foodlist theme setup
 */
function anva_foodlist_setup() {
	add_filter( 'foodlist_menu_template', 'anva_menu_template', 10, 2 );
	add_filter( 'foodlist_menu_section_template', 'anva_menu_section_template', 10, 2 );
	add_filter( 'foodlist_menu_item_template', 'anva_menu_item_template', 10, 2 );
	add_action( 'wp_enqueue_scripts', 'foodlist_load_scripts' );
}

/*
 * Foodlist front end scripts
 */
function foodlist_load_scripts() {
	wp_dequeue_style( 'foodlist-frontend' );
	wp_enqueue_style( 'foodlist-screen', get_template_directory_uri() . '/assets/css/screen-foodlist.css' );
}

/*
 * Foodlist menu template
 */
function anva_menu_template( $tpl ) {
	$tpl = '
		<div class="fl-menu" id="fl-menu-[menu_id]">
			<div class="fl-menu-desc">
				[menu_excerpt]
			</div>
			<div id="menu-toc"></div>
			<ul class="fl-menu-sections clearfix">
				[menu_sections]
				<li>
					[menu_section]
				</li>
				[/menu_sections]
			</ul>
		</div>
	';
	return $tpl;
}

/*
 * Foodlist menu section template
 */
function anva_menu_section_template( $tpl ) {
	$tpl = '
		<div class="fl-menu-section" id="fl-menu-section-[menu_section_id]-[menu_section_instance]">
			<h2>[menu_section_title] <a href="#menu-toc" title="Ir Arriba"><i class="fa fa-long-arrow-up"></i></a></h2>
			<div class="fl-menu-section-content">
				[menu_section_excerpt]
			</div>
			<ul class="fl-menu-items section-full clearfix">
				[menu_items]
				<li>
					[menu_item]
				</li>
				[/menu_items]
			</ul>
		</div>
	';
	return $tpl;
}

/*
 * Foodlist menu item template
 */
function anva_menu_item_template( $tpl ) {	
	$tpl = '
		<div class="fl-menu-item" id="fl-menu-item-[menu_item_id]-[menu_item_instance]">
			<div class="fl-menu-item-inner">
				<div class="fl-menu-item-image">
					[menu_item_thumbnail]
				</div>
				<div class="fl-menu-item-content">
					<div class="fl-menu-item-title">
						<h3>[menu_item_title]</h3>
					</div>
					<div class="fl-menu-item-desc">
						[menu_item_excerpt]
					</div>
					<div class="fl-menu-item-meta">
						<div class="fl-menu-item-tags">
							[menu_item_tags]
            		<span>
            			<img src="[menu_item_tag_icon_url]" alt="[menu_item_tag_description]" />
            			<span class="sr-only">[menu_item_tag_description]</span>
            		</span>
        			[/menu_item_tags]
						</div>
						<span class="fl-menu-item-currency">[currency_sign]</span>
						<span class="fl-menu-item-price">[menu_item_price]</span>
					</div>
				</div>
			</div>
		</div>
	';
	return $tpl;
}
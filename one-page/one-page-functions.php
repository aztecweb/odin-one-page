<?php

/**
 * Add One Page assets.
 *
 * @since 
 *
 * @global string $selected_page The element id of the selected page.
 * @return void
 */
function odin_onepage_enqueue_assets() {
	global $selected_page;
	
	$assets_directory_uri = get_template_directory_uri() . '/one-page/assets';
	
	wp_enqueue_style( 'odin-one-page-style', $assets_directory_uri . '/css/style.css' );
	
	wp_enqueue_script(
			'jquery-special',
			$assets_directory_uri . '/js/libs/jquery.inview.min.js',
			array( 'jquery' )
	);
	wp_enqueue_script( 
			'odin-one-page', 
			$assets_directory_uri . '/js/one-page.js', 
			array( 'jquery-special' ) 
	);
	
	wp_localize_script( 'odin-one-page', 'odin_onepage', array(
		'selected_page' => $selected_page
	) );
	
}
add_action( 'wp_enqueue_scripts', 'odin_onepage_enqueue_assets' );

/**
 * Load the structure of the One Page.
 *
 * @since 
 *
 * @global string $selected_page The element id of the selected page.
 * @return void
 */
function odin_onepage_load_pages() {
	global $selected_page;	
	
	$selected_page = false;
	
	// if isn't page, don't load
	$queried_object = get_queried_object();
	if( ! $queried_object || $queried_object->post_type != 'page' ) {
		return;
	}
	
	// isn't in main menu, don't load
	
	// get menu items
	$locations = get_nav_menu_locations();
	$items = wp_get_nav_menu_items( $locations['main-menu'] );
	
	// get complete URL
	$url  = ( empty($_SERVER['HTTPS'] ) || $_SERVER['HTTPS'] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
	$url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":" . $_SERVER["SERVER_PORT"] : "";
	$url .= $_SERVER["REQUEST_URI"];
	
	// search the url in array
	$found = false;
	foreach( $items as $item ) {
		if( $item->url == $url ) {
			
			$selected_page = "page-" . $item->object_id;
			$found = true;
			continue;
		}
	}
	
	if( ! $found ) {
		return;
	}
	
	require get_template_directory() . '/onepage.php';
	exit;
}
add_action( 'template_redirect', 'odin_onepage_load_pages' );

/**
 * Get the menu itens to build the site structure and add the post id as class 
 * of the item to associate with the corresponding page. If the item isn't a 
 * page, do nothing.
 *
 * @since 
 * 
 * @global WP_Post[] $odin_onepage_pages The pages of the main menu.
 * @param array $classes The actual item classes.
 * @param WP_Post $item The object that represents the menu item
 * @param array $args The wp_nav_menu function args.
 * @return array The news item classes.
 */
function odin_onepage_add_menu_item_class( $classes, $item, $args ) {
	if( $args->theme_location == 'main-menu') {
		global $odin_onepage_pages;
		
		// ignore non-page items
		$item_object = get_post_meta( $item->ID, '_menu_item_object', true );
		if( $item_object == 'page' ) {
			// get the the corresponding post object of the menu page
			$item_object_id = get_post_meta( $item->ID, '_menu_item_object_id', true );
			$odin_onepage_pages[] = get_post( $item_object_id );
			
			// add class with de post ID to scroll when the link is clicked
			$classes[] = "page-" . $item_object_id;
		}
	}
	
	return $classes;
}
add_filter( 'nav_menu_css_class', 'odin_onepage_add_menu_item_class', 10, 3 );


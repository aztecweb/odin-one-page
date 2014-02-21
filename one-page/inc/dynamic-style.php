<?php

/**
 * Dynamyc stylesheet to load custom options in the pages
 * 
 * @global WP_Post[] $odin_onepage_pages The pages of the main menu.
 */
global $odin_onepage_pages;

// load the WordPress
$absolute_path = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
$wp_load = $absolute_path[0] . 'wp-load.php';
require_once($wp_load);

header('Content-type: text/css');
header('Cache-control: must-revalidate');

$properties = array( "color", "image", "repeat", "position", "attacment" );
foreach( $odin_onepage_pages as $page ) {
	foreach( $properties as $property ) {
		$meta = get_post_meta( $page->ID, "page_background_{$property}", true );
		if( $property == 'image' && $meta ) {
			$attachment = wp_get_attachment_image_src( $meta, 'full' );
			$page_properties[$property] = "url({$attachment[0]})";
		} elseif( $property == 'position' && $meta ) {
			$page_properties[$property] = str_replace( "_", " ", $meta );
		} else {
			$page_properties[$property] = $meta;
		}
	}
	
	if( $page_properties["color"] || $page_properties["image"] ) {
		echo "#page-{$page->ID}{\n";
		if( $page_properties["color"] ) {
			echo "\tbackground-color: {$page_properties["color"]};\n";
		}
		$images_properties = array_slice( $page_properties, 1 );
		foreach( $images_properties as $property => $value ) {
			if( $property ) {
				echo "\tbackground-{$property}: {$value};\n";
			}
		}
		echo "}\n\n";
	}
}
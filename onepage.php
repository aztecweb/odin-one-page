<?php
/**
 * Odin One Page structure.
 *
 * This is the main file when de one page is supported. All pages are loaded
 * from this file.
 *
 * @package Odin
 * @since 
 * 
 * @global WP_Post[] $odin_onepage_pages The pages of the main menu.
 * @global WP_Post $post The current post in the loop.
 */

global $odin_onepage_pages;
global $post;

get_header();


foreach( $odin_onepage_pages as $item ) {
	query_posts( "page_id=" . $item->ID );
	
	$onepage = true;
	require get_page_template();
} 
wp_reset_query();


get_footer();
<?php

require_once get_template_directory() . '/core/classes/class-metabox.php';

/**
 * Add metaboxes to the post-types
 * 
 * Page Background: Add option to use a custom background in the page. 
 * 
 */
function odin_onepage_metaboxes() {
	$page_background_metabox = new Odin_Metabox(
			'page_background', 
			__( 'Background', 'odin-onepage' ),
			'page',
			'normal',
			'high'
	);
	$page_background_metabox->set_fields(
			array(
					array(
							'id' => 'page_background_color',
							'label' => __( 'Color', 'odin-onepage' ),
							'type' => 'color',
							'description' => __( 'The background color.', 'odin-onepage' ),
					),
					array(
							'id' => 'page_background_image',
							'label' => __( 'Image', 'odin-onepage' ),
							'type' => 'image',
							'description' => __( 'The background image.', 'odin-onepage' ),
					),
					array(
							'id' => 'page_background_repeat',
							'label' => __( 'Repeat', 'odin-onepage' ),
							'type' => 'select',
							'description' => __( 'The background image repeat property.', 'odin-onepage' ),
							'options' => array(
									'repeat' => __( 'Repeat', 'odin-onepage' ),
									'repeat-x' => __( 'Repeat X', 'odin-onepage' ),
									'repeat-y' => __( 'Repeat Y', 'odin-onepage' ),
									'no-repeat' => __( 'No Repeat', 'odin-onepage' ),
							),
					),
					array(
							'id' => 'page_background_position',
							'label' => __( 'Position', 'odin-onepage' ),
							'type' => 'select',
							'description' => __( 'The background image position property.', 'odin-onepage' ),
							'options' => array(
									'left_top' => __( 'Left Top', 'odin-onepage' ),
									'left_center' => __( 'Left Center', 'odin-onepage' ),
									'left_bottom' => __( 'Left Bottom', 'odin-onepage' ),
									'center_top' => __( 'Center Top', 'odin-onepage' ),
									'center_center' => __( 'Center Center', 'odin-onepage' ),
									'center_bottom' => __( 'Center Bottom', 'odin-onepage' ),
									'right_top' => __( 'Right Top', 'odin-onepage' ),
									'right_center' => __( 'Right Center', 'odin-onepage' ),
									'right_bottom' => __( 'Right Bottom', 'odin-onepage' ),
							),
					),
					array(
							'id' => 'page_background_attacment',
							'label' => __( 'Attachment', 'odin-onepage' ),
							'type' => 'select',
							'description' => __( 'The background image attachment property.', 'odin-onepage' ),
							'options' => array(
									'scroll' => __( 'Scroll', 'odin-onepage' ),
									'fixed' => __( 'Fixed', 'odin-onepage' ),
									'local' => __( 'Local', 'odin-onepage' ),
							),
					),
			)
	);
}

add_action( 'init', 'odin_onepage_metaboxes', 1 );
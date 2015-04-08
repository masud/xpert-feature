<?php
/*
Plugin Name: Xpert Feature
Plugin URI: http://themexpert.com/wordpress-plugins/xpert-team
Version: 1.0
Author: ThemeXpert
Authro URI : http://www.themexpert.com
Description: Supercharge your WordPress team plugin
License: GPLv2 or later
Text Domain: xf
*/



add_action('init', 'metabox_menu_register');
	function metabox_menu_register(){
	register_post_type('products',[
		'label'=> 'Products',
		'show_ui' => true,
		'has_archive' => true
		]);

}


add_action('add_meta_boxes', 'metabox_field_details');
	function metabox_field_details(){
	add_meta_box(
		'more-details',
		'More Details',
		function(){},
		'products'
		);
}


// function prfx_custom_meta() {
//     add_meta_box( 

//     	'custom_meta_box_id',
//     	'Product Section',
//     	'meta_box_callback_funct',
//     	'post',
//     	'normal'
//      );
// }
// add_action( 'add_meta_boxes', 'prfx_custom_meta' );

// function meta_box_callback_funct(){
	
// }






?>

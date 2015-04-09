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

add_action( 'init', 'codex_book_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_book_init() {
	$labels = array(
		'name'               => _x( 'Books', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Book', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Books', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor','thumbnail' )
	);

	register_post_type( 'book', $args );
}


    function metaboxes() {
        add_action('add_meta_boxes', function() {
            add_meta_box('tx_feature', 'Additional Settings', 'tx_settings', 'book');
        });

        function tx_settings($post) {
            $id = $post->ID;
            $tx_title        = get_post_meta($id, 'tx_title', true);
            $tx_url         = get_post_meta($id, 'tx_url', true);
            $tx_position      = get_post_meta($id, 'tx_position', true);

            ?>
            <style>
            #tx_feature table { width: 100%; }
            #tx_feature td.custom-title { width: 30%; height: 28px; }
            </style>
            <table class="custom-table">
                <tr>
                    <td class="custom-title"><label for="tx_title">Testo Bottone</label></td>
                    <td class="custom-input">
                        <input type="text" class="widefat" id="tx_title" name="tx_title" value="<?php echo esc_attr($tx_title); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="custom-title"><label for="tx_url">URL</label></td>
                    <td class="custom-input">
                        <input type="text" class="widefat" id="tx_url" name="tx_url" value="<?php echo esc_attr($tx_url); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="custom-title"><label for="tx_position">Posizione</label></td>
                    <td class="custom-input">
                        <select id="tx_position" name="tx_position">
                            <option value="right" <?php if($tx_position == 'right') echo 'selected="selected"'; ?>>Right</option>
                            <option value="left" <?php if($tx_position == 'left') echo 'selected="selected"'; ?>>Left</option>                           
                        </select>
                    </td>
                </tr>
            </table>

            <?php

        }

        add_action('save_post', 'tx_save');

        function tx_save($id) {
            if(!empty($_POST['tx_title']))
                update_post_meta($id, 'tx_title', $_POST['tx_title']) || add_post_meta($id, 'tx_title', $_POST['tx_title']);
            if(!empty($_POST['tx_url']))
                update_post_meta($id, 'tx_url', $_POST['tx_url']) || add_post_meta($id, 'tx_url', $_POST['tx_url']);
            if(!empty($_POST['tx_position']))
                update_post_meta($id, 'tx_position', $_POST['tx_position']) || add_post_meta($id, 'tx_position', $_POST['tx_position']);
        }


    }


add_action( 'init', 'metaboxes' );




global $tx_title;
global $tx_url;
global $tx_position;
global $id;

 
 
 
$tx_title = get_post_meta($id, 'tx_title', true);
$tx_url = get_post_meta($id, 'tx_url', true);
$tx_position = get_post_meta($id, 'tx_position', true);
var_dump($tx_title);
 
if(!empty($tx_url))
	echo do_shortcode('[tx_feature link="'.$tx_url.'" float="'.$tx_position.'"]'.$tx_title.'[/tx_feature]');
 
add_shortcode('tx_feature', function($atts, $content) {
	global $post;
	global $id;
 
    $atts = shortcode_atts(
        array(
            'float'     => 'right',
            'link'      => '',
            'styles'    => '',
            'content'   => !empty($content)? $content : 'Scarica allegato'
        ), $atts
    );
 
    extract($atts);
 echo get_post_meta($id, 'tx_title', true);
 echo get_post_meta($id, 'tx_url', true);
 echo get_post_meta($id, 'tx_position', true);
    if(!empty($link)) {
        $btn = '
            <div class="dbtn_dwn">
                <a href="'.$link.'" class="dwn_button" style="float:'.$float.';'.$styles.'">'.$content.'<span class="dwn_arrow"></span></a>
            </div>
        ';
        return $btn;
    } else {
        return false;
    }
});
 
 
 
 
 
 
 
 
add_action( 'admin_enqueue_scripts', 'FeatureBackendScripts' );
function FeatureBackendScripts(){
 
wp_enqueue_script('image-picker-js', plugins_url('assets/vendor/image-picker/js/image-picker.js',__FILE__));
wp_enqueue_style('image-picker-css', plugins_url('assets/vendor/image-picker/css/image-picker.css', __FILE__));
 
}




?>
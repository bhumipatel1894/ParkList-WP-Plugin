<?php
/**
 * Register Post type functionality
 *
 * @package Parks Directory
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Function to register post type
 *
 * @since 1.0.0
 */
function pd_register_post_type() {

	// Create new Parks custom post type
	$pd_labels = array(
		'name'						=> __( 'Parks', 'parks-directory' ),
		'singular_name'				=> __( 'Park', 'parks-directory' ),
		'add_new'					=> __( 'Add Park', 'parks-directory' ),
		'add_new_item'				=> __( 'Add New Park', 'parks-directory' ),
		'edit_item'					=> __( 'Edit Park', 'parks-directory' ),
		'new_item'					=> __( 'New Park', 'parks-directory' ),
		'view_item'					=> __( 'View Park', 'parks-directory' ),
		'search_items'				=> __( 'Search Park', 'parks-directory' ),
		'not_found'					=> __( 'No Park Items found', 'parks-directory' ),
		'not_found_in_trash'		=> __( 'No Park Items found in Trash', 'parks-directory' ),
		'parent_item_colon'			=> '',
		'menu_name'					=> __( 'Parks', 'parks-directory' ),
		'set_featured_image'		=> __( 'Set Park Image', 'parks-directory' ),
		'featured_image'			=> __( 'Park Image', 'parks-directory' ),
		'remove_featured_image'		=> __( 'Remove Park Image', 'parks-directory' ),
		'use_featured_image'		=> __( 'Use as Park image', 'parks-directory' ),
		'items_list'				=> __( 'Parks list.', 'parks-directory' ),
		'item_published'			=> __( 'Park published.', 'parks-directory' ),
		'item_published_privately'	=> __( 'Park published privately.', 'parks-directory' ),
		'item_reverted_to_draft'	=> __( 'Park scheduled.', 'parks-directory' ),
		'item_scheduled'			=> __( 'Park reverted to draft.', 'parks-directory' ),
		'item_updated'				=> __( 'Park updated.', 'parks-directory' ),
		'item_link'					=> __( 'Park Link', 'parks-directory' ),
		'item_link_description'		=> __( 'A link to a Park.', 'parks-directory' ),
	);

	$pd_args = array(
							'labels'				=> $pd_labels,
							'public'				=> true,
							'publicly_queryable'	=> true,
							'exclude_from_search'	=> false,
							'show_ui'				=> true,
							'show_in_menu'			=> true, 
							'query_var'				=> true,
							'rewrite'				=> array(
															'slug'			=> apply_filters( 'pd_Park_post_slug', 'park' ),
															'with_front'	=> false
														),
	'capability_type'	=> 'post',
	'has_archive'		=> true,
	'hierarchical'		=> false,
	'show_in_rest'		=> true,
	'menu_icon'			=> 'dashicons-palmtree',
	'supports'			=> array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author', 'publicize' ),
	'taxonomies'		=> array( 'post_tag' )
);

	register_post_type( PD_POST_TYPE, apply_filters( 'pd_registered_post_type_args', $pd_args ) );
}
add_action( 'init', 'pd_register_post_type' );

/**
* Function to register taxonomy
*
* @since 1.1.7
*/
function pd_register_taxonomies() {

	$labels = array(
		'name'				=> __( 'Facilities', 'parks-directory' ),
		'singular_name'		=> __( 'Facility', 'parks-directory' ),
		'search_items'		=> __( 'Search Facility', 'parks-directory' ),
		'all_items'			=> __( 'All Facility', 'parks-directory' ),
		'parent_item'		=> __( 'Parent Facility', 'parks-directory' ),
		'parent_item_colon'	=> __( 'Parent Facility:', 'parks-directory' ),
		'edit_item'			=> __( 'Edit Facility', 'parks-directory' ),
		'update_item'		=> __( 'Update Facility', 'parks-directory' ),
		'add_new_item'		=> __( 'Add New Facility', 'parks-directory' ),
		'new_item_name'		=> __( 'New Facility Name', 'parks-directory' ),
		'menu_name'			=> __( 'Park Facility', 'parks-directory' ),
	);

	$args = array(
				'labels'			=> $labels,
				'hierarchical'		=> true,
				'show_ui'			=> true,
				'show_in_menu' 		=> true,
				'show_admin_column'	=> true,
				'show_tagcloud' 	=> true,
				'query_var'			=> true,
				'show_in_rest'		=> true,
				'rewrite'			=> array( 'slug' => apply_filters( 'pd_Park_cat_slug', 'facility' ) ),
	);

	register_taxonomy( 'facilities', 'parks', $args );
}
add_action( 'init', 'pd_register_taxonomies' );
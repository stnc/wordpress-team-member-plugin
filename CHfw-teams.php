<?php
/*
	Plugin Name: Nucleon Team
	Plugin URI: 
	Description: Team Members plugin for the Nucleon theme.
	Version: 1.3.0
	Author: Chrom Themes

	Text Domain: CHfw-teams
	Domain Path: /languages/
*/



define( 'CHfw_PATH', plugin_dir_path( __FILE__ ) . 'includes/' );

// Load plugin text-domain

 $locale = apply_filters( 'plugin_locale', get_locale(), 'CHfw-teams' );

load_textdomain( 'CHfw-teams', WP_LANG_DIR . 'CHfw-teams/CHfw-teams-' . $locale . '.mo' );
load_plugin_textdomain( 'CHfw-teams', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );



function CHfw_register_post_type_team()
{
    $singular =  'Team';
    $plural = __('Team','CHfw-teams');
    $slug = str_replace(' ', '_', strtolower($singular));
    $labels = array(
        'name' => $plural,
        'singular_name' => $singular,
        'add_new' => __('Add New','CHfw-teams'),
        'add_new_item' =>  __('Add New Team Member','CHfw-teams'),
        'edit' => __('Edit','CHfw-teams'),
        'edit_item' =>  __('Edit Team Member','CHfw-teams'),
        'new_item' =>   __('New Team Member','CHfw-teams'),
        'view' => __('View Team Member','CHfw-teams'),
        'view_item' => __('View Team Member','CHfw-teams'),
        'search_term' =>  __('Search Team Member','CHfw-teams'),
        'parent' =>  __('Parent Team Member','CHfw-teams'),
        'not_found' => 'No Team Member found',
        'not_found_in_trash' => 'No Team Member in Trash'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-businessman',
        'can_export' => true,
        'delete_with_user' => false,
        'hierarchical' => false,
        'has_archive' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        // 'capabilities' => array(),
        'rewrite' => array(
          //  'slug' => $slug,
            'with_front' => true,
            'pages' => true,
            'feeds' => true
        ),
        'supports' => array(
            'title',
            'editor',
            'revisions',
            'thumbnail',
        )
    );
    register_post_type($slug, $args);
}
add_action('init', 'CHfw_register_post_type_team');



require (CHfw_PATH."class-team-member.php");
add_image_size('CHfw-teamImageSize', 240, 310, true);

// Visual composer init
require( CHfw_PATH . 'visual-composer/init.php' );



<?php
/*
Plugin Name:Chrom Themes Team
Plugin URI:
Description: Team Members plugin for the Nucleon theme.
Version: 1.11.16
Author: Chrom Themes
Text Domain: CHfw-team
Domain Path: /languages/
*/
define( 'CHfw_team_PATH', plugin_dir_path( __FILE__ ) . 'includes/' );

// Load plugin text-domain

$locale = apply_filters( 'plugin_locale', get_locale(), 'CHfw-team' );

load_textdomain( 'CHfw-team', WP_LANG_DIR . 'CHfw-team/CHfw-team-' . $locale . '.mo' );
load_plugin_textdomain( 'CHfw-team', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );


function CHfw_register_post_type_team() {
    $singular = 'team';
    $plural   = __( 'team', 'CHfw-team' );
    $slug     = str_replace( ' ', '_', strtolower( $singular ) );
    $labels   = array(
        'name'               => $plural,
        'singular_name'      => $singular,
        'add_new'            => __( 'Add New', 'CHfw-team' ),
        'add_new_item'       => __( 'Add New team ', 'CHfw-team' ),
        'edit'               => __( 'Edit', 'CHfw-team' ),
        'edit_item'          => __( 'Edit team ', 'CHfw-team' ),
        'new_item'           => __( 'New team ', 'CHfw-team' ),
        'view'               => __( 'View team ', 'CHfw-team' ),
        'view_item'          => __( 'View team ', 'CHfw-team' ),
        'search_term'        => __( 'Search team ', 'CHfw-team' ),
        'parent'             => __( 'Parent team ', 'CHfw-team' ),
        'not_found'          => 'No team  found',
        'not_found_in_trash' => 'No team in Trash',
    
    );
    $args     = array(
        'label'               => 'team',
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'show_in_nav_menus'   => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => 'dashicons-businessman',
        'can_export'          => true,
        'delete_with_user'    => false,
        'hierarchical'        => true,
        'show_in_nav_menus'   => false,
        'has_archive'         => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'map_meta_cap'        => true,
        'capabilities'        => array(),
        'rewrite'             => array(
            'slug'         => 'team',
            'with_front'   => false,
            'pages'        => true,
            'hierarchical' => true,
            'feeds'        => true
        ),
        
        'supports' => array(
            'title',
            'excerpt',
            'editor',
            'thumbnail',
        )
    );
    
    register_post_type( $slug, $args );
    
}

add_action( 'init', 'CHfw_register_post_type_team' );


require( CHfw_team_PATH . "class-team-member.php" );

add_image_size( 'CHfw-teamImageSize', 240, 310, true );


if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'CHfw-teamPostSize', 320, 320, false );
}


$CHfw_team_ch_postID = isset( $_GET['post'] ) ? $_GET['post'] : null;//post  id  for edit

$CHfw_team_post_type_ch = get_post_type( $CHfw_team_ch_postID );//get type

$CHfw_team_post_type_post = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : 'post';//for new

if ( $CHfw_team_post_type_post == 'team' or $CHfw_team_post_type_ch == 'team' ) {
    if ( is_admin() ) {
        add_action( 'load-post.php', 'CHfw_team_init_metabox' );
        add_action( 'load-post-new.php', 'CHfw_team_init_metabox' );
    }
}



/*------------------UPDATE team---------------------*/

//add_action( 'publish_team', 'team_schedule_team_expiration_event_insert' );
function team_schedule_team_expiration_event_insert( $post_id ) {
    // Schedule the actual event
    //wp_schedule_single_event( 30 * DAY_IN_SECONDS, 'updateCategories_team_after_expiration_V1', array( $post_id ) );//insert
    updateCategories_team_after_expiration_V1( $post_id );
    write_log("run");
    
}


add_action( 'updateCategories_team_after_expiration', 'updateCategories_team_after_expiration', 10, 1 );
// This function will run once the 'addCategories_team_after_expiration' is called


function updateCategories_team_after_expiration( $post_id ) {
    
    global $wpdb;
    
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( wp_is_post_autosave( $post_id ) ) {
        return;
    }
    
    // Check if not a revision.
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    
    $term_cal = term_exists( 'Auto Draft', 'booked_custom_calendars' );
    if ( $term_cal !== 0 && $term_cal !== null ) {
        wp_delete_term( $term_cal['term_id'], 'booked_custom_calendars' );
    }
    
    $term_event = term_exists( 'Auto Draft', 'mp-event_category' );
    if ( $term_event !== 0 && $term_event !== null ) {
        wp_delete_term( $term_event['term_id'], 'mp-event_category' );
    }
    
    $post_title            = get_the_title( $post_id );
    
    $display_before_title = get_post_meta( $post_id, 'wow_BeforeTitle' );
    
    if ( count( $display_before_title ) > 0 ) {
        $display_before_title = $display_before_title[0];
    } else {
        $display_before_title = null;
    }
    
    $term_event_id = term_exists( $post_title, 'mp-event_category' );
    if ( $term_event_id !== 0 && $term_event_id !== '' ) {
        $eklenen_term_id = isset( $term_event_id['term_id'] ) ? $term_event_id['term_id'] : 0;
    }
    //buranın amacı term daha oluşmuş mu ona bakar eğer oluşmuşsa oluşturmaz
    $booked_custom_calendars_term         = term_exists( $post_title, 'booked_custom_calendars' );
    $eklenen_booked_custom_calendars_term = 0;
    if ( $booked_custom_calendars_term !== 0 && $booked_custom_calendars_term !== "" ) {
        $eklenen_booked_custom_calendars_term = isset( $booked_custom_calendars_term['term_id'] ) ? $booked_custom_calendars_term['term_id'] : 0;
    }

//daha once eklenmemiş yani burada ilk ekleme de wow_BeforeTitle oluşmaz savebefore değeridir
    if ( empty( $display_before_title ) ) {
        
        $args = array(
            'description' => "team plugin ; Automatic Value: " . $post_title . "",
            'slug'        => $post_title,
        );
//buranın amacı term daha oluşmuş mu ona bakar eğer oluşmuşsa oluşturmaz
        
        
        $term_event_id = wp_insert_term( $post_title, "mp-event_category", $args );
        $eklenen_term_id = isset( $term_event_id['term_id'] ) ? $term_event_id['term_id'] : 0; //yeni eklenen term bilgisini gönder
        
        $booked_custom_calendars_term=wp_insert_term( $post_title, "booked_custom_calendars", $args );
        $eklenen_booked_custom_calendars_term = isset( $booked_custom_calendars_term['term_id'] ) ? $booked_custom_calendars_term['term_id'] : 0;
        
        
    } //olay burada kırılacak burada insert yapacak ,yani burası ilk insert olayı olacak yer olsun
    else {
        //1 yeni yazılan ile eskisi farklı mı
        //isim (post) üzerinden term exist yap
        //eğer farklı ise
        //1 appoinmtetn calendar a bak -bunu güncelle
        // 2- ve timetable evnt e bak  --bak bunu guncelle
        //yoksa ve yeni ise term_insert
        
        //buraya girerse title değişmiştir post title değişen değerdir eski değeri($display_before_title) term_exist yapıp
        if ( $display_before_title != $post_title ) {
            $term_control_event_category = term_exists( $display_before_title, 'mp-event_category' );
            wp_update_term( $term_control_event_category['term_id'], 'mp-event_category', array(
                'name' => $post_title,
                'slug' => $post_title
            ) );
            
            //booked_custom_calendars taxonomy change
            $term_control_booked_custom_calendars = term_exists( $display_before_title, 'booked_custom_calendars' );
            wp_update_term( $term_control_booked_custom_calendars['term_id'], 'booked_custom_calendars', array(
                'name' => $post_title,
                'slug' => $post_title
            ) );
        }
    }
    $cat_ids = array();
    
    $selected_departman_id = CHfw_get_meta( $post_id, 'display_doctor_department', 'CHfw_DoctorAndDepartmant_ForSingleteamPage' );
    
    if ( $selected_departman_id != false ) { //yani değer boş gelmemeiş ise --u yuzden wp_schedule_single_event() kullandım
        $selected_departman_id = (int) $selected_departman_id;
    }
    
    if ( is_int( $selected_departman_id ) ) {
//secilen departmanın bulur
        echo $sql = "SELECT t.*, tt.* FROM " . $wpdb->prefix . "terms AS t
	INNER JOIN " . $wpdb->prefix . "term_taxonomy AS tt ON (tt.term_id = t.term_id)
	INNER JOIN " . $wpdb->prefix . "term_relationships AS tr ON (tr.term_taxonomy_id = tt.term_taxonomy_id)
	WHERE tt.taxonomy IN ('mp-event_category') AND tr.object_id IN (" . $selected_departman_id . ")
	ORDER BY t.name ASC;";
        $cat_ids = $wpdb->get_col( $sql );
    }
    
    //burası event de bulunana evnt categories e atama yapar
    array_push( $cat_ids, $eklenen_term_id );
    wp_set_post_terms( $selected_departman_id, $cat_ids, 'mp-event_category' );
    //events de bulunan metabox kullanıyor (doctor selected olan )
    $daha_once_eklene_degerler = get_post_meta( $selected_departman_id, 'CHfw_mpevent_departmentForSingleEventPage' );
    $dilimler = explode( ",", $daha_once_eklene_degerler[0] );
    array_push( $dilimler, $eklenen_booked_custom_calendars_term );
    $daha_once_eklene_degerler = implode( ",", $dilimler );
    update_post_meta( $selected_departman_id, 'CHfw_mpevent_departmentForSingleEventPage', $daha_once_eklene_degerler );
}


//  runs when a Post is update
add_action( 'publish_team', 'team_schedule_team_expiration_event_update' );
function team_schedule_team_expiration_event_update( $post_id ) {
    // Schedule the actual event
    //updateCategories_team_after_expiration( $post_id );
    wp_schedule_single_event( strtotime( "+2 seconds" ), 'updateCategories_team_after_expiration', array( $post_id ) );
}


//TODO kalan problemeler
//1- event cat ve custom calandar dan bir tane data silinirse team da kalana  ne olacak
//2--team ın departmanı değişmişse event deki categorilerden kaldırılıp ,değişen yeni kategorisne eklenmeli
//wow ismi yerine plugine uyan bir isim olmalı team-stnc gibi bla bla
// verify if this is an auto save routine.
// If it is our form has not been submitted, so we dont want to do anything
add_action( 'pre_post_update', 'post_updating_callback' );
function post_updating_callback( $post_id ) {
    global $post;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( $post->post_status == "publish" && $post->post_type == "team" ) {
        //$postarr = get_post($post_id,'ARRAY_A');
        $display_before_title_read = get_the_title( $post_id );
        
        
        update_post_meta( $post_id, 'wow_BeforeTitle', $display_before_title_read );
        
    }
}






require ("CHfw-team-metabox-options.php");







<?php

/***SIDEBAR Doctor select METABOX (ONLY team )****/
function Nuc_doctor_selected_get_meta( $value ) {
	global $post;

	$field = get_post_meta( $post->ID, 'Nuc_DoctorAndDepartmant_ForSingleteamPage', true );
	if ( ! empty( $field ) ) {
		if ( array_key_exists( $value, $field ) ) {
			$field = $field[ $value ];
		} else {
			return '';
		}
	}

	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}

}

function Nuc_doctor_selected_add_meta_box() {
	add_meta_box(
		'Nuc_DoctorAndDepartmant_ForSingleteamPage_metabox',
		__( 'Doctor Selected & Department', 'doctor_selected' ),
		'Nuc_doctor_selected_html',
		'team',
		'side',
		'default'
	);
}


function Nuc_doctor_selected_html( $post ) {
	wp_nonce_field( '_doctor_selected_nonce', 'doctor_selected_nonce' ); ?>
	<label for="display_doctor_department">
        <?php
        _e( 'Department:', 'CHfw-team' );
        $mp_events                         = array(
	        'offset'         => 1,
	        'post_type'      => 'mp-event',
	        'posts_per_page' => - 1,
	        'numberposts'    => - 1,
	        "orderby"        => "post_date",
	        "order"          => "DESC",
	        "post_status"    => "publish"
        );
        $myposts_display_doctor_department = get_posts( $mp_events );

        ?>
    </label>
	<br>
	<select name="display_doctor_department" id="display_doctor_department">
        <?php foreach ( $myposts_display_doctor_department as $mypost ) { ?>
	        <option
		        value="<?php echo $mypost->ID ?>" <?php echo ( Nuc_doctor_selected_get_meta( 'display_doctor_department' ) == $mypost->ID ) ? 'selected' : '' ?> ><?php echo $mypost->post_title ?></option>
        <?php } ?>
    </select>

	<br>
	<label for="display_doctor_calendar_select">
        <?php
        _e( 'Calendar to Display Doctor:', 'CHfw-team' );
        $calendars = get_terms( 'booked_custom_calendars', 'orderby=slug&hide_empty=0' );
        ?>
    </label>
	<br>
	<select name="display_doctor_calendar_select" id="display_doctor_calendar_select">
        <?php foreach ( $calendars as $cal ) { ?>
	        <option
		        value="<?php echo $cal->term_id ?>" <?php echo ( Nuc_doctor_selected_get_meta( 'display_doctor_calendar_select' ) == $cal->term_id ) ? 'selected' : '' ?> ><?php echo $cal->name ?></option>
        <?php } ?>
    </select>
	<?php
}

function Nuc_doctor_selected_save( $post_id ) {
	//post fields
	$fields = array(
		'fields' => array(
			array(
				'name' => 'display_doctor_calendar_select',
			),
			array(
				'name' => 'display_doctor_department',
			)
		)
	);

	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	// Check if not a revision.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	// Stop the script when doing autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	$post_meta_ = array();

	foreach ( $fields['fields'] as $key => $field ) {
		$post_meta_[ $field['name'] ] = isset( $_POST[ $field['name'] ] ) ? $_POST[ $field['name'] ] : '';
	}

	update_post_meta( $post_id, 'Nuc_DoctorAndDepartmant_ForSingleteamPage', $post_meta_ );

}


/*register metabox */
function Nuc_team_init_metabox() {
	// add meta box
	add_action( 'add_meta_boxes', 'Nuc_doctor_selected_add_meta_box' );
	// metabox save
	add_action( 'save_post', 'Nuc_doctor_selected_save' );
}

/*team pagination fix*/
$scFW_teamLimit_posts = isset( $Nuc_rdx_options['team_limit_posts'] ) ? $Nuc_rdx_options['team_limit_posts'] : 5;

function Nuc_team_posts_per_page( $query ) {
	global $scFW_teamLimit_posts;
	if ( isset( $query->query_vars['post_type'] ) ) {
		if ( $query->query_vars['post_type'] == 'team' ) {
			$query->query_vars['posts_per_page'] = $scFW_teamLimit_posts;
		}
	}

	return $query;
}

if ( ! is_admin() ) {
	add_filter( 'pre_get_posts', 'Nuc_team_posts_per_page' );
}
/***SIDEBAR Doctor select METABOX (ONLY team-LOCATIONS )****/

 /*comign soon****/
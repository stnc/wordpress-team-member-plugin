<?php
$Nuc_themeName               = 'CHfw-';//for include data
$Nuc_prefix_team            = $Nuc_themeName . "teamSetting_";
$Nuc_OptionsPageSettingteam = array(
	'name'     => $Nuc_prefix_team . 'meta-box-page',
	'nonce'    => 'st_studio_team',
	'title'    => __( 'Doctor Info', 'chthemes-team' ),
	'page'     => 'team',
	//'context' => 'side',
	'context'  => 'normal',
	'priority' => 'default',
	'class'    => '',
	'style'    => '',
	'title_h2' => true,
	'fields'   => array(

		array(
			'name'        => $Nuc_prefix_team . 'title',
			'title'       => __( 'Title', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter title ", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'gender',
			'title'       => __( 'Gender of doctor', 'chthemes-team' ),
			'type'        => 'select',
			'description' => __( "Select gender", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
			'options'     => array(
				'male'   => __( 'Male', 'chfw-lang' ),
				'female' => __( 'Female', 'chfw-lang' ),
			)
		),

		array(
			'name'        => $Nuc_prefix_team . 'birth',
			'title'       => __( 'Date of birth', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter date of birth.", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'adress',
			'title'       => __( 'Adress ', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter Adress", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'email',
			'title'       => __( 'Email', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter email adress", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'phone',
			'title'       => __( 'Phone', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter phone", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),

		array(
			'name'        => $Nuc_prefix_team . 'website',
			'title'       => __( 'Website', 'chthemes-team' ),
			'type'        => 'text',
			'description' => __( "Enter team member's Google+ profile URL.", 'chthemes-team' ),
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),

		array(
			'name'        => 'page_header_type_info',
			'title'       => __( 'Professional Skills', 'chfw-lang' ),
			'type'        => 'info',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
			'extra'       => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'expertise',
			'title'       => __( 'Expertise', 'chthemes-team' ),
			'type'        => 'text',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),
		array(
			'name'        => $Nuc_prefix_team . 'education',
			'title'       => __( 'Education', 'chthemes-team' ),
			'type'        => 'textarea',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),


		array(
			'name'        => $Nuc_prefix_team . 'degree',
			'title'       => __( 'Degree', 'chthemes-team' ),
			'type'        => 'text',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),


		array(
			'name'        => $Nuc_prefix_team . 'experience',
			'title'       => __( 'Experience', 'chthemes-team' ),
			'type'        => 'text',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),


		array(
			'name'        => $Nuc_prefix_team . 'profession',
			'title'       => __( 'Profession', 'chthemes-team' ),
			'type'        => 'text',
			'description' => '',
			'style'       => '',
			'class'       => '',
			'class_li'    => '',
		),


	)
);





/*LOCATIONS */

$Nuc_themeName               = 'CHfw-';//for include data
$Nuc_prefix_team            = $Nuc_themeName . "teamLocationOpt_";
$Nuc_OptionsPageSettingteamLocaiton = array(
		'name'     => $Nuc_prefix_team . 'meta-box-page',
		'nonce'    => 'st_studio_team',
		'title'    => __( 'Location Info', 'chthemes-team' ),
		'page'     => 'team_location',
		'context'  => 'normal',
		'priority' => 'default',
		'class'    => '',
		'style'    => '',
		'title_h2' => true,
		'fields'   => array(

				array(
						'name'        => $Nuc_prefix_team . 'birth',
						'title'       => __( 'Adress', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter adress info", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),
				array(
						'name'        => $Nuc_prefix_team . 'title',
						'title'       => __( 'Zip Code', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter zip code", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),


				array(
						'name'        => $Nuc_prefix_team . 'adress',
						'title'       => __( 'Map directions', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter map directions (Google Map)", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),
				array(
						'name'        => $Nuc_prefix_team . 'email',
						'title'       => __( 'Email', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter email adress", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),
				array(
						'name'        => $Nuc_prefix_team . 'phone',
						'title'       => __( 'Phone', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter phone", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),

				array(
						'name'        => $Nuc_prefix_team . 'website',
						'title'       => __( 'Website', 'chthemes-team' ),
						'type'        => 'text',
						'description' => __( "Enter team member's Google+ profile URL.", 'chthemes-team' ),
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),



				array(
						'name'        => $Nuc_prefix_team . 'education',
						'title'       => __( 'Patient', 'chthemes-team' ),
						'type'        => 'textarea',
						'description' => '',
						'style'       => '',
						'class'       => '',
						'class_li'    => '',
				),

				array(
						'name' => $Nuc_prefix_team . 'media',
						'title' => __('Images','chfw-lang'),
						'type' => 'media-gallery',
						'description' => __('Select a custom uploaded image.','chthemes-team'),
						'style' => 'color:#fff;box-shadow:none;',
						'extra' =>'',
						'class_li' =>'',
						'class' => '',
				)


		)
);

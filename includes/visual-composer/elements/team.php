<?php

// VC element: team
vc_map( array(
		'name'			=> __( 'Team', 'CHfw-teams' ),
		'category'		=> __( 'CH Content', 'CHfw-teams' ),
		'description'	=> __( 'Team members grid', 'CHfw-teams' ),
		'base'			=> 'chfw_team',
		'icon'			=> 'fa fa-cubes',
		'params'			=> array(
				array(
						'type' 			=> 'dropdown',
						'heading' 		=> __('Columns', 'CHfw-teams' ),
						'param_name' 	=> 'columns',
						'description'	=> __( 'Select columns', 'CHfw-teams' ),
						'value' 		=> array(
								'2 Column'	=> '6',
								'3 Column'	=> '4',
								'4 Column'	=> '3',
								'6 Column'	=> '2'
						)
				),
				array(
						'type' 			=> 'textfield',
						'heading' 		=> __( 'Items', 'CHfw-teams' ),
						'param_name' 	=> 'items',
						'description'	=> __( 'Number of items to display.', 'CHfw-teams' )
				),


		)
) );
	
<?php
$CHfw_themeName = 'CHfw-';//for include data 
$CHfw_prefix_team = $CHfw_themeName .  "teamSetting_";
$CHfw_OptionsPageSettingTeam = array(
		'name' => $CHfw_prefix_team . 'meta-box-page',
		'nonce' => 'st_studio_team',
		'title' => __('Details','chthemes-teams'),
		'page' => 'team',
		'title_h2' => true,
		'context' => 'normal',
		'priority' => 'default',
		'class' => '',
		'style' => '',
		'fields' => array(
				array(
						'name' => $CHfw_prefix_team . 'Status',
						'title' => __('Status','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's status.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),
				array(
						'name' => $CHfw_prefix_team . 'facebook',
						'title' => __('Facebook','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's Facebook profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),
				array(
						'name' => $CHfw_prefix_team . 'twitter',
						'title' => __('Twitter','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's Twitter profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),
				array(
						'name' => $CHfw_prefix_team . 'github',
						'title' => __('Github','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's github profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),
				array(
						'name' => $CHfw_prefix_team . 'inteagram',
						'title' => __('Instagram','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's Instagram profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),

				array(
						'name' => $CHfw_prefix_team . 'googleplus',
						'title' => __('Google+','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's Google+ profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),

				array(
						'name' => $CHfw_prefix_team . 'linkedin',
						'title' => __('Linkedin','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's Linkedin profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),
				array(
						'name' => $CHfw_prefix_team . 'youtube',
						'title' => __('YouTube','chthemes-teams'),
						'type' => 'text',
						'description' => __("Enter team member's YouTube profile URL.",'chthemes-teams'),
						'style' => '',
						'class' => '',
						'class_li' =>'',
				),


		)
);

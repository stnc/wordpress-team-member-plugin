<?php

/* Visual Composer add  */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Include external shortcodes
	//if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
function CHfw_vc_register_shortcodes_Team() {
	include( CHfw_PATH . 'visual-composer/shortcodes/team.php' );
}

add_action( 'init', 'CHfw_vc_register_shortcodes_Team' );


if ( is_admin() ) {
	// Include external elements
	function CHfw_vc_register_elements_teamEl() {
		include( CHfw_PATH . 'visual-composer/elements/team.php' );
	}

	add_action( 'vc_build_admin_page', 'CHfw_vc_register_elements_teamEl' );
	// Note: Using the "vc_build_admin_page" action so external elements are added before default WooCommerce elements
}

}
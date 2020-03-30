<?php
/* Custom Feeds for Instagram support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('jude_instagram_feed_theme_setup9')) {
	add_action( 'after_setup_theme', 'jude_instagram_feed_theme_setup9', 9 );
	function jude_instagram_feed_theme_setup9() {
		if (is_admin()) {
			add_filter( 'jude_filter_tgmpa_required_plugins',		'jude_instagram_feed_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'jude_instagram_feed_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jude_filter_tgmpa_required_plugins',	'jude_instagram_feed_tgmpa_required_plugins');
	function jude_instagram_feed_tgmpa_required_plugins($list=array()) {
		if (jude_storage_isset('required_plugins', 'instagram-feed')) {
			$list[] = array(
					'name' 		=> jude_storage_get_array('required_plugins', 'instagram-feed'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		}
		return $list;
	}
}

// Check if Custom Feeds for Instagram installed and activated
if ( !function_exists( 'jude_exists_instagram_feed' ) ) {
	function jude_exists_instagram_feed() {
		return defined('SBIVER');
	}
}
?>
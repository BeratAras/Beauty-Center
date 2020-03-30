<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('jude_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'jude_booked_theme_setup9', 9 );
	function jude_booked_theme_setup9() {
		if (jude_exists_booked()) {
			add_action( 'wp_enqueue_scripts', 						'jude_booked_frontend_scripts', 1100 );
			add_filter( 'jude_filter_merge_styles',					'jude_booked_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'jude_filter_tgmpa_required_plugins',		'jude_booked_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'jude_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jude_filter_tgmpa_required_plugins',	'jude_booked_tgmpa_required_plugins');
	function jude_booked_tgmpa_required_plugins($list=array()) {
		if (jude_storage_isset('required_plugins', 'booked')) {
			$path = jude_get_file_dir('plugins/booked/booked.zip');
			if (!empty($path) || jude_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> jude_storage_get_array('required_plugins', 'booked'),
					'slug' 		=> 'booked',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
                    'version'   => '2.2.5',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'jude_exists_booked' ) ) {
	function jude_exists_booked() {
		return class_exists('booked_plugin');
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'jude_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jude_booked_frontend_scripts', 1100 );
	function jude_booked_frontend_scripts() {
		if (jude_is_on(jude_get_theme_option('debug_mode')) && jude_get_file_dir('plugins/booked/booked.css')!='')
			wp_enqueue_style( 'jude-booked',  jude_get_file_url('plugins/booked/booked.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'jude_booked_merge_styles' ) ) {
	//Handler of the add_filter('jude_filter_merge_styles', 'jude_booked_merge_styles');
	function jude_booked_merge_styles($list) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}

// Add plugin-specific colors and fonts to the custom CSS
if (jude_exists_booked()) { require_once JUDE_THEME_DIR . 'plugins/booked/booked.styles.php'; }
?>
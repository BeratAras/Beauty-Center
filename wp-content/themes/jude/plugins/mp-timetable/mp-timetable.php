<?php
/* MP Timetable support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('jude_mptt_theme_setup9')) {
	add_action( 'after_setup_theme', 'jude_mptt_theme_setup9', 9 );
	function jude_mptt_theme_setup9() {
		if (jude_exists_mptt()) {
			add_action( 'wp_enqueue_scripts', 						'jude_mptt_frontend_scripts', 1100 );
			add_filter( 'jude_filter_merge_styles',				'jude_mptt_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'jude_filter_tgmpa_required_plugins',	'jude_mptt_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'jude_mptt_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jude_filter_tgmpa_required_plugins',	'jude_mptt_tgmpa_required_plugins');
	function jude_mptt_tgmpa_required_plugins($list=array()) {
		if (jude_storage_isset('required_plugins', 'mp-timetable')) {
			$list[] = array(
					'name' 		=> jude_storage_get_array('required_plugins', 'mp-timetable'),
					'slug' 		=> 'mp-timetable',
					'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin is installed and activated
if ( !function_exists( 'jude_exists_mp_timetable' ) ) {
	function jude_exists_mptt() {
		return class_exists('Mp_Time_Table');
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'jude_mptt_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jude_mptt_frontend_scripts', 1100 );
	function jude_mptt_frontend_scripts() {
		if (jude_exists_mptt()) {
			if (jude_is_on(jude_get_theme_option('debug_mode')) && jude_get_file_dir('plugins/mp-timetable/mp-timetable.css')!='')
				wp_enqueue_style( 'mp-timetable',  jude_get_file_url('plugins/mp-timetable/mp-timetable.css'), array(), null );
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'jude_mptt_merge_styles' ) ) {
	//Handler of the add_filter('jude_filter_merge_styles', 'jude_mptt_merge_styles');
	function jude_mptt_merge_styles($list) {
		$list[] = 'plugins/mp-timetable/mp-timetable.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (jude_exists_mptt()) { require_once JUDE_THEME_DIR . 'plugins/mp-timetable/mp-timetable.styles.php'; }
?>
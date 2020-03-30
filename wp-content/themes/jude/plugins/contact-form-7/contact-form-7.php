<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('jude_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'jude_cf7_theme_setup9', 9 );
	function jude_cf7_theme_setup9() {
		
		if (jude_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'jude_cf7_frontend_scripts', 1100 );
			add_filter( 'jude_filter_merge_styles',						'jude_cf7_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'jude_filter_tgmpa_required_plugins',			'jude_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'jude_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('jude_filter_tgmpa_required_plugins',	'jude_cf7_tgmpa_required_plugins');
	function jude_cf7_tgmpa_required_plugins($list=array()) {
		if (jude_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> jude_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
			// CF7 extension - datepicker 
			if (!JUDE_THEME_FREE) {
				$params = array(
					'name' 		=> esc_html__('Contact Form 7 Datepicker', 'jude'),
					'slug' 		=> 'contact-form-7-datepicker',
                    'version'   => '2.6.0',
					'required' 	=> false
				);
				$path = jude_get_file_dir('plugins/contact-form-7/contact-form-7-datepicker.zip');
				if ($path != '')
					$params['source'] = $path;
				$list[] = $params;
			}
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'jude_exists_cf7' ) ) {
	function jude_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'jude_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'jude_cf7_frontend_scripts', 1100 );
	function jude_cf7_frontend_scripts() {
		if (jude_is_on(jude_get_theme_option('debug_mode')) && jude_get_file_dir('plugins/contact-form-7/contact-form-7.css')!='')
			wp_enqueue_style( 'contact-form-7',  jude_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'jude_cf7_merge_styles' ) ) {
	//Handler of the add_filter('jude_filter_merge_styles', 'jude_cf7_merge_styles');
	function jude_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}
?>
<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.06
 */

$jude_header_css = $jude_header_image = '';
$jude_header_video = jude_get_header_video();
if (true || empty($jude_header_video)) {
	$jude_header_image = get_header_image();
	if (jude_trx_addons_featured_image_override(true)) $jude_header_image = jude_get_current_mode_image($jude_header_image);
}

$jude_header_id = str_replace('header-custom-', '', jude_get_theme_option("header_style"));
if ((int) $jude_header_id == 0) {
	$jude_header_id = jude_get_post_id(array(
												'name' => $jude_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$jude_header_id = apply_filters('jude_filter_get_translated_layout', $jude_header_id);
}
$jude_header_meta = get_post_meta($jude_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($jude_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($jude_header_id)));
				echo !empty($jude_header_image) || !empty($jude_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($jude_header_video!='') 
					echo ' with_bg_video';
				if ($jude_header_image!='') 
					echo ' '.esc_attr(jude_add_inline_css_class('background-image: url('.esc_url($jude_header_image).');'));
				if (!empty($jude_header_meta['margin']) != '') 
					echo ' '.esc_attr(jude_add_inline_css_class('margin-bottom: '.esc_attr(jude_prepare_css_value($jude_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (jude_is_on(jude_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight jude-full-height';
				?> scheme_<?php echo esc_attr(jude_is_inherit(jude_get_theme_option('header_scheme')) 
												? jude_get_theme_option('color_scheme') 
												: jude_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($jude_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('jude_action_show_layout', $jude_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
	
?></header>
<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */


$jude_header_css = $jude_header_image = '';
$jude_header_video = jude_get_header_video();
if (true || empty($jude_header_video)) {
	$jude_header_image = get_header_image();
	if (jude_trx_addons_featured_image_override(true)) $jude_header_image = jude_get_current_mode_image($jude_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($jude_header_image) || !empty($jude_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($jude_header_video!='') echo ' with_bg_video';
					if ($jude_header_image!='') echo ' '.esc_attr(jude_add_inline_css_class('background-image: url('.esc_url($jude_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (jude_is_on(jude_get_theme_option('header_fullheight'))) echo ' header_fullheight jude-full-height';
					?> scheme_<?php echo esc_attr(jude_is_inherit(jude_get_theme_option('header_scheme')) 
													? jude_get_theme_option('color_scheme') 
													: jude_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($jude_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (jude_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');


?></header>
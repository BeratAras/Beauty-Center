<div class="front_page_section front_page_section_blog<?php
			$jude_scheme = jude_get_theme_option('front_page_blog_scheme');
			if (!jude_is_inherit($jude_scheme)) echo ' scheme_'.esc_attr($jude_scheme);
			echo ' front_page_section_paddings_'.esc_attr(jude_get_theme_option('front_page_blog_paddings'));
		?>"<?php
		$jude_css = '';
		$jude_bg_image = jude_get_theme_option('front_page_blog_bg_image');
		if (!empty($jude_bg_image)) 
			$jude_css .= 'background-image: url('.esc_url(jude_get_attachment_url($jude_bg_image)).');';
		if (!empty($jude_css))
			echo ' style="' . esc_attr($jude_css) . '"';
?>><?php
	// Add anchor
	$jude_anchor_icon = jude_get_theme_option('front_page_blog_anchor_icon');	
	$jude_anchor_text = jude_get_theme_option('front_page_blog_anchor_text');	
	if ((!empty($jude_anchor_icon) || !empty($jude_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_blog"'
										. (!empty($jude_anchor_icon) ? ' icon="'.esc_attr($jude_anchor_icon).'"' : '')
										. (!empty($jude_anchor_text) ? ' title="'.esc_attr($jude_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_blog_inner<?php
			if (jude_get_theme_option('front_page_blog_fullheight'))
				echo ' jude-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$jude_css = '';
			$jude_bg_mask = jude_get_theme_option('front_page_blog_bg_mask');
			$jude_bg_color = jude_get_theme_option('front_page_blog_bg_color');
			if (!empty($jude_bg_color) && $jude_bg_mask > 0)
				$jude_css .= 'background-color: '.esc_attr($jude_bg_mask==1
																	? $jude_bg_color
																	: jude_hex2rgba($jude_bg_color, $jude_bg_mask)
																).';';
			if (!empty($jude_css))
				echo ' style="' . esc_attr($jude_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_blog_content_wrap content_wrap">
			<?php
			// Caption
			$jude_caption = jude_get_theme_option('front_page_blog_caption');
			if (!empty($jude_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_blog_caption front_page_block_<?php echo !empty($jude_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($jude_caption); ?></h2><?php
			}
		
			// Description (text)
			$jude_description = jude_get_theme_option('front_page_blog_description');
			if (!empty($jude_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_blog_description front_page_block_<?php echo !empty($jude_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post(wpautop($jude_description)); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_blog_output"><?php 
				if (is_active_sidebar('front_page_blog_widgets')) {
					dynamic_sidebar( 'front_page_blog_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!jude_exists_trx_addons())
						jude_customizer_need_trx_addons_message();
					else
						jude_customizer_need_widgets_message('front_page_blog_caption', 'ThemeREX Addons - Blogger');
				}
			?></div>
		</div>
	</div>
</div>
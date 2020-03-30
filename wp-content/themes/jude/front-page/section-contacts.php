<div class="front_page_section front_page_section_contacts<?php
			$jude_scheme = jude_get_theme_option('front_page_contacts_scheme');
			if (!jude_is_inherit($jude_scheme)) echo ' scheme_'.esc_attr($jude_scheme);
			echo ' front_page_section_paddings_'.esc_attr(jude_get_theme_option('front_page_contacts_paddings'));
		?>"<?php
		$jude_css = '';
		$jude_bg_image = jude_get_theme_option('front_page_contacts_bg_image');
		if (!empty($jude_bg_image)) 
			$jude_css .= 'background-image: url('.esc_url(jude_get_attachment_url($jude_bg_image)).');';
		if (!empty($jude_css))
			echo ' style="' . esc_attr($jude_css) . '"';
?>><?php
	// Add anchor
	$jude_anchor_icon = jude_get_theme_option('front_page_contacts_anchor_icon');	
	$jude_anchor_text = jude_get_theme_option('front_page_contacts_anchor_text');	
	if ((!empty($jude_anchor_icon) || !empty($jude_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_contacts"'
										. (!empty($jude_anchor_icon) ? ' icon="'.esc_attr($jude_anchor_icon).'"' : '')
										. (!empty($jude_anchor_text) ? ' title="'.esc_attr($jude_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_contacts_inner<?php
			if (jude_get_theme_option('front_page_contacts_fullheight'))
				echo ' jude-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$jude_css = '';
			$jude_bg_mask = jude_get_theme_option('front_page_contacts_bg_mask');
			$jude_bg_color = jude_get_theme_option('front_page_contacts_bg_color');
			if (!empty($jude_bg_color) && $jude_bg_mask > 0)
				$jude_css .= 'background-color: '.esc_attr($jude_bg_mask==1
																	? $jude_bg_color
																	: jude_hex2rgba($jude_bg_color, $jude_bg_mask)
																).';';
			if (!empty($jude_css))
				echo ' style="' . esc_attr($jude_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$jude_caption = jude_get_theme_option('front_page_contacts_caption');
			$jude_description = jude_get_theme_option('front_page_contacts_description');
			if (!empty($jude_caption) || !empty($jude_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($jude_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo !empty($jude_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($jude_caption);
					?></h2><?php
				}
			
				// Description
				if (!empty($jude_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo !empty($jude_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($jude_description));
					?></div><?php
				}
			}

			// Content (text)
			$jude_content = jude_get_theme_option('front_page_contacts_content');
			$jude_layout = jude_get_theme_option('front_page_contacts_layout');
			if ($jude_layout == 'columns' && (!empty($jude_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ((!empty($jude_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?><div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo !empty($jude_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($jude_content);
				?></div><?php
			}

			if ($jude_layout == 'columns' && (!empty($jude_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div><div class="column-2_3"><?php
			}
		
			// Shortcode output
			$jude_sc = jude_get_theme_option('front_page_contacts_shortcode');
			if (!empty($jude_sc) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo !empty($jude_sc) ? 'filled' : 'empty'; ?>"><?php
					jude_show_layout(do_shortcode($jude_sc));
				?></div><?php
			}

			if ($jude_layout == 'columns' && (!empty($jude_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>
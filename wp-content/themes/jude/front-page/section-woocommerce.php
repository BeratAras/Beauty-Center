<div class="front_page_section front_page_section_woocommerce<?php
			$jude_scheme = jude_get_theme_option('front_page_woocommerce_scheme');
			if (!jude_is_inherit($jude_scheme)) echo ' scheme_'.esc_attr($jude_scheme);
			echo ' front_page_section_paddings_'.esc_attr(jude_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$jude_css = '';
		$jude_bg_image = jude_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($jude_bg_image)) 
			$jude_css .= 'background-image: url('.esc_url(jude_get_attachment_url($jude_bg_image)).');';
		if (!empty($jude_css))
			echo ' style="' . esc_attr($jude_css) . '"';
?>><?php
	// Add anchor
	$jude_anchor_icon = jude_get_theme_option('front_page_woocommerce_anchor_icon');	
	$jude_anchor_text = jude_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($jude_anchor_icon) || !empty($jude_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($jude_anchor_icon) ? ' icon="'.esc_attr($jude_anchor_icon).'"' : '')
										. (!empty($jude_anchor_text) ? ' title="'.esc_attr($jude_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (jude_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' jude-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$jude_css = '';
			$jude_bg_mask = jude_get_theme_option('front_page_woocommerce_bg_mask');
			$jude_bg_color = jude_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($jude_bg_color) && $jude_bg_mask > 0)
				$jude_css .= 'background-color: '.esc_attr($jude_bg_mask==1
																	? $jude_bg_color
																	: jude_hex2rgba($jude_bg_color, $jude_bg_mask)
																).';';
			if (!empty($jude_css))
				echo ' style="' . esc_attr($jude_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$jude_caption = jude_get_theme_option('front_page_woocommerce_caption');
			$jude_description = jude_get_theme_option('front_page_woocommerce_description');
			if (!empty($jude_caption) || !empty($jude_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($jude_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($jude_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($jude_caption);
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($jude_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($jude_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($jude_description));
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$jude_woocommerce_sc = jude_get_theme_option('front_page_woocommerce_products');
				if ($jude_woocommerce_sc == 'products') {
					$jude_woocommerce_sc_ids = jude_get_theme_option('front_page_woocommerce_products_per_page');
					$jude_woocommerce_sc_per_page = count(explode(',', $jude_woocommerce_sc_ids));
				} else {
					$jude_woocommerce_sc_per_page = max(1, (int) jude_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$jude_woocommerce_sc_columns = max(1, min($jude_woocommerce_sc_per_page, (int) jude_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$jude_woocommerce_sc}"
									. ($jude_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($jude_woocommerce_sc_ids).'"' 
											: '')
									. ($jude_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(jude_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($jude_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(jude_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(jude_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($jude_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($jude_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>
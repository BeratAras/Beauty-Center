<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */

$jude_footer_scheme =  jude_is_inherit(jude_get_theme_option('footer_scheme')) ? jude_get_theme_option('color_scheme') : jude_get_theme_option('footer_scheme');
$jude_footer_id = str_replace('footer-custom-', '', jude_get_theme_option("footer_style"));
if ((int) $jude_footer_id == 0) {
	$jude_footer_id = jude_get_post_id(array(
												'name' => $jude_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$jude_footer_id = apply_filters('jude_filter_get_translated_layout', $jude_footer_id);
}
$jude_footer_meta = get_post_meta($jude_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($jude_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($jude_footer_id))); 
						if (!empty($jude_footer_meta['margin']) != '') 
							echo ' '.esc_attr(jude_add_inline_css_class('margin-top: '.jude_prepare_css_value($jude_footer_meta['margin']).';'));
						?> scheme_<?php echo esc_attr($jude_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('jude_action_show_layout', $jude_footer_id);
	?>
</footer><!-- /.footer_wrap -->

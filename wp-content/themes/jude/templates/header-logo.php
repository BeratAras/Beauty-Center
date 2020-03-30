<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_args = get_query_var('jude_logo_args');

// Site logo
$jude_logo_type   = isset($jude_args['type']) ? $jude_args['type'] : '';
$jude_logo_image  = jude_get_logo_image($jude_logo_type);
$jude_logo_text   = jude_is_on(jude_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$jude_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($jude_logo_image) || !empty($jude_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '/' : esc_url(home_url('/')); ?>"><?php
		if (!empty($jude_logo_image)) {
			if (empty($jude_logo_type) && function_exists('the_custom_logo') && (int) $jude_logo_image > 0) {
				the_custom_logo();
			} else {
				$jude_attr = jude_getimagesize($jude_logo_image);
				echo '<img src="'.esc_url($jude_logo_image).'" alt="'.esc_html__('image', 'jude').'"'.(!empty($jude_attr[3]) ? ' '.wp_kses_data($jude_attr[3]) : '').'>';
			}
		} else {
			jude_show_layout(jude_prepare_macros($jude_logo_text), '<span class="logo_text">', '</span>');
			jude_show_layout(jude_prepare_macros($jude_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>
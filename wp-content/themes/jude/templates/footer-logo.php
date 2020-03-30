<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */

// Logo
if (jude_is_on(jude_get_theme_option('logo_in_footer'))) {
	$jude_logo_image = '';
	if (jude_is_on(jude_get_theme_option('logo_retina_enabled')) && jude_get_retina_multiplier(2) > 1)
		$jude_logo_image = jude_get_theme_option( 'logo_footer_retina' );
	if (empty($jude_logo_image)) 
		$jude_logo_image = jude_get_theme_option( 'logo_footer' );
	$jude_logo_text   = get_bloginfo( 'name' );
	if (!empty($jude_logo_image) || !empty($jude_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($jude_logo_image)) {
					$jude_attr = jude_getimagesize($jude_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($jude_logo_image).'" class="logo_footer_image" alt="' . esc_html__('image', 'jude') . '"'.(!empty($jude_attr[3]) ? ' ' . wp_kses_data($jude_attr[3]) : '').'></a>' ;
				} else if (!empty($jude_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($jude_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>
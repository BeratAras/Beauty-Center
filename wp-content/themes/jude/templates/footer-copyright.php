<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */

// Copyright area
$jude_footer_scheme =  jude_is_inherit(jude_get_theme_option('footer_scheme')) ? jude_get_theme_option('color_scheme') : jude_get_theme_option('footer_scheme');
$jude_copyright_scheme = jude_is_inherit(jude_get_theme_option('copyright_scheme')) ? $jude_footer_scheme : jude_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($jude_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$jude_copyright = jude_prepare_macros(jude_get_theme_option('copyright'));
				if (!empty($jude_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $jude_copyright, $jude_matches)) {
						$jude_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $jude_copyright);
					}
					// Display copyright
					echo wp_kses_post(nl2br($jude_copyright));
				}
			?></div>
		</div>
	</div>
</div>

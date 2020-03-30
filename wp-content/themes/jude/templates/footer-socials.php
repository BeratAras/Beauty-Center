<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */


// Socials
if ( jude_is_on(jude_get_theme_option('socials_in_footer')) && ($jude_output = jude_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php jude_show_layout($jude_output); ?>
		</div>
	</div>
	<?php
}
?>
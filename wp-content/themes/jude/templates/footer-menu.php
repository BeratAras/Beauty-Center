<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */

// Footer menu
$jude_menu_footer = jude_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($jude_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php jude_show_layout($jude_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>
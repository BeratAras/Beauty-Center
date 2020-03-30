<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

if (jude_sidebar_present()) {
	ob_start();
	$jude_sidebar_name = jude_get_theme_option('sidebar_widgets');
	jude_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($jude_sidebar_name) ) {
		dynamic_sidebar($jude_sidebar_name);
	}
	$jude_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($jude_out)) {
		$jude_sidebar_position = jude_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($jude_sidebar_position); ?> widget_area<?php if (!jude_is_inherit(jude_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(jude_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'jude_action_before_sidebar' );
				jude_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $jude_out));
				do_action( 'jude_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>
<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

// Header sidebar
$jude_header_name = jude_get_theme_option('header_widgets');
$jude_header_present = !jude_is_off($jude_header_name) && is_active_sidebar($jude_header_name);
if ($jude_header_present) { 
	jude_storage_set('current_sidebar', 'header');
	$jude_header_wide = jude_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($jude_header_name) ) {
		dynamic_sidebar($jude_header_name);
	}
	$jude_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($jude_widgets_output)) {
		$jude_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $jude_widgets_output);
		$jude_need_columns = strpos($jude_widgets_output, 'columns_wrap')===false;
		if ($jude_need_columns) {
			$jude_columns = max(0, (int) jude_get_theme_option('header_columns'));
			if ($jude_columns == 0) $jude_columns = min(6, max(1, substr_count($jude_widgets_output, '<aside ')));
			if ($jude_columns > 1)
				$jude_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($jude_columns).' widget', $jude_widgets_output);
			else
				$jude_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($jude_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$jude_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($jude_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'jude_action_before_sidebar' );
				jude_show_layout($jude_widgets_output);
				do_action( 'jude_action_after_sidebar' );
				if ($jude_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$jude_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>
<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.10
 */

// Footer sidebar
$jude_footer_name = jude_get_theme_option('footer_widgets');
$jude_footer_present = !jude_is_off($jude_footer_name) && is_active_sidebar($jude_footer_name);
if ($jude_footer_present) { 
	jude_storage_set('current_sidebar', 'footer');
	$jude_footer_wide = jude_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($jude_footer_name) ) {
		dynamic_sidebar($jude_footer_name);
	}
	$jude_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($jude_out)) {
		$jude_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $jude_out);
		$jude_need_columns = true;	//or check: strpos($jude_out, 'columns_wrap')===false;
		if ($jude_need_columns) {
			$jude_columns = max(0, (int) jude_get_theme_option('footer_columns'));
			if ($jude_columns == 0) $jude_columns = min(4, max(1, substr_count($jude_out, '<aside ')));
			if ($jude_columns > 1)
				$jude_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($jude_columns).' widget', $jude_out);
			else
				$jude_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($jude_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
			<div class="sc_content_width_widgets">
				<?php 
				if (!$jude_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($jude_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'jude_action_before_sidebar' );
				jude_show_layout($jude_out);
				do_action( 'jude_action_after_sidebar' );
				if ($jude_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$jude_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>
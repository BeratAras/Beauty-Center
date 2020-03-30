<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

						// Widgets area inside page content
						jude_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					jude_create_widgets_area('widgets_below_page');

					$jude_body_style = jude_get_theme_option('body_style');
					if ($jude_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$jude_footer_type = jude_get_theme_option("footer_type");
			if ($jude_footer_type == 'custom' && !jude_is_layouts_available())
				$jude_footer_type = 'default';
			get_template_part( "templates/footer-{$jude_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (jude_is_on(jude_get_theme_option('debug_mode')) && jude_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(jude_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>
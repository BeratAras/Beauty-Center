<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

// Page (category, tag, archive, author) title

if ( jude_need_page_title() ) {
	jude_sc_layouts_showed('title', true);
	jude_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$jude_blog_title = jude_get_blog_title();
							$jude_blog_title_text = $jude_blog_title_class = $jude_blog_title_link = $jude_blog_title_link_text = '';
							if (is_array($jude_blog_title)) {
								$jude_blog_title_text = $jude_blog_title['text'];
								$jude_blog_title_class = !empty($jude_blog_title['class']) ? ' '.$jude_blog_title['class'] : '';
								$jude_blog_title_link = !empty($jude_blog_title['link']) ? $jude_blog_title['link'] : '';
								$jude_blog_title_link_text = !empty($jude_blog_title['link_text']) ? $jude_blog_title['link_text'] : '';
							} else
								$jude_blog_title_text = $jude_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($jude_blog_title_class); ?>"><?php
								$jude_top_icon = jude_get_category_icon();
								if (!empty($jude_top_icon)) {
									$jude_attr = jude_getimagesize($jude_top_icon);
									?><img src="<?php echo esc_url($jude_top_icon); ?>" alt="<?php esc_html__('image', 'jude'); ?>" <?php if (!empty($jude_attr[3])) jude_show_layout($jude_attr[3]);?>><?php
								}
								echo wp_kses_data($jude_blog_title_text);
							?></h1>
							<?php
							if (!empty($jude_blog_title_link) && !empty($jude_blog_title_link_text)) {
								?><a href="<?php echo esc_url($jude_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($jude_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'jude_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
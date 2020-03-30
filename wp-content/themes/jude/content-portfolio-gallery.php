<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_blog_style = explode('_', jude_get_theme_option('blog_style'));
$jude_columns = empty($jude_blog_style[1]) ? 2 : max(2, $jude_blog_style[1]);
$jude_post_format = get_post_format();
$jude_post_format = empty($jude_post_format) ? 'standard' : str_replace('post-format-', '', $jude_post_format);
$jude_animation = jude_get_theme_option('blog_animation');
$jude_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($jude_columns).' post_format_'.esc_attr($jude_post_format) ); ?>
	<?php echo (!jude_is_off($jude_animation) ? ' data-animation="'.esc_attr(jude_get_animation_classes($jude_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($jude_image[1]) && !empty($jude_image[2])) echo intval($jude_image[1]) .'x' . intval($jude_image[2]); ?>"
	data-src="<?php if (!empty($jude_image[0])) echo esc_url($jude_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$jude_image_hover = 'icon';
	if (in_array($jude_image_hover, array('icons', 'zoom'))) $jude_image_hover = 'dots';
	$jude_components = jude_is_inherit(jude_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: jude_array_get_keys_by_value(jude_get_theme_option('meta_parts'));
	$jude_counters = jude_is_inherit(jude_get_theme_option_from_meta('counters')) 
								? 'comments'
								: jude_array_get_keys_by_value(jude_get_theme_option('counters'));
	jude_show_post_featured(array(
		'hover' => $jude_image_hover,
		'thumb_size' => jude_get_thumb_size( strpos(jude_get_theme_option('body_style'), 'full')!==false || $jude_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($jude_components)
										? jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(
											'components' => $jude_components,
											'counters' => $jude_counters,
											'seo' => false,
											'echo' => false
											), $jude_blog_style[0], $jude_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'jude') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>
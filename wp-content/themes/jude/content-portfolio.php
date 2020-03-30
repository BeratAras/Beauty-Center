<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($jude_columns).' post_format_'.esc_attr($jude_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!jude_is_off($jude_animation) ? ' data-animation="'.esc_attr(jude_get_animation_classes($jude_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$jude_image_hover = jude_get_theme_option('image_hover');
	// Featured image
	jude_show_post_featured(array(
		'thumb_size' => jude_get_thumb_size(strpos(jude_get_theme_option('body_style'), 'full')!==false || $jude_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $jude_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $jude_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>
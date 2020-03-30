<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_post_id    = get_the_ID();
$jude_post_date  = jude_get_date();
$jude_post_title = get_the_title();
$jude_post_link  = get_permalink();
$jude_post_author_id   = get_the_author_meta('ID');
$jude_post_author_name = get_the_author_meta('display_name');
$jude_post_author_url  = get_author_posts_url($jude_post_author_id, '');

$jude_args = get_query_var('jude_args_widgets_posts');
$jude_show_date = isset($jude_args['show_date']) ? (int) $jude_args['show_date'] : 1;
$jude_show_image = isset($jude_args['show_image']) ? (int) $jude_args['show_image'] : 1;
$jude_show_author = isset($jude_args['show_author']) ? (int) $jude_args['show_author'] : 1;
$jude_show_counters = isset($jude_args['show_counters']) ? (int) $jude_args['show_counters'] : 1;
$jude_show_categories = isset($jude_args['show_categories']) ? (int) $jude_args['show_categories'] : 1;

$jude_output = jude_storage_get('jude_output_widgets_posts');

$jude_post_counters_output = '';
if ( $jude_show_counters ) {
	$jude_post_counters_output = '<span class="post_info_item post_info_counters">'
								. jude_get_post_counters('comments')
							. '</span>';
}


$jude_output .= '<article class="post_item with_thumb">';

if ($jude_show_image) {
	$jude_post_thumb = get_the_post_thumbnail($jude_post_id, jude_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($jude_post_thumb) $jude_output .= '<div class="post_thumb">' . ($jude_post_link ? '<a href="' . esc_url($jude_post_link) . '">' : '') . ($jude_post_thumb) . ($jude_post_link ? '</a>' : '') . '</div>';
}

$jude_output .= '<div class="post_content">'
			. ($jude_show_categories 
					? '<div class="post_categories">'
						. jude_get_post_categories()
						. $jude_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($jude_post_link ? '<a href="' . esc_url($jude_post_link) . '">' : '') . ($jude_post_title) . ($jude_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('jude_filter_get_post_info', 
								'<div class="post_info">'
									. ($jude_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($jude_post_link ? '<a href="' . esc_url($jude_post_link) . '" class="post_info_date">' : '') 
											. esc_html($jude_post_date) 
											. ($jude_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($jude_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'jude') . ' ' 
											. ($jude_post_link ? '<a href="' . esc_url($jude_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($jude_post_author_name) 
											. ($jude_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$jude_show_categories && $jude_post_counters_output
										? $jude_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
jude_storage_set('jude_output_widgets_posts', $jude_output);
?>
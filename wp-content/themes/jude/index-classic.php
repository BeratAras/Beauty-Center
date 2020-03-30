<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

jude_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	jude_show_layout(get_query_var('blog_archive_start'));

	$jude_classes = 'posts_container '
						. (substr(jude_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$jude_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$jude_sticky_out = jude_get_theme_option('sticky_style')=='columns' 
							&& is_array($jude_stickies) && count($jude_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($jude_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$jude_sticky_out) {
		if (jude_get_theme_option('first_post_large') && !is_paged() && !in_array(jude_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($jude_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($jude_sticky_out && !is_sticky()) {
			$jude_sticky_out = false;
			?></div><div class="<?php echo esc_attr($jude_classes); ?>"><?php
		}
		get_template_part( 'content', $jude_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	jude_show_pagination();

	jude_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>
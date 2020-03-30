<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

jude_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	jude_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$jude_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$jude_sticky_out = jude_get_theme_option('sticky_style')=='columns' 
							&& is_array($jude_stickies) && count($jude_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($jude_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($jude_sticky_out && !is_sticky()) {
			$jude_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $jude_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($jude_sticky_out) {
		$jude_sticky_out = false;
		?></div><?php
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
<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$jude_content = '';
$jude_blog_archive_mask = '%%CONTENT%%';
$jude_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $jude_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($jude_content = apply_filters('the_content', get_the_content())) != '') {
		if (($jude_pos = strpos($jude_content, $jude_blog_archive_mask)) !== false) {
			$jude_content = preg_replace('/(\<p\>\s*)?'.$jude_blog_archive_mask.'(\s*\<\/p\>)/i', $jude_blog_archive_subst, $jude_content);
		} else
			$jude_content .= $jude_blog_archive_subst;
		$jude_content = explode($jude_blog_archive_mask, $jude_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) jude_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$jude_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$jude_args = jude_query_add_posts_and_cats($jude_args, '', jude_get_theme_option('post_type'), jude_get_theme_option('parent_cat'));
$jude_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($jude_page_number > 1) {
	$jude_args['paged'] = $jude_page_number;
	$jude_args['ignore_sticky_posts'] = true;
}
$jude_ppp = jude_get_theme_option('posts_per_page');
if ((int) $jude_ppp != 0)
	$jude_args['posts_per_page'] = (int) $jude_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($jude_args);


// Add internal query vars in the new query!
if (is_array($jude_content) && count($jude_content) == 2) {
	set_query_var('blog_archive_start', $jude_content[0]);
	set_query_var('blog_archive_end', $jude_content[1]);
}

get_template_part('index');
?>
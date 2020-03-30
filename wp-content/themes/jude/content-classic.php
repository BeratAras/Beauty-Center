<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_blog_style = explode('_', jude_get_theme_option('blog_style'));
$jude_columns = empty($jude_blog_style[1]) ? 2 : max(2, $jude_blog_style[1]);
$jude_expanded = !jude_sidebar_present() && jude_is_on(jude_get_theme_option('expand_content'));
$jude_post_format = get_post_format();
$jude_post_format = empty($jude_post_format) ? 'standard' : str_replace('post-format-', '', $jude_post_format);
$jude_animation = jude_get_theme_option('blog_animation');
$jude_components = jude_is_inherit(jude_get_theme_option_from_meta('meta_parts')) 
							? 'categories,date,counters'.($jude_columns < 3 ? ',edit' : '')
							: jude_array_get_keys_by_value(jude_get_theme_option('meta_parts'));
$jude_counters = jude_is_inherit(jude_get_theme_option_from_meta('counters')) 
							? 'comments'
							: jude_array_get_keys_by_value(jude_get_theme_option('counters'));

?><div class="<?php echo esc_attr($jude_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($jude_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($jude_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($jude_columns)
					. ' post_layout_'.esc_attr($jude_blog_style[0]) 
					. ' post_layout_'.esc_attr($jude_blog_style[0]).'_'.esc_attr($jude_columns)
					); ?>
	<?php echo (!jude_is_off($jude_animation) ? ' data-animation="'.esc_attr(jude_get_animation_classes($jude_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	jude_show_post_featured( array( 'thumb_size' => jude_get_thumb_size($jude_blog_style[0] == 'classic'
													? (strpos(jude_get_theme_option('body_style'), 'full')!==false 
															? ( $jude_columns > 2 ? 'big' : 'huge' )
															: (	$jude_columns > 2
																? ($jude_expanded ? 'med' : 'small')
																: ($jude_expanded ? 'big' : 'med')
																)
														)
													: (strpos(jude_get_theme_option('body_style'), 'full')!==false 
															? ( $jude_columns > 2 ? 'masonry-big' : 'full' )
															: (	$jude_columns <= 2 && $jude_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($jude_post_format, array('link', 'aside', 'status', 'quote', 'audio', 'video')) ) {
		?>
		<div class="post_header entry-header">
			<?php

			do_action('jude_action_before_post_meta'); 

			// Post meta
			$jude_components = jude_is_inherit(jude_get_theme_option_from_meta('meta_parts')) 
										? 'categories'
										: jude_array_get_keys_by_value(jude_get_theme_option('meta_parts'));					
			if (!empty($jude_components))
				jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(
					'components' => $jude_components,					
					'seo' => false
					), 'excerpt', 1)
				);	
			
			do_action('jude_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			// Post meta
			$jude_components = jude_is_inherit(jude_get_theme_option_from_meta('meta_parts')) 
										? 'author,date,counters,edit'
										: jude_array_get_keys_by_value(jude_get_theme_option('meta_parts'));
			$jude_counters = jude_is_inherit(jude_get_theme_option_from_meta('counters')) 
										? 'comments'
										: jude_array_get_keys_by_value(jude_get_theme_option('counters'));

			if (!empty($jude_components))
				jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(
					'components' => $jude_components,
					'counters' => $jude_counters,
					'seo' => false
					), 'excerpt', 1)
				);
			do_action('jude_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$jude_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($jude_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($jude_post_format == 'quote') {
				if (($quote = jude_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					jude_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($jude_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($jude_components))
				jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(
					'components' => $jude_components,
					'counters' => $jude_counters
					), $jude_blog_style[0], $jude_columns)
				);
		}
		// More button
		if ( $jude_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'jude'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>
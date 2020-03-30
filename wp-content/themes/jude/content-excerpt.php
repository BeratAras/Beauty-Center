<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_post_format = get_post_format();
$jude_post_format = empty($jude_post_format) ? 'standard' : str_replace('post-format-', '', $jude_post_format);
$jude_animation = jude_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($jude_post_format) ); ?>
	<?php echo (!jude_is_off($jude_animation) ? ' data-animation="'.esc_attr(jude_get_animation_classes($jude_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// blockqoute view
	if ($jude_post_format == 'quote') {
		if (($quote = jude_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
			jude_show_layout(wpautop($quote));
		else
			the_excerpt();
	}

	// Featured image
	jude_show_post_featured(array( 'thumb_size' => jude_get_thumb_size( strpos(jude_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

	// Title and post meta
	if (get_the_title() != '') {
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
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			

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
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (jude_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'jude' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'jude' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$jude_show_learn_more = !in_array($jude_post_format, array('link', 'aside', 'status', 'quote', 'audio'));

			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($jude_post_format, array('link', 'aside', 'status'))) {
					the_content();
				}
				else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
			?></div><?php
			// More button
			if ( $jude_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'jude'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>
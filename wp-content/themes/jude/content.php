<?php
/**
 * The default template to display the content of the single post, page or attachment
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_seo = jude_is_on(jude_get_theme_option('seo_snippets'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post_item_single post_type_'.esc_attr(get_post_type()) 
												. ' post_format_'.esc_attr(str_replace('post-format-', '', get_post_format())) 
												);
		if ($jude_seo) {
			?> itemscope="itemscope" 
			   itemprop="articleBody" 
			   itemtype="http://schema.org/<?php echo esc_attr(jude_get_markup_schema()); ?>" 
			   itemid="<?php echo esc_url(get_the_permalink()); ?>"
			   content="<?php echo esc_attr(get_the_title()); ?>"<?php
		}
?>><?php

	do_action('jude_action_before_post_data'); 

	// Structured data snippets
	if ($jude_seo)
		get_template_part('templates/seo');

	// Featured image
	if ( jude_is_off(jude_get_theme_option('hide_featured_on_single'))
			&& !jude_sc_layouts_showed('featured') 
			&& strpos(get_the_content(), '[trx_widget_banner]')===false) {
		do_action('jude_action_before_post_featured'); 
		jude_show_post_featured();
		do_action('jude_action_after_post_featured');
	} else if (has_post_thumbnail()) {
		?><meta itemprop="image" itemtype="http://schema.org/ImageObject" content="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>"><?php
	}

	// Title and post meta
	if ( (!jude_sc_layouts_showed('title') || !jude_sc_layouts_showed('postmeta')) && !in_array(get_post_format(), array('link', 'aside', 'status', 'quote')) ) {
		do_action('jude_action_before_post_title'); 
		?>
		<div class="post_header entry-header" style='display: none;'>
			<?php
			// Post title
			if (!jude_sc_layouts_showed('title')) {
				the_title( '<h3 class="post_title entry-title"'.($jude_seo ? ' itemprop="headline"' : '').'>', '</h3>' );
			}
			// Post meta
			if (!jude_sc_layouts_showed('postmeta') && jude_is_on(jude_get_theme_option('show_post_meta'))) {
				jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(
					'components' => jude_array_get_keys_by_value(jude_get_theme_option('meta_parts')),
					'counters' => jude_array_get_keys_by_value(jude_get_theme_option('counters')),
					'seo' => jude_is_on(jude_get_theme_option('seo_snippets'))
					), 'single', 1)
				);
			}
			?>
		</div><!-- .post_header -->
		<?php
		do_action('jude_action_after_post_title'); 
	}

	do_action('jude_action_before_post_content'); 

	// Post content
	?>
	<div class="post_content entry-content" itemprop="mainEntityOfPage">
		<?php
		do_action('jude_action_before_post_meta');
		?>
		<div class="single_meta_top">
			<?php
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
			<?php
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
			?>
		</div>
		<?php

		the_content( );

		do_action('jude_action_before_post_pagination'); 

		wp_link_pages( array(
			'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'jude' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'jude' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
		) );

		// Taxonomies and share
		if ( is_single() && !is_attachment() ) {
			
			do_action('jude_action_before_post_meta'); 

			?><div class="post_meta post_meta_single"><?php
				
				// Post taxonomies
				the_tags( '<span class="post_meta_item post_tags"><span class="post_meta_label">'.esc_html__('Tags:', 'jude').'</span> ', ' ', '</span>' );

				// Share
				if (jude_is_on(jude_get_theme_option('show_share_links'))) {
					jude_show_share_links(array(
							'type' => 'block',
							'caption' => '',
							'before' => '<span class="post_meta_item post_share">',
							'after' => '</span>'
						));
				}
			?></div><?php

			do_action('jude_action_after_post_meta'); 
		}
		?>
	</div><!-- .entry-content -->
	

	<?php
	do_action('jude_action_after_post_content'); 

	
	?>
</article>

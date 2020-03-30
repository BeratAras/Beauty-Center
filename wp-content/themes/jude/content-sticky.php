<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

$jude_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$jude_post_format = get_post_format();
$jude_post_format = empty($jude_post_format) ? 'standard' : str_replace('post-format-', '', $jude_post_format);
$jude_animation = jude_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($jude_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($jude_post_format) ); ?>
	<?php echo (!jude_is_off($jude_animation) ? ' data-animation="'.esc_attr(jude_get_animation_classes($jude_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	jude_show_post_featured(array(
		'thumb_size' => jude_get_thumb_size($jude_columns==1 ? 'big' : ($jude_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($jude_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			jude_show_post_meta(apply_filters('jude_filter_post_meta_args', array(), 'sticky', $jude_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>
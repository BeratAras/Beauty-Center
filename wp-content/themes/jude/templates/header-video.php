<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.14
 */
$jude_header_video = jude_get_header_video();
$jude_embed_video = '';
if (!empty($jude_header_video) && !jude_is_from_uploads($jude_header_video)) {
	if (jude_is_youtube_url($jude_header_video) && preg_match('/[=\/]([^=\/]*)$/', $jude_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$jude_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($jude_header_video) . '[/embed]' ));
			$jude_embed_video = jude_make_video_autoplay($jude_embed_video);
		} else {
			$jude_header_video = str_replace('/watch?v=', '/embed/', $jude_header_video);
			$jude_header_video = jude_add_to_url($jude_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$jude_embed_video = '<iframe src="' . esc_url($jude_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php jude_show_layout($jude_embed_video); ?></div><?php
	}
}
?>
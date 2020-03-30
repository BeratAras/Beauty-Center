<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'jude_mptt_get_css' ) ) {
	add_filter( 'jude_filter_get_css', 'jude_mptt_get_css', 10, 4 );
	function jude_mptt_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
			$rad = jude_get_border_radius();
			$rad50 = ' '.$rad != ' 0' ? '50%' : 0;
			$css['fonts'] .= <<<CSS

.post_type_mp-event .timeslot .timeslot-user .avatar,
.post_type_mp-column .event-user .avatar {
	-webkit-border-radius: {$rad50};
	    -ms-border-radius: {$rad50};
			border-radius: {$rad50};
}


CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS


.mptt-shortcode-hours {
	color: {$colors['bd_color']};
}
.mptt-shortcode-wrapper .mptt-shortcode-table tbody .mptt-event-container .timeslot {
	color: {$colors['text']};
}
.mptt-shortcode-wrapper .mptt-shortcode-list .mptt-column .mptt-events-list .mptt-list-event {
	border-color: {$colors['text_light']};
}
/* single page */
body.single-mp-event .page_content_wrap .content .post_item_single .post_featured,
body.single-mp-event .page_content_wrap .content .post_item_single .post_header,
body.single-mp-event .page_content_wrap .content .post_item_single .post_content,
body.single-mp-column .page_content_wrap .content .post_item_single .post_featured,
body.single-mp-column .page_content_wrap .content .post_item_single .post_header,
body.single-mp-column .page_content_wrap .content .post_item_single .post_content {
	background-color: {$colors['bd_color']};
}
.post_type_mp-event .timeslot{
	color: {$colors['text']};
	background-color: {$colors['bg_color']};
}
.post_type_mp-event .timeslot .timeslot-link {
	color: {$colors['text_dark']};
}


CSS;
		}
		
		return $css;
	}
}
?>
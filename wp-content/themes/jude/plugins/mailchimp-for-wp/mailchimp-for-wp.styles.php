<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('jude_mailchimp_get_css')) {
	add_filter('jude_filter_get_css', 'jude_mailchimp_get_css', 10, 4);
	function jude_mailchimp_get_css($css, $colors, $fonts, $scheme='') {
		
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS
form.mc4wp-form .mc4wp-form-fields input[type="email"] {
	{$fonts['input_font-family']}
	{$fonts['input_font-size']}
	{$fonts['input_font-weight']}
	{$fonts['input_font-style']}
	{$fonts['input_line-height']}
	{$fonts['input_text-decoration']}
	{$fonts['input_text-transform']}
	{$fonts['input_letter-spacing']}
}
CSS;
		
			
			$rad = jude_get_border_radius();
			$css['fonts'] .= <<<CSS

form.mc4wp-form .mc4wp-form-fields input[type="email"],
form.mc4wp-form .mc4wp-form-fields input[type="submit"] {
	-webkit-border-radius: {$rad};
	    -ms-border-radius: {$rad};
			border-radius: {$rad};
}

CSS;
		}

		
		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

form.mc4wp-form input[type="email"] {
	background-color: {$colors['bd_color']};
	border-color: {$colors['bg_color']};
	color: {$colors['text_light']};
}
form.mc4wp-form .mc4wp-alert {
	background-color: {$colors['text_link']};
	border-color: {$colors['text_hover']};
	color: {$colors['inverse_text']};
}
form.mc4wp-form .mc4wp-alert a{	color: {$colors['text_dark']};}
form.mc4wp-form .mc4wp-alert a:hover{ color: {$colors['text_light']};}
CSS;
		}

		return $css;
	}
}
?>
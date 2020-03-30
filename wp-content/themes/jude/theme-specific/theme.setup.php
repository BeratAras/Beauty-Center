<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0.22
 */

if (!defined("JUDE_THEME_FREE")) define("JUDE_THEME_FREE", false);
if (!defined("JUDE_THEME_FREE_WP")) define("JUDE_THEME_FREE_WP", false);

// Theme storage
$JUDE_STORAGE = array(
	// Theme required plugin's slugs
	'required_plugins' => array_merge(

		// List of plugins for both - FREE and PREMIUM versions
		//-----------------------------------------------------
		array(
			// Required plugins
			// DON'T COMMENT OR REMOVE NEXT LINES!
			'trx_addons'					=> esc_html__('ThemeREX Addons', 'jude'),

			// Recommended (supported) plugins fot both (lite and full) versions
			// If plugin not need - comment (or remove) it
			'contact-form-7'				=> esc_html__('Contact Form 7', 'jude'),
			'instagram-feed'				=> esc_html__('Custom Feeds for Instagram', 'jude'),
			'mailchimp-for-wp'				=> esc_html__('MailChimp for WP', 'jude'),
			'woocommerce'					=> esc_html__('WooCommerce', 'jude'),
			'wp-gdpr-compliance'			=> esc_html__('WP GDPR Compliance', 'jude')
		),

		// List of plugins for PREMIUM version only
		//-----------------------------------------------------
		JUDE_THEME_FREE 
			? array(
					// Recommended (supported) plugins for the FREE (lite) version
					'siteorigin-panels'			=> esc_html__('SiteOrigin Panels', 'jude'),
					) 
			: array(
					// Recommended (supported) plugins for the PRO (full) version
					// If plugin not need - comment (or remove) it
					'booked'					=> esc_html__('Booked Appointments', 'jude'),
					'essential-grid'			=> esc_html__('Essential Grid', 'jude'),
					'mp-timetable'				=> esc_html__('MP Time Table', 'jude'),
					'the-events-calendar'		=> esc_html__('The Events Calendar', 'jude'),
					'js_composer'				=> esc_html__('WPBakery Page Builder', 'jude'),
					'vc-extensions-bundle'		=> esc_html__('WPBakery Page Builder extensions bundle', 'jude'),
				)
	),
	
	// Theme-specific URLs (will be escaped in place of the output)
	'theme_demo_url'	=> 'http://jude.axiomthemes.com',
	'theme_doc_url'		=> 'http://jude.axiomthemes.com/doc',
	'theme_download_url'=> 'http://theme.download.url',

	'theme_support_url'	=> 'http://axiom.ticksy.com',									// Axiom	
	'theme_video_url'	=> 'https://www.youtube.com/channel/UCBjqhuwKj3MfE3B6Hg2oA8Q',	// Axiom	
);

// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)

if ( !function_exists('jude_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'jude_customizer_theme_setup1', 1 );
	function jude_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
		// -- Internal theme settings
		// -----------------------------------------------------------------
		jude_storage_set('settings', array(
			
			'duplicate_options'		=> 'child',		// none  - use separate options for template and child-theme
													// child - duplicate theme options from the main theme to the child-theme only
													// both  - sinchronize changes in the theme options between main and child themes
			
			'custmize_refresh'		=> 'auto',		// Refresh method for preview area in the Appearance - Customize:
													// auto - refresh preview area on change each field with Theme Options
													// manual - refresh only obn press button 'Refresh' at the top of Customize frame
		
			'max_load_fonts'		=> 5,			// Max fonts number to load from Google fonts or from uploaded fonts
		
			'comment_maxlength'		=> 1000,		// Max length of the message from contact form

			'comment_after_name'	=> true,		// Place 'comment' field before the 'name' and 'email'
			
			'socials_type'			=> 'icons',		// Type of socials:
													// icons - use font icons to present social networks
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_type'			=> 'icons',		// Type of other icons:
													// icons - use font icons to present icons
													// images - use images from theme's folder trx_addons/css/icons.png
			
			'icons_selector'		=> 'internal',	// Icons selector in the shortcodes:
													// vc (default) - standard VC icons selector (very slow and don't support images)
													// internal - internal popup with plugin's or theme's icons list (fast)
			'check_min_version'		=> true,		// Check if exists a .min version of .css and .js and return path to it
													// instead the path to the original file
													// (if debug_mode is off and modification time of the original file < time of the .min file)
			'autoselect_menu'		=> false,		// Show any menu if no menu selected in the location 'main_menu'
													// (for example, the theme is just activated)
			'disable_jquery_ui'		=> false,		// Prevent loading custom jQuery UI libraries in the third-party plugins
		
			'use_mediaelements'		=> true,		// Load script "Media Elements" to play video and audio
			
			'tgmpa_upload'			=> false		// Allow upload not pre-packaged plugins via TGMPA
		));


		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------
		
		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		jude_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Over the Rainbow',
				'family' => 'cursive',
				'styles' => ''		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Rubik',
				'family' => 'sans-serif',
				'styles' => '300,300i,400,400i,500,500i,700,700i,900,900i'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Playfair Display',
				'family' => 'serif',
				'styles' => '400,400i,700,700i,900,900i'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Playfair Display SC',
				'family' => 'serif',
				'styles' => '400,400i,700,700i,900,900i'		// Parameter 'style' used only for the Google fonts
				)
		));
		
		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		jude_storage_set('load_fonts_subset', 'latin,latin-ext');
		
		// Settings of the main tags
		jude_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'jude'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '1.2142rem',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.9em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.45em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'jude'),
				'font-family'		=> 'Playfair Display SC,serif',
				'font-size' 		=> '4.7058em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.125em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.75px',
				'margin-top'		=> '0.73em',
				'margin-bottom'		=> '0.55em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'jude'),
				'font-family'		=> 'Playfair Display,serif',
				'font-size' 		=> '2.9411em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0',
				'margin-top'		=> '1.165em',
				'margin-bottom'		=> '0.43em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'jude'),
				'font-family'		=> 'Playfair Display SC,serif',
				'font-size' 		=> '2.2352em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2631em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.75px',
				'margin-top'		=> '1.17em',
				'margin-bottom'		=> '0.6em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'jude'),
				'font-family'		=> 'Playfair Display,serif',
				'font-size' 		=> '1.5294em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3076em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.65px',
				'margin-top'		=> '1.8em',
				'margin-bottom'		=> '0.95em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'jude'),
				'font-family'		=> 'Playfair Display,serif',
				'font-size' 		=> '1.4117em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.4166em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.075px',
				'margin-top'		=> '1.725em',
				'margin-bottom'		=> '1em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '1.058em',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3888em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '2.1176em',
				'margin-bottom'		=> '1.6em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'jude'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '10px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '3px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'jude'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',	// Attention! Firefox don't allow line-height less then 1.5em in the select
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'jude'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px',
				'margin-top'		=> '0.4em',
				'margin-bottom'		=> ''
				),
			'menu' => array(
				'title'				=> esc_html__('Main menu', 'jude'),
				'description'		=> esc_html__('Font settings of the main menu items', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '11px',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'jude'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'jude'),
				'font-family'		=> 'Rubik,sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '300',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme colors for customizer
		// -- Attention! Inner scheme must be last in the array below
		// -----------------------------------------------------------------
		jude_storage_set('scheme_color_groups', array(
			'main'	=> array(
							'title'			=> esc_html__('Main', 'jude'),
							'description'	=> esc_html__('Colors of the main content area', 'jude')
							),
			'alter'	=> array(
							'title'			=> esc_html__('Alter', 'jude'),
							'description'	=> esc_html__('Colors of the alternative blocks (sidebars, etc.)', 'jude')
							),
			'extra'	=> array(
							'title'			=> esc_html__('Extra', 'jude'),
							'description'	=> esc_html__('Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'jude')
							),
			'inverse' => array(
							'title'			=> esc_html__('Inverse', 'jude'),
							'description'	=> esc_html__('Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'jude')
							),
			'input'	=> array(
							'title'			=> esc_html__('Input', 'jude'),
							'description'	=> esc_html__('Colors of the form fields (text field, textarea, select, etc.)', 'jude')
							),
			)
		);
		jude_storage_set('scheme_color_names', array(
			'bg_color'	=> array(
							'title'			=> esc_html__('Background color', 'jude'),
							'description'	=> esc_html__('Background color of this block in the normal state', 'jude')
							),
			'bg_hover'	=> array(
							'title'			=> esc_html__('Background hover', 'jude'),
							'description'	=> esc_html__('Background color of this block in the hovered state', 'jude')
							),
			'bd_color'	=> array(
							'title'			=> esc_html__('Border color', 'jude'),
							'description'	=> esc_html__('Border color of this block in the normal state', 'jude')
							),
			'bd_hover'	=>  array(
							'title'			=> esc_html__('Border hover', 'jude'),
							'description'	=> esc_html__('Border color of this block in the hovered state', 'jude')
							),
			'text'		=> array(
							'title'			=> esc_html__('Text', 'jude'),
							'description'	=> esc_html__('Color of the plain text inside this block', 'jude')
							),
			'text_dark'	=> array(
							'title'			=> esc_html__('Text dark', 'jude'),
							'description'	=> esc_html__('Color of the dark text (bold, header, etc.) inside this block', 'jude')
							),
			'text_light'=> array(
							'title'			=> esc_html__('Text light', 'jude'),
							'description'	=> esc_html__('Color of the light text (post meta, etc.) inside this block', 'jude')
							),
			'text_link'	=> array(
							'title'			=> esc_html__('Link', 'jude'),
							'description'	=> esc_html__('Color of the links inside this block', 'jude')
							),
			'text_hover'=> array(
							'title'			=> esc_html__('Link hover', 'jude'),
							'description'	=> esc_html__('Color of the hovered state of links inside this block', 'jude')
							),
			'text_link2'=> array(
							'title'			=> esc_html__('Link 2', 'jude'),
							'description'	=> esc_html__('Color of the accented texts (areas) inside this block', 'jude')
							),
			'text_hover2'=> array(
							'title'			=> esc_html__('Link 2 hover', 'jude'),
							'description'	=> esc_html__('Color of the hovered state of accented texts (areas) inside this block', 'jude')
							),
			'text_link3'=> array(
							'title'			=> esc_html__('Link 3', 'jude'),
							'description'	=> esc_html__('Color of the other accented texts (buttons) inside this block', 'jude')
							),
			'text_hover3'=> array(
							'title'			=> esc_html__('Link 3 hover', 'jude'),
							'description'	=> esc_html__('Color of the hovered state of other accented texts (buttons) inside this block', 'jude')
							)
			)
		);
		jude_storage_set('schemes', array(
		
			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'jude'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#faefed',
					'bd_color'			=> '#ffffff',
		
					// Text and links colors
					'text'				=> '#454550',
					'text_light'		=> '#c9727a',
					'text_dark'			=> '#202031',
					'text_link'			=> '#dfb6b0',
					'text_hover'		=> '#911439',
					'text_link2'		=> '#80d572',
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',
		
					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#eeccc7',
					'alter_bg_hover'	=> '#ffffff',
					'alter_bd_color'	=> '#faefed',
					'alter_bd_hover'	=> '#dadada',
					'alter_text'		=> '#454550',
					'alter_light'		=> '#c9727a',
					'alter_dark'		=> '#202031',
					'alter_link'		=> '#c9727a',
					'alter_hover'		=> '#911439',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',
		
					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#faefed',
					'extra_bg_hover'	=> '#f2d9d5',
					'extra_bd_color'	=> '#ffffff',
					'extra_bd_hover'	=> '#3d3d3d',
					'extra_text'		=> '#202031',
					'extra_light'		=> '#afafaf',
					'extra_dark'		=> '#202031',
					'extra_link'		=> '#911439',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',
		
					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#ffffff',
					'input_bg_hover'	=> '#ffffff',
					'input_bd_color'	=> '#e7eaed',
					'input_bd_hover'	=> '#911439',
					'input_text'		=> '#c9727a',
					'input_light'		=> '#a7a7a7',
					'input_dark'		=> '#911439',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#67bcc1',
					'inverse_bd_hover'	=> '#5aa4a9',
					'inverse_text'		=> '#c9727a',
					'inverse_light'		=> '#333333',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#ffffff'
				)
			),
		
			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'jude'),
				'colors' => array(
					
					// Whole block border and background
					'bg_color'			=> '#1b1b29',
					'bd_color'			=> '#202031',
		
					// Text and links colors
					'text'				=> '#5e5e6e',
					'text_light'		=> '#c9727a',
					'text_dark'			=> '#ffffff',
					'text_link'			=> '#dfb6b0',
					'text_hover'		=> '#911439',
					'text_link2'		=> '#80d572',
					'text_hover2'		=> '#8be77c',
					'text_link3'		=> '#ddb837',
					'text_hover3'		=> '#eec432',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'	=> '#202031',
					'alter_bg_hover'	=> '#1e1e2e',
					'alter_bd_color'	=> '#363544',
					'alter_bd_hover'	=> '#4a4a4a',
					'alter_text'		=> '#5e5e6e',
					'alter_light'		=> '#c9727a',
					'alter_dark'		=> '#ffffff',
					'alter_link'		=> '#c9727a',
					'alter_hover'		=> '#911439',
					'alter_link2'		=> '#8be77c',
					'alter_hover2'		=> '#80d572',
					'alter_link3'		=> '#eec432',
					'alter_hover3'		=> '#ddb837',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'	=> '#faefed',
					'extra_bg_hover'	=> '#f3f5f7',
					'extra_bd_color'	=> '#363544',
					'extra_bd_hover'	=> '#4a4a4a',
					'extra_text'		=> '#5e5e6e',
					'extra_light'		=> '#5f5f5f',
					'extra_dark'		=> '#202031',
					'extra_link'		=> '#911439',
					'extra_hover'		=> '#fe7259',
					'extra_link2'		=> '#80d572',
					'extra_hover2'		=> '#8be77c',
					'extra_link3'		=> '#ddb837',
					'extra_hover3'		=> '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'	=> '#202031',
					'input_bg_hover'	=> '#202031',
					'input_bd_color'	=> '#2e2d32',
					'input_bd_hover'	=> '#911439',
					'input_text'		=> '#c9727a',
					'input_light'		=> '#5f5f5f',
					'input_dark'		=> '#911439',
					
					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color'	=> '#e36650',
					'inverse_bd_hover'	=> '#cb5b47',
					'inverse_text'		=> '#c9727a',
					'inverse_light'		=> '#5f5f5f',
					'inverse_dark'		=> '#000000',
					'inverse_link'		=> '#ffffff',
					'inverse_hover'		=> '#ffffff'
				)
			)
		
		));
		
		// Simple schemes substitution
		jude_storage_set('schemes_simple', array(
			// Main color	// Slave elements and it's darkness koef.
			'text_link'		=> array('alter_hover' => 1,	'extra_link' => 1, 'inverse_bd_color' => 0.85, 'inverse_bd_hover' => 0.7),
			'text_hover'	=> array('alter_link' => 1,		'extra_hover' => 1),
			'text_link2'	=> array('alter_hover2' => 1,	'extra_link2' => 1),
			'text_hover2'	=> array('alter_link2' => 1,	'extra_hover2' => 1),
			'text_link3'	=> array('alter_hover3' => 1,	'extra_link3' => 1),
			'text_hover3'	=> array('alter_link3' => 1,	'extra_hover3' => 1)
		));

		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		jude_storage_set('scheme_colors_add', array(
			'bg_color_0'		=> array('color' => 'bg_color',			'alpha' => 0),
			'bg_color_02'		=> array('color' => 'bg_color',			'alpha' => 0.2),
			'bg_color_07'		=> array('color' => 'bg_color',			'alpha' => 0.7),
			'bg_color_08'		=> array('color' => 'bg_color',			'alpha' => 0.8),
			'bg_color_09'		=> array('color' => 'bg_color',			'alpha' =>  0.9),
			'bd_color_08'		=> array('color' => 'bd_color',			'alpha' =>  0.8),
			'alter_bg_color_07'	=> array('color' => 'alter_bg_color',	'alpha' => 0.7),
			'alter_bg_color_04'	=> array('color' => 'alter_bg_color',	'alpha' => 0.4),
			'alter_bg_color_02'	=> array('color' => 'alter_bg_color',	'alpha' => 0.2),
			'alter_bd_color_02'	=> array('color' => 'alter_bd_color',	'alpha' => 0.2),
			'extra_bg_color_07'	=> array('color' => 'extra_bg_color',	'alpha' => 0.7),
			'text_dark_07'		=> array('color' => 'text_dark',		'alpha' => 0.7),
			'inverse_dark_04'		=> array('color' => 'inverse_dark',		'alpha' => 0.4),
			'text_link_02'		=> array('color' => 'text_link',		'alpha' => 0.2),
			'text_link_07'		=> array('color' => 'text_link',		'alpha' => 0.7),
			'text_link_08'		=> array('color' => 'text_link',		'alpha' => 0.8),
			'text_link_09'		=> array('color' => 'text_link',		'alpha' => 0.9),
			'text_link_blend'	=> array('color' => 'text_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5),
			'alter_link_blend'	=> array('color' => 'alter_link',		'hue' => 2, 'saturation' => -5, 'brightness' => 5)
		));
		
		
		// -----------------------------------------------------------------
		// -- Theme specific thumb sizes
		// -----------------------------------------------------------------
		jude_storage_set('theme_thumbs', apply_filters('jude_filter_add_thumb_sizes', array(
			'jude-thumb-huge'		=> array(
												'size'	=> array(1170, 658, true),
												'title' => esc_html__( 'Huge image', 'jude' ),
												'subst'	=> 'trx_addons-thumb-huge'
												),
			'jude-thumb-big' 		=> array(
												'size'	=> array( 760, 428, true),
												'title' => esc_html__( 'Large image', 'jude' ),
												'subst'	=> 'trx_addons-thumb-big'
												),
			'jude-thumb-sq' 		=> array(												
												'size'	=> array( 700, 530, true),
												'title' => esc_html__( 'Square image', 'jude' ),
												'subst'	=> 'trx_addons-thumb-sq'
												),

			'jude-thumb-med' 		=> array(
												'size'	=> array( 530, 354, true),
												'title' => esc_html__( 'Medium image', 'jude' ),
												'subst'	=> 'trx_addons-thumb-medium'
												),

			'jude-thumb-tiny' 		=> array(
												'size'	=> array(  90,  90, true),
												'title' => esc_html__( 'Small square avatar', 'jude' ),
												'subst'	=> 'trx_addons-thumb-tiny'
												),

			'jude-thumb-masonry-big' => array(
												'size'	=> array( 760,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry Large (scaled)', 'jude' ),
												'subst'	=> 'trx_addons-thumb-masonry-big'
												),

			'jude-thumb-masonry'		=> array(
												'size'	=> array( 370,   0, false),		// Only downscale, not crop
												'title' => esc_html__( 'Masonry (scaled)', 'jude' ),
												'subst'	=> 'trx_addons-thumb-masonry'
												)
			))
		);
	}
}




//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( !function_exists( 'jude_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options', 'jude_importer_set_options', 9 );
	function jude_importer_set_options($options=array()) {
		if (is_array($options)) {
			// Save or not installer's messages to the log-file
			$options['debug'] = true;
			// Prepare demo data
			$options['demo_url'] = esc_url(jude_get_protocol() . '://demofiles.axiomthemes.com/jude/');
			// Required plugins
			$options['required_plugins'] = array_keys(jude_storage_get('required_plugins'));
			// Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
			// Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
			$options['regenerate_thumbnails'] = 3;
			// Default demo
			$options['files']['default']['title'] = esc_html__('Jude Demo', 'jude');			
			$options['files']['default']['domain_demo']= esc_url(jude_get_protocol().'://jude.axiomthemes.com');		// Demo-site domain
			// If theme need more demo - just copy 'default' and change required parameter
			// Banners
			$options['banners'] = array(
				array(
					'image' => jude_get_file_url('theme-specific/theme.about/images/frontpage.png'),
					'title' => esc_html__('Front Page Builder', 'jude'),
					'content' => wp_kses_post(__('Create your front page right in the WordPress Customizer. There is no need in WPBakery Page Builder or any other builder. Simply enable/disable sections, fill them out with content, and customize to your liking.', 'jude')),
					'link_url' => esc_url('//www.youtube.com/watch?v=VT0AUbMl_KA'),
					'link_caption' => esc_html__('More about Front Page Builder', 'jude'),
					'duration' => 20
					),
				array(
					'image' => jude_get_file_url('theme-specific/theme.about/images/layouts.png'),
					'title' => esc_html__('Custom Layouts', 'jude'),
					'content' => wp_kses_post(__('Use Layouts Builder to create and customize header and footer styles for your website. With a flexible page builder interface and custom shortcodes, you can create as many header and footer layouts as you want with ease.', 'jude')),
					'link_url' => esc_url('//www.youtube.com/watch?v=pYhdFVLd7y4'),
					'link_caption' => esc_html__('More about Custom Layouts', 'jude'),
					'duration' => 20
					),
				array(
					'image' => jude_get_file_url('theme-specific/theme.about/images/documentation.png'),
					'title' => esc_html__('Read Full Documentation', 'jude'),
					'content' => wp_kses_post(__('Need more details? Please check our full online documentation for detailed information on how to use Jude.', 'jude')),
					'link_url' => esc_url(jude_storage_get('theme_doc_url')),
					'link_caption' => esc_html__('Online Documentation', 'jude'),
					'duration' => 15
					),
				array(
					'image' => jude_get_file_url('theme-specific/theme.about/images/video-tutorials.png'),
					'title' => esc_html__('Video Tutorials', 'jude'),
					'content' => wp_kses_post(__('No time for reading documentation? Check out our video tutorials and learn how to customize Jude in detail.', 'jude')),
					'link_url' => esc_url(jude_storage_get('theme_video_url')),
					'link_caption' => esc_html__('Video Tutorials', 'jude'),
					'duration' => 15
					),
				array(
					'image' => jude_get_file_url('theme-specific/theme.about/images/studio.png'),
					'title' => esc_html__('Website Customization', 'jude'),
					'content' => wp_kses_post(__('Need a website fast? Order our custom service, and we will build a website based on this theme for a very fair price. We can also implement additional functionality such as website translation, setting up WPML, and much more.', 'jude')),
					'link_url' => esc_url('//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themedash'),
					'link_caption' => esc_html__('Contact us', 'jude'),
					'duration' => 25
					)
				);
		}
		return $options;
	}
}




// -----------------------------------------------------------------
// -- Theme options for customizer
// -----------------------------------------------------------------
if (!function_exists('jude_create_theme_options')) {

	function jude_create_theme_options() {

		// Message about options override. 
		// Attention! Not need esc_html() here, because this message put in wp_kses_data() below
		$msg_override = __('<b>Attention!</b> Some of these options can be overridden in the following sections (Blog, Plugins settings, etc.) or in the settings of individual pages', 'jude');

		jude_storage_set('options', array(
		
			// 'Logo & Site Identity'
			'title_tagline' => array(
				"title" => esc_html__('Logo & Site Identity', 'jude'),
				"desc" => '',
				"priority" => 10,
				"type" => "section"
				),
			'logo_info' => array(
				"title" => esc_html__('Logo in the header', 'jude'),
				"desc" => '',
				"priority" => 20,
				"type" => "info",
				),
			'logo_text' => array(
				"title" => esc_html__('Use Site Name as Logo', 'jude'),
				"desc" => wp_kses_data( __('Use the site title and tagline as a text logo if no image is selected', 'jude') ),
				"class" => "jude_column-1_2 jude_new_row",
				"priority" => 30,
				"std" => 1,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_retina_enabled' => array(
				"title" => esc_html__('Allow retina display logo', 'jude'),
				"desc" => wp_kses_data( __('Show fields to select logo images for Retina display', 'jude') ),
				"class" => "jude_column-1_2",
				"priority" => 40,
				"refresh" => false,
				"std" => 0,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'logo_max_height' => array(
				"title" => esc_html__('Logo max. height', 'jude'),
				"desc" => wp_kses_data( __("Max. height of the logo image (in pixels). Maximum size of logo depends on the actual size of the picture", 'jude') ),
				"std" => 80,
				"min" => 20,
				"max" => 160,
				"step" => 1,
				"refresh" => false,
				"type" => JUDE_THEME_FREE ? "hidden" : "slider"
				),
			// Parameter 'logo' was replaced with standard WordPress 'custom_logo'
			'logo_retina' => array(
				"title" => esc_html__('Logo for Retina', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'jude') ),
				"class" => "jude_column-1_2",
				"priority" => 70,
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile_header' => array(
				"title" => esc_html__('Logo for the mobile header', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile header (if enabled in the section "Header - Header mobile"', 'jude') ),
				"class" => "jude_column-1_2 jude_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_header_retina' => array(
				"title" => esc_html__('Logo for the mobile header for Retina', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'jude') ),
				"class" => "jude_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "image"
				),
			'logo_mobile' => array(
				"title" => esc_html__('Logo mobile', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the mobile menu', 'jude') ),
				"class" => "jude_column-1_2 jude_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_mobile_retina' => array(
				"title" => esc_html__('Logo mobile for Retina', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo used on Retina displays (if empty - use default logo from the field above)', 'jude') ),
				"class" => "jude_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "image"
				),
			'logo_side' => array(
				"title" => esc_html__('Logo side', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu', 'jude') ),
				"class" => "jude_column-1_2 jude_new_row",
				"std" => '',
				"type" => "image"
				),
			'logo_side_retina' => array(
				"title" => esc_html__('Logo side for Retina', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo (with vertical orientation) to display it in the side menu on Retina displays (if empty - use default logo from the field above)', 'jude') ),
				"class" => "jude_column-1_2",
				"dependency" => array(
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "image"
				),
			
		
		
			// 'General settings'
			'general' => array(
				"title" => esc_html__('General Settings', 'jude'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 20,
				"type" => "section",
				),

			'general_layout_info' => array(
				"title" => esc_html__('Layout', 'jude'),
				"desc" => '',
				"type" => "info",
				),
			'body_style' => array(
				"title" => esc_html__('Body style', 'jude'),
				"desc" => wp_kses_data( __('Select width of the body content', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'jude')
				),
				"refresh" => false,
				"std" => 'wide',
				"options" => jude_get_list_body_styles(),
				"type" => "select"
				),
			'boxed_bg_image' => array(
				"title" => esc_html__('Boxed bg image', 'jude'),
				"desc" => wp_kses_data( __('Select or upload image, used as background in the boxed body', 'jude') ),
				"dependency" => array(
					'body_style' => array('boxed')
				),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'jude')
				),
				"std" => '',
				"hidden" => true,
				"type" => "image"
				),
			'remove_margins' => array(
				"title" => esc_html__('Remove margins', 'jude'),
				"desc" => wp_kses_data( __('Remove margins above and below the content area', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Content', 'jude')
				),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),

			'general_sidebar_info' => array(
				"title" => esc_html__('Sidebar', 'jude'),
				"desc" => '',
				"type" => "info",
				),
			'sidebar_position' => array(
				"title" => esc_html__('Sidebar position', 'jude'),
				"desc" => wp_kses_data( __('Select position to show sidebar', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'jude')
				),
				"std" => 'right',
				"options" => array(),
				"type" => "switch"
				),
			'sidebar_widgets' => array(
				"title" => esc_html__('Sidebar widgets', 'jude'),
				"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Widgets', 'jude')
				),
				"dependency" => array(
					'sidebar_position' => array('left', 'right')
				),
				"std" => 'sidebar_widgets',
				"options" => array(),
				"type" => "select"
				),
			'expand_content' => array(
				"title" => esc_html__('Expand content', 'jude'),
				"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'jude') ),
				"refresh" => false,
				"std" => 1,
				"type" => "checkbox"
				),

			'general_effects_info' => array(
				"title" => esc_html__('Design & Effects', 'jude'),
				"desc" => '',
				"type" => "hidden",
				),

			'general_misc_info' => array(
				"title" => esc_html__('Miscellaneous', 'jude'),
				"desc" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "info",
				),
			'seo_snippets' => array(
				"title" => esc_html__('SEO snippets', 'jude'),
				"desc" => wp_kses_data( __('Add structured data markup to the single posts and pages', 'jude') ),
				"std" => 0,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'privacy_text' => array(
				"title" => esc_html__("Text with Privacy Policy link", 'jude'),
				"desc"  => wp_kses_data( __("Specify text with Privacy Policy link for the checkbox 'I agree ...'", 'jude') ),
				"std"   => wp_kses_post( __( 'I agree that my submitted data is being collected and stored.', 'jude') ),
				"type"  => "text"
			),

		
		
			// 'Header'
			'header' => array(
				"title" => esc_html__('Header', 'jude'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 30,
				"type" => "section"
				),

			'header_style_info' => array(
				"title" => esc_html__('Header style', 'jude'),
				"desc" => '',
				"type" => "info"
				),
			'header_type' => array(
				"title" => esc_html__('Header style', 'jude'),
				"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => 'default',
				"options" => jude_get_list_header_footer_types(),
				"type" => JUDE_THEME_FREE ? "hidden" : "switch"
				),
			'header_style' => array(
				"title" => esc_html__('Select custom layout', 'jude'),
				"desc" => wp_kses_post( __("Select custom header from Layouts Builder", 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"dependency" => array(
					'header_type' => array('custom')
				),
				"std" => JUDE_THEME_FREE ? 'header-custom-sow-header-default' : 'header-custom-header-default',
				"options" => array(),
				"type" => "select"
				),
			'header_position' => array(
				"title" => esc_html__('Header position', 'jude'),
				"desc" => wp_kses_data( __('Select position to display the site header', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => 'default',
				"options" => array(),
				"type" => JUDE_THEME_FREE ? "hidden" : "switch"
				),
			
			'header_fullheight' => array(
				"title" => esc_html__('Header fullheight', 'jude'),
				"desc" => wp_kses_data( __("Enlarge header area to fill whole screen. Used only if header have a background image", 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => 0,
				"type" => "hidden"
				),
			'header_zoom' => array(
				"title" => esc_html__('Header zoom', 'jude'),
				"desc" => wp_kses_data( __("Zoom the header title. 1 - original size", 'jude') ),
				"std" => 1,
				"min" => 0.3,
				"max" => 2,
				"step" => 0.1,
				"refresh" => false,
				"type" => JUDE_THEME_FREE ? "hidden" : "slider"
				),

			'menu_info' => array(
				"title" => esc_html__('Main menu', 'jude'),
				"desc" => wp_kses_data( __('Select main menu style, position, color scheme and other parameters', 'jude') ),
				"type" => JUDE_THEME_FREE ? "hidden" : "info"
				),
			'menu_style' => array(
				"title" => esc_html__('Menu position', 'jude'),
				"desc" => wp_kses_data( __('Select position of the main menu', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => 'top',
				"options" => array(
					'top'	=> esc_html__('Top',	'jude'),
					'left'	=> esc_html__('Left',	'jude'),
					'right'	=> esc_html__('Right',	'jude')
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "switch"
				),
			'menu_side_stretch' => array(
				"title" => esc_html__('Stretch sidemenu', 'jude'),
				"desc" => wp_kses_data( __('Stretch sidemenu to window height (if menu items number >= 5)', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 0,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_side_icons' => array(
				"title" => esc_html__('Iconed sidemenu', 'jude'),
				"desc" => wp_kses_data( __('Get icons from anchors and display it in the sidemenu or mark sidemenu items with simple dots', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Header', 'jude')
				),
				"dependency" => array(
					'menu_style' => array('left', 'right')
				),
				"std" => 1,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'menu_mobile_fullscreen' => array(
				"title" => esc_html__('Mobile menu fullscreen', 'jude'),
				"desc" => wp_kses_data( __('Display mobile and side menus on full screen (if checked) or slide narrow menu from the left or from the right side (if not checked)', 'jude') ),
				"std" => 1,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_image_info' => array(
				"title" => esc_html__('Header image', 'jude'),
				"desc" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "info"
				),
			'header_image_override' => array(
				"title" => esc_html__('Header image override', 'jude'),
				"desc" => wp_kses_data( __("Allow override the header image with the page's/post's/product's/etc. featured image", 'jude') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => 0,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),

			'header_mobile_info' => array(
				"title" => esc_html__('Mobile header', 'jude'),
				"desc" => wp_kses_data( __("Configure the mobile version of the header", 'jude') ),
				"priority" => 500,
				"type" => JUDE_THEME_FREE ? "hidden" : "info"
				),
			'header_mobile_enabled' => array(
				"title" => esc_html__('Enable the mobile header', 'jude'),
				"desc" => wp_kses_data( __("Use the mobile version of the header (if checked) or relayout the current header on mobile devices", 'jude') ),
				"std" => 0,
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_additional_info' => array(
				"title" => esc_html__('Additional info', 'jude'),
				"desc" => wp_kses_data( __('Additional info to show at the top of the mobile header', 'jude') ),
				"std" => '',
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"refresh" => false,
				"teeny" => false,
				"rows" => 20,
				"type" => JUDE_THEME_FREE ? "hidden" : "text_editor"
				),
			'header_mobile_hide_info' => array(
				"title" => esc_html__('Hide additional info', 'jude'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_logo' => array(
				"title" => esc_html__('Hide logo', 'jude'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_login' => array(
				"title" => esc_html__('Hide login/logout', 'jude'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_search' => array(
				"title" => esc_html__('Hide search', 'jude'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),
			'header_mobile_hide_cart' => array(
				"title" => esc_html__('Hide cart', 'jude'),
				"std" => 0,
				"dependency" => array(
					'header_mobile_enabled' => array(1)
				),
				"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
				),


		
			// 'Footer'
			'footer' => array(
				"title" => esc_html__('Footer', 'jude'),
				"desc" => wp_kses_data( $msg_override ),
				"priority" => 50,
				"type" => "section"
				),
			'footer_type' => array(
				"title" => esc_html__('Footer style', 'jude'),
				"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'jude')
				),
				"std" => 'default',
				"options" => jude_get_list_header_footer_types(),
				"type" => JUDE_THEME_FREE ? "hidden" : "switch"
				),
			'footer_style' => array(
				"title" => esc_html__('Select custom layout', 'jude'),
				"desc" => wp_kses_post( __("Select custom footer from Layouts Builder", 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'jude')
				),
				"dependency" => array(
					'footer_type' => array('custom')
				),
				"std" => JUDE_THEME_FREE ? 'footer-custom-sow-footer-default' : 'footer-custom-footer-default',
				"options" => array(),
				"type" => "select"
				),
			'footer_widgets' => array(
				"title" => esc_html__('Footer widgets', 'jude'),
				"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'jude')
				),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 'footer_widgets',
				"options" => array(),
				"type" => "select"
				),
			'footer_columns' => array(
				"title" => esc_html__('Footer columns', 'jude'),
				"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'jude') ),
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Footer', 'jude')
				),
				"dependency" => array(
					'footer_type' => array('default'),
					'footer_widgets' => array('^hide')
				),
				"std" => 0,
				"options" => jude_get_list_range(0,6),
				"type" => "select"
				),
			'logo_in_footer' => array(
				"title" => esc_html__('Show logo', 'jude'),
				"desc" => wp_kses_data( __('Show logo in the footer', 'jude') ),
				'refresh' => false,
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'logo_footer' => array(
				"title" => esc_html__('Logo for footer', 'jude'),
				"desc" => wp_kses_data( __('Select or upload site logo to display it in the footer', 'jude') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1)
				),
				"std" => '',
				"type" => "image"
				),
			'logo_footer_retina' => array(
				"title" => esc_html__('Logo for footer (Retina)', 'jude'),
				"desc" => wp_kses_data( __('Select or upload logo for the footer area used on Retina displays (if empty - use default logo from the field above)', 'jude') ),
				"dependency" => array(
					'footer_type' => array('default'),
					'logo_in_footer' => array(1),
					'logo_retina_enabled' => array(1)
				),
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "image"
				),
			'socials_in_footer' => array(
				"title" => esc_html__('Show social icons', 'jude'),
				"desc" => wp_kses_data( __('Show social icons in the footer (under logo or footer widgets)', 'jude') ),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"std" => 0,
				"type" => "checkbox"
				),
			'copyright' => array(
				"title" => esc_html__('Copyright', 'jude'),
				"desc" => wp_kses_data( __('Copyright text in the footer. Use {Y} to insert current year and press "Enter" to create a new line', 'jude') ),
				"std" => esc_html__('Copyright &copy; {Y} by Axiomthemes. All rights reserved.', 'jude'),
				"dependency" => array(
					'footer_type' => array('default')
				),
				"refresh" => false,
				"type" => "textarea"
				),			
		
		
			// 'Blog'
			'blog' => array(
				"title" => esc_html__('Blog', 'jude'),
				"desc" => wp_kses_data( __('Options of the the blog archive', 'jude') ),
				"priority" => 70,
				"type" => "panel",
				),
		
				// Blog - Posts page
				'blog_general' => array(
					"title" => esc_html__('Posts page', 'jude'),
					"desc" => wp_kses_data( __('Style and components of the blog archive', 'jude') ),
					"type" => "section",
					),
				'blog_general_info' => array(
					"title" => esc_html__('General settings', 'jude'),
					"desc" => '',
					"type" => "info",
					),
				'blog_style' => array(
					"title" => esc_html__('Blog style', 'jude'),
					"desc" => '',
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => 'excerpt',
					"options" => array(),
					"type" => "select"
					),
				'first_post_large' => array(
					"title" => esc_html__('First post large', 'jude'),
					"desc" => wp_kses_data( __('Make your first post stand out by making it bigger', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('classic', 'masonry')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				"blog_content" => array( 
					"title" => esc_html__('Posts content', 'jude'),
					"desc" => wp_kses_data( __("Display either post excerpts or the full post content", 'jude') ),
					"std" => "excerpt",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"options" => array(
						'excerpt'	=> esc_html__('Excerpt',	'jude'),
						'fullpost'	=> esc_html__('Full post',	'jude')
					),
					"type" => "switch"
					),
				'excerpt_length' => array(
					"title" => esc_html__('Excerpt length', 'jude'),
					"desc" => wp_kses_data( __("Length (in words) to generate excerpt from the post content. Attention! If the post excerpt is explicitly specified - it appears unchanged", 'jude') ),
					"dependency" => array(
						'blog_style' => array('excerpt'),
						'blog_content' => array('excerpt')
					),
					"std" => 60,
					"type" => "text"
					),
				'blog_columns' => array(
					"title" => esc_html__('Blog columns', 'jude'),
					"desc" => wp_kses_data( __('How many columns should be used in the blog archive (from 2 to 4)?', 'jude') ),
					"std" => 2,
					"options" => jude_get_list_range(2,4),
					"type" => "hidden"
					),
				'post_type' => array(
					"title" => esc_html__('Post type', 'jude'),
					"desc" => wp_kses_data( __('Select post type to show in the blog archive', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"linked" => 'parent_cat',
					"refresh" => false,
					"hidden" => true,
					"std" => 'post',
					"options" => array(),
					"type" => "select"
					),
				'parent_cat' => array(
					"title" => esc_html__('Category to show', 'jude'),
					"desc" => wp_kses_data( __('Select category to show in the blog archive', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"refresh" => false,
					"hidden" => true,
					"std" => '0',
					"options" => array(),
					"type" => "select"
					),
				'posts_per_page' => array(
					"title" => esc_html__('Posts per page', 'jude'),
					"desc" => wp_kses_data( __('How many posts will be displayed on this page', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"hidden" => true,
					"std" => '',
					"type" => "text"
					),
				"blog_pagination" => array( 
					"title" => esc_html__('Pagination style', 'jude'),
					"desc" => wp_kses_data( __('Show Older/Newest posts or Page numbers below the posts list', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"std" => "pages",
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"options" => array(
						'pages'	=> esc_html__("Page numbers", 'jude'),
						'links'	=> esc_html__("Older/Newest", 'jude'),
						'more'	=> esc_html__("Load more", 'jude'),
						'infinite' => esc_html__("Infinite scroll", 'jude')
					),
					"type" => "select"
					),
				'show_filters' => array(
					"title" => esc_html__('Show filters', 'jude'),
					"desc" => wp_kses_data( __('Show categories as tabs to filter posts', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
						'blog_style' => array('portfolio', 'gallery')
					),
					"hidden" => true,
					"std" => 0,
					"type" => JUDE_THEME_FREE ? "hidden" : "checkbox"
					),
	
				'blog_sidebar_info' => array(
					"title" => esc_html__('Sidebar', 'jude'),
					"desc" => '',
					"type" => "info",
					),
				'sidebar_position_blog' => array(
					"title" => esc_html__('Sidebar position', 'jude'),
					"desc" => wp_kses_data( __('Select position to show sidebar', 'jude') ),
					"std" => 'right',
					"options" => array(),
					"type" => "switch"
					),
				'sidebar_widgets_blog' => array(
					"title" => esc_html__('Sidebar widgets', 'jude'),
					"desc" => wp_kses_data( __('Select default widgets to show in the sidebar', 'jude') ),
					"dependency" => array(
						'sidebar_position_blog' => array('left', 'right')
					),
					"std" => 'sidebar_widgets',
					"options" => array(),
					"type" => "select"
					),
				'expand_content_blog' => array(
					"title" => esc_html__('Expand content', 'jude'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'jude') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),


				'blog_advanced_info' => array(
					"title" => esc_html__('Advanced settings', 'jude'),
					"desc" => '',
					"type" => "info",
					),
				'no_image' => array(
					"title" => esc_html__('Image placeholder', 'jude'),
					"desc" => wp_kses_data( __('Select or upload an image used as placeholder for posts without a featured image', 'jude') ),
					"std" => '',
					"type" => "image"
					),
				'time_diff_before' => array(
					"title" => esc_html__('Easy Readable Date Format', 'jude'),
					"desc" => wp_kses_data( __("For how many days to show the easy-readable date format (e.g. '3 days ago') instead of the standard publication date", 'jude') ),
					"std" => 5,
					"type" => "text"
					),
				'sticky_style' => array(
					"title" => esc_html__('Sticky posts style', 'jude'),
					"desc" => wp_kses_data( __('Select style of the sticky posts output', 'jude') ),
					"std" => 'inherit',
					"options" => array(
						'inherit' => esc_html__('Decorated posts', 'jude'),
						'columns' => esc_html__('Mini-cards',	'jude')
					),
					"type" => JUDE_THEME_FREE ? "hidden" : "select"
					),
				"blog_animation" => array( 
					"title" => esc_html__('Animation for the posts', 'jude'),
					"desc" => wp_kses_data( __('Select animation to show posts in the blog. Attention! Do not use any animation on pages with the "wheel to the anchor" behaviour (like a "Chess 2 columns")!', 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"std" => "none",
					"options" => array(),
					"type" => JUDE_THEME_FREE ? "hidden" : "select"
					),
				'meta_parts' => array(
					"title" => esc_html__('Post meta', 'jude'),
					"desc" => wp_kses_data( __("If your blog page is created using the 'Blog archive' page template, set up the 'Post Meta' settings in the 'Theme Options' section of that page.", 'jude') )
								. '<br>'
								. wp_kses_data( __("<b>Tip:</b> Drag items to change their order.", 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'jude'),
						'date'		 => esc_html__('Post date', 'jude'),
						'author'	 => esc_html__('Post author', 'jude'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'jude'),
						'share'		 => esc_html__('Share links', 'jude'),
						'edit'		 => esc_html__('Edit link', 'jude')
					),
					"type" => JUDE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters' => array(
					"title" => esc_html__('Views, Likes and Comments', 'jude'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'jude') ),
					"override" => array(
						'mode' => 'page',
						'section' => esc_html__('Content', 'jude')
					),
					"dependency" => array(
						'#page_template' => array( 'blog.php' ),
						'.editor-page-attributes__template select' => array( 'blog.php' ),
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'jude'),
						'likes' => esc_html__('Likes', 'jude'),
						'comments' => esc_html__('Comments', 'jude')
					),
					"type" => JUDE_THEME_FREE ? "hidden" : "checklist"
				),

				
				// Blog - Single posts
				'blog_single' => array(
					"title" => esc_html__('Single posts', 'jude'),
					"desc" => wp_kses_data( __('Settings of the single post', 'jude') ),
					"type" => "section",
					),
				'hide_featured_on_single' => array(
					"title" => esc_html__('Hide featured image on the single post', 'jude'),
					"desc" => wp_kses_data( __("Hide featured image on the single post's pages", 'jude') ),
					"override" => array(
						'mode' => 'page,post',
						'section' => esc_html__('Content', 'jude')
					),
					"std" => 0,
					"type" => "checkbox"
					),
				'hide_sidebar_on_single' => array(
					"title" => esc_html__('Hide sidebar on the single post', 'jude'),
					"desc" => wp_kses_data( __("Hide sidebar on the single post's pages", 'jude') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'show_post_meta' => array(
					"title" => esc_html__('Show post meta', 'jude'),
					"desc" => wp_kses_data( __("Display block with post's meta: date, categories, counters, etc.", 'jude') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'meta_parts_post' => array(
					"title" => esc_html__('Post meta', 'jude'),
					"desc" => wp_kses_data( __("Meta parts for single posts.", 'jude') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'categories=1|date=1|counters=1|author=0|share=0|edit=1',
					"options" => array(
						'categories' => esc_html__('Categories', 'jude'),
						'date'		 => esc_html__('Post date', 'jude'),
						'author'	 => esc_html__('Post author', 'jude'),
						'counters'	 => esc_html__('Views, Likes and Comments', 'jude'),
						'share'		 => esc_html__('Share links', 'jude'),
						'edit'		 => esc_html__('Edit link', 'jude')
					),
					"type" => JUDE_THEME_FREE ? "hidden" : "checklist"
				),
				'counters_post' => array(
					"title" => esc_html__('Views, Likes and Comments', 'jude'),
					"desc" => wp_kses_data( __("Likes and Views are available only if ThemeREX Addons is active", 'jude') ),
					"dependency" => array(
						'show_post_meta' => array(1)
					),
					"dir" => 'vertical',
					"sortable" => true,
					"std" => 'views=1|likes=1|comments=1',
					"options" => array(
						'views' => esc_html__('Views', 'jude'),
						'likes' => esc_html__('Likes', 'jude'),
						'comments' => esc_html__('Comments', 'jude')
					),
					"type" => JUDE_THEME_FREE ? "hidden" : "checklist"
				),
				'show_share_links' => array(
					"title" => esc_html__('Show share links', 'jude'),
					"desc" => wp_kses_data( __("Display share links on the single post", 'jude') ),
					"std" => 1,
					"type" => "checkbox"
					),
				'show_author_info' => array(
					"title" => esc_html__('Show author info', 'jude'),
					"desc" => wp_kses_data( __("Display block with information about post's author", 'jude') ),
					"std" => 1,
					"type" => "checkbox"
					),
			'blog_end' => array(
				"type" => "panel_end",
				),
			
		
		
			// 'Colors'
			'panel_colors' => array(
				"title" => esc_html__('Colors', 'jude'),
				"desc" => '',
				"priority" => 300,
				"type" => "section"
				),

			'color_schemes_info' => array(
				"title" => esc_html__('Color schemes', 'jude'),
				"desc" => wp_kses_data( __('Color schemes for various parts of the site. "Inherit" means that this block is used the Site color scheme (the first parameter)', 'jude') ),
				"type" => "info",
				),
			'color_scheme' => array(
				"title" => esc_html__('Site Color Scheme', 'jude'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'jude')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'header_scheme' => array(
				"title" => esc_html__('Header Color Scheme', 'jude'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'jude')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'menu_scheme' => array(
				"title" => esc_html__('Sidemenu Color Scheme', 'jude'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'jude')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => JUDE_THEME_FREE ? "hidden" : "switch"
				),
			'sidebar_scheme' => array(
				"title" => esc_html__('Sidebar Color Scheme', 'jude'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'jude')
				),
				"std" => 'default',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),
			'footer_scheme' => array(
				"title" => esc_html__('Footer Color Scheme', 'jude'),
				"desc" => '',
				"override" => array(
					'mode' => 'page,cpt_team,cpt_services,cpt_dishes,cpt_competitions,cpt_rounds,cpt_matches,cpt_cars,cpt_properties,cpt_courses,cpt_portfolio',
					'section' => esc_html__('Colors', 'jude')
				),
				"std" => 'inherit',
				"options" => array(),
				"refresh" => false,
				"type" => "switch"
				),

			'color_scheme_editor_info' => array(
				"title" => esc_html__('Color scheme editor', 'jude'),
				"desc" => wp_kses_data(__('Select color scheme to modify. Attention! Only those sections in the site will be changed which this scheme was assigned to', 'jude') ),
				"type" => "info",
				),
			'scheme_storage' => array(
				"title" => esc_html__('Color scheme editor', 'jude'),
				"desc" => '',
				"std" => '$jude_get_scheme_storage',
				"refresh" => false,
				"colorpicker" => "tiny",
				"type" => "scheme_editor"
				),


			// 'Hidden'
			'media_title' => array(
				"title" => esc_html__('Media title', 'jude'),
				"desc" => wp_kses_data( __('Used as title for the audio and video item in this post', 'jude') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'jude')
				),
				"hidden" => true,
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "text"
				),
			'media_author' => array(
				"title" => esc_html__('Media author', 'jude'),
				"desc" => wp_kses_data( __('Used as author name for the audio and video item in this post', 'jude') ),
				"override" => array(
					'mode' => 'post',
					'section' => esc_html__('Content', 'jude')
				),
				"hidden" => true,
				"std" => '',
				"type" => JUDE_THEME_FREE ? "hidden" : "text"
				),


			// Internal options.
			// Attention! Don't change any options in the section below!
			// Use huge priority to call render this elements after all options!
			'reset_options' => array(
				"title" => '',
				"desc" => '',
				"std" => '0',
				"priority" => 10000,
				"type" => "hidden",
				),

			'last_option' => array(		// Need to manually call action to include Tiny MCE scripts
				"title" => '',
				"desc" => '',
				"std" => 1,
				"type" => "hidden",
				),

		));


		// Prepare panel 'Fonts'
		$fonts = array(
		
			// 'Fonts'
			'fonts' => array(
				"title" => esc_html__('Typography', 'jude'),
				"desc" => '',
				"priority" => 200,
				"type" => "panel"
				),

			// Fonts - Load_fonts
			'load_fonts' => array(
				"title" => esc_html__('Load fonts', 'jude'),
				"desc" => wp_kses_data( __('Specify fonts to load when theme start. You can use them in the base theme elements: headers, text, menu, links, input fields, etc.', 'jude') )
						. '<br>'
						. wp_kses_data( __('<b>Attention!</b> Press "Refresh" button to reload preview area after the all fonts are changed', 'jude') ),
				"type" => "section"
				),
			'load_fonts_subset' => array(
				"title" => esc_html__('Google fonts subsets', 'jude'),
				"desc" => wp_kses_data( __('Specify comma separated list of the subsets which will be load from Google fonts', 'jude') )
						. '<br>'
						. wp_kses_data( __('Available subsets are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese', 'jude') ),
				"class" => "jude_column-1_3 jude_new_row",
				"refresh" => false,
				"std" => '$jude_get_load_fonts_subset',
				"type" => "text"
				)
		);

		for ($i=1; $i<=jude_get_theme_setting('max_load_fonts'); $i++) {
			if (jude_get_value_gp('page') != 'theme_options') {
				$fonts["load_fonts-{$i}-info"] = array(
					// Translators: Add font's number - 'Font 1', 'Font 2', etc
					"title" => esc_html(sprintf(__('Font %s', 'jude'), $i)),
					"desc" => '',
					"type" => "info",
					);
			}
			$fonts["load_fonts-{$i}-name"] = array(
				"title" => esc_html__('Font name', 'jude'),
				"desc" => '',
				"class" => "jude_column-1_3 jude_new_row",
				"refresh" => false,
				"std" => '$jude_get_load_fonts_option',
				"type" => "text"
				);
			$fonts["load_fonts-{$i}-family"] = array(
				"title" => esc_html__('Font family', 'jude'),
				"desc" => $i==1 
							? wp_kses_data( __('Select font family to use it if font above is not available', 'jude') )
							: '',
				"class" => "jude_column-1_3",
				"refresh" => false,
				"std" => '$jude_get_load_fonts_option',
				"options" => array(
					'inherit' => esc_html__("Inherit", 'jude'),
					'serif' => esc_html__('serif', 'jude'),
					'sans-serif' => esc_html__('sans-serif', 'jude'),
					'monospace' => esc_html__('monospace', 'jude'),
					'cursive' => esc_html__('cursive', 'jude'),
					'fantasy' => esc_html__('fantasy', 'jude')
				),
				"type" => "select"
				);
			$fonts["load_fonts-{$i}-styles"] = array(
				"title" => esc_html__('Font styles', 'jude'),
				"desc" => $i==1 
							? wp_kses_data( __('Font styles used only for the Google fonts. This is a comma separated list of the font weight and styles. For example: 400,400italic,700', 'jude') )
								. '<br>'
								. wp_kses_data( __('<b>Attention!</b> Each weight and style increase download size! Specify only used weights and styles.', 'jude') )
							: '',
				"class" => "jude_column-1_3",
				"refresh" => false,
				"std" => '$jude_get_load_fonts_option',
				"type" => "text"
				);
		}
		$fonts['load_fonts_end'] = array(
			"type" => "section_end"
			);

		// Fonts - H1..6, P, Info, Menu, etc.
		$theme_fonts = jude_get_theme_fonts();
		foreach ($theme_fonts as $tag=>$v) {
			$fonts["{$tag}_section"] = array(
				"title" => !empty($v['title']) 
								? $v['title'] 
								// Translators: Add tag's name to make title 'H1 settings', 'P settings', etc.
								: esc_html(sprintf(__('%s settings', 'jude'), $tag)),
				"desc" => !empty($v['description']) 
								? $v['description'] 
								// Translators: Add tag's name to make description
								: wp_kses_post( sprintf(__('Font settings of the "%s" tag.', 'jude'), $tag) ),
				"type" => "section",
				);
	
			foreach ($v as $css_prop=>$css_value) {
				if (in_array($css_prop, array('title', 'description'))) continue;
				$options = '';
				$type = 'text';
				$title = ucfirst(str_replace('-', ' ', $css_prop));
				if ($css_prop == 'font-family') {
					$type = 'select';
					$options = array();
				} else if ($css_prop == 'font-weight') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'jude'),
						'100' => esc_html__('100 (Light)', 'jude'), 
						'200' => esc_html__('200 (Light)', 'jude'), 
						'300' => esc_html__('300 (Thin)',  'jude'),
						'400' => esc_html__('400 (Normal)', 'jude'),
						'500' => esc_html__('500 (Semibold)', 'jude'),
						'600' => esc_html__('600 (Semibold)', 'jude'),
						'700' => esc_html__('700 (Bold)', 'jude'),
						'800' => esc_html__('800 (Black)', 'jude'),
						'900' => esc_html__('900 (Black)', 'jude')
					);
				} else if ($css_prop == 'font-style') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'jude'),
						'normal' => esc_html__('Normal', 'jude'), 
						'italic' => esc_html__('Italic', 'jude')
					);
				} else if ($css_prop == 'text-decoration') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'jude'),
						'none' => esc_html__('None', 'jude'), 
						'underline' => esc_html__('Underline', 'jude'),
						'overline' => esc_html__('Overline', 'jude'),
						'line-through' => esc_html__('Line-through', 'jude')
					);
				} else if ($css_prop == 'text-transform') {
					$type = 'select';
					$options = array(
						'inherit' => esc_html__("Inherit", 'jude'),
						'none' => esc_html__('None', 'jude'), 
						'uppercase' => esc_html__('Uppercase', 'jude'),
						'lowercase' => esc_html__('Lowercase', 'jude'),
						'capitalize' => esc_html__('Capitalize', 'jude')
					);
				}
				$fonts["{$tag}_{$css_prop}"] = array(
					"title" => $title,
					"desc" => '',
					"class" => "jude_column-1_5",
					"refresh" => false,
					"std" => '$jude_get_theme_fonts_option',
					"options" => $options,
					"type" => $type
				);
			}
			
			$fonts["{$tag}_section_end"] = array(
				"type" => "section_end"
				);
		}

		$fonts['fonts_end'] = array(
			"type" => "panel_end"
			);

		// Add fonts parameters to Theme Options
		jude_storage_set_array_before('options', 'panel_colors', $fonts);

		// Add Header Video if WP version < 4.7
		if (!function_exists('get_header_video_url')) {
			jude_storage_set_array_after('options', 'header_image_override', 'header_video', array(
				"title" => esc_html__('Header video', 'jude'),
				"desc" => wp_kses_data( __("Select video to use it as background for the header", 'jude') ),
				"override" => array(
					'mode' => 'page',
					'section' => esc_html__('Header', 'jude')
				),
				"std" => '',
				"type" => "video"
				)
			);
		}

		// Add option 'logo' if WP version < 4.5
		// or 'custom_logo' if current page is 'Theme Options'
		if (!function_exists('the_custom_logo') || (isset($_REQUEST['page']) && $_REQUEST['page']=='theme_options')) {
			jude_storage_set_array_before('options', 'logo_retina', function_exists('the_custom_logo') ? 'custom_logo' : 'logo', array(
				"title" => esc_html__('Logo', 'jude'),
				"desc" => wp_kses_data( __('Select or upload the site logo', 'jude') ),
				"class" => "jude_column-1_2 jude_new_row",
				"priority" => 60,
				"std" => '',
				"type" => "image"
				)
			);
		}
	}
}


// Returns a list of options that can be overridden for CPT
if (!function_exists('jude_options_get_list_cpt_options')) {
	function jude_options_get_list_cpt_options($cpt, $title='') {
		if (empty($title)) $title = ucfirst($cpt);
		return array(
					"header_info_{$cpt}" => array(
						"title" => esc_html__('Header', 'jude'),
						"desc" => '',
						"type" => "info",
						),
					"header_type_{$cpt}" => array(
						"title" => esc_html__('Header style', 'jude'),
						"desc" => wp_kses_data( __('Choose whether to use the default header or header Layouts (available only if the ThemeREX Addons is activated)', 'jude') ),
						"std" => 'inherit',
						"options" => jude_get_list_header_footer_types(true),
						"type" => JUDE_THEME_FREE ? "hidden" : "switch"
						),
					"header_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'jude'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select custom layout to display the site header on the %s pages', 'jude'), $title) ),
						"dependency" => array(
							"header_type_{$cpt}" => array('custom')
						),
						"std" => 'inherit',
						"options" => array(),
						"type" => JUDE_THEME_FREE ? "hidden" : "select"
						),
					"header_position_{$cpt}" => array(
						"title" => esc_html__('Header position', 'jude'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to display the site header on the %s pages', 'jude'), $title) ),
						"std" => 'inherit',
						"options" => array(),
						"type" => JUDE_THEME_FREE ? "hidden" : "switch"
						),
					"header_image_override_{$cpt}" => array(
						"title" => esc_html__('Header image override', 'jude'),
						"desc" => wp_kses_data( __("Allow override the header image with the post's featured image", 'jude') ),
						"std" => 0,
						"type" => "hidden"
						),
						
					"sidebar_info_{$cpt}" => array(
						"title" => esc_html__('Sidebar', 'jude'),
						"desc" => '',
						"type" => "info",
						),
					"sidebar_position_{$cpt}" => array(
						"title" => esc_html__('Sidebar position', 'jude'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select position to show sidebar on the %s pages', 'jude'), $title) ),
						"refresh" => false,
						"std" => 'left',
						"options" => array(),
						"type" => "switch"
						),
					"sidebar_widgets_{$cpt}" => array(
						"title" => esc_html__('Sidebar widgets', 'jude'),
						// Translators: Add CPT name to the description
						"desc" => wp_kses_data( sprintf(__('Select sidebar to show on the %s pages', 'jude'), $title) ),
						"dependency" => array(
							"sidebar_position_{$cpt}" => array('left', 'right')
						),
						"std" => 'hide',
						"options" => array(),
						"type" => "select"
						),
					"hide_sidebar_on_single_{$cpt}" => array(
						"title" => esc_html__('Hide sidebar on the single pages', 'jude'),
						"desc" => wp_kses_data( __("Hide sidebar on the single page", 'jude') ),
						"std" => 0,
						"type" => "checkbox"
						),
						
					"footer_info_{$cpt}" => array(
						"title" => esc_html__('Footer', 'jude'),
						"desc" => '',
						"type" => "info",
						),
					"footer_type_{$cpt}" => array(
						"title" => esc_html__('Footer style', 'jude'),
						"desc" => wp_kses_data( __('Choose whether to use the default footer or footer Layouts (available only if the ThemeREX Addons is activated)', 'jude') ),
						"std" => 'inherit',
						"options" => jude_get_list_header_footer_types(true),
						"type" => JUDE_THEME_FREE ? "hidden" : "switch"
						),
					"footer_style_{$cpt}" => array(
						"title" => esc_html__('Select custom layout', 'jude'),
						"desc" => wp_kses_data( __('Select custom layout to display the site footer', 'jude') ),
						"std" => 'inherit',
						"dependency" => array(
							"footer_type_{$cpt}" => array('custom')
						),
						"options" => array(),
						"type" => JUDE_THEME_FREE ? "hidden" : "select"
						),
					"footer_widgets_{$cpt}" => array(
						"title" => esc_html__('Footer widgets', 'jude'),
						"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'jude') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 'footer_widgets',
						"options" => array(),
						"type" => "select"
						),
					"footer_columns_{$cpt}" => array(
						"title" => esc_html__('Footer columns', 'jude'),
						"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'jude') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default'),
							"footer_widgets_{$cpt}" => array('^hide')
						),
						"std" => 0,
						"options" => jude_get_list_range(0,6),
						"type" => "select"
						),
					"footer_wide_{$cpt}" => array(
						"title" => esc_html__('Footer fullwide', 'jude'),
						"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'jude') ),
						"dependency" => array(
							"footer_type_{$cpt}" => array('default')
						),
						"std" => 0,
						"type" => "checkbox"
						),
					);
	}
}


// Return lists with choises when its need in the admin mode
if (!function_exists('jude_options_get_list_choises')) {
	add_filter('jude_filter_options_get_list_choises', 'jude_options_get_list_choises', 10, 2);
	function jude_options_get_list_choises($list, $id) {
		if (is_array($list) && count($list)==0) {
			if (strpos($id, 'header_style')===0)
				$list = jude_get_list_header_styles(strpos($id, 'header_style_')===0);
			else if (strpos($id, 'header_position')===0)
				$list = jude_get_list_header_positions(strpos($id, 'header_position_')===0);
			else if (strpos($id, 'header_widgets')===0)
				$list = jude_get_list_sidebars(strpos($id, 'header_widgets_')===0, true);
			else if (substr($id, -7) == '_scheme')
				$list = jude_get_list_schemes($id!='color_scheme');
			else if (strpos($id, 'sidebar_widgets')===0)
				$list = jude_get_list_sidebars(strpos($id, 'sidebar_widgets_')===0, true);
			else if (strpos($id, 'sidebar_position')===0)
				$list = jude_get_list_sidebars_positions(strpos($id, 'sidebar_position_')===0);
			else if (strpos($id, 'widgets_above_page')===0)
				$list = jude_get_list_sidebars(strpos($id, 'widgets_above_page_')===0, true);
			else if (strpos($id, 'widgets_above_content')===0)
				$list = jude_get_list_sidebars(strpos($id, 'widgets_above_content_')===0, true);
			else if (strpos($id, 'widgets_below_page')===0)
				$list = jude_get_list_sidebars(strpos($id, 'widgets_below_page_')===0, true);
			else if (strpos($id, 'widgets_below_content')===0)
				$list = jude_get_list_sidebars(strpos($id, 'widgets_below_content_')===0, true);
			else if (strpos($id, 'footer_style')===0)
				$list = jude_get_list_footer_styles(strpos($id, 'footer_style_')===0);
			else if (strpos($id, 'footer_widgets')===0)
				$list = jude_get_list_sidebars(strpos($id, 'footer_widgets_')===0, true);
			else if (strpos($id, 'blog_style')===0)
				$list = jude_get_list_blog_styles(strpos($id, 'blog_style_')===0);
			else if (strpos($id, 'post_type')===0)
				$list = jude_get_list_posts_types();
			else if (strpos($id, 'parent_cat')===0)
				$list = jude_array_merge(array(0 => esc_html__('- Select category -', 'jude')), jude_get_list_categories());
			else if (strpos($id, 'blog_animation')===0)
				$list = jude_get_list_animations_in();
			else if ($id == 'color_scheme_editor')
				$list = jude_get_list_schemes();
			else if (strpos($id, '_font-family') > 0)
				$list = jude_get_list_load_fonts(true);
		}
		return $list;
	}
}
?>
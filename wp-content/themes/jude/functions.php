<?php
/**
 * Theme functions: init, enqueue scripts and styles, include required files and widgets
 *
 * @package WordPress
 * @subpackage JUDE
 * @since JUDE 1.0
 */

if (!defined("JUDE_THEME_DIR")) define("JUDE_THEME_DIR", trailingslashit( get_template_directory() ));
if (!defined("JUDE_CHILD_DIR")) define("JUDE_CHILD_DIR", trailingslashit( get_stylesheet_directory() ));

//-------------------------------------------------------
//-- Theme init
//-------------------------------------------------------

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

if ( !function_exists('jude_theme_setup1') ) {
	add_action( 'after_setup_theme', 'jude_theme_setup1', 1 );
	function jude_theme_setup1() {
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		// Attention! Translations must be loaded before first call any translation functions!
		load_theme_textdomain( 'jude', get_template_directory() . '/languages' );

		// Set theme content width
		$GLOBALS['content_width'] = apply_filters( 'jude_filter_content_width', 1170 );
	}
}

if ( !function_exists('jude_theme_setup') ) {
	add_action( 'after_setup_theme', 'jude_theme_setup' );
	function jude_theme_setup() {

		// Add default posts and comments RSS feed links to head 
		add_theme_support( 'automatic-feed-links' );
		
		// Custom header setup
		add_theme_support( 'custom-header', array(
			'header-text' => false,
			'video' => true
			)
		);
		
		// Custom logo
		add_theme_support( 'custom-logo', array(
			'width'       => 250,
			'height'      => 60,
			'flex-width'  => true,
			'flex-height' => true
			)
		);
		// Custom backgrounds setup
		add_theme_support( 'custom-background', array()	);

		// Partial refresh support in the Customize
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') ); 
 
 		// Autogenerate title tag
		add_theme_support('title-tag');
 		
		// Add theme menus
		add_theme_support('nav-menus');
		
		// Switch default markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption') );
		
		// Editor custom stylesheet - for user
		add_editor_style( array_merge(
			array(
				'css/editor-style.css',
				jude_get_file_url('css/font-icons/css/fontello-embedded.css')
			),
			jude_theme_fonts_for_editor()
			)
		);	
	
		// Register navigation menu
		register_nav_menus(array(
			'menu_main' => esc_html__('Main Menu', 'jude'),
			'menu_mobile' => esc_html__('Mobile Menu', 'jude'),
			'menu_footer' => esc_html__('Footer Menu', 'jude')
			)
		);
		
		// Register theme-specific thumb sizes
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);
		$thumb_sizes = jude_storage_get('theme_thumbs');
		$mult = jude_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'jude_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			add_image_size( $k, $v['size'][0], $v['size'][1], $v['size'][2]);
			if ($mult > 1) add_image_size( $k.'-@retina', $v['size'][0]*$mult, $v['size'][1]*$mult, $v['size'][2]);
		}
		// Add new thumb names
		add_filter( 'image_size_names_choose',	'jude_theme_thumbs_sizes' );

		// Excerpt filters
		add_filter( 'excerpt_length',			'jude_excerpt_length' );
		add_filter( 'excerpt_more',				'jude_excerpt_more' );
		
		// Add required meta tags in the head
		add_action('wp_head',		 			'jude_wp_head', 0);
		
		// Load current page/post customization (if present)
		add_action('wp_footer',		 			'jude_wp_footer');
		add_action('admin_footer',	 			'jude_wp_footer');
		
		// Enqueue scripts and styles for frontend
		add_action('wp_enqueue_scripts', 		'jude_wp_scripts', 1000);			// priority 1000 - load styles
																						// before the plugin's support custom styles
																						// (with priority 1100)
																						// and child-theme styles
																						// (with priority 1200)
		add_action('wp_enqueue_scripts', 		'jude_wp_scripts_child', 1200);		// priority 1200 - load styles
																						// after the plugin's support custom styles
																						// (with priority 1100)
		add_action('wp_enqueue_scripts', 		'jude_wp_scripts_responsive', 2000);	// priority 2000 - load responsive
																						// after all other styles
		add_action('wp_footer',		 			'jude_localize_scripts');
		
		// Add body classes
		add_filter( 'body_class',				'jude_add_body_classes' );

		// Register sidebars
		add_action('widgets_init',				'jude_register_sidebars');
	}

}


//-------------------------------------------------------
//-- Theme scripts and styles
//-------------------------------------------------------

// Load frontend scripts
if ( !function_exists( 'jude_wp_scripts' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'jude_wp_scripts', 1000);
	function jude_wp_scripts() {
		
		// Enqueue styles
		//------------------------
		
		// Links to selected fonts
		$links = jude_theme_fonts_links();
		if (count($links) > 0) {
			foreach ($links as $slug => $link) {
				wp_enqueue_style( sprintf('jude-font-%s', $slug), $link, array(), null );
			}
		}
		
		// Font icons styles must be loaded before main stylesheet
		// This style NEED the theme prefix, because style 'fontello' in some plugin contain different set of characters
		// and can't be used instead this style!
		wp_enqueue_style( 'fontello-style',  jude_get_file_url('css/font-icons/css/fontello-embedded.css'), array(), null );

		// Load main stylesheet
		$main_stylesheet = get_template_directory_uri() . '/style.css';
		wp_enqueue_style( 'jude-main', $main_stylesheet, array(), null );

		// Add custom bg image for the Front page
		if ( is_front_page() 
			&& jude_is_on(jude_get_theme_option('front_page_enabled'))
			&& ($bg_image = jude_remove_protocol_from_url(jude_get_theme_option('front_page_bg_image'), false)) != '' )
			wp_add_inline_style( 'jude-main', 'body.frontpage { background-image:url('.esc_url($bg_image).') !important }' );

		// Add custom bg image for the body_style == 'boxed'
		else if ( jude_get_theme_option('body_style') == 'boxed' && ($bg_image = jude_get_theme_option('boxed_bg_image')) != '' )
			wp_add_inline_style( 'jude-main', '.body_style_boxed { background-image:url('.esc_url($bg_image).') !important }' );

		// Merged styles
		if ( jude_is_off(jude_get_theme_option('debug_mode')) )
			wp_enqueue_style( 'jude-styles', jude_get_file_url('css/__styles.css'), array(), null );

		// Custom colors
		if ( !is_customize_preview() && !isset($_GET['color_scheme']) && jude_is_off(jude_get_theme_option('debug_mode')) )
			wp_enqueue_style( 'jude-colors', jude_get_file_url('css/__colors.css'), array(), null );
		else
			wp_add_inline_style( 'jude-main', jude_customizer_get_css() );

		// Add post nav background
		jude_add_bg_in_post_nav();


		// Enqueue scripts	
		//------------------------

		// Modernizr will load in head before other scripts and styles
		$need_masonry = (jude_storage_get('blog_archive')===true
							&& in_array(substr(jude_get_theme_option('blog_style'), 0, 7), array('gallery', 'portfol', 'masonry')))
						|| (is_single()
							&& str_replace('post-format-', '', get_post_format())=='gallery');
		if ( $need_masonry )
			wp_enqueue_script( 'modernizr', jude_get_file_url('js/theme.gallery/modernizr.min.js'), array(), null, false );

		// Superfish Menu
		// Attention! To prevent duplicate this script in the plugin and in the menu, don't merge it!
		wp_enqueue_script( 'superfish', jude_get_file_url('js/superfish/superfish.min.js'), array('jquery'), null, true );
		
		// Merged scripts
		if ( jude_is_off(jude_get_theme_option('debug_mode')) )
			wp_enqueue_script( 'jude-init', jude_get_file_url('js/__scripts.js'), array('jquery'), null, true );
		else {
			// Skip link focus
			wp_enqueue_script( 'skip-link-focus-fix', jude_get_file_url('js/skip-link-focus-fix.js'), null, true );
			// Background video
			$header_video = jude_get_header_video();
			if (!empty($header_video) && !jude_is_inherit($header_video)) {
				if (jude_is_youtube_url($header_video))
					wp_enqueue_script( 'tubular', jude_get_file_url('js/jquery.tubular.js'), array('jquery'), null, true );
				else
					wp_enqueue_script( 'bideo', jude_get_file_url('js/bideo.js'), array(), null, true );
			}
			// Theme scripts
			wp_enqueue_script( 'jude-utils', jude_get_file_url('js/_utils.js'), array('jquery'), null, true );
			wp_enqueue_script( 'jude-init', jude_get_file_url('js/_init.js'), array('jquery'), null, true );	
		}
		// Load scripts for 'Masonry' layout
		if ( $need_masonry ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'masonry' );
			wp_enqueue_script( 'classie', jude_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
			wp_enqueue_script( 'jude-gallery-script', jude_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );
		}
		// Load scripts for 'Portfolio' layout
		if ( jude_storage_get('blog_archive')===true
				&& in_array(substr(jude_get_theme_option('blog_style'), 0, 7), array('gallery', 'portfol'))
				&& !is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		
		// Comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Media elements library	
		if (jude_get_theme_setting('use_mediaelements')) {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
	}
}

// Load child-theme stylesheet (if different) after all styles (with priorities 1000 and 1100)
if ( !function_exists( 'jude_wp_scripts_child' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'jude_wp_scripts_child', 1200);
	function jude_wp_scripts_child() {
		$main_stylesheet = get_template_directory_uri() . '/style.css';
		$child_stylesheet = get_stylesheet_directory_uri() . '/style.css';
		if ($child_stylesheet != $main_stylesheet) {
			wp_enqueue_style( 'jude-child', $child_stylesheet, array('jude-main'), null );
		}
	}
}

// Add variables to the scripts in the frontend
if ( !function_exists( 'jude_localize_scripts' ) ) {
	//Handler of the add_action('wp_footer', 'jude_localize_scripts');
	function jude_localize_scripts() {

		$video = jude_get_header_video();

		wp_localize_script( 'jude-init', 'JUDE_STORAGE', apply_filters( 'jude_filter_localize_script', array(
			// AJAX parameters
			'ajax_url' => esc_url(admin_url('admin-ajax.php')),
			'ajax_nonce' => esc_attr(wp_create_nonce(admin_url('admin-ajax.php'))),
			
			// Site base url
			'site_url' => get_site_url(),
			'theme_url' => get_template_directory_uri(),
						
			// Site color scheme
			'site_scheme' => sprintf('scheme_%s', jude_get_theme_option('color_scheme')),
			
			// User logged in
			'user_logged_in' => is_user_logged_in() ? true : false,
			
			// Window width to switch the site header to the mobile layout
			'mobile_layout_width' => 767,
			'mobile_device' => wp_is_mobile(),
						
			// Sidemenu options
			'menu_side_stretch' => jude_get_theme_option('menu_side_stretch') > 0 ? true : false,
			'menu_side_icons' => jude_get_theme_option('menu_side_icons') > 0 ? true : false,

			// Video background
			'background_video' => jude_is_from_uploads($video) ? $video : '',

			// Video and Audio tag wrapper
			'use_mediaelements' => jude_get_theme_setting('use_mediaelements') ? true : false,

			// Messages max length
			'comment_maxlength'	=> intval(jude_get_theme_setting('comment_maxlength')),

			
			// Internal vars - do not change it!
			
			// Flag for review mechanism
			'admin_mode' => false,

			// E-mail mask
			'email_mask' => '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$',
			
			// Strings for translation
			'strings' => array(
					'ajax_error'		=> esc_html__('Invalid server answer!', 'jude'),
					'error_global'		=> esc_html__('Error data validation!', 'jude'),
					'name_empty' 		=> esc_html__("The name can't be empty", 'jude'),
					'name_long'			=> esc_html__('Too long name', 'jude'),
					'email_empty'		=> esc_html__('Too short (or empty) email address', 'jude'),
					'email_long'		=> esc_html__('Too long email address', 'jude'),
					'email_not_valid'	=> esc_html__('Invalid email address', 'jude'),
					'text_empty'		=> esc_html__("The message text can't be empty", 'jude'),
					'text_long'			=> esc_html__('Too long message text', 'jude')
					)
			))
		);
	}
}

// Load responsive styles (priority 2000 - load it after main styles and plugins custom styles)
if ( !function_exists( 'jude_wp_scripts_responsive' ) ) {
	//Handler of the add_action('wp_enqueue_scripts', 'jude_wp_scripts_responsive', 2000);
	function jude_wp_scripts_responsive() {
		wp_enqueue_style( 'jude-responsive', jude_get_file_url('css/responsive.css'), array(), null );
	}
}

//  Add meta tags and inline scripts in the header for frontend
if (!function_exists('jude_wp_head')) {
	//Handler of the add_action('wp_head',	'jude_wp_head', 1);
	function jude_wp_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="format-detection" content="telephone=no">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php
	}
}

// Add theme specified classes to the body
if ( !function_exists('jude_add_body_classes') ) {
	//Handler of the add_filter( 'body_class', 'jude_add_body_classes' );
	function jude_add_body_classes( $classes ) {
		$classes[] = 'body_tag';	// Need for the .scheme_self
		$classes[] = 'scheme_' . esc_attr(jude_get_theme_option('color_scheme'));

		$blog_mode = jude_storage_get('blog_mode');
		$classes[] = 'blog_mode_' . esc_attr($blog_mode);
		$classes[] = 'body_style_' . esc_attr(jude_get_theme_option('body_style'));

		if (in_array($blog_mode, array('post', 'page'))) {
			$classes[] = 'is_single';
		} else {
			$classes[] = ' is_stream';
			$classes[] = 'blog_style_'.esc_attr(jude_get_theme_option('blog_style'));
			if (jude_storage_get('blog_template') > 0)
				$classes[] = 'blog_template';
		}
		
		if (jude_sidebar_present()) {
			$classes[] = 'sidebar_show sidebar_' . esc_attr(jude_get_theme_option('sidebar_position')) ;
		} else {
			$classes[] = 'sidebar_hide';
			if (jude_is_on(jude_get_theme_option('expand_content')))
				 $classes[] = 'expand_content';
		}
		
		if (jude_is_on(jude_get_theme_option('remove_margins')))
			 $classes[] = 'remove_margins';

		if ( is_front_page() 
			&& jude_is_on(jude_get_theme_option('front_page_enabled')) 
			&& ($bg_image = jude_get_theme_option('front_page_bg_image')) != '' )
			$classes[] = 'with_bg_image';

		$classes[] = 'header_type_' . esc_attr(jude_get_theme_option("header_type"));
		$classes[] = 'header_style_' . esc_attr(jude_get_theme_option("header_type")=='default'
													? 'header-default'
													: jude_get_theme_option("header_style"));
		$classes[] = 'header_position_' . esc_attr(jude_get_theme_option("header_position"));
		$classes[] = 'header_mobile_' . esc_attr(jude_is_on(jude_get_theme_option("header_mobile_enabled")) ? 'enabled' : 'disabled');

		$menu_style= jude_get_theme_option("menu_style");
		$classes[] = 'menu_style_' . esc_attr($menu_style) . (in_array($menu_style, array('left', 'right'))	? ' menu_style_side' : '');
		$classes[] = 'no_layout';
		
		return $classes;
	}
}
	
// Load current page/post customization (if present)
if ( !function_exists( 'jude_wp_footer' ) ) {
	//Handler of the add_action('wp_footer', 'jude_wp_footer');
	//and add_action('admin_footer', 'jude_wp_footer');
	function jude_wp_footer() {
		// Add header zoom
		$header_zoom = max(0.3, min(2, (float) jude_get_theme_option('header_zoom')));
		if ( $header_zoom != 1 ) jude_add_inline_css(".sc_layouts_title_title{font-size:{$header_zoom}em}");
		// Add logo max height
		$logo_max_height = max(20, min(160, (int) jude_get_theme_option('logo_max_height')));
		jude_add_inline_css(".sc_layouts_row .custom-logo-link img,.custom-logo-link img,.sc_layouts_row .sc_layouts_logo img,.sc_layouts_logo img{max-height:{$logo_max_height}px}");
		// Put inline styles to the output
		if (($css = jude_get_inline_css()) != '') {
			wp_enqueue_style(  'jude-inline-styles',  jude_get_file_url('css/__inline.css'), array(), null );
			wp_add_inline_style( 'jude-inline-styles', $css );
		}
	}
}


//-------------------------------------------------------
//-- Sidebars and widgets
//-------------------------------------------------------

// Register widgetized areas
if ( !function_exists('jude_register_sidebars') ) {
	// Handler of the add_action('widgets_init', 'jude_register_sidebars');
	function jude_register_sidebars() {
		$sidebars = jude_get_sidebars();
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $id=>$sb) {
				register_sidebar( array(
										'name'          => esc_html($sb['name']),
										'description'   => esc_html($sb['description']),
										'id'            => esc_attr($id),
										'before_widget' => '<aside id="%1$s" class="widget %2$s">',
										'after_widget'  => '</aside>',
										'before_title'  => '<h5 class="widget_title">',
										'after_title'   => '</h5>'
										)
								);
			}
		}
	}
}

// Return theme specific widgetized areas
if ( !function_exists('jude_get_sidebars') ) {
	function jude_get_sidebars() {
		$list = apply_filters('jude_filter_list_sidebars', array(
			'sidebar_widgets'		=> array(
							'name' => esc_html__('Sidebar Widgets', 'jude'),
							'description' => esc_html__('Widgets to be shown on the main sidebar', 'jude')
							),
			'footer_widgets'		=> array(
							'name' => esc_html__('Footer Widgets', 'jude'),
							'description' => esc_html__('Widgets to be shown at the bottom of the page (in the page footer area)', 'jude')
							)
			)
		);
		return $list;
	}
}


//-------------------------------------------------------
//-- Theme fonts
//-------------------------------------------------------

// Return links for all theme fonts
if ( !function_exists('jude_theme_fonts_links') ) {
	function jude_theme_fonts_links() {
		$links = array();
		
		/*
		Translators: If there are characters in your language that are not supported
		by chosen font(s), translate this to 'off'. Do not translate into your own language.
		*/
		$google_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Google fonts: on or off', 'jude' ) );
		$custom_fonts_enabled = ( 'off' !== esc_html_x( 'on', 'Custom fonts (included in the theme): on or off', 'jude' ) );
		
		if ( ($google_fonts_enabled || $custom_fonts_enabled) && !jude_storage_empty('load_fonts') ) {
			$load_fonts = jude_storage_get('load_fonts');
			if (count($load_fonts) > 0) {
				$google_fonts = '';
				foreach ($load_fonts as $font) {
					$url = '';
					if ($custom_fonts_enabled && empty($font['styles'])) {
						$slug = jude_get_load_fonts_slug($font['name']);
						$url  = jude_get_file_url( sprintf('css/font-face/%s/stylesheet.css', $slug));
						if ($url != '') $links[$slug] = $url;
					}
					if ($google_fonts_enabled && empty($url)) {
						$google_fonts .= ($google_fonts ? '%7C' : '') 
										. str_replace(' ', '+', $font['name'])
										. ':' 
										. (empty($font['styles']) ? '400,400italic,700,700italic' : $font['styles']);
					}
				}
				if ($google_fonts && $google_fonts_enabled) {
					$links['google_fonts'] = sprintf('%s://fonts.googleapis.com/css?family=%s&subset=%s', jude_get_protocol(), $google_fonts, jude_get_theme_option('load_fonts_subset'));
				}
			}
		}
		return $links;
	}
}

// Return links for WP Editor
if ( !function_exists('jude_theme_fonts_for_editor') ) {
	function jude_theme_fonts_for_editor() {
		$links = array_values(jude_theme_fonts_links());
		if (is_array($links) && count($links) > 0) {
			for ($i=0; $i<count($links); $i++) {
				$links[$i] = str_replace(',', '%2C', $links[$i]);
			}
		}
		return $links;
	}
}


//-------------------------------------------------------
//-- The Excerpt
//-------------------------------------------------------
if ( !function_exists('jude_excerpt_length') ) {
	function jude_excerpt_length( $length ) {
		return max(1, jude_get_theme_option('excerpt_length'));
	}
}

if ( !function_exists('jude_excerpt_more') ) {
	function jude_excerpt_more( $more ) {
		return '&hellip;';
	}
}




//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------
if ( !function_exists('jude_theme_thumbs_sizes') ) {
	//Handler of the add_filter( 'image_size_names_choose', 'jude_theme_thumbs_sizes' );
	function jude_theme_thumbs_sizes( $sizes ) {
		$thumb_sizes = jude_storage_get('theme_thumbs');
		$mult = jude_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v['title'];
			if ($mult > 1) $sizes[$k.'-@retina'] = $v['title'].' '.esc_html__('@2x', 'jude' );
		}
		return $sizes;
	}
}



//-------------------------------------------------------
//-- Include theme (or child) PHP-files
//-------------------------------------------------------

require_once JUDE_THEME_DIR . 'includes/utils.php';
require_once JUDE_THEME_DIR . 'includes/storage.php';
require_once JUDE_THEME_DIR . 'includes/lists.php';
require_once JUDE_THEME_DIR . 'includes/wp.php';

if (is_admin()) {
	require_once JUDE_THEME_DIR . 'includes/tgmpa/class-tgm-plugin-activation.php';
	require_once JUDE_THEME_DIR . 'includes/admin.php';
}

require_once JUDE_THEME_DIR . 'theme-options/theme.customizer.php';

require_once JUDE_THEME_DIR . 'front-page/front-page.options.php';

require_once JUDE_THEME_DIR . 'theme-specific/theme.tags.php';
require_once JUDE_THEME_DIR . 'theme-specific/theme.hovers/theme.hovers.php';
require_once JUDE_THEME_DIR . 'theme-specific/theme.about/theme.about.php';


// Plugins support
if (is_array($JUDE_STORAGE['required_plugins']) && count($JUDE_STORAGE['required_plugins']) > 0) {
	foreach ($JUDE_STORAGE['required_plugins'] as $plugin_slug => $plugin_name) {
		$plugin_slug = jude_esc($plugin_slug);
		$plugin_path = JUDE_THEME_DIR . sprintf('plugins/%s/%s.php', $plugin_slug, $plugin_slug);
		if (file_exists($plugin_path)) { require_once $plugin_path; }
	}
}


//For Internet Explorer
if ( !function_exists('jude_ie_browser') ) {
    function jude_ie_browser($classes)
    {
        global $is_IE;
        if ($is_IE) {
            $classes[] = 'ie';
        }
        return $classes;
    }

    add_filter('body_class', 'jude_ie_browser');
}
?>
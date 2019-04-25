<?php
/**
 * Functions
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

define( 'VISUALCOMPOSERSTARTER_VERSION', '3.0.1' );

if ( ! function_exists( 'visualcomposerstarter_setup' ) ) :
	/**
	 * Theme setup
	 */
	function visualcomposerstarter_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'visual-composer-starter', get_template_directory() . '/languages' );

		/*
		 * Define sidebars
		 */
		define( 'VISUALCOMPOSERSTARTER_PAGE_SIDEBAR',                     'vct_overall_site_page_sidebar' );
		define( 'VISUALCOMPOSERSTARTER_POST_SIDEBAR',                     'vct_overall_site_post_sidebar' );
		define( 'VISUALCOMPOSERSTARTER_ARCHIVE_AND_CATEGORY_SIDEBAR',     'vct_overall_site_aac_sidebar' );
		define( 'VISUALCOMPOSERSTARTER_DISABLE_HEADER',                   'vct_overall_site_disable_header' );
		define( 'VISUALCOMPOSERSTARTER_DISABLE_FOOTER',                   'vct_overall_site_disable_footer' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable custom logo
		 */
		add_theme_support( 'custom-logo' );

		/*
		 * Enable custom background
		 */
		add_theme_support( 'custom-background', array(
				'default-color' => '#ffffff',
			) );

		visualcomposerstarter_set_old_styles();
		visualcomposerstarter_set_old_content_size();

		/*
		 * Feed Links
		 */
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'post-formats', array( 'gallery', 'video', 'image' ) );

		add_theme_support( 'html5', array( 'comment-form', 'comment-list', 'gallery', 'caption' ) );

		if ( get_theme_mod( 'vct_overall_site_featured_image', true ) === true ) {
			add_theme_support( 'post-thumbnails' );
		}

		add_image_size( 'visualcomposerstarter-featured-loop-image', 848, 0 );
		add_image_size( 'visualcomposerstarter-featured-loop-image-full', 1140, 0 );
		add_image_size( 'visualcomposerstarter-featured-single-image-boxed', 1170, 0 );
		add_image_size( 'visualcomposerstarter-featured-single-image-full', 1920, 0 );

		/*
		 * Set the default content width.
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 848;
		}

		/*
		 * This theme uses wp_nav_menu() in two locations.
		 */
		register_nav_menus( array(
			'primary'       => esc_html__( 'Primary Menu', 'visual-composer-starter' ),
			'secondary'     => esc_html__( 'Footer Menu', 'visual-composer-starter' ),
		) );

		/*
		 * Comment reply
		 */
		add_action( 'comment_form_before', 'visualcomposerstarter_enqueue_comments_reply' );

		/*
		 * ACF Integration
		 */

		if ( class_exists( 'acf' ) && function_exists( 'register_field_group' ) ) {
			$vct_acf_page_options = array(
				'id' => 'acf_page-options',
				'title' => esc_html__( 'Page Options', 'visual-composer-starter' ),
				'fields' => array(
					array(
						'key' => 'field_589f5a321f0bc',
						'label' => esc_html__( 'Sidebar Position', 'visual-composer-starter' ),
						'name' => 'sidebar_position',
						'type' => 'select',
						'instructions' => esc_html__( 'Select specific sidebar position.', 'visual-composer-starter' ),
						'choices' => array(
							'default' => esc_html__( 'Default', 'visual-composer-starter' ),
							'none' => esc_html__( 'None', 'visual-composer-starter' ),
							'left' => esc_html__( 'Left', 'visual-composer-starter' ),
							'right' => esc_html__( 'Right', 'visual-composer-starter' ),
						),
						'default_value' => get_theme_mod( VISUALCOMPOSERSTARTER_PAGE_SIDEBAR, 'none' ),
						'allow_null' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_589f55db2faa9',
						'label' => esc_html__( 'Hide Page Title', 'visual-composer-starter' ),
						'name' => 'hide_page_title',
						'type' => 'checkbox',
						'choices' => array(
							1 => esc_html__( 'Yes', 'visual-composer-starter' ),
						),
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'page',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			);

			$vct_acf_post_options = array(
				'id' => 'acf_post-options',
				'title' => esc_html__( 'Post Options', 'visual-composer-starter' ),
				'fields' => array(
					array(
						'key' => 'field_589f5b1d656ca',
						'label' => esc_html__( 'Sidebar Position', 'visual-composer-starter' ),
						'name' => 'sidebar_position',
						'type' => 'select',
						'instructions' => esc_html__( 'Select specific sidebar position.', 'visual-composer-starter' ),
						'choices' => array(
							'default' => esc_html__( 'Default', 'visual-composer-starter' ),
							'none' => esc_html__( 'None', 'visual-composer-starter' ),
							'left' => esc_html__( 'Left', 'visual-composer-starter' ),
							'right' => esc_html__( 'Right', 'visual-composer-starter' ),
						),
						'default_value' => get_theme_mod( VISUALCOMPOSERSTARTER_POST_SIDEBAR, 'none' ),
						'allow_null' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_589f5b9a56207',
						'label' => esc_html__( 'Hide Post Title', 'visual-composer-starter' ),
						'name' => 'hide_page_title',
						'type' => 'checkbox',
						'choices' => array(
							1 => esc_html__( 'Yes', 'visual-composer-starter' ),
						),
						'default_value' => '',
						'layout' => 'vertical',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'post',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array(
					'position' => 'side',
					'layout' => 'default',
					'hide_on_screen' => array(),
				),
				'menu_order' => 0,
			);

			if ( ! get_theme_mod( VISUALCOMPOSERSTARTER_DISABLE_HEADER, false ) ) {
				$vct_acf_page_options['fields'][] = array(
					'key' => 'field_58c800e5a7722',
					'label' => 'Disable Header',
					'name' => 'disable_page_header',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'visual-composer-starter' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);

				$vct_acf_post_options['fields'][] = array(
					'key' => 'field_58c7e3f0b7dfb',
					'label' => 'Disable Header',
					'name' => 'disable_post_header',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'visual-composer-starter' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);
			}

			if ( ! get_theme_mod( VISUALCOMPOSERSTARTER_DISABLE_FOOTER, false ) ) {
				$vct_acf_page_options['fields'][] = array(
					'key' => 'field_58c800faa7723',
					'label' => 'Disable Footer',
					'name' => 'disable_page_footer',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'visual-composer-starter' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);

				$vct_acf_post_options['fields'][] = array(
					'key' => 'field_58c7e40db7dfc',
					'label' => 'Disable Footer',
					'name' => 'disable_post_footer',
					'type' => 'checkbox',
					'choices' => array(
						1 => esc_html__( 'Yes', 'visual-composer-starter' ),
					),
					'default_value' => '',
					'layout' => 'vertical',
				);
			}
			register_field_group( $vct_acf_page_options );
			register_field_group( $vct_acf_post_options );
		} // End if().

		/**
		 * Customizer settings.
		 */
		require get_template_directory() . '/inc/customizer/class-visualcomposerstarter-fonts.php';
		require get_template_directory() . '/inc/customizer/class-visualcomposerstarter-customizer.php';
		require get_template_directory() . '/inc/hooks.php';
		new VisualComposerStarter_Fonts();
		new VisualComposerStarter_Customizer();

	}
endif; /* visualcomposerstarter_setup */

add_action( 'after_setup_theme', 'visualcomposerstarter_setup' );

/**
 *  Style Switch Toggle function
 */
function visualcomposerstarter_style_switch_toggle_acf() {
	$screen = get_current_screen();
	if ( isset( $screen->base ) && 'post' === $screen->base ) {
		$font_uri = VisualComposerStarter_Fonts::vct_theme_get_google_font_uri( array( 'Open Sans' ) );
		wp_register_style( 'visualcomposerstarter-toggle-acf-fonts', $font_uri );
		wp_enqueue_style( 'visualcomposerstarter-toggle-acf-fonts' );

		wp_register_style( 'visualcomposerstarter-toggle-acf-style', get_template_directory_uri() . '/css/toggle-switch.css', array(), false );
		wp_enqueue_style( 'visualcomposerstarter-toggle-acf-style' );
	}
}
add_action( 'admin_enqueue_scripts', 'visualcomposerstarter_style_switch_toggle_acf' );

/**
 *  Script Switch Toggle function
 */
function visualcomposerstarter_script_switch_toggle_acf() {
	$screen = get_current_screen();
	if ( isset( $screen->base ) && 'post' === $screen->base ) {
		wp_register_script( 'visualcomposerstarter-toggle-acf-script', get_template_directory_uri() . '/js/toggle-switch-acf.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'visualcomposerstarter-toggle-acf-script' );
	}
}
add_action( 'admin_enqueue_scripts', 'visualcomposerstarter_script_switch_toggle_acf' );

/**
 * Ajax Comment Reply
 */
function visualcomposerstarter_enqueue_comments_reply() {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/*
 * Add Next Page Button to WYSIWYG editor
 */

add_filter( 'mce_buttons', 'visualcomposerstarter_page_break' );

/**
 * Add page break
 *
 * @param VisualComposerStarter_Customizer $mce_buttons Add page break.
 *
 * @return array
 */
function visualcomposerstarter_page_break( $mce_buttons ) {
	$pos = array_search( 'wp_more', $mce_buttons, true );

	if ( false !== $pos ) {
		$buttons = array_slice( $mce_buttons, 0, $pos );
		$buttons[] = 'wp_page';
		$mce_buttons = array_merge( $buttons, array_slice( $mce_buttons, $pos ) );
	}

	return $mce_buttons;
}

/**
 * Enqueues styles.
 *
 * @since Visual Composer Starter 1.0
 */
function visualcomposerstarter_style() {

	/* Bootstrap stylesheet */
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/css/bootstrap.css', array(), '4.1.1', 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/node_modules/font-awesome/css/font-awesome.css', array(), '4.7.0', 'all' );	

	/* Add Visual Composer Starter Font */
	wp_register_style( 'visualcomposerstarter-font', get_template_directory_uri() . '/css/visual-composer-starter-font.min.css', array(), VISUALCOMPOSERSTARTER_VERSION );

	/* Slick slider stylesheet */
	wp_register_style( 'slick-style', get_template_directory_uri() . '/css/slick.min.css', array(), '1.6.0' );

	/* General theme stylesheet */
	wp_register_style( 'visualcomposerstarter-general', get_template_directory_uri() . '/css/style.css', array(), VISUALCOMPOSERSTARTER_VERSION );

	/* Woocommerce stylesheet */
	wp_register_style( 'visualcomposerstarter-woocommerce', get_template_directory_uri() . '/css/woocommerce.min.css', array(), VISUALCOMPOSERSTARTER_VERSION );

	/* Stylesheet with additional responsive style */
	wp_register_style( 'visualcomposerstarter-responsive', get_template_directory_uri() . '/css/responsive.min.css', array(), VISUALCOMPOSERSTARTER_VERSION );

	/* Theme stylesheet */
	wp_register_style( 'visualcomposerstarter-style', get_stylesheet_uri() );

	/* Font options */
	$fonts = array(
		get_theme_mod( 'vct_fonts_and_style_body_font_family', 'Roboto' ),
		get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h2_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h3_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h4_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h5_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_h6_font_family', 'Playfair Display' ),
		get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ),
	);

	$font_uri = VisualComposerStarter_Fonts::vct_theme_get_google_font_uri( $fonts );

	/* Load Google Fonts */
	wp_register_style( 'visualcomposerstarter-fonts', $font_uri, array(), null, 'screen' );

	/* Enqueue styles */
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'font-awesome' );
	wp_enqueue_style( 'visualcomposerstarter-font' );
	wp_enqueue_style( 'slick-style' );
	wp_enqueue_style( 'visualcomposerstarter-general' );
	wp_enqueue_style( 'visualcomposerstarter-woocommerce' );
	wp_enqueue_style( 'visualcomposerstarter-responsive' );
	wp_enqueue_style( 'visualcomposerstarter-style' );
	wp_enqueue_style( 'visualcomposerstarter-fonts' );
	
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_style' );


/**
 * Enqueues scripts.
 *
 * @since Visual Composer Starter 1.0
 */
function visualcomposerstarter_script() {
	/* Bootstrap Transition JS */
  	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/node_modules/bootstrap/dist/js/bootstrap.js', array('jquery'), '4.1.1', true );

	/* Bootstrap Transition JS */
	wp_register_script( 'bootstrap-collapser', get_template_directory_uri() . '/js/bootstrap/collapse.min.js', array( 'jquery' ), '3.3.7', true );

	/* Slick Slider JS */
	wp_register_script( 'slick-js', get_template_directory_uri() . '/js/slick/slick.min.js', array( 'jquery' ), '1.6.0', true );


	/* Main theme JS functions */
	wp_register_script( 'visualcomposerstarter-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), VISUALCOMPOSERSTARTER_VERSION, true );

	wp_localize_script( 'jquery', 'visualcomposerstarter', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'visualcomposerstarter' ),
		'woo_coupon_form' => get_theme_mod( 'woocommerce_coupon_from', false ),
	) );

	/* Enqueue scripts */
	wp_enqueue_script( 'bootstrap-transition' );
	wp_enqueue_script( 'bootstrap-collapser' );
	wp_enqueue_script( 'slick-js' );
	wp_enqueue_script( 'research' );
	wp_enqueue_script( 'visualcomposerstarter-script' );
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_script' );

/**
 * Used by hook: 'customize_preview_init'
 *
 * @see add_action('customize_preview_init',$func)
 */
function visualcomposerstarter_customizer_live_preview() {
	wp_enqueue_script( 'visualcomposerstarter-themecustomizer', get_template_directory_uri() . '/js/customize-preview.min.js', array(
			'jquery',
			'customize-preview',
		), '', true );
}
add_action( 'customize_preview_init', 'visualcomposerstarter_customizer_live_preview' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param Classes $classes Classes list.
 *
 * @return array
 */
function visualcomposerstarter_body_classes( $classes ) {
	$classes[] = 'visualcomposerstarter';

	/* Sandwich color */
	if ( get_theme_mod( 'vct_header_sandwich_style', '#333333' ) === '#FFFFFF' ) {
		$classes[] = 'sandwich-color-light';
	}

	/* Header Style */
	if ( get_theme_mod( 'vct_header_position', 'top' ) === 'sandwich' ) {
		$classes[] = 'menu-sandwich';
	}

	/* Menu position */
	if ( get_theme_mod( 'vct_header_sticky_header', false ) === true ) {
		$classes[] = 'fixed-header';
	}

	/* Navbar background */
	if ( get_theme_mod( 'vct_header_reserve_space_for_header', true ) === false ) {
		$classes[] = 'navbar-no-background';
	}

	/* Width of header-area */
	if ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width' ) {
		$classes[] = 'header-full-width';
	} elseif ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width_boxed' ) {
		$classes[] = 'header-full-width-boxed';
	}

	/* Width of content-area */
	if ( get_theme_mod( 'vct_overall_content_area_size', 'boxed' ) === 'full_width' ) {
		$classes[] = 'content-full-width';
	}

	/* Height of featured image */
	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'full_height' ) {
		$classes[] = 'featured-image-full-height';
	}

	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$classes[] = 'featured-image-custom-height';
	}

	if ( false === visualcomposerstarter_is_the_header_displayed() ) {
		$classes[] = 'header-area-disabled';
	}
	if ( false === visualcomposerstarter_is_the_footer_displayed() ) {
		$classes[] = 'footer-area-disabled';
	}

	return $classes;
}
add_filter( 'body_class', 'visualcomposerstarter_body_classes' );

/**
 *  Give linked images class
 *
 * @param string $html Html.
 * @since Visual Composer Starter 1.2
 * @return mixed
 */
function visualcomposerstarter_give_linked_images_class( $html ) {
	$classes = 'image-link'; // separated by spaces, e.g. 'img image-link'.

	$patterns = array();
	$replacements = array();

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in double quotes.
	$patterns[0] = '/<a([^>]*)class="([^"]*)"([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[0] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor has existing classes contained in single quotes.
	$patterns[1] = '/<a([^>]*)class=\'([^\']*)\'([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[1] = '<a\1class="' . $classes . ' \2"\3><img\4></a>';

	// Matches img tag wrapped in anchor tag where anchor tag has no existing classes.
	$patterns[2] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/';
	$replacements[2] = '<a\1 class="' . $classes . '"><img\2></a>';

	$html = preg_replace( $patterns, $replacements, $html );

	return $html;
}
add_filter( 'the_content', 'visualcomposerstarter_give_linked_images_class' );

/*
 * Register sidebars
 */
register_sidebar(
	array(
		'name'          => esc_html__( 'Sidebar', 'visual-composer-starter' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'visual-composer-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);

register_sidebar(
	array(
		'name'          => esc_html__( 'Menu Area', 'visual-composer-starter' ),
		'id'            => 'menu',
		'description'   => esc_html__( 'Add widgets here to appear in menu area.', 'visual-composer-starter' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h2>',
	)
);
/**
 * Footer area 1.
 *
 * @return array
 */
function visualcomposerstarter_footer_1() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 1', 'visual-composer-starter' ),
		'id' => 'footer',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 2.
 *
 * @return array
 */
function visualcomposerstarter_footer_2() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 2', 'visual-composer-starter' ),
		'id' => 'footer-2',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 3.
 *
 * @return array
 */
function visualcomposerstarter_footer_3() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 3', 'visual-composer-starter' ),
		'id' => 'footer-3',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}
/**
 * Footer area 4.
 *
 * @return array
 */
function visualcomposerstarter_footer_4() {
	return array(
		'name' => esc_html__( 'Footer Widget Column 4', 'visual-composer-starter' ),
		'id' => 'footer-4',
		'description' => esc_html__( 'Add widgets here to appear in your footer.', 'visual-composer-starter' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h2>',
	);
}

add_action( 'widgets_init',             'visualcomposerstarter_all_widgets' );
add_action( 'admin_bar_init',           'visualcomposerstarter_widgets' );

/**
 * All widgets.
 */
function visualcomposerstarter_all_widgets() {
	/**
	 * Register all zones for availability in customizer
	 */
	register_sidebar(
		visualcomposerstarter_footer_1()
	);
	register_sidebar(
		visualcomposerstarter_footer_2()
	);
	register_sidebar(
		visualcomposerstarter_footer_3()
	);
	register_sidebar(
		visualcomposerstarter_footer_4()
	);
}

/**
 * Widgets handler
 */
function visualcomposerstarter_widgets() {
	unregister_sidebar( 'footer' );
	unregister_sidebar( 'footer-2' );
	unregister_sidebar( 'footer-3' );
	unregister_sidebar( 'footer-4' );
	if ( get_theme_mod( 'vct_footer_area_widget_area', false ) ) {
		$footer_columns = intval( get_theme_mod( 'vct_footer_area_widgetized_columns', 1 ) );
		if ( $footer_columns >= 1 ) {
			register_sidebar(
				visualcomposerstarter_footer_1()
			);
		}

		if ( $footer_columns >= 2 ) {
			register_sidebar(
				visualcomposerstarter_footer_2()
			);
		}

		if ( $footer_columns >= 3 ) {
			register_sidebar(
				visualcomposerstarter_footer_3()
			);
		}
		if ( 4 === $footer_columns ) {
			register_sidebar(
				visualcomposerstarter_footer_4()
			);
		}
	}

}

/**
 * Is header displayed
 *
 * @return bool
 */
function visualcomposerstarter_is_the_header_displayed() {
	if ( get_theme_mod( VISUALCOMPOSERSTARTER_DISABLE_HEADER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return ! get_field( 'field_58c800e5a7722' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return ! get_field( 'field_58c800e5a7722', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e3f0b7dfb' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Is footer displayed.
 *
 * @return bool
 */
function visualcomposerstarter_is_the_footer_displayed() {
	if ( get_theme_mod( VISUALCOMPOSERSTARTER_DISABLE_FOOTER, false ) ) {
		return false;
	} elseif ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return ! get_field( 'field_58c800faa7723' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return ! get_field( 'field_58c800faa7723', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return ! get_field( 'field_58c7e40db7dfc' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get header container class.
 *
 * @return string
 */
function visualcomposerstarter_get_header_container_class() {
	if ( get_theme_mod( 'vct_header_top_header_width', 'boxed' ) === 'full_width' ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Get header image container class.
 *
 * @return string
 */
function visualcomposerstarter_get_header_image_container_class() {
	if ( get_theme_mod( 'vct_overall_site_featured_image_width', 'full_width' ) === 'full_width' ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Get contant container class
 *
 * @return string
 */
function visualcomposerstarter_get_content_container_class() {
	if ( 'full_width' === get_theme_mod( 'vct_overall_content_area_size', 'boxed' ) ) {
		return 'container-fluid';
	} else {
		return 'container';
	}
}

/**
 * Check needed sidebar
 *
 * @return string
 */
function visualcomposerstarter_check_needed_sidebar() {
	if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
		return VISUALCOMPOSERSTARTER_PAGE_SIDEBAR;
	} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
		return VISUALCOMPOSERSTARTER_PAGE_SIDEBAR;
	} elseif ( is_singular() ) {
		return VISUALCOMPOSERSTARTER_POST_SIDEBAR;
	} elseif ( is_archive() || is_category() || is_search() || is_front_page() || is_home() ) {
		return VISUALCOMPOSERSTARTER_ARCHIVE_AND_CATEGORY_SIDEBAR;
	} else {
		return 'none';
	}
}

/**
 * Specify sidebar
 *
 * @return null
 */
function visualcomposerstarter_specify_sidebar() {
	if ( is_page() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc' ) : null;
	} elseif ( is_singular() ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5b1d656ca' ) : null;
	} elseif ( ( is_archive() || is_category() || is_search() || is_front_page() || is_home() ) && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
		if ( is_front_page() ) {
			$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'page_on_front' ) ) : null;
		} elseif ( is_home() ) {
			$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'page_for_posts' ) ) : null;
		} else {
			$value = get_theme_mod( visualcomposerstarter_check_needed_sidebar(), 'none' );
		}
	} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
		$value = function_exists( 'get_field' ) ? get_field( 'field_589f5a321f0bc', get_option( 'woocommerce_shop_page_id' ) ) : null;
	} else {
		$value = null;
	}

	$value = apply_filters( 'visualcomposerstarter_specify_sidebar', $value );

	if ( 'default' === $value ) {
		return get_theme_mod( visualcomposerstarter_check_needed_sidebar(), 'none' );
	} else {
		$specify_setting = function_exists( 'get_field' ) ? $value : null;
		if ( $specify_setting ) {
			return $specify_setting;
		} else {
			return get_theme_mod( visualcomposerstarter_check_needed_sidebar(), 'none' );
		}
	}
}

/**
 * Is the title displayed
 *
 * @return bool
 */
function visualcomposerstarter_is_the_title_displayed() {
	if ( function_exists( 'get_field' ) ) {
		if ( is_page() && ! ( function_exists( 'is_shop' ) && is_shop() ) ) {
			return (bool) ! get_field( 'field_589f55db2faa9' );
		} elseif ( function_exists( 'is_shop' ) && is_shop() && get_option( 'woocommerce_shop_page_id' ) ) {
			return (bool) ! get_field( 'field_589f55db2faa9', get_option( 'woocommerce_shop_page_id' ) );
		} elseif ( is_singular() ) {
			return (bool) ! get_field( 'field_589f5b9a56207' );
		} else {
			return true;
		}
	} else {
		return true;
	}
}

/**
 * Get main content block class
 *
 * @return string
 */
function visualcomposerstarter_get_maincontent_block_class() {
	switch ( visualcomposerstarter_specify_sidebar() ) {
		case 'none':
			return 'col-md-12';
		case 'left':
			return 'col-md-9 col-md-push-3';
		case 'right':
			return 'col-md-9';
		default:
			return 'col-md-12';
	}
}

/**
 * Get sidebar class
 *
 * @return bool|string
 */
function visualcomposerstarter_get_sidebar_class() {
	switch ( visualcomposerstarter_specify_sidebar() ) {
		case 'none':
			return false;
		case 'left':
			return 'col-md-3 col-md-pull-9';
		case 'right':
			return 'col-md-3';
		default:
			return false;
	}
}

/**
 * Inline styles.
 */
/*function visualcomposerstarter_inline_styles() {
	wp_register_style( 'visualcomposerstarter-custom-style', get_template_directory_uri() . '/css/customizer-custom.css', array(), false );
	wp_enqueue_style( 'visualcomposerstarter-custom-style' );
	$css = '';

	// Fonts and style.
	$css .= '
	//Body fonts and style
	body,
	#main-menu ul li ul li,
	.comment-content cite,
	.entry-content cite,
	#add_payment_method .cart-collaterals .cart_totals table small,
	.woocommerce-cart .cart-collaterals .cart_totals table small,
	.woocommerce-checkout .cart-collaterals .cart_totals table small,
	.visualcomposerstarter.woocommerce-cart .woocommerce .cart-collaterals .cart_totals .cart-subtotal td,
	.visualcomposerstarter.woocommerce-cart .woocommerce .cart-collaterals .cart_totals .cart-subtotal th,
	.visualcomposerstarter.woocommerce-cart .woocommerce table.cart,
	.visualcomposerstarter.woocommerce .woocommerce-ordering,
	.visualcomposerstarter.woocommerce .woocommerce-result-count,
	.visualcomposerstarter legend,
	.visualcomposerstarter.woocommerce-account .woocommerce-MyAccount-content a.button
	 { font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_font_family', 'Roboto' ) ) . '; }
	 body,
	 .sidebar-widget-area a:hover, .sidebar-widget-area a:focus,
	 .sidebar-widget-area .widget_recent_entries ul li:hover, .sidebar-widget-area .widget_archive ul li:hover, .sidebar-widget-area .widget_categories ul li:hover, .sidebar-widget-area .widget_meta ul li:hover, .sidebar-widget-area .widget_recent_entries ul li:focus, .sidebar-widget-area .widget_archive ul li:focus, .sidebar-widget-area .widget_categories ul li:focus, .sidebar-widget-area .widget_meta ul li:focus, .visualcomposerstarter.woocommerce-cart .woocommerce table.cart .product-name a { color: ' . get_theme_mod( 'vct_fonts_and_style_body_primary_color', '#555555' ) . '; }
	  .comment-content table,
	  .entry-content table { border-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_primary_color', '#555555' ) ) . '; }
	  .entry-full-content .entry-author-data .author-biography,
	  .entry-full-content .entry-meta,
	  .nav-links.post-navigation a .meta-nav,
	  .search-results-header h4,
	  .entry-preview .entry-meta li,
	  .entry-preview .entry-meta li a,
	  .entry-content .gallery-caption,
	  .comment-content blockquote,
	  .entry-content blockquote,
	  .wp-caption .wp-caption-text,
	  .comments-area .comment-list .comment-metadata a { color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_secondary_text_color', '#777777' ) ) . '; }
	  .comments-area .comment-list .comment-metadata a:hover,
	  .comments-area .comment-list .comment-metadata a:focus { border-bottom-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_secondary_text_color', '#777777' ) ) . '; }
	  a,
	  .comments-area .comment-list .reply a,
	  .comments-area span.required,
	  .comments-area .comment-subscription-form label:before,
	  .entry-preview .entry-meta li a:hover:before,
	  .entry-preview .entry-meta li a:focus:before,
	  .entry-preview .entry-meta li.entry-meta-category:hover:before,
	  .entry-content p a:hover,
	  .entry-content ol a:hover,
	  .entry-content ul a:hover,
	  .entry-content table a:hover,
	  .entry-content datalist a:hover,
	  .entry-content blockquote a:hover,
	  .entry-content dl a:hover,
	  .entry-content address a:hover,
	  .entry-content p a:focus,
	  .entry-content ol a:focus,
	  .entry-content ul a:focus,
	  .entry-content table a:focus,
	  .entry-content datalist a:focus,
	  .entry-content blockquote a:focus,
	  .entry-content dl a:focus,
	  .entry-content address a:focus,
	  .entry-content ul > li:before,
	  .comment-content p a:hover,
	  .comment-content ol a:hover,
	  .comment-content ul a:hover,
	  .comment-content table a:hover,
	  .comment-content datalist a:hover,
	  .comment-content blockquote a:hover,
	  .comment-content dl a:hover,
	  .comment-content address a:hover,
	  .comment-content p a:focus,
	  .comment-content ol a:focus,
	  .comment-content ul a:focus,
	  .comment-content table a:focus,
	  .comment-content datalist a:focus,
	  .comment-content blockquote a:focus,
	  .comment-content dl a:focus,
	  .comment-content address a:focus,
	  .comment-content ul > li:before,
	  .sidebar-widget-area .widget_recent_entries ul li,
	  .sidebar-widget-area .widget_archive ul li,
	  .sidebar-widget-area .widget_categories ul li,
	  .sidebar-widget-area .widget_meta ul li { color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) ) . '; }     
	  .comments-area .comment-list .reply a:hover,
	  .comments-area .comment-list .reply a:focus,
	  .comment-content p a,
	  .comment-content ol a,
	  .comment-content ul a,
	  .comment-content table a,
	  .comment-content datalist a,
	  .comment-content blockquote a,
	  .comment-content dl a,
	  .comment-content address a,
	  .entry-content p a,
	  .entry-content ol a,
	  .entry-content ul a,
	  .entry-content table a,
	  .entry-content datalist a,
	  .entry-content blockquote a,
	  .entry-content dl a,
	  .entry-content address a { border-bottom-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) ) . '; }    
	  .entry-content blockquote, .comment-content { border-left-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_active_color', '#557cbf' ) ) . '; }
	  
	  html, #main-menu ul li ul li { font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_font_size', '16px' ) ) . ' }
	  body, #footer, .footer-widget-area .widget-title { line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_line_height', '1.7' ) ) . '; }
	  body {
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_letter_spacing', '0.01rem' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_font_style', 'normal' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_capitalization', 'none' ) ) . ';
	  }
	  
	  .comment-content address,
	  .comment-content blockquote,
	  .comment-content datalist,
	  .comment-content dl,
	  .comment-content ol,
	  .comment-content p,
	  .comment-content table,
	  .comment-content ul,
	  .entry-content address,
	  .entry-content blockquote,
	  .entry-content datalist,
	  .entry-content dl,
	  .entry-content ol,
	  .entry-content p,
	  .entry-content table,
	  .entry-content ul {
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_body_margin_bottom', '1.5rem' ) ) . ';
	  }
	  
	  //Buttons font and style
	  .comments-area .form-submit input[type=submit],
	  .blue-button { 
			background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
			font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ) ) . ';
			font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_size', '16px' ) ) . ';
			font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_weight', '400' ) ) . ';
			font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_style', 'normal' ) ) . ';
			letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_letter_spacing', '0.01rem' ) ) . ';
			line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_line_height', '1' ) ) . ';
			text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_capitalization', 'none' ) ) . ';
			margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_margin_top', '0' ) ) . ';
			margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_margin_bottom', '0' ) ) . ';
	  }
	  .visualcomposerstarter .products .added_to_cart {
			font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ) ) . ';
	  }
	  .comments-area .form-submit input[type=submit]:hover, .comments-area .form-submit input[type=submit]:focus,
	  .blue-button:hover, .blue-button:focus, 
	  .entry-content p a.blue-button:hover { 
			background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	  
	  .nav-links.archive-navigation .page-numbers,
	  .visualcomposerstarter.woocommerce nav.woocommerce-pagination ul li .page-numbers {
	        background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
	  }
	  
	  .nav-links.archive-navigation a.page-numbers:hover, 
	  .nav-links.archive-navigation a.page-numbers:focus, 
	  .nav-links.archive-navigation .page-numbers.current,
	  .visualcomposerstarter.woocommerce nav.woocommerce-pagination ul li .page-numbers:hover, 
	  .visualcomposerstarter.woocommerce nav.woocommerce-pagination ul li .page-numbers:focus, 
	  .visualcomposerstarter.woocommerce nav.woocommerce-pagination ul li .page-numbers.current {
	        background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	  .visualcomposerstarter.woocommerce button.button,
	  .visualcomposerstarter.woocommerce a.button.product_type_simple,
	  .visualcomposerstarter.woocommerce a.button.product_type_grouped,
	  .visualcomposerstarter.woocommerce a.button.product_type_variable,
	  .visualcomposerstarter.woocommerce a.button.product_type_external,
	  .visualcomposerstarter .woocommerce .buttons a.button.wc-forward,
	  .visualcomposerstarter .woocommerce #place_order,
	  .visualcomposerstarter .woocommerce .button.checkout-button,
	  .visualcomposerstarter .woocommerce .button.wc-backward,
	  .visualcomposerstarter .woocommerce .track_order .button,
	  .visualcomposerstarter .woocommerce .vct-thank-you-footer a,
	  .visualcomposerstarter .woocommerce .woocommerce-EditAccountForm .button,
	  .visualcomposerstarter .woocommerce .woocommerce-MyAccount-content a.edit,
	  .visualcomposerstarter .woocommerce .woocommerce-mini-cart__buttons.buttons a,
	  .visualcomposerstarter .woocommerce .woocommerce-orders-table__cell .button,
	  .visualcomposerstarter .woocommerce a.button,
	  .visualcomposerstarter .woocommerce button.button,
	  .visualcomposerstarter #review_form #respond .form-submit .submit
	   {
	  		background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
			font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_family', 'Playfair Display' ) ) . ';
			font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_size', '16px' ) ) . ';
			font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_weight', '400' ) ) . ';
			font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_font_style', 'normal' ) ) . ';
			letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_letter_spacing', '0.01rem' ) ) . ';
			line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_line_height', '1' ) ) . ';
			text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_capitalization', 'none' ) ) . ';
			margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_margin_top', '0' ) ) . ';
			margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_margin_bottom', '0' ) ) . ';
	  }
	  .visualcomposerstarter.woocommerce button.button.alt.disabled {
            background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_color', '#557cbf' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_color', '#f4f4f4' ) ) . ';
	  }
	  .visualcomposerstarter.woocommerce a.button:hover,
	  .visualcomposerstarter.woocommerce a.button:focus,
	  .visualcomposerstarter.woocommerce button.button:hover,
	  .visualcomposerstarter.woocommerce button.button:focus,
	  .visualcomposerstarter .woocommerce #place_order:hover,
	  .visualcomposerstarter .woocommerce .button.checkout-button:hover,
	  .visualcomposerstarter .woocommerce .button.wc-backward:hover,
	  .visualcomposerstarter .woocommerce .track_order .button:hover,
	  .visualcomposerstarter .woocommerce .vct-thank-you-footer a:hover,
	  .visualcomposerstarter .woocommerce .woocommerce-EditAccountForm .button:hover,
	  .visualcomposerstarter .woocommerce .woocommerce-MyAccount-content a.edit:hover,
	  .visualcomposerstarter .woocommerce .woocommerce-mini-cart__buttons.buttons a:hover,
	  .visualcomposerstarter .woocommerce .woocommerce-orders-table__cell .button:hover,
	  .visualcomposerstarter .woocommerce a.button:hover,
	  .visualcomposerstarter #review_form #respond .form-submit .submit:hover
	  .visualcomposerstarter .woocommerce #place_order:focus,
	  .visualcomposerstarter .woocommerce .button.checkout-button:focus,
	  .visualcomposerstarter .woocommerce .button.wc-backward:focus,
	  .visualcomposerstarter .woocommerce .track_order .button:focus,
	  .visualcomposerstarter .woocommerce .vct-thank-you-footer a:focus,
	  .visualcomposerstarter .woocommerce .woocommerce-EditAccountForm .button:focus,
	  .visualcomposerstarter .woocommerce .woocommerce-MyAccount-content a.edit:focus,
	  .visualcomposerstarter .woocommerce .woocommerce-mini-cart__buttons.buttons a:focus,
	  .visualcomposerstarter .woocommerce .woocommerce-orders-table__cell .button:focus,
	  .visualcomposerstarter .woocommerce a.button:focus,
	  .visualcomposerstarter #review_form #respond .form-submit .submit:focus { 
			background-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_background_hover_color', '#3c63a6' ) ) . '; 
			color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_buttons_text_hover_color', '#f4f4f4' ) ) . '; 
	  }
	';

	// Headers font and style.
	$css .= '
	//Headers fonts and style
	.header-widgetised-area .widget_text,
	 #main-menu > ul > li > a, 
	 .entry-full-content .entry-author-data .author-name, 
	 .nav-links.post-navigation a .post-title, 
	 .comments-area .comment-list .comment-author,
	 .comments-area .comment-list .reply a,
	 .comments-area .comment-form-comment label,
	 .comments-area .comment-form-author label,
	 .comments-area .comment-form-email label,
	 .comments-area .comment-form-url label,
	 .comment-content blockquote,
	 .entry-content blockquote { font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ) ) . '; }
	.entry-full-content .entry-author-data .author-name,
	.entry-full-content .entry-meta a,
	.nav-links.post-navigation a .post-title,
	.comments-area .comment-list .comment-author,
	.comments-area .comment-list .comment-author a,
	.search-results-header h4 strong,
	.entry-preview .entry-meta li a:hover,
	.entry-preview .entry-meta li a:focus { color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) ) . '; }
	
	.entry-full-content .entry-meta a,
	.comments-area .comment-list .comment-author a:hover,
	.comments-area .comment-list .comment-author a:focus,
	.nav-links.post-navigation a .post-title { border-bottom-color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) ) . '; }

	 
	 h1 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_font_size', '42px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_margin_bottom', '2.125rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_capitalization', 'none' ) ) . ';  
	 }
	 h1 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_active_color', '#557cbf' ) ) . ';}
	 h1 a:hover, h1 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h1_active_color', '#557cbf' ) ) . ';}
	 h2 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_font_size', '36px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_capitalization', 'none' ) ) . ';  
	 }
	 h2 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_active_color', '#557cbf' ) ) . ';}
	 h2 a:hover, h2 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h2_active_color', '#557cbf' ) ) . ';}
	 h3 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_font_size', '30px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_capitalization', 'none' ) ) . ';  
	 }
	 h3 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_active_color', '#557cbf' ) ) . ';}
	 h3 a:hover, h3 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h3_active_color', '#557cbf' ) ) . ';}
	 h4 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_font_size', '22px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_capitalization', 'none' ) ) . ';  
	 }
	 h4 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_active_color', '#557cbf' ) ) . ';}
	 h4 a:hover, h4 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h4_active_color', '#557cbf' ) ) . ';}
	 h5 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_font_size', '22px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_capitalization', 'none' ) ) . ';  
	 }
	 h5 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_active_color', '#557cbf' ) ) . ';}
	 h5 a:hover, h5 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h5_active_color', '#557cbf' ) ) . ';}
	 h6 {
		color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_text_color', '#333333' ) ) . ';
		font-family: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_font_family', 'Playfair Display' ) ) . ';
		font-size: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_font_size', '16px' ) ) . ';
		font-weight: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_weight', '400' ) ) . ';
		font-style: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_font_style', 'normal' ) ) . ';
		letter-spacing: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_letter_spacing', '0.01rem' ) ) . ';
		line-height: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_line_height', '1.1' ) ) . ';
		margin-top: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_margin_top', '0' ) ) . ';
		margin-bottom: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_margin_bottom', '0.625rem' ) ) . ';
		text-transform: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_capitalization', 'none' ) ) . ';  
	 }
	 h6 a {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_active_color', '#557cbf' ) ) . ';}
	 h6 a:hover, h6 a:focus {color: ' . esc_html( get_theme_mod( 'vct_fonts_and_style_h6_active_color', '#557cbf' ) ) . ';}
	';

	$header_and_menu_area_background = get_theme_mod( 'vct_header_background', '#ffffff' );
	if ( true === get_theme_mod( 'vct_header_reserve_space_for_header', true ) || '#ffffff' !== $header_and_menu_area_background ) {
		$css .= '
		//Header and menu area background color
		#header .navbar .navbar-wrapper,
		body.navbar-no-background #header .navbar.fixed.scroll,
		body.header-full-width-boxed #header .navbar,
		body.header-full-width #header .navbar {
			background-color: ' . esc_html( $header_and_menu_area_background ) . ';
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li ul { background-color: ' . esc_html( $header_and_menu_area_background ) . '; }
		}
		body.navbar-no-background #header .navbar {background-color: transparent;}
		';
	}

	$header_and_menu_area_text_color = get_theme_mod( 'vct_header_text_color', '#555555' );
	if ( '#555555' !== $header_and_menu_area_text_color ) {
		$css .= '
		//Header and menu area text color
		#header { color: ' . esc_html( $header_and_menu_area_text_color ) . ' }
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li,
			body:not(.menu-sandwich) #main-menu ul li a,
			body:not(.menu-sandwich) #main-menu ul li ul li a { color:  ' . esc_html( $header_and_menu_area_text_color ) . ' }
		}
		';
	}

	$header_and_menu_area_text_active_color = get_theme_mod( 'vct_header_text_active_color', '#333333' );
	if ( '#333333' !== $header_and_menu_area_text_active_color ) {
		$css .= '
		//Header and menu area active text color
		#header a:hover {
			color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
			border-bottom-color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
		}
		
		@media only screen and (min-width: 768px) {
			body:not(.menu-sandwich) #main-menu ul li a:hover,
			body:not(.menu-sandwich) #main-menu ul li.current-menu-item > a,
			body:not(.menu-sandwich) #main-menu ul li ul li a:focus, body:not(.menu-sandwich) #main-menu ul li ul li a:hover,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul>li.current_page_item>a,
			body:not(.menu-sandwich) .sandwich-color-light #main-menu>ul ul li.current_page_item>a {
				color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
				border-bottom-color: ' . esc_html( $header_and_menu_area_text_active_color ) . ';
			}
		}
		';
	}

	$header_padding = get_theme_mod( 'vct_header_padding', '25px' );
	if ( '25px' !== $header_padding ) {
		$css .= '
		 //Header padding 

		.navbar-wrapper { padding: ' . esc_html( $header_padding ) . ' 15px; }
		';
	}

	$header_sandwich_icon_color = get_theme_mod( 'vct_header_sandwich_icon_color', '#ffffff' );
	if ( '#ffffff' !== $header_sandwich_icon_color ) {
		$css .= '
			.navbar-toggle .icon-bar {background-color: ' . esc_html( $header_sandwich_icon_color ) . ';}
		';
	}

	$header_and_menu_area_menu_hover_background = get_theme_mod( 'vct_header_menu_hover_background', '#eeeeee' );
	if ( '#eeeeee' !== $header_and_menu_area_menu_hover_background ) {
		$css .= '
		//Header and menu area menu hover background color
		@media only screen and (min-width: 768px) { body:not(.menu-sandwich) #main-menu ul li ul li:hover > a { background-color: ' . esc_html( $header_and_menu_area_menu_hover_background ) . '; } }
		';
	}

	// Featured image custom height.
	$vct_featured_image_custom_height = get_theme_mod( 'vct_overall_site_featured_image_custom_height', '400px' );
	if ( is_numeric( $vct_featured_image_custom_height ) ) {
		$vct_featured_image_custom_height .= 'px';
	}
	if ( get_theme_mod( 'vct_overall_site_featured_image_height', 'auto' ) === 'custom' ) {
		$css .= '
		//Featured image custom height
		.header-image .fade-in-img { height: ' . esc_html( $vct_featured_image_custom_height ) . '; }
		';

	}

	$content_area_background = get_theme_mod( 'vct_overall_site_content_background', '#ffffff' );
	if ( '#ffffff' !== $content_area_background ) {
		$css .= '
		//Content area background
		.content-wrapper { background-color: ' . esc_html( $content_area_background ) . '; }
		';
	}

	$content_area_comments_background = get_theme_mod( 'vct_overall_site_comments_background', '#f4f4f4' );
	if ( '#f4f4f4' !== $content_area_comments_background ) {
		$css .= '
		//Comments background
		.comments-area { background-color: ' . esc_html( $content_area_comments_background ) . '; }
		';
	}

	$footer_area_background = get_theme_mod( 'vct_footer_area_background', '#333333' );
	if ( '#333333' !== $footer_area_background ) {
		// Work out if hash given.
		$hex = str_replace( '#', '', $footer_area_background );

		// HEX TO RGB.
		$rgb = array( hexdec( substr( $hex,0,2 ) ), hexdec( substr( $hex,2,2 ) ), hexdec( substr( $hex,4,2 ) ) );
		// CALCULATE.
		for ( $i = 0; $i < 3; $i++ ) {
			$rgb[ $i ] = round( $rgb[ $i ] * 1.1 );

			// In case rounding up causes us to go to 256.
			if ( $rgb[ $i ] > 255 ) {
				$rgb[ $i ] = 255;
			}
		}
		// RBG to Hex.
		$hex = '';
		for ( $i = 0; $i < 3; $i++ ) {
			// Convert the decimal digit to hex.
			$hex_digit = dechex( $rgb[ $i ] );
			// Add a leading zero if necessary.
			if ( strlen( $hex_digit ) === 1 ) {
				$hex_digit = '0' . $hex_digit;
			}
			// Append to the hex string.
			$hex .= $hex_digit;
		}
		$footer_widget_area_background = '#' . $hex;
		$css .= '
		//Footer area background color
		#footer { background-color: ' . esc_html( $footer_area_background ) . '; }
		.footer-widget-area { background-color: ' . esc_html( $footer_widget_area_background ) . '; }
		';
	}

	$footer_area_text_color = get_theme_mod( 'vct_footer_area_text_color', '#777777' );
	if ( '#777777' !== $footer_area_text_color ) {
		$css .= '
		//Footer area text color
		#footer,
		#footer .footer-socials ul li a span {color: ' . esc_html( $footer_area_text_color ) . '; }
		';
	}

	$footer_area_text_active_color = get_theme_mod( 'vct_footer_area_text_active_color', '#ffffff' );
	if ( '#ffffff' !== $footer_area_text_active_color ) {
		$css .= '
		//Footer area text active color
		#footer a,
		#footer .footer-socials ul li a:hover span { color: ' . esc_html( $footer_area_text_active_color ) . '; }
		#footer a:hover { border-bottom-color: ' . esc_html( $footer_area_text_active_color ) . '; }
		';
	}
	$on_sale_color = get_theme_mod( 'woo_on_sale_color', '#FAC917' );
	if ( '#FAC917' !== $on_sale_color ) {
		$css .= '
		//Woocommerce
		.vct-sale svg>g>g {fill: ' . esc_html( $on_sale_color ) . ';}
		';
	}

	$price_tag_color = get_theme_mod( 'woo_price_tag_color', '#2b4b80' );
	$css .= '
	.visualcomposerstarter.woocommerce ul.products li.product .price,
	.visualcomposerstarter.woocommerce div.product p.price,
	.visualcomposerstarter.woocommerce div.product p.price ins,
	.visualcomposerstarter.woocommerce div.product span.price,
	.visualcomposerstarter.woocommerce div.product span.price ins,
	.visualcomposerstarter.woocommerce.widget .quantity,
	.visualcomposerstarter.woocommerce.widget del,
	.visualcomposerstarter.woocommerce.widget ins,
	.visualcomposerstarter.woocommerce.widget span.woocommerce-Price-amount.amount,
	.visualcomposerstarter.woocommerce p.price ins,
	.visualcomposerstarter.woocommerce p.price,
	.visualcomposerstarter.woocommerce span.price,
	.visualcomposerstarter.woocommerce span.price ins,
	.visualcomposerstarter .woocommerce.widget span.amount,
	.visualcomposerstarter .woocommerce.widget ins {
		color: ' . esc_html( $price_tag_color ) . '
	}
	';

	$old_price_tag_color = get_theme_mod( 'woo_old_price_tag_color', '#d5d5d5' );
	$css .= '
	.visualcomposerstarter.woocommerce span.price del,
	.visualcomposerstarter.woocommerce p.price del,
	.visualcomposerstarter.woocommerce p.price del span,
	.visualcomposerstarter.woocommerce span.price del span,
	.visualcomposerstarter .woocommerce.widget del,
	.visualcomposerstarter .woocommerce.widget del span.amount,
	.visualcomposerstarter.woocommerce ul.products li.product .price del {
		color: ' . esc_html( $old_price_tag_color ) . '
	}
	';

	$cart_color = get_theme_mod( 'woo_cart_color', '#2b4b80' );
	$cart_text_color = get_theme_mod( 'woo_cart_text_color', '#fff' );
	$css .= '
	.visualcomposerstarter .vct-cart-items-count {
	    background: ' . esc_html( $cart_color ) . ';
	    color: ' . esc_html( $cart_text_color ) . ';
	}
	.visualcomposerstarter .vct-cart-wrapper svg g>g {
	    fill: ' . esc_html( $cart_color ) . ';
	}
	';

	$link_color = get_theme_mod( 'woo_link_color', '#d5d5d5' );
	$css .= '
	.visualcomposerstarter.woocommerce div.product .entry-categories a,
	.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li a
	{
		color: ' . esc_html( $link_color ) . ';
	}
	';

	$link_hover_color = get_theme_mod( 'woo_link_hover_color', '#2b4b80' );
	$css .= '
	.visualcomposerstarter.woocommerce div.product .entry-categories a:hover,
	.visualcomposerstarter.woocommerce-cart .woocommerce table.cart .product-name a:hover,
	.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
	.visualcomposerstarter.woocommerce div.product .entry-categories a:focus,
	.visualcomposerstarter.woocommerce-cart .woocommerce table.cart .product-name a:focus,
	.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
	{
		color: ' . esc_html( $link_hover_color ) . ';
	}
	';

	$link_active_color = get_theme_mod( 'woo_link_active_color', '#2b4b80' );
	$css .= '
	.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li.active a
	{
		color: ' . esc_html( $link_active_color ) . ';
	}
	.visualcomposerstarter.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:before
	{
		background: ' . esc_html( $link_active_color ) . ';
	}
	';

	$outline_button_color = get_theme_mod( 'woo_outline_button_color', '#4e4e4e' );
	$css .= '
	.woocommerce button.button[name="update_cart"],
    .button[name="apply_coupon"],
    .vct-checkout-button,
    .woocommerce button.button:disabled, 
    .woocommerce button.button:disabled[disabled]
	{
		color: ' . esc_html( $outline_button_color ) . ';
	}';

	$price_filter_widget_color = get_theme_mod( 'woo_price_filter_widget_color', '#2b4b80' );
	$css .= '
	.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-handle,
	.visualcomposerstarter .woocommerce.widget.widget_price_filter .ui-slider .ui-slider-range
	{
		background-color: ' . esc_html( $price_filter_widget_color ) . ';
	}';

	$widget_links_color = get_theme_mod( 'woo_widget_links_color', '#000' );
	$css .= '
	.visualcomposerstarter .woocommerce.widget li a
	{
		color: ' . esc_html( $widget_links_color ) . ';
	}';

	$widget_links_hover_color = get_theme_mod( 'woo_widget_links_hover_color', '#2b4b80' );
	$css .= '
	.visualcomposerstarter .woocommerce.widget li a:hover,
	.visualcomposerstarter .woocommerce.widget li a:focus
	{
		color: ' . esc_html( $widget_links_hover_color ) . ';
	}';

	$delete_icon_color = get_theme_mod( 'woo_delete_icon_color', '#d5d5d5' );
	$css .= '
	.visualcomposerstarter.woocommerce-cart .woocommerce table.cart a.remove:before,
	.visualcomposerstarter .woocommerce.widget .cart_list li a.remove:before,
	.visualcomposerstarter.woocommerce-cart .woocommerce table.cart a.remove:after,
	.visualcomposerstarter .woocommerce.widget .cart_list li a.remove:after
	{
		background-color: ' . esc_html( $delete_icon_color ) . ';
	}';

	//wp_add_inline_style( 'visualcomposerstarter-custom-style', $css );
}
add_action( 'wp_enqueue_scripts', 'visualcomposerstarter_inline_styles' );
*/
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'visualcomposerstarter_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 */
function visualcomposerstarter_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array();

	if ( ! class_exists( 'acf' ) ) {
		$plugins[] = array(
			'name' => 'Advanced Custom Fields',
			'slug' => 'advanced-custom-fields',
			'required' => false,
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'visual-composer-starter',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}

/**
 *  For backward compatibility for background
 *
 * @deprecated 1.3
 */
function visualcomposerstarter_set_old_styles() {
	if ( get_theme_mod( 'vct_overall_site_bg_color' ) ) {
		set_theme_mod( 'background_color', str_replace( '#', '', get_theme_mod( 'vct_overall_site_bg_color' ) ) );
		remove_theme_mod( 'vct_overall_site_bg_color' );
	}

	if ( get_theme_mod( 'vct_overall_site_enable_bg_image' ) ) {

		set_theme_mod( 'background_attachment', 'scroll' );
		set_theme_mod( 'background_image', esc_url_raw( get_theme_mod( 'vct_overall_site_bg_image' ) ) );
		if ( 'repeat' === get_theme_mod( 'vct_overall_site_bg_image_style' ) ) {
			set_theme_mod( 'background_repeat', 'repeat' );
		} else {
			set_theme_mod( 'background_repeat', 'no-repeat' );
			set_theme_mod( 'background_size', esc_html( get_theme_mod( 'vct_overall_site_bg_image_style' ) ) );
		}

		remove_theme_mod( 'vct_overall_site_bg_image' );
		remove_theme_mod( 'vct_overall_site_bg_image_style' );
		remove_theme_mod( 'vct_overall_site_enable_bg_image' );
	}
}

/**
 * For backward compatibility content area size
 *
 * @deprecated 2.0.4
 */
function visualcomposerstarter_set_old_content_size() {
	if ( get_theme_mod( 'vct_content_area_size' ) ) {
		set_theme_mod( 'vct_overall_content_area_size', get_theme_mod( 'vct_content_area_size' ) );
		remove_theme_mod( 'vct_content_area_size' );
	}
}


/**
 *  WooCommerce support
 */
function visualcomposerstarter_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'visualcomposerstarter_support' );

/**
 *  WooCommerce single product gallery
 */
function visualcomposerstarter_woo_setup() {
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'visualcomposerstarter_woo_setup' );

/**
 *  WooCommerce single product categories layout
 */
function visualcomposerstarter_woo_categories() {
	global $product;
	// @codingStandardsIgnoreLine
	echo wc_get_product_category_list( $product->get_id(), ' ', '<div class="entry-categories"><span class="screen-reader-text">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'visual-composer-starter' ) . '</span>', '</div>' );
}
add_action( 'woocommerce_single_product_summary', 'visualcomposerstarter_woo_categories', 1 );

/**
 * WooCommerce single product tags layout
 */
function visualcomposerstarter_woo_tags() {
	global $product;
	// @codingStandardsIgnoreLine
	echo wc_get_product_tag_list( $product->get_id(), ' ', '<div class="entry-tags"><span class="screen-reader-text">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'visual-composer-starter' ) . '</span>', '</div>' );
}
add_action( 'woocommerce_single_product_summary', 'visualcomposerstarter_woo_tags', 65 );

/**
 * WooCommerce single product price layout
 *
 * @param product $price layout.
 * @param product $regular_price number.
 * @param product $sale_price number.
 * @return string
 */
function visualcomposerstarter_woo_format_sale_price( $price, $regular_price, $sale_price ) {
	$price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';

	return $price;
}
add_filter( 'woocommerce_format_sale_price', 'visualcomposerstarter_woo_format_sale_price', 10, 3 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 25 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );

/**
 * WooCommerce single product sale flash layout
 *
 * @param single $post data.
 * @param single $product data.
 * @return string
 */
function visualcomposerstarter_woo_sale_flash( $post, $product ) {
	$sale = <<<HTML
 <span class="onsale vct-sale">
	<svg width="48px" height="48px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg">
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Product-Open" transform="translate(-20.000000, -24.000000)" fill-rule="nonzero" fill="#FAC917">
                <g id="Image" transform="translate(0.000000, 4.000000)">
                    <g id="Discount" transform="translate(20.000000, 20.000000)">
                        <ellipse id="Oval" cx="17.5163" cy="19.8834847" rx="2.04" ry="2.00245399"></ellipse>
                        <ellipse id="Oval" cx="30.4763" cy="28.011092" rx="2.04" ry="2.00245399"></ellipse>
                        <path d="M47.2963,26.5975951 L46.5563,25.606184 C45.7563,24.5264294 45.7363,23.0638528 46.5263,21.9644663 L47.2463,20.9632393 C48.3463,19.4319509 47.8363,17.3018896 46.1463,16.408638 L45.0463,15.8294969 C43.8463,15.2012761 43.1863,13.8859387 43.4163,12.5607853 L43.6263,11.3534233 C43.9463,9.50802454 42.5363,7.80004908 40.6263,7.72152147 L39.3763,7.67244172 C38.0163,7.61354601 36.8363,6.71047853 36.4563,5.42458896 L36.1063,4.24667485 C35.5763,2.44053988 33.5563,1.50802454 31.7963,2.25403681 L30.6463,2.7350184 C29.3963,3.26507975 27.9363,2.95096933 27.0263,1.94974233 L26.1963,1.0368589 C24.9263,-0.357006135 22.6963,-0.347190184 21.4363,1.0761227 L20.6163,1.99882209 C19.7163,3.00986503 18.2663,3.34360736 17.0063,2.83317791 L15.8463,2.36201227 C14.0763,1.64544785 12.0763,2.61722699 11.5663,4.42336196 L11.2363,5.61109202 C10.8763,6.90679755 9.7163,7.82949693 8.3563,7.89820859 L7.1063,7.96692025 C5.1963,8.07489571 3.8163,9.80250307 4.1663,11.6479018 L4.3963,12.8552638 C4.6463,14.1706012 4.0063,15.4957546 2.8163,16.1436074 L1.7263,16.7423804 C0.0563,17.6552638 -0.4237,19.7951411 0.7063,21.3067975 L1.4463,22.2982086 C2.2463,23.3779632 2.2663,24.8405399 1.4763,25.9399264 L0.7563,26.9411534 C-0.3437,28.4724417 0.1663,30.6025031 1.8563,31.4957546 L2.9563,32.0748957 C4.1563,32.7031166 4.8163,34.018454 4.5863,35.3436074 L4.3763,36.5509693 C4.0563,38.3963681 5.4663,40.1043436 7.3763,40.1828712 L8.6263,40.2319509 C9.9863,40.2908466 11.1663,41.1939141 11.5463,42.4798037 L11.8963,43.6577178 C12.4263,45.4638528 14.4463,46.3963681 16.2063,45.6503558 L17.3563,45.1693742 C18.6063,44.6393129 20.0663,44.9534233 20.9763,45.9546503 L21.8063,46.8675337 C23.0863,48.2613988 25.3163,48.2515828 26.5663,46.8282699 L27.3863,45.9055706 C28.2863,44.8945276 29.7363,44.5607853 30.9963,45.0712147 L32.1563,45.5423804 C33.9263,46.2589448 35.9263,45.2871656 36.4363,43.4810307 L36.7663,42.2933006 C37.1263,40.9975951 38.2863,40.0748957 39.6463,40.006184 L40.8963,39.9374724 C42.8063,39.8294969 44.1863,38.1018896 43.8363,36.2564908 L43.6063,35.0491288 C43.3563,33.7337914 43.9963,32.408638 45.1863,31.7607853 L46.2763,31.1620123 C47.9463,30.2589448 48.4263,28.1190675 47.2963,26.5975951 Z M12.5863,19.8834847 C12.5863,17.213546 14.7863,15.0540368 17.5063,15.0540368 C20.2263,15.0540368 22.4263,17.213546 22.4263,19.8834847 C22.4263,22.5534233 20.2263,24.7129325 17.5063,24.7129325 C14.7863,24.7129325 12.5863,22.5436074 12.5863,19.8834847 Z M18.4563,32.3399264 C18.0363,32.8405399 17.2763,32.9092515 16.7663,32.4969816 L16.7663,32.4969816 C16.2563,32.0847117 16.1863,31.3386994 16.6063,30.8380859 L29.5163,15.5742822 C29.9363,15.0736687 30.6963,15.0049571 31.2063,15.417227 C31.7163,15.8294969 31.7863,16.5755092 31.3663,17.0761227 L18.4563,32.3399264 Z M30.4763,32.8405399 C27.7563,32.8405399 25.5563,30.6810307 25.5563,28.011092 C25.5563,25.3411534 27.7563,23.1816442 30.4763,23.1816442 C33.1963,23.1816442 35.3963,25.3411534 35.3963,28.011092 C35.3963,30.6810307 33.1963,32.8405399 30.4763,32.8405399 Z" id="Shape"></path>
                    </g>
                </g>
            </g>
        </g>
    </svg>
</span>
HTML;

	return $sale;
}
add_filter( 'woocommerce_sale_flash', 'visualcomposerstarter_woo_sale_flash', 10, 2 );

/**
 * Update cart woocommerce cart item count
 */
function visualcomposerstarter_woo_cart_count() {
	if ( function_exists( 'WC' ) ) {
		echo esc_html( WC()->cart->get_cart_contents_count() );
	}
	die;
}
add_action( 'wp_ajax_visualcomposerstarter_woo_cart_count', 'visualcomposerstarter_woo_cart_count' );
add_action( 'wp_ajax_nopriv_visualcomposerstarter_woo_cart_count', 'visualcomposerstarter_woo_cart_count' );

/**
 * Add variable container
 *
 * @param dropdown $html content.
 * @return string
 */
function visualcomposerstarter_woo_variable_container( $html ) {
	return '<div class="vct-variable-container">' . $html . '</div>';
}
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'visualcomposerstarter_woo_variable_container' );

/**
 * Removes the "shop" title on the main shop page
 *
 * @access public
 * @return bool
 */
function visualcomposerstarter_woo_hide_page_title() {
	return visualcomposerstarter_is_the_title_displayed();
}
add_filter( 'woocommerce_show_page_title', 'visualcomposerstarter_woo_hide_page_title' );

// Move payments after customer details.
remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20 );

function add_class_on_li( $classes, $item, $args )
{
  $classes[] = 'nav-item';
  return $classes;
}
add_filter( 'nav_menu_css_class', 'add_class_on_li', 1, 3 );

function add_link_atts( $atts, $item, $args )
{
  if( $args->theme_location == 'primary' )
  {
    $atts['class'] = 'nav-link text-white ml-lg-2 ml-xl-4 montserrat-regular';
  }
  if( $args->theme_location == 'footer-about' )
  {
    $atts['class'] = 'list-group-item list-group-item-action footer-menu';
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_link_atts', 10, 3 );


function vc_shortcode_carrousel_home ( $atts ){
	$html = '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';
  		$html = '<ol class="carousel-indicators home">';
		    $args = array(
		        'category_name'   => 'home-slider',
		        'orderby'         => 'ID',
		        'order'           => 'ASC',
		        'tag_slug__in'    => array( 'home' )
		    );
		    $myposts = get_posts( $args );
		    $count = count( $myposts );

		    //var_dump($myposts);

		    for( $i=0; $i<$count; $i++) :
		        if( $i === 0 ) :
		          $html .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="active d-none"></li>';
		        else:
		          $html .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $i . '" class="d-none"></li>';
		        endif;
		      endfor;
  		$html .= '</ol>';
		$html .= '<div class="carousel-inner" role="listbox">';
		    for( $i=0; $i<$count; $i++) : setup_postdata( $myposts[$i] );
		    	if ($i === 0) { $class = "active"; }  else { $class = ""; }
		    	$img = 'http://localhost/optionmetrics/wp-content/uploads/2018/06/Background.jpg';
		      	$html .= '<div class="carousel-item h100vh300 '.$class.' style="background-image: url('.$img.')">';
		        $html .= '<div class="d-flex h-100 align-items-center justify-content-center">';
		        	$html .= '<div class="carousel-caption position-static">';
		            	$html .= '<p class="blender-pro-bold main-slider-title mb-5">'. $myposts[$i]->post_title .'</p>';
		            	$html .= '<a class="btn btn-outline-light mb-3 btn-main-slider montserrat-light mr-md-3" href="/data-products/">View Products</a>';
		            	$html .= '<a class="btn btn-yellow mb-3 btn-main-slider" href="/qualification-process/">Let’s Talk</a>';
		          	$html .= '</div>';
		          	$html .='<div class="btn-down-arrow"><a href="#why-option"><i class="fas fa-chevron-down"></i></a></div>';
		        $html .= '</div>';
		      $html .= '</div>';
		    endfor; 
		  $html .= '</div>';
		  $html .= '<a class="carousel-control-prev d-none" href="#carouselExampleIndicators" role="button" data-slide="prev">';
		    $html .= '<span class="fa fa-angle-left fa-3x"></span>';
		    $html .= '<span class="sr-only">Previous</span>';
		  $html .= '</a>';
		  $html .= '<a class="carousel-control-next d-none" href="#carouselExampleIndicators" role="button" data-slide="next">';
		    $html .= '<span class="fa fa-angle-right fa-3x"></span>';
		    $html .= '<span class="sr-only">Next</span>';
		  $html .= '</a>';
		$html .= '</div>';




	
    return $html;


}
add_shortcode( 'my_vc_php_output', 'vc_shortcode_carrousel_home');


function vc_shortcode_news_home ( $atts ){
	$html = '<div class="row">';
      	$html .= '<div class="col-12 px-lg-0">';
        	$html .= '<div class="container bg-light-custom news-wrapper pb-0 px-lg-5">';
          		$html .= '<div class="row">';
            		$html .= '<div class="col-sm-12">';
              			$html .= '<p class="section-title text-center mb-4">News & Events</p>';
            		$html .= '</div>';
            		$html .= '<div class="col-md-6">';
            			//FEATURED
							$args = array(
							    'category_name'   => 'news-events',
							    'orderby'         => 'rand',
							    'showposts'       => 1,
							    'tag_slug__in'    => array( 'featured' )
  							);
  							$ft_post = new WP_Query( $args );
  								if( $ft_post->have_posts() ) :
    								while( $ft_post->have_posts() ) :
      									$ft_post->the_post();
      									$html .= '<div class="text-right position-absolute post-date big pr-3 pt-2">';
											$html .= '<span class="d-block h5 montserrat-light">'.get_the_date( 'M' ).'</span>';
											$html .= '<span class="d-block montserrat-medium">'.get_the_date( 'Y' ).'</span>';
										$html .= '</div>';
										$html .= '<a href="'.home_url().'"/news-events/">';
										$html .= '<img src="'.get_the_post_thumbnail_url().'" alt="Featured News And Events" class="img-fluid w-100 mb-3" />';
										$html .= '</a>';
										$html .= '<a href="'.home_url().'"/news-events/">';
										  $html .= '<p class="text-blue montserrat-medium home-news-events-main">'.get_the_title().'</p>';
										$html .= '</a>';
										$html .= '<p class="text-grey lato-regular home-news-events-main mb-4">'.get_the_content().'</p>';
										$html .= '<a class="text-blue-dark montserrat-medium mb-4 d-block" href="'.get_the_permalink().'">READ MORE';
										    $html .= '<span class="fa fa-angle-double-right"></span>';
										$html .= '</a>';
									endwhile; 
								endif;
	           		$html .= '</div>';
            		$html .= '<div class="col-md-6">';
              			$html .= '<div class="row">';
	                		//LAST FOUR
	              			$tag = get_term_by( 'name', 'featured', 'post_tag' );
	              			$args = array(
	    						'category_name'   => 'news-events',
	    						'orderby'         => 'date',
	    						'order'           => 'DESC',
	    						'showposts'       => 4,
	    						'tag__not_in'     => array( $tag->term_id )
	  						);											
  							$news = new WP_Query( $args );
  								if( $news->have_posts() ) :
    								while( $news->have_posts() ) :
      									$news->the_post();
									  	$html .= '<div class="col-6 col-md-6 hide-show-more">';
											$html .= '<div class="text-right position-absolute post-date pr-2 pt-2">';
  												$html .= '<span class="d-block montserrat-light">'.get_the_date( 'M' ).'</span>';
  												$html .= '<span class="d-block small montserrat-medium">'.get_the_date( 'Y' ).'</span>';
											$html .= '</div>';
									  		$html .= '<a href="'.home_url().'"/news-events/">';
									    		$html .= '<img src="'.get_the_post_thumbnail_url().'" alt="News & Events News-Event-ID-'.get_the_ID().'" class="img-fluid w-100 mb-3">';
									  		$html .= '</a>';
									  		$html .= '<a href="'.home_url().'"/news-events/">';
									  		  	$html .= '<p class="text-blue montserrat-medium home-news-events-last-four mb-1">'.get_the_title().'</p>';
									  		$html .= '</a>';
									  			$html .= '<p class="text-grey lato-regular home-news-events-last-four mb-5 mb-md-2 _content">'.get_the_content().'</p>';
									  		$html .= '<a class="btn btn-link pl-0 mb-5 text-blue montserrat-medium d-none d-md-inline-block" href="'.home_url().'"/news-events/">READ MORE';
									    		$html .= '<span class="fa fa-angle-double-right"></span>';
									 		$html .= '</a>';
									 	$html .= '</div>';
									endwhile; 
								endif;

              			$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
        	$html .= '</div>';
      	$html .= '</div>';
    $html .= '</div>';

    return $html;

}
add_shortcode( 'my_vc_php_output_news_home', 'vc_shortcode_news_home');


function vc_shortcode_news_featured ( $atts ){
    $html = '<div class="col-12 px-md-5 mb-5" id="events-offset">';
        $args = array(
    		'category_name'   => 'news-events',
    		'orderby'         => 'rand',
    		'showposts'       => 1,
    		'tag_slug__in'    => array( 'featured' )
  		);
  		$ft_post = new WP_Query( $args );
		if( $ft_post->have_posts() ) :
    		while( $ft_post->have_posts() ) :
      		$ft_post->the_post();
      		$html .= '<div class="row d-flex align-items-center">';
  				$html .= '<div class="col-12 text-center d-md-none">';
    				$html .= '<p class="section-title text-blue montserrat-medium">Events</p>';
				$html .= '</div>';
  				$html .= '<div class="col-md-6 pl-4">';
    				$html .= '<div class="text-right position-absolute post-date big pr-3 pt-2">';
  					$html .= '<span class="d-block h5 montserrat-light">'.get_the_date( 'M' ).'</span>';
  					$html .= '<span class="d-block montserrat-medium">'.get_the_date( 'Y' ).'</span>';
				$html .= '</div>';
   				$html .= '<img src="'.get_the_post_thumbnail_url().'" alt="Featured News And Events" class="img-fluid w-100 mb-3" />';
	  			$html .= '</div>';
				$html .= '<div class="col-md-6 text-center text-md-left">';
				    $html .= '<p class="text-blue-dark montserrat-medium">'.get_the_title().'</p>';
	    			$html .= '<p class="text-grey lato-regular">'.get_the_content().'</p>';
    				$html .= '<a href="'.get_the_permalink().' class="btn btn-link montserrat-medium pl-0 text-blue-dark">READ MORE <span class="fa fa-angle-double-right"></span> </a>';
  				$html .= '</div>';
			$html .= '</div>';
			endwhile; 
		endif;         
    $html .= '</div>';

    return $html;
}
add_shortcode( 'my_vc_php_output_news_featured', 'vc_shortcode_news_featured');


function vc_shortcode_events ( $atts ){
	$events = get_term_by( 'name', 'events', 'post_tag' );
  	$current_year = date('Y');
  	$const = 2002;
  	$args = array(
    	'category_name'   => 'news-events',
    	'orderby'         => 'date',
    	'order'           => 'DESC',
    	'tag__in'         => array( $events->term_id )
  	);

	if (isset($_GET['years'])) {
	    $year_param = $_GET['years'];
		$args['year'] = $year_param;
	}

  	$newsPosts = new WP_Query( $args );

	$html = '<div class="col-12 col-md-5 mb-5" id="news-offset">';
  		$html = '<div class="row">';
    		$html .= '<div class="col-12 text-center">';
      			$html .= '<p class="section-title text-blue montserrat-medium">Events</p>';
    		$html .= '</div>';
    		$html .= '<div class="col-12">';
      			$html .= '<select class="om-select width-100" name="events-year-filter" id="events-year-filter">';
        			$html .= '<option value="filter-by-year">Filter by year</option>';
        				for ($i=$current_year; $i>=$const; $i--):
          					$html .= '<option value="'.$i.'">'.$i.'</option>';
        				endfor; 
      				$html .= '</select>';
      				$html .= '<table id="news">'; 
        			$html .= '<thead><tr><th></th></tr></thead>';
        			$html .= '<tbody>';
          				if( $newsPosts->have_posts() ) :
              				while( $newsPosts->have_posts() ) :
                				$newsPosts->the_post();
          							$html .= '<tr>';
            							$html .= '<td>';
              								$html .= '<div class="row">';
                								$html .= '<div class="col px-1 hide-show-more py-3">';
                  									$html .= '<p class="event-pub-title event-pub-label montserrat-bold mb-0">'.get_the_title().'</p>';
                  									$html .= '<p class="event-pub-date event-pub-label montserrat-bold">'.get_the_date( 'F jS, Y' ).'</p>';
                  									$html .= '<p class="event-pub-description event-pub-label lato-light mb-3 _content">'.get_the_content().'</p>';
                  									$html .= '<a class="event-pub-read-more montserrat-medium" href="'.get_the_permalink().'">READ MORE<span class="fa fa-angle-double-right"></span></a>';
                    							$html .='</div>';
              								$html .='</div>';
            							$html .='</td>';
          							$html .='</tr>';
          					endwhile;
          				endif;
        			$html .='</tbody>';
      			$html .='</table>';
    		$html .='</div>';
  		$html .='</div>';
	$html .='</div>';

	/*$sc_args = '[wp-datatable id="news" fat="LEVEL"]
	search: true,
	responsive: true,
	pageLength: 6,
	lengthChange: false,
	bInfo: false,
	language: {
	  search: "",
	  searchPlaceholder: "Search Events...",
	  paginate: {
	    next: "<span class=\"fa fa-chevron-right\"></span>",
	    previous: "<span class=\"fa fa-chevron-left\"></span>",
	  }
	},
	[/wp-datatable]';
    echo do_shortcode( $sc_args );*/

  return $html;

}
add_shortcode( 'my_vc_php_output_events', 'vc_shortcode_events');







function vc_shortcode_news ( $atts ){
  $featured = get_term_by( 'name', 'featured', 'post_tag' );
  $news = get_term_by( 'name', 'news', 'post_tag' );

  $args = array(
    'category_name'   => 'news-events',
    'orderby'         => 'date',
    'order'           => 'DESC',
    'tag__not_in'     => array( $featured->term_id ),
    'tag__in'         => array( $news->term_id )
  );
  $eventPosts = new WP_Query( $args );

  	$html = '<div class="col-12 ">';
  		$html .= '<div class="row">';
    		$html .= '<div class="col-12 d-none d-md-block d-lg-none text-center">';
      			$html .= '<p class="section-title text-blue montserrat-medium">News</p>'; 
    		$html .= '</div>';
    		$html .= '<div class="col-12 d-none d-lg-inline-block pl-4">';
      			$html .= '<p class="section-title text-blue montserrat-medium position-relative">News</p>';
    		$html .= '</div>';
    		$html .= '<div class="col-12">';
      			$html .= '<table id="events">';
    				$html .= '<thead><tr><th></th></tr></thead>';
    				$html .= '<tbody>';
	      				if( $eventPosts->have_posts() ) :
	          				while( $eventPosts->have_posts() ) :
	            				$eventPosts->the_post();
		      					$html .= '<tr>';
			        				$html .= '<td>';
			          					$html .= '<div class="row">';
			            					$html .= '<div class="col-6 col-md-5">';
			              						$html .= '<img src="'.get_the_post_thumbnail_url().'" alt="News & Events News-Event-ID-'.get_the_ID().'" class="img-fluid w-100 mb-3">';
			            					$html .= '</div>';
			            					$html .= '<div class="col-6 col-md-7 hide-show-more">';
			              						$html .= '<p class="text-blue montserrat-bold news-mini mb-2">'.get_the_title().'</p>';
			              						$html .= '<p class="text-grey-dark lato-regular news-mini mb-2 _content">'.get_the_content().'</p>';
			              						$html .= '<a class="text-blue montserrat-medium" href="'.get_the_permalink().'"> READ MORE <span class="fa fa-angle-double-right"></span> </a>';
			            					$html .= '</div>';
			          					$html .= '</div>';
			        				$html .= '</td>';
		      					$html .= '</tr>';
	      					endwhile;
	      				endif;
    				$html .= '</tbody>';
  				$html .= '</table>';
    		$html .= '</div>';
  		$html .= '</div>';
	$html .= '</div>'; 
	/*$sc_args = '[wp-datatable id="events" fat="LEVEL"]
    	search: true,
    	responsive: true,
    	pageLength: 4,
    	lengthChange: false,
    	bInfo: false,
    	language: {
      		search: "",
      		searchPlaceholder: "Search News...",
      		paginate: {
        		next: "<span class=\"fa fa-chevron-right\"></span>",
        		previous: "<span class=\"fa fa-chevron-left\"></span>",
      		}
    	}
  	[/wp-datatable]';
  	echo do_shortcode( $sc_args );*/

  return $html;

}
add_shortcode( 'my_vc_php_output_news', 'vc_shortcode_news');


function vc_shortcode_careers ( $atts ){

		$html = '<div class="position-relative">';
  			$html .= '<div class="position-absolute page-wrapper-up">';
    			$html .= '<div class="container pt-3 p-lg-5 pb-4 bg-white">';
      				$html .= '<div id="form-careers" class="py-5">';
          				$html .= '<div class="text-center mx-auto">';
            				$html .= '<p class="text-blue montserrat-bold mb-4 be-part-title">Be part of an exceptionally creative and intelligent team</p>';
            				$html .= '<p class="text-black lato-light mb-4 be-part-description">OptionMetrics is hiring. Join developers, quants, and econometrics specialists with a passion for excellence in all things volatility to collaborate on proprietary data and analytics products for our distinguished client base of hedge fund managers, institutional investors, and academic institutions.</p>';
				            $html .= '<p class="text-black lato-bold mb-4 be-part-description">We encourage true ownership over products and reward innovation. Take your career to new heights.</p>';

            				$html .= '<div class="d-lg-none">';
              					$html .= '<div class="m-auto about-us-form">';
                					$html .= '<div class="form-group text-center lato-regular text-white">';
                  						$html .= '<label for="exampleFormControlInput1">I’m interested in</label>';
                  						$html .= '<select class="form-control" id="exampleFormControlInput1">';
                    						$html .= '<option value="0">Choose Job Category</option>';
                      							$jobs = new WP_Query( array( 'category_name' => 'careers' ) );
                      								if( $jobs->have_posts() ) :
                        								while( $jobs->have_posts() ) :
                          									$jobs->the_post();
                      											$html .= '<option value="'.get_the_permalink().'"'.get_the_title() . ' (' . get_post_meta(get_the_ID(), 'careers_location', true) . ')</option>';
                    									endwhile; 
                    								endif;
                  						$html .= '</select>';
                					$html .= '</div>';
                					$html .= '<div class="form-group mb-0">';
                 						$html .= '<button class="btn btn-warning montserrat-medium btn-block" id="search-job-mobile">Submit</button>';
                					$html .= '</div>';
            					$html .= '</div>';
        					$html .= ' </div>';
        					$html .= ' <div class="d-none d-lg-block mt-lg-5">';
        						$html .= '<div class="form-inline justify-content-center">';
            						$html .= '<div class="form-group text-center lato-regular text-white">';
                						$html .= '<label for="exampleFormControlInput2" class="mr-4">I’m interested in</label>';
                							$html .= '<select class="form-control" id="exampleFormControlSelect2">';
                								$html .= '<option value="0">Choose Job Category</option>';
                      								if( $jobs->have_posts() ) :
                        								while( $jobs->have_posts() ) :
                          									$jobs->the_post();
                      											$html .= '<option value="'.get_the_permalink().'"'.get_the_title() . ' (' . get_post_meta(get_the_ID(), 'careers_location', true) . ')</option>';
                    									endwhile; 
                    								endif;
                  							$html .= '</select>';
                					$html .= '</div>';
                					$html .= '<div class="form-group mb-0">';
                  						$html .= '<button class="btn btn-yellow btn-block ml-4" style="height:38px;font-size:16px;" id="search-job-desktop">Submit</button>';
                					$html .= '</div>';
            					$html .= '</div>';
        					$html .= '</div>';
          				$html .= '</div>';
      				$html .= '</div>';
      				$html .= '<div class="text-center">';
        				$html .= '<div class="col-12 p-0 py-5">';
          					$html .= '<div id="carouselJobs" class="carousel slide" data-ride="carousel">';
            					$html .= '<ol class="carousel-indicators blue jobs-indicators">';
              						$i = 0;
              							if( $jobs->have_posts() ) :
                							while( $jobs->have_posts() ) :
                  								$jobs->the_post();
                  								if ($i == 0 ) { $clsb = 'active '; } else { $clsb = ''; }
              										$html .= '<li data-target="#carouselJobs" data-slide-to="'.$i.'" '.$clsb.'style="margin-left:5px!important;margin-right:5px!important;"></li>';
              									$i++; 
              								endwhile; 
              							endif;
            					$html .= '</ol>';
            						$html .= '<div class="carousel-inner" role="listbox">';
              							$i = 0;
                							if( $jobs->have_posts() ) :
                  								while( $jobs->have_posts() ) :
                    								$jobs->the_post();
                    									if ($i == 0 ) { $cls = 'active '; } else { $cls = ''; }
                											$html .= '<div class="carousel-item '.$cls.'">';
                  										 		$html .= '<div class="col-md-6 offset-md-3">'.get_the_post_thumbnail( get_the_ID(), "", array( "class" => "attachment-full img-fluid w-100" ) ).'>';
																	$html .= '<p class="montserrat-medium text-blue mt-2 mb-0">'.get_the_title().'</p>';
                  	 												$html .= '<a href="'.get_the_permalink().'" class="btn btn-link montserrat-medium text-blue pl-md-0 o-50">SEE POSITION<span class="fa fa-angle-double-right"></span></a>';
                  												$html .= '</div>';
                											$html .= '</div>';
              											$i++; 
              									endwhile; 
              								endif;
            						$html .= '</div>';
            						$html .= '<a class="carousel-control-prev text-jobs-indicators" href="#carouselJobs" role="button" data-slide="prev">';
              							$html .= '<span class="fa fa-angle-left fa-3x position-absolute" aria-hidden="true"></span>';
              							$html .= '<span class="sr-only">Previous</span>';
            						$html .= '</a>';
            						$html .= '<a class="carousel-control-next text-jobs-indicators" href="#carouselJobs" role="button" data-slide="next">';
              							$html .= '<span class="fa fa-angle-right fa-3x position-absolute" aria-hidden="true"></span>';
              							$html .= '<span class="sr-only">Next</span>';
            						$html .= '</a>';
          					$html .= '</div>';
        				$html .= '</div>';
      				$html .= '</div>';
    			$html .= '</div>';
			$html .= '</div>';
		$html .= '</div>';

  return $html;

}
add_shortcode( 'my_vc_php_output_careers', 'vc_shortcode_careers');

add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);
function ajax_filter_posts_scripts()
{
    // Enqueue script
    // just enqueue as its already registered
    wp_enqueue_script('afp_script1', '//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js', array('jquery'), '0.0.1', true);
    wp_enqueue_script('afp_script2', '//cdn.datatables.net/plug-ins/1.10.19/sorting/date-uk.js', array('jquery'), '0.0.1', true);
    wp_enqueue_script('afp_script', get_template_directory_uri() .'/js/research.js', array('jquery'), '0.0.1', true);
    wp_enqueue_script('afp_script');
    wp_localize_script('afp_script', 'afp_vars', array(
            'afp_nonce' => wp_create_nonce('afp_nonce'), // Create nonce which we later will use to verify AJAX request
            'afp_ajax_url' => admin_url('admin-ajax.php'),
            'error' => __('Sorry, something went wrong. Please try again', 'reportabug'),
        )
    );


}

add_action('wp_ajax_filter_posts', 'ajax_filter_get_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts');


//Get Posts Ajax
function ajax_filter_get_posts($category)
{

    // Verify nonce
    if (!isset($_POST['afp_nonce']) ||
        !wp_verify_nonce($_POST['afp_nonce'], 'afp_nonce')
    )
        die('Permission denied');
    if (isset($_POST['date'])) {
        $year = $_POST['date'];
    } else {
        $year = '';
    }

    $tag = $_POST['stuff'];
    $category = $_POST['taxonomy'];

    $args = array(
        'category_name' => $category,
        'posts_per_page' => -1,
        'hide_empty' => true,
        'orderby' => 'publish_date',
        'order' => 'DESC',
        's' => '',
        'tag_slug__in' => $tag,
        'date_query' => array(array(
            'year' => $year
        ))
    );
    $the_query = new WP_Query ($args);
    $post_id = get_the_id();
    $post_array = array();
    if ($the_query->have_posts()) :
        ob_start();
        while ($the_query->have_posts()) :
            $the_query->the_post();

            $title = get_the_title();
            $post_date = get_the_date('F jS, Y');
            $link = get_the_permalink();
            $content = get_the_content();

            if ($category == 'research') {
                $html_post = '<p class="text-blue h6 montserrat-medium">' . $title . '</p>';
                $html_post .= '<p class="text-grey-light lato-italic">' . $post_date . '</p>';
                $html_post .= '<p class="_content lato-regular text-grey">' . get_the_content() . '</p>';
                $html_post .= '<a href="' . $link . '" class="btn btn-link text-grey-light montserrat-regular mb-3">READ MORE<span class="fa fa-angle-double-right"></span></a>';
            } else {
                $html_post = '<div class="row">';
                $html_post .= '<div class="col px-1 hide-show-more py-3">';
                $html_post .= '<p class="event-pub-title event-pub-label montserrat-bold mb-0">' . $post_date . '</p>';
                $html_post .= '<p class="event-pub-date event-pub-label montserrat-bold">' . $title . '</p>';
                $html_post .= '<p class="event-pub-description event-pub-label lato-light mb-3 _content">' . $content . '</p>';
                $html_post .= '<a class="event-pub-read-more montserrat-medium" href="' . $link . '">';
                $html_post .= '    READ MORE';
                $html_post .= '<span class="fa fa-angle-double-right"></span>';
                $html_post .= '</a>';
                $html_post .= '</div>';
                $html_post .= '</div>';
            }

            $post_array[0] = $html_post;
            //Inserting the date in UK format to sort by date with datatablesJS on Research.js file
            $post_array['1'] = get_the_date('d/m/Y', get_the_id());
            $dataSet[] = $post_array;
        endwhile;
        ob_get_clean();
    else:
        $html_post = '<div class="text-center"><p class="text-center"><i class="far fa-file"></i> <span>No Data Found</span></p></div>';
        $post_array[0] = $html_post;
        $post_array['1'] = get_the_date('d/m/Y', $post_id);
        $dataSet[] = $post_array;
    endif;

    echo json_encode($dataSet);
    wp_die();


}


function vc_shortcode_research ( $atts ){

    $html = '<div class="row">';
        $html .= '<div class="col-12 d-none d-md-block">';
         	$html .= '<p class="our-most-research-title montserrat-bold">Our Most Recent Research</p>';
        $html .= '</div>';
        $html .= '<div class="col-12 col-md-7 d-md-none">';
        	$html .= '<p class="text-blue lato-regular py-md-4 text-center" style="max-width:880px;">OptionMetrics data is an essential component of many studies performed by both academics and practitioners. Below is a partial list of academic papers that used OptionMetrics data:</p>';
          		$html .= '<div class="text-center pt-3">';
            		$html .= '<p class="montserrat-bold research-section-title mb-3" id="research-by-mobile">Research by:</p>';
            			$html .= '<select class="om-select" name="type-of-research-select" id="type-of-research-select">';
              				$html .= '<option data-toggle="tab" value="view-all">View All</option>';
              				$html .= '<option data-toggle="tab" value="optionmetrics">Optionmetrics</option>';
              				$html .= '<option data-toggle="tab" value="academics">Academics</option>';
              				$html .= '<option data-toggle="tab" value="institutional">Institutional</option>';
            			$html .= '</select>';
	          		$html .= '</div>';
        		$html .= '</div>';
        		$html .= '<div class="col-12 px-4 pb-5 text-center hide-show-more d-md-none">';
          			//get_template_part( 'partials/research', 'mobile' ); 
        		$html .= '</div>'; 
        		$html .= '<div class="col-12 px-4 d-none d-md-block hide-show-more text-center">';
          			// RESEARCH FEATURED SECTION
        			$args = array(
						'category_name'   => 'research',
						'orderby'         => 'rand',
						'showposts'       => 1,
						'tag_slug__in'    => array( 'featured' )
					);
					$ft_post = new WP_Query( $args );
					if( $ft_post->have_posts() ) :
						while( $ft_post->have_posts() ) :
					  		$ft_post->the_post();
							$html .= '<p class="text-blue h4 montserrat-regular mx-auto" style="max-width:700px;">'.get_the_title().'</p>';
							$html .= '<p class="text-grey-light lato-italic text-center my-4">'.get_the_date( "F jS, Y" ).'</p>';
							$html .= '<p id="research-top" class="lato-regular mx-auto px-md-0" style="max-width:1100px;">'.get_the_content().'<a class="text-blue-dark montserrat-medium ml-1" href="'.get_the_permalink().'"> READ MORE <span class="fa fa-angle-double-right"></span> </a> </p>';
							$html .= '<a href="#papers-view" class="btn btn-yellow mt-3 mb-4" id="view-our-research-papers">View Our Research Papers</a>';
						endwhile;
					endif;
        		$html .= '</div>';
        		$html .= '<div class="col-12 col-lg-7 d-none d-md-block">';
          			$html .= '<p class="research-essential-info lato-regular py-md-4" style="max-width:880px;">OptionMetrics data is an essential component of many studies performed by both academics and practitioners. Below is a partial list of academic papers that used OptionMetrics data:</p>';
        		$html .= '</div>';
        		$html .= '<div class="col-sm-7 d-none d-md-block hide-show-more pb-4">';
        			$html .= '<p class="montserrat-bold research-section-title" id="research-by">Research by:</p>';
          			$html .= '<nav>';
            			$html .= '<div class="nav nav-tabs justify-content-between mb-5" id="nav-tab" role="tablist">';
              				$html .= '<a class="nav-item research-nav-item first active" id="nav-tab-view-all" data-toggle="tab" role="tab" aria-controls="nav-view-all" aria-selected="true" name="view-all-research">View All</a>';
              				$html .= '<a class="nav-item research-nav-item" id="nav-tab-optionmetrics" data-toggle="tab" role="tab" aria-controls="nav-optionmetrics" aria-selected="false" name="optionmetrics">Optionmetrics</a>';
              				$html .= '<a class="nav-item research-nav-item" id="nav-tab-academics" data-toggle="tab" role="tab" aria-controls="nav-academics" aria-selected="false" name="academics-research">Academics</a>';
              				$html .= '<a class="nav-item research-nav-item" id="nav-tab-institutional" data-toggle="tab" role="tab" aria-controls="nav-institutional" aria-selected="false" name="institutional">Institutional</a>';
          		  		$html .= '</div>';
          			$html .= '</nav>';
          			//RESEARCH DESKTOP
          			$featured = get_term_by('name', 'featured', 'post_tag');
					$type_of_research = isset($_GET['type_of_research']) ? $_GET['type_of_research'] : 'view-all-research';
					$args = array(
    					'category_name' => 'research',
    					'orderby' => 'publish_date',
    					'order' => 'DESC',
    					'tag__not_in' => $featured->term_id,
    					'tag' => $type_of_research
					);

					if (isset($_GET['query_year'])) {
					    $year = $_GET['query_year'];
					    if (is_numeric($year)) {
					        $args['date_query'] = array(array(
					            'year' => $year
					        ));
					    }
					}

					$research_desktop = new WP_Query($args);
					$html .= '<div id="papers-view">';
        				$html .= '<table id="research-posts" class="display" style="width:100%">';

        				$html .= '</table>';
          			$html .= '</div>';
        		$html .= '</div>';
        		$html .= '<div class="col-12 col-md-5 pb-5">';
          			//RESEARCH PAPPERS
        			$args = array(
    					'category_name'   => 'white-papers',
    					'orderby'         => 'date',
    					'order'           => 'DESC',
    					'showposts'       => 3
  					);
  					$papers = new WP_Query( $args );

					$html .= '<p class="montserrat-bold research-section-title">Top Research Papers</p>';
					$html .= '<div class="bg-light p-3 mb-3">';
    					$i = 1;
    					if( $papers->have_posts() ) :
      						while( $papers->have_posts() ) :
        						$papers->the_post();
        						$link = get_post_meta( get_the_ID(), 'white_papers_url', true );
        							$html .= '<a href="<?php echo $link; ?>" target="_blank" class="text-blue montserrat-medium p-3 d-block">'.get_the_title().'</a>';
    								if( $i < $papers->post_count ) :
        								$html .= '<hr />';
        							$i++;
      								endif;
      						endwhile;
      					endif;
      				$html .= '</div>';
      				//RESEARCH YEARS
      				$year_param = isset($_GET['query_year']) ? $_GET['query_year'] : 'all';
  					$year = date('Y');
  					$LAST = 2002;

					$html .= '<p class="montserrat-bold research-section-title d-none d-sm-block mt-5">All Research Papers</p>';
					$html .= '<div class="w-100 position-relative d-none d-sm-block" style="left:10px;">';
					  	$html .= '<div class="timeline">';
					  	if ($year_param == 'all') { $clsa = 'active'; } else { $clsa = ''; }
					    $html .= '<div class="entry '.$clsa.'">';
					      	$html .= '<p class="d-inline timeline-year montserrat-light text-blue '.$clsa.'" data-year="all" style="cursor:pointer">All years</p> </div>';
					    	for ($i=$year; $i>=$LAST; $i--):
					    		if ($i == $year_param) { $cls = 'active'; } else { $cls = ''; }
					    		$html .= '<div class="entry '.$cls.'">';
					      			$html .= '<p class="d-inline timeline-year montserrat-light text-blue '.$cls.'" data-year="'.$i.'" style="cursor:pointer">'.$i.'</p>';
					    		$html .= '</div>';
					    	endfor;
					    $html .= '</div>';
					$html .= '</div>';
        		$html .= '</div>';
        		$html .= '<div class="col-12 pb-5">';
          			$html .= '<div class="col-12">';
            			$html .= '<p class="section-title text-center my-0">Some of our Clients</p>';
          			$html .= '</div>';
          			$html .= '<div class="col-12">';
          				do_shortcode( '[jssor-slider alias="carousel-slider.slider"]' );
          			$html .= '</div>';
        		$html .= '</div>';
    	$html .= '</div>';
	$html .= '</div>';


	return $html;

}
add_shortcode( 'my_vc_php_output_research', 'vc_shortcode_research');




function vc_shortcode_about_us ( $atts ){


   	$html = '<div class="row">';
        $html .= '<div class="pt-4 pb-0 col-md-6 pr-md-2 pl-md-5 pt-md-5 col-lg-4">';
          	$html .= '<div class="row">';
            	$html .= '<div class="col-md-3 text-center">';
            		$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Common_language_icon.png').'" alt="Common Language" class="img-fluid w-md-100 pb-4" />';
            	$html .= '</div>';
           		$html .= '<div class="col-md-9 text-center text-md-left pl-md-0">';
          			$html .= '<div class="row">';
               			$html .= '<div class="col-12">';
               				$html .= '<p class="text-blue p montserrat-medium mb-4">We use a common language all practitioners understand</p>';
               			$html .= '</div>';
               			$html .= '<div class="col-12">';
         	    			$html .= '<p class="text-grey lato-regular p">Black-Scholes-Merton implied volatilities are standard for quoting options prices. Differences across delta (smile or skew) and across time-to-expiration (term structure) provide ample fodder for investigating arbitrage and relative value opportunities.</p>';
               			$html .= '</div>';
          			$html .= '</div>';
           		$html .= '</div>';
        	$html .= '</div>';
    	$html .= '</div>';
	    $html .= '<div class="pt-4 pb-0 col-md-6 pr-md-5 pl-md-2 pt-md-5 col-lg-4 pr-lg-2">';
	        $html .= '<div class="row">';
	            $html .= '<div class="col-md-3 text-center pr-md-0"><img src="'.home_url('wp-content/uploads/2019/04/Replicate_icon.png').'" alt="Replicate" class="img-fluid w-md-100 pb-4" /></div>';
	            $html .= '<div class="col-md-9 text-center text-md-left pl-md-0">';
	            	$html .= '<div class="row">';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-blue p montserrat-medium mb-4">Replicate and extend studies with full confidence.</p>';
	                	$html .= '</div>';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-grey lato-regular p">Our data is the industry standard across academic and industry research that involves options data, from trading strategy research to corporate finance.<br/>Currently, over 300 institutional subscribers and universities rely on OptionMetrics.</p>';
	                	$html .= '</div>';
	              	$html .= '</div>';
	            $html .= '</div>';
	        $html .= '</div>';
	    $html .= '</div>';
	    $html .= '<div class="pt-4 pb-0 col-md-6 pr-md-2 pl-md-5 pt-md-5 col-lg-4 pl-lg-2 pr-lg-5">';
	        $html .= '<div class="row">';
	            $html .= '<div class="col-md-3 text-center pr-md-0"><img src="'.home_url('wp-content/uploads/2019/04/InControl_icon.png').'" alt="In Control" class="img-fluid w-md-100 pb-4" /></div>';
	            $html .= '<div class="col-md-9 text-center text-md-left pl-md-0">'; 
	            	$html .= '<div class="row">';
	                	$html .= '<div class="col-12">'; 
	                  		$html .= '<p class="text-blue p montserrat-medium mb-4">You are in control.</p>';
	                	$html .= '</div>';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-grey lato-regular p">Our products allow you to backtest trading strategies, evaluate risk models, and perform sophisticated research on all aspects of option investment.</p>';
	                	$html .= '</div>';
	              	$html .= '</div>';
	            $html .= '</div>';
	        $html .= '</div>';
	    $html .= '</div>';
	    $html .= '<div class="pt-4 pb-0 col-md-6 pr-md-5 pl-md-2 pt-md-5 col-lg-4 pl-lg-5 pr-lg-2">';
	        $html .= '<div class="row">';
	            $html .= '<div class="col-md-3 text-center">';
	            	$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Methodology_icon.png').'" alt="Methodology" class="img-fluid w-md-100 pb-4" />';
	            $html .= '</div>';
	            $html .= '<div class="col-md-9 text-center text-md-left pl-md-0">';
	            	$html .= '<div class="row">';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-blue p montserrat-medium mb-4">Completely transparent methodology.</p>';
	                	$html .= '</div>';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-grey lato-regular">Our documentation explains exactly how our calculations work with enough detail to allow replication for spot checking. Additionally, all the raw data used is included with a subscription.</p>';
	                	$html .= '</div>';
	              	$html .= '</div>';
	            $html .= '</div>';
	        $html .= '</div>';
	    $html .= '</div>';
	    $html .= '<div class="pt-4 pb-0 col-md-6 pl-md-5 pr-md-2 pt-md-5 col-lg-4 pl-lg-2 pr-lg-2">';
	        $html .= '<div class="row">';
	            $html .= '<div class="col-md-3 text-center pr-md-0">';
	              	$html .= '<img src="'.home_url('wp-content/uploads/2019/04/OurData_icon.png').'" alt="Our Data" class="img-fluid w-md-100 pb-4" />';
	            $html .= '</div>';
	            $html .= '<div class="col-md-9 text-center text-md-left pl-md-0">';
	              	$html .= '<div class="row">';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-blue p montserrat-medium mb-4">Our data is independent and completely based on traded instruments and exchange data.</p>';
	                	$html .= '</div>';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-grey lato-regular">We do not use input from market makers or brokers, and we are not affiliated with any bank, exchange or data vendor.</p>';
	                	$html .= '</div>';
	              	$html .= '</div>';
	            $html .= '</div>';
	        $html .= '</div>';
	    $html .= '</div>';
	    $html .= '<div class="pt-4 pb-0 col-md-6 pl-md-2 pr-md-5 pt-md-5 col-lg-4 pl-lg-2">';
	        $html .= '<div class="row">';
	            $html .= '<div class="col-md-3 text-center pr-md-0">';
	              	$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Host_icon.png').'" alt="Host" class="img-fluid w-md-100 pb-4" />';
	            $html .= '</div>';
	            $html .= '<div class="col-md-9 text-center text-md-left pl-md-0">';
	              	$html .= '<div class="row">';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-blue p montserrat-medium mb-4">Host and access data to suit your needs.</p>';
	                	$html .= '</div>';
	                	$html .= '<div class="col-12">';
	                  		$html .= '<p class="text-grey lato-regular">Access is not tied to any particular API or tool. Users can choose to use an SQL server database and we include utilities to help set this up.</p>';
	                	$html .= '</div>';
	              	$html .= '</div>';
	            $html .= '</div>';
	        $html .= '</div>';
	    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="col-12 mt-5 mb-4 text-center">';
        $html .= '<a class="btn btn-yellow btn-main-slider" href="/qualification-process/">Get Started Now!</a>';
    $html .= '</div>';
    $html .= '<div class="mb-5" id="leaderships">';
        $html .= '<div class="row px-lg-5 mx-lg-5">';
          	$html .= '<div class="col-12">';
            	$html .= '<p class="section-title text-center mb-5 mt-5">Leadership</p>';
          	$html .= '</div>';
          	$html .= '<div class="col-12 d-lg-none">';
            	$html .= '<div id="carouselPartners" class="carousel slide" data-ride="carousel">';
              		$html .= '<ol class="carousel-indicators blue partners-indicators">';
                		$html .= '<li data-target="#carouselPartners" data-slide-to="0" class="active"></li>';
                		$html .= '<li data-target="#carouselPartners" data-slide-to="1"></li>';
              		$html .= '</ol>';
              		$html .= '<div class="carousel-inner" role="listbox">';
                		$html .= '<div class="carousel-item active text-center">';
                  			$html .= '<img src="'.home_url('wp-content/uploads/2019/04/David_photo_on.png').'" alt="David" />';
                  			$html .= '<div class="arrow-up mt-5 mx-auto"></div>';
              				$html .= '<div class="partner-wrapper">';
                				$html .= '<p class="text-blue montserrat-medium h5">David J. Hait, Ph.D.</p>';
                				$html .= '<p class="text-blue montserrat-medium font-italic small">CEO AND FOUNDER</p>';
                				$html .= '<p class="text-grey lato-regular">David J. Hait, Ph.D. is the CEO of OptionMetrics, LLC, which he founded in 1999. Dr. Hait is a financial economist with over 20 years of experience in applied quantitative derivative research and technology. Prior to founding OptionMetrics he served as Vice President in the Fixed Income Research Group at Paine Webber, and taught courses on derivatives at J. P. Morgan. Dr. Hait received his Ph.D. in Finance from New York University’s Stern School of Business, where he was an Adjunct Professor at the Stern School of Business and Courant Institute of Mathematics. Dr. Hait also received an MS in Computer Science from University of California at Berkeley and a BSE in Computer Engineering from the University of Pennsylvania.</p>';
              				$html .= '</div>';
                		$html .= '</div>';
                		$html .= '<div class="carousel-item text-center">';
                  			$html .= '<img src="'.home_url('wp-content/uploads/2019/04/photo_eran_on.png').'" alt="Eran" />';
                  			$html .= '<div class="arrow-up mt-5 mx-auto"></div>';
                  				$html .= '<div class="partner-wrapper">';
                    				$html .= '<p class="text-blue montserrat-medium h5">Eran Steinberg</p>';
                    				$html .= '<p class="text-blue montserrat-medium font-italic small">COO AND CHIEF OF STAFF</p>';
                    				$html .= '<p class="text-grey lato-regular">Eran is a seasoned sales executive with close to 20 years of financial industry experience. Prior to joining OptionMetrics, Eran spent 13 years at Capital IQ, a leading global provider of public and private capital market data applications, helping it grow from its earliest days through and beyond its eventual acquisition by Standard & Poor’s (now S&P Global), finishing as Head of Account Management for all of the Americas. Prior to S&P Eran spent close to a decade working in for profit education for Kaplan Test Prep and then briefly for ALFY, a start-up focused on designing a subscription-based educational gaming site for young children. Eran received a Bachelor of Science in Management from Binghamton University (SUNY), and a J.D. from the Benjamin N. Cardozo School of Law (Yeshiva University).</p>';
                  				$html .= '</div>';
                			$html .= '</div>';
              			$html .= '</div>';
              			$html .= '<a class="carousel-control-prev" href="#carouselPartners" role="button" data-slide="prev">';
                			$html .= '<span class="fa fa-angle-left fa-3x text-grey position-absolute" style="top:50px;" aria-hidden="true"></span>';
                			$html .= '<span class="sr-only">Previous</span>';
              			$html .= '</a>';
              			$html .= '<a class="carousel-control-next" href="#carouselPartners" role="button" data-slide="next">';
                			$html .= '<span class="fa fa-angle-right fa-3x text-grey position-absolute" style="top:50px;" aria-hidden="true"></span>';
                			$html .= '<span class="sr-only">Next</span>';
              			$html .= '</a>';
            		$html .= '</div>';
          		$html .= '</div>';
          		$html .= '<div class="col-lg-6 d-none d-lg-inline-block text-center">';
            		$html .= '<img src="'.home_url('wp-content/uploads/2019/04/David_photo_on.png').'" alt="David" class="img-fluid partner-img david active" />';
          		$html .= '</div>';
          		$html .= '<div class="col-lg-6 d-none d-lg-inline-block text-center">';
            		$html .= '<img src="'.home_url('wp-content/uploads/2019/04/photo_eran_on.png').'" alt="Eran" class="img-fluid partner-img eran" />';
          		$html .= '</div>';
          		$html .= '<div class="col-12 d-none partner eran px-xl-0">';
            		$html .= '<div class="arrow-up mt-70 ml-eran"></div>';
            			$html .= '<div class="partner-wrapper">';
              				$html .= '<p class="text-blue montserrat-medium h5 pl-5">Eran Steinberg</p>';
              				$html .= '<p class="text-blue montserrat-medium font-italic small pl-5">COO AND CHIEF OF STAFF</p>';
              				$html .= '<p class="text-grey lato-regular px-5">Eran is a seasoned sales executive with close to 20 years of financial industry experience. Prior to joining OptionMetrics, Eran spent 13 years at Capital IQ, a leading global provider of public and private capital market data applications, helping it grow from its earliest days through and beyond its eventual acquisition by Standard & Poor’s (now S&P Global), finishing as Head of Account Management for all of the Americas. Prior to S&P Eran spent close to a decade working in for profit education for Kaplan Test Prep and then briefly for ALFY, a start-up focused on designing a subscription-based educational gaming site for young children. Eran received a Bachelor of Science in Management from Binghamton University (SUNY), and a J.D. from the Benjamin N. Cardozo School of Law (Yeshiva University).</p>';
			            $html .= '</div>';
          			$html .= '</div>';
          		$html .= '<div class="col-12 d-none d-lg-inline-block partner david px-xl-0">';
            		$html .= '<div class="arrow-up mt-70 ml-david"></div>';
            		$html .= '<div class="partner-wrapper">';
              			$html .= '<p class="text-blue montserrat-medium h5 pl-5">David J. Hait, Ph.D.</p>';
              			$html .= '<p class="text-blue montserrat-medium font-italic small pl-5">CEO AND FOUNDER</p>';
              			$html .= '<p class="text-grey lato-regular px-5">David J. Hait, Ph.D. is the CEO of OptionMetrics, LLC, which he founded in 1999. Dr. Hait is a financial economist with over 20 years of experience in applied quantitative derivative research and technology. Prior to founding OptionMetrics he served as Vice President in the Fixed Income Research Group at Paine Webber, and taught courses on derivatives at J. P. Morgan. Dr. Hait received his Ph.D. in Finance from New York University’s Stern School of Business, where he was an Adjunct Professor at the Stern School of Business and Courant Institute of Mathematics. Dr. Hait also received an MS in Computer Science from University of California at Berkeley and a BSE in Computer Engineering from the University of Pennsylvania.</p>';
	            $html .= '</div>';
          	$html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';

	return $html;

}
add_shortcode( 'my_vc_php_output_about_us', 'vc_shortcode_about_us');




function vc_shortcode_data_products ( $atts ){


    $html = '<div class="row d-md-none">';
      	$html .= '<div class="col-12 text-center">';
        	$html .= '<p class="section-title text-blue montserrat-regular">Data Analysis Products</p>';
      	$html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="row">';
      	$html .= '<div class="col-12 px-4">';
        	//MAPS
      		$html .= '<div class="row d-flex align-items-center">';
  				$html .= '<div class="col-md-5 col-lg-6 col-xl-7 mb-5">';
    				$html .= '<img src="'.home_url('wp-content/uploads/2019/04/map_us.png').'" alt="Map" class="img-fluid map us">';
    				$html .= '<img src="'.home_url('wp-content/uploads/2019/04/map_canada.png').'" alt="Map" class="img-fluid map canada d-none">';
    				$html .= '<img src="'.home_url('wp-content/uploads/2019/04/map_europe.png').'" alt="Map" class="img-fluid map europe d-none">';
    				$html .= '<img src="'.home_url('wp-content/uploads/2019/04/map_asia.png').'" alt="Map" class="img-fluid map asia d-none">';
    				$html .= '<img src="'.home_url('wp-content/uploads/2019/04/map_global.png').'" alt="Map" class="img-fluid map global d-none">';
  				$html .= '</div>';
  				$html .= '<div class="col-md-7 col-lg-6 col-xl-5 maps-nav-items-container">';
    				$html .= '<nav>';
      					$html .= '<div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist" style="margin-bottom: 20px;">';
        					$html .= '<a class="nav-item nav-link maps-main-nav-items active" id="nav-tab-ivydb" data-toggle="tab" href="#nav-ivydb" role="tab" aria-controls="nav-ivydb" aria-selected="true" name="ivy">IvyDB</a>';
        					$html .= '<a class="nav-item nav-link maps-main-nav-items" id="nav-tab-optigraph" data-toggle="tab" href="#nav-optigraph" role="tab" aria-controls="nav-optigraph" aria-selected="false" name="optigraph">OptiGraph</a>';
      					$html .= '</div>';
    				$html .= '</nav>';
    				$html .= '<div class="tab-content" id="nav-tabContent">';
      					$html .= '<div class="tab-pane fade show active" id="nav-ivydb" role="tabpanel" aria-labelledby="nav-ivydb-tab">';
        					$html .= '<nav>';
          						$html .= '<div class="nav nav-tabs" id="nav-tab-country" role="tablist" style="border:none!important;margin-bottom:10px;">';
            						$html .= '<a class="nav-item nav-link active nav-item-country US-button" id="nav-tab-country-us" data-toggle="tab" data-country="us" href="#nav-us" role="tab" aria-controls="nav-us" aria-selected="true">US</a>';
            						$html .= '<a class="nav-item nav-link nav-item-country US-button" id="nav-tab-country-europe" data-toggle="tab" data-country="europe" href="#nav-europe" role="tab" aria-controls="nav-europe" aria-selected="true">Europe</a>';
            						$html .= '<a class="nav-item nav-link nav-item-country US-button" id="nav-tab-country-asia" data-toggle="tab" data-country="asia" href="#nav-asia" role="tab" aria-controls="nav-asia" aria-selected="false">Asia</a>';
            						$html .= '<a class="nav-item nav-link nav-item-country US-button" id="nav-tab-country-canada" data-toggle="tab" data-country="canada" href="#nav-canada" role="tab" aria-controls="nav-canada" aria-selected="false">Canada</a>';
            						$html .= '<a class="nav-item nav-link nav-item-country US-button" id="nav-tab-country-global" data-toggle="tab" data-country="global" href="#nav-global" role="tab" aria-controls="nav-global" aria-selected="false">Global Indices</a>';
          						$html .= '</div>';
        					$html .= '</nav>';
        					$html .= '<div class="tab-content" id="nav-tab-countryContent">';
          						$html .= '<div class="tab-pane show active" id="nav-us" role="tabpanel">';
            						$html .= '<p class="section-text">Since its launch in 2002, the IvyDB US database has been the industry standard for historical option prices and implied volatility data. Used by over 300 institutions, IvyDB contains accurate end-of-day prices for options along with their correctly calculated implied volatilities and greeks. With IvyDB, you’ll be able to evaluate risk models, test trading strategies, and perform sophisticated research on all aspects of the options markets.</p>';
          						$html .= '</div>';
          						$html .= '<div class="tab-pane show" id="nav-canada" role="tabpanel">';
            						$html .= '<p class="section-text">IvyDB Canada was launched in 2011, following the successes of its regional counterparts, IvyDB US, Europe, and Asia. Used by over 300 institutions, OptionMetrics’ IvyDB products contain accurate end-of-day prices for options along with their correctly calculated implied volatilities and greeks. With IvyDB, you’ll be able to evaluate risk models, test trading strategies, and perform sophisticated research on all aspects of the options markets.</p>';
          						$html .= '</div>';
          						$html .= '<div class="tab-pane show" id="nav-europe" role="tabpanel">';
            						$html .= '<p class="section-text">Following the success of its US counterpart, IvyDB Europe was launched in 2008. It has since become the industry standard for historical option prices and implied volatility data in the European markets. Used by over 300 institutions, IvyDB contains accurate end-of-day prices for options along with their correctly calculated implied volatilities and greeks. With IvyDB, you’ll be able to evaluate risk models, test trading strategies, and perform sophisticated research on all aspects of the options markets.</p>';
          						$html .= '</div>';
          						$html .= '<div class="tab-pane show" id="nav-asia" role="tabpanel">';
            						$html .= '<p class="section-text">Since its launch in 2010, IvyDB Asia has brought much-needed transparency of option prices and implied volatility data in the Asian markets. Used by over 300 institutions, OptionMetrics’ IvyDB products contain accurate end-of-day prices for options along with their correctly calculated implied volatilities and greeks. With IvyDB, you’ll be able to evaluate risk models, test trading strategies, and perform sophisticated research on all aspects of the options markets.</p>';
								$html .= '</div>';
          						$html .= '<div class="tab-pane show" id="nav-global" role="tabpanel">';
            						$html .= '<p class="section-text">Following the success of its regional counterparts (IvyDB US, Europe, Asia, and Canada), IvyDB Global Indices was launched in 2011. Used by over 300 institutions, OptionMetrics’ IvyDB products contain accurate end-of-day prices for options along with their correctly calculated implied volatilities and greeks. With IvyDB, you’ll be able to evaluate risk models, test trading strategies, and perform sophisticated research on all aspects of the options markets.</p>';
					            $html .= '</div>';
        					$html .= '</div>';
      					$html .= '</div>';
      					$html .= '<div class="tab-pane fade" id="nav-optigraph" role="tabpanel" aria-labelledby="nav-optigraph-tab">';
        					$html .= '<p class="section-text">Optigraph is a flexible and fast charting tool for graphing realized and implied volatility data on all US optionable securities, including indices. Users can quickly view volatility patterns going as far back as 1996 and compare vols across securities.<br/><br/>';
        						$html .= 'With OptiGraph you can also calculate correlations between volatilities, analyze which vols are cheap or rich across underlying securities or different maturities, view skew patterns, trading volume, and more.<br/><br/>';
        						$html .= 'Currently, OptiGraph is used by professional options traders at major investment banks, prop trading shops, and hedge funds. Traditional money managers also use OptiGraph to quickly assess implied volatility levels for the stocks and indices they trade.';
        					$html .= '</p>';
      					$html .= '</div>';
    				$html .= '</div>';
    				if( !is_page( 'data-products' ) ) : 
    					$html .= '<div class="text-center text-md-left">';
      						$html .= '<a href="/data-products/" class="btn btn-link text-uppercase pl-md-0 text-blue mt-xl-3 montserrat-medium">learn more <span class="fa fa-angle-double-right"></span> </a>';
    					$html .= '</div>';
  					endif;
  				$html .= '</div>';
			$html .= '</div>';
      	$html .= '</div>';
    $html .= '</div>';
    // US ACCORDION 
    $html .= '<div class="row d-flex align-items-center justify-content-between mb-lg-5 CO-body">';
      	$html .= '<div class="col-md-10 offset-md-1 d-none d-md-block __i">';
        	$html .= '<div id="accordion">';
          		$html .= '<div class="card content-nav-graph">';
            		$html .= '<div id="headingOne" class="orange1">';
              			$html .= '<a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne" aria-expanded="true" role="button">';
                			$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">';
                			$html .= '<p class="montserrat-medium">Comprehensive Coverage</p>';
              			$html .= '</a>';
            		$html .= '</div>';
            		$html .= '<div id="collapseOne" class="collapse show orange1" aria-labelledby="headingOne" data-parent="#accordion">';
              			$html .= '<div class="card-body lato-regular">';
                			$html .= 'IvyDB contains a complete historical record of end-of-day data on all US exchange-traded equity and index options (including options on ETF’s and ADR’s) from January 1996 onward. The data includes both daily option pricing information (symbol, date, closing bid and ask quote, volume, and open interest) as well as high, low, and closing prices for the underlying equity or index. IvyDB also provides all interest rate, dividend, and corporate action information for each security, so you can correlate your own option pricing models with calculations.';
              			$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
          		$html .= '<div class="card content-nav-graph">';
            		$html .= '<div id="headingTwo" class="green2">';
              			$html .= '<a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" role="button">';
			                $html .= '<img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">';
                			$html .= '<p class="montserrat-medium">Accurate Calculations</p>';
              			$html .= '</a>';
            		$html .= '</div>';
            		$html .= '<div id="collapseTwo" class="collapse green2" aria-labelledby="headingTwo" data-parent="#accordion">';
              			$html .= '<div class="card-body lato-regular">';
                			$html .= 'For each option price, we calculate an accurate implied volatility and store it along with the option sensitivities (delta, gamma, vega, and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated.';
                			$html .= 'In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.';
              			$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
          		$html .= '<div class="card content-nav-graph">';
            		$html .= '<div id="headingThree" class="ping3">';
              			$html .= '<a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" role="button">';
                			$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">';
                			$html .= '<p class="montserrat-medium">Continuous Time Series</p>';
              			$html .= '</a>';
            		$html .= '</div>';
            		$html .= '<div id="collapseThree" class="collapse ping3" aria-labelledby="headingThree" data-parent="#accordion">';
              			$html .= '<div class="card-body lato-regular">';
                			$html .= 'Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.';
		              	$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
          		$html .= '<div class="card content-nav-graph">';
	            	$html .= '<div id="headingFour" class="blue4">';
	              		$html .= '<a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" role="button">';
	                		$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">';
	                		$html .= '<p class="montserrat-medium">Daily Updates</p>';
	              		$html .= '</a>';
	            	$html .= '</div>';
            		$html .= '<div id="collapseFour" class="collapse blue4" aria-labelledby="headingFour" data-parent="#accordion">';
              			$html .= '<div class="card-body lato-regular">';
                			$html .= 'IvyDB US is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.';
              			$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
          		$html .= '<div class="card content-nav-graph">';
            		$html .= '<div id="headingFive" class="purple5">';
              			$html .= '<a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" role="button">';
                			$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">';
                			$html .= '<p class="montserrat-medium">Customer Support</p>';
              			$html .= '</a>';
            		$html .= '</div>';
            		$html .= '<div id="collapseFive" class="collapse purple5" aria-labelledby="headingFive" data-parent="#accordion">';
              			$html .= '<div class="card-body lato-regular">';
                			$html .= 'As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.';
              			$html .= '</div>';
            		$html .= '</div>';
          		$html .= '</div>';
        	$html .= '</div>';
      	$html .= '</div>';

      	// IMAGES 
      	$html .= '<div class="col-md-6 tab-content d-none">';
        	$html .= '<img src="'.home_url('wp-content/uploads/2019/04/Comprehensive_illustration.png').'" alt="Graph" class="img-fluid tab-pane active comprehensive mx-auto" id="comprehensive" role="tabpanel" aria-labelledby="comprehensive-tab">';
	        $html .= '<img src="'.home_url('wp-content/uploads/2019/04/Accurate_illustration.png').' alt="Graph" class="img-fluid tab-pane accurate mx-auto" id="accurate" role="tabpanel" aria-labelledby="accurate-tab">';
	        $html .= '<img src="'.home_url('wp-content/uploads/2019/04/Continouos_illustration.png').'" alt="Graph" class="img-fluid tab-pane continouos mx-auto" id="continouos" role="tabpanel" aria-labelledby="continouos-tab">';
	        $html .= '<img src="'.home_url('wp-content/uploads/2019/04/Daily_illustration.png').'" alt="Graph" class="img-fluid tab-pane daily mx-auto" id="daily" role="tabpanel" aria-labelledby="daily-tab">';
	        $html .= '<img src="'.home_url('wp-content/uploads/2019/04/Customer_illustration.png').'" alt="Graph" class="img-fluid tab-pane customer mx-auto" id="customer" role="tabpanel" aria-labelledby="customer-tab">';
    	    $html .= '<div class="col-12 text-center">';
        		$html .= '<a class="btn btn-yellow btn-main-slider mt-4" href="/contact">Let\'s Talk</a>';
        	$html .= '</div>';
      	$html .= '</div>';

      	// view responsive
      	$html .= '<div class="col-sm-12 d-md-none px-0 CO-body-mobile">
        <div id="accordionUno">
          <div class="card content-nav-graph">
            <div id="heading1" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapse1" class="collapse show orange1" aria-labelledby="heading1" data-parent="#accordionUno">
              <div class="card-body lato-regular">
                IvyDB contains a complete historical record of end-of-day data on all US exchange-traded equity and index options (including options on ETF’s and ADR’s) from January 1996 onward. The data includes both daily option pricing information (symbol, date, closing bid and ask quote, volume, and open interest) as well as high, low, and closing prices for the underlying equity or index. IvyDB also provides all interest rate, dividend, and corporate action information for each security, so you can correlate your own option pricing models with calculations.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading2" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapse2" class="collapse green2" aria-labelledby="heading2" data-parent="#accordionUno">
              <div class="card-body lato-regular">
                For each option price, we calculate an accurate implied volatility and store it along with the option sensitivities (delta, gamma, vega, and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated.

                In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading3" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapse3" class="collapse ping3" aria-labelledby="heading3" data-parent="#accordionUno">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading4" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapse4" class="collapse blue4" aria-labelledby="heading4" data-parent="#accordionUno">
              <div class="card-body lato-regular">
                IvyDB US is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading5" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'"" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapse5" class="collapse purple5" aria-labelledby="heading5" data-parent="#accordionUno">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

	   <div class="row d-flex align-items-center justify-content-between mb-5 CO-body" >
      <!-- Accordion -->
      <div class="col-md-10 offset-md-1 d-none d-md-block __i">
        <div id="accordion3">
          <div class="card content-nav-graph">
            <div id="headingEleven" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="true" aria-controls="collapseEleven" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapseEleven" class="collapse show orange1" aria-labelledby="headingEleven" data-parent="#accordion3">
              <div class="card-body lato-regular">
                IvyDB Europe covers over 900 optionable securities (equities and indices), from all major European exchanges, including the UK, France, Germany, Switzerland, Netherlands, Belgium, Spain, and Italy. Historical data and daily updates are available for most securities since January 2002. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwelve" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapseTwelve" class="collapse green2" aria-labelledby="headingTwelve" data-parent="#accordion3">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations along with the option sensitivities (delta, gamma, vega , and theta). In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingThirteen" class=" ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapseThirteen" class="collapse ping3" aria-labelledby="headingThirteen" data-parent="#accordion3">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingFourteen" class=" blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapseFourteen" class="collapse blue4" aria-labelledby="headingFourteen" data-parent="#accordion3">
              <div class="card-body lato-regular">
                IvyDB Europe is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingFifteen" class=" purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapseFifteen" class="collapse purple5" aria-labelledby="headingFifteen" data-parent="#accordion3">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-6 tab-content d-none">
        <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="Graph" class="img-fluid tab-pane active comprehensive" id="comprehensive" role="tabpanel" aria-labelledby="comprehensive-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Accurate_illustration.png').'" alt="Graph" class="img-fluid tab-pane accurate" id="accurate" role="tabpanel" aria-labelledby="accurate-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Continouos_illustration.png').'" alt="Graph" class="img-fluid tab-pane continouos" id="continouos" role="tabpanel" aria-labelledby="continouos-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Daily_illustration.png').'" alt="Graph" class="img-fluid tab-pane daily" id="daily" role="tabpanel" aria-labelledby="daily-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Customer_illustration.png').'" alt="Graph" class="img-fluid tab-pane customer" id="customer" role="tabpanel" aria-labelledby="customer-tab">
        <div class="col-12 text-center">
          <a class="btn btn-yellow btn-main-slider mt-4" href="/contact">Let\'s Talk</a>
        </div>
      </div>

      <div class="col-sm-12 d-md-none px-0 CO-body-mobile">
        <div id="accordionTres">
          <div class="card content-nav-graph">
            <div id="heading11" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapse11" aria-expanded="true" aria-controls="collapse11" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapse11" class="collapse show orange1" aria-labelledby="heading11" data-parent="#accordionTres">
              <div class="card-body lato-regular">
                IvyDB Europe covers over 900 optionable securities (equities and indices), from all major European exchanges, including the UK, France, Germany, Switzerland, Netherlands, Belgium, Spain, and Italy. Historical data and daily updates are available for most securities since January 2002. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading12" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse12" aria-expanded="false" aria-controls="collapse12" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapse12" class="collapse green2" aria-labelledby="heading12" data-parent="#accordionTres">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations along with the option sensitivities (delta, gamma, vega , and theta). In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading13" class=" ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse13" aria-expanded="false" aria-controls="collapse13" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapse13" class="collapse ping3" aria-labelledby="heading13" data-parent="#accordionTres">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading14" class=" blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse14" aria-expanded="false" aria-controls="collapse14" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapse14" class="collapse blue4" aria-labelledby="heading14" data-parent="#accordionTres">
              <div class="card-body lato-regular">
                IvyDB Europe is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading15" class=" purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse15" aria-expanded="false" aria-controls="collapse15" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapse15" class="collapse purple5" aria-labelledby="heading15" data-parent="#accordionTres">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row d-flex align-items-center justify-content-between mb-5 CO-body">

      <div class="col-md-10 offset-md-1 d-none d-md-block __i">
        <div id="accordion4">
          <div class="card content-nav-graph">
            <div id="headingSixteen" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapseSixteen" aria-expanded="true" aria-controls="collapseSixteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapseSixteen" class="collapse show orange1" aria-labelledby="headingSixteen" data-parent="#accordion4">
              <div class="card-body lato-regular">
                IvyDB Asia covers over 500 optionable securities (equities and indices), from all major Asian-Pacific exchanges, including Hong Kong, Japan, Taiwan, Korea, and Australia. Historical data and daily updates are available for most securities since January 2006. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingSeventeen" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseSeventeen" aria-expanded="false" aria-controls="collapseSeventeen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapseSeventeen" class="collapse green2" aria-labelledby="headingSeventeen" data-parent="#accordion4">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations along with the option sensitivities (delta, gamma, vega , and theta). In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingEighteen" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseEighteen" aria-expanded="false" aria-controls="collapseEighteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapseEighteen" class="collapse ping3" aria-labelledby="headingEighteen" data-parent="#accordion4">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingNineteen" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseNineteen" aria-expanded="false" aria-controls="collapseNineteen" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapseNineteen" class="collapse blue4" aria-labelledby="headingNineteen" data-parent="#accordion4">
              <div class="card-body lato-regular">
                IvyDB Asia is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwenty" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwenty" aria-expanded="false" aria-controls="collapseTwenty" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapseTwenty" class="collapse purple5" aria-labelledby="headingTwenty" data-parent="#accordion4">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-md-6 col-xl-6 tab-content d-none">
        <img src="'.home_url('wp-content/uploads/2019/04/Comprehensive_illustration.png').'" alt="Graph" class="img-fluid tab-pane active comprehensive" id="comprehensive" role="tabpanel" aria-labelledby="comprehensive-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Accurate_illustration.png').'" alt="Graph" class="img-fluid tab-pane accurate" id="accurate" role="tabpanel" aria-labelledby="accurate-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Continouos_illustration.png').'" alt="Graph" class="img-fluid tab-pane continouos" id="continouos" role="tabpanel" aria-labelledby="continouos-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Daily_illustration.png').'" alt="Graph" class="img-fluid tab-pane daily" id="daily" role="tabpanel" aria-labelledby="daily-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Customer_illustration.png').'" alt="Graph" class="img-fluid tab-pane customer" id="customer" role="tabpanel" aria-labelledby="customer-tab">
        <div class="col-12 text-center">
          <a class="btn btn-yellow btn-main-slider mt-4" href="/contact">Let\'s Talk</a>
        </div>
      </div>

      <!-- view responsive -->
      <div class="col-sm-12 d-md-none px-0 CO-body-mobile">
        <div id="accordionCuatro">
          <div class="card content-nav-graph">
            <div id="heading16" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapse16" aria-expanded="true" aria-controls="collapse16" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapse16" class="collapse show orange1" aria-labelledby="heading16" data-parent="#accordionCuatro">
              <div class="card-body lato-regular">
                IvyDB Asia covers over 500 optionable securities (equities and indices), from all major Asian-Pacific exchanges, including Hong Kong, Japan, Taiwan, Korea, and Australia. Historical data and daily updates are available for most securities since January 2006. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading17" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse17" aria-expanded="false" aria-controls="collapse17" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapse17" class="collapse green2" aria-labelledby="heading17" data-parent="#accordionCuatro">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations along with the option sensitivities (delta, gamma, vega , and theta). In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading18" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse18" aria-expanded="false" aria-controls="collapse18" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapse18" class="collapse ping3" aria-labelledby="heading18" data-parent="#accordionCuatro">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading19" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse19" aria-expanded="false" aria-controls="collapse19" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapse19" class="collapse blue4" aria-labelledby="heading19" data-parent="#accordionCuatro">
              <div class="card-body lato-regular">
                IvyDB Asia is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading20" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse20" aria-expanded="false" aria-controls="collapse20" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapse20" class="collapse purple5" aria-labelledby="heading20" data-parent="#accordionCuatro">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row d-flex align-items-center justify-content-between mb-5 CO-body" >
      <!-- Accordion -->
      <div class="col-md-10 offset-md-1 d-none d-md-block __i">
        <div id="accordion2">
          <div class="card content-nav-graph">
            <div id="headingSix" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapseSix" class="collapse show orange1" aria-labelledby="headingSix" data-parent="#accordion2">
              <div class="card-body lato-regular">
                IvyDB Canada covers over 200 optionable securities (equities, indices, and ETFs) from Canadian exchanges. Historical data and daily updates are available for most securities since March 2007. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingSeven" class=" green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapseSeven" class="collapse green2" aria-labelledby="headingSeven" data-parent="#accordion2">
              <div class="card-body lato-regular">
                For each option price, we calculate an accurate implied volatility and store it along with the option sensitivities (delta, gamma, vega , and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated. In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingEight" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapseEight" class="collapse ping3" aria-labelledby="headingEight" data-parent="#accordion2">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingNine" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapseNine" class="collapse blue4" aria-labelledby="headingNine" data-parent="#accordion2">
              <div class="card-body lato-regular">
                IvyDB Canada is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTen" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen"  role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapseTen" class="collapse purple5" aria-labelledby="headingTen" data-parent="#accordion2">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-xl-6 tab-content d-none">
        <img src="'.home_url('wp-content/uploads/2019/04/Comprehensive_illustration.png').'" alt="Graph" class="img-fluid tab-pane active comprehensive" id="comprehensive" role="tabpanel" aria-labelledby="comprehensive-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Accurate_illustration.png').'" alt="Graph" class="img-fluid tab-pane accurate" id="accurate" role="tabpanel" aria-labelledby="accurate-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Continouos_illustration.png').'" alt="Graph" class="img-fluid tab-pane continouos" id="continouos" role="tabpanel" aria-labelledby="continouos-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Daily_illustration.png').'" alt="Graph" class="img-fluid tab-pane daily" id="daily" role="tabpanel" aria-labelledby="daily-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Customer_illustration.png').'" alt="Graph" class="img-fluid tab-pane customer" id="customer" role="tabpanel" aria-labelledby="customer-tab">
        <div class="col-12 text-center">
          <a class="btn btn-yellow btn-main-slider mt-4" href="/contact">Let\'s Talk</a>
        </div>
      </div>

      <div class="col-sm-12 d-md-none px-0 CO-body-mobile">
        <div id="accordionDos">
          <div class="card content-nav-graph">
            <div id="heading6" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapse6" class="collapse show orange1" aria-labelledby="heading6" data-parent="#accordionDos">
              <div class="card-body lato-regular">
                IvyDB Canada covers over 200 optionable securities (equities, indices, and ETFs) from Canadian exchanges. Historical data and daily updates are available for most securities since March 2007. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading7" class=" green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').' alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapse7" class="collapse green2" aria-labelledby="heading7" data-parent="#accordionDos">
              <div class="card-body lato-regular">
                For each option price, we calculate an accurate implied volatility and store it along with the option sensitivities (delta, gamma, vega , and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated. In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading8" class=" ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse8" aria-expanded="false" aria-controls="collapse8" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapse8" class="collapse ping3" aria-labelledby="heading8" data-parent="#accordionDos">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading9" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse9" aria-expanded="false" aria-controls="collapse9" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapse9" class="collapse blue4" aria-labelledby="heading9" data-parent="#accordionDos">
              <div class="card-body lato-regular">
                IvyDB Canada is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading10" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse10" aria-expanded="false" aria-controls="collapse10" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapse10" class="collapse purple5" aria-labelledby="heading10" data-parent="#accordionDos">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="row d-flex align-items-center justify-content-between mb-5 CO-body" >

      <div class="col-md-10 offset-md-1 d-none d-md-block __i">
        <div id="accordion5">
          <div class="card content-nav-graph">
            <div id="headingTwentyone" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapseTwentyone" aria-expanded="true" aria-controls="collapseTwentyone" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapseTwentyone" class="collapse show orange1" aria-labelledby="headingTwentyone" data-parent="#accordion5">
              <div class="card-body lato-regular">
                IvyDB Global Indices covers 29 major indices from exchanges in the US, Europe, Asia, and Canada. Historical data and daily updates are available for most securities since 1996 for the US, 2002 for Europe, and 2006 for Asia and Canada. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwentytwo" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwentytwo" aria-expanded="false" aria-controls="collapseTwentytwo" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapseTwentytwo" class="collapse green2" aria-labelledby="headingTwentytwo" data-parent="#accordion5">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations, along with the option sensitivities (delta, gamma, vega, and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated. In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwentythree" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwentythree" aria-expanded="false" aria-controls="collapseTwentythree" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapseTwentythree" class="collapse ping3" aria-labelledby="headingTwentythree" data-parent="#accordion5">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwentyfour" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwentyfour" aria-expanded="false" aria-controls="collapseTwentyfour" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapseTwentyfour" class="collapse blue4" aria-labelledby="headingTwentyfour" data-parent="#accordion5">
              <div class="card-body lato-regular">
                IvyDB Global Indices is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="headingTwentyfive" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapseTwentyfive" aria-expanded="false" aria-controls="collapseTwentyfive" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapseTwentyfive" class="collapse purple5" aria-labelledby="headingTwentyfive" data-parent="#accordion5">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>

     
      <div class="col-md-6 col-xl-6 tab-content d-none">
        <img src="'.home_url('wp-content/uploads/2019/04/Comprehensive_illustration.png').'" alt="Graph" class="img-fluid tab-pane active comprehensive" id="comprehensive" role="tabpanel" aria-labelledby="comprehensive-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Accurate_illustration.png').'" alt="Graph" class="img-fluid tab-pane accurate" id="accurate" role="tabpanel" aria-labelledby="accurate-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Continouos_illustration.png').'" alt="Graph" class="img-fluid tab-pane continouos" id="continouos" role="tabpanel" aria-labelledby="continouos-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Daily_illustration.png').'" alt="Graph" class="img-fluid tab-pane daily" id="daily" role="tabpanel" aria-labelledby="daily-tab">
        <img src="'.home_url('wp-content/uploads/2019/04/Customer_illustration.png').'" alt="Graph" class="img-fluid tab-pane customer" id="customer" role="tabpanel" aria-labelledby="customer-tab">
        <div class="col-12 text-center">
          <a class="btn btn-yellow btn-main-slider mt-4" href="/contact">Let\'s Talk</a>
        </div>
      </div>

      <!-- view responsive -->
      <div class="col-sm-12 d-md-none px-0 CO-body-mobile">
        <div id="accordeonCinco">
          <div class="card content-nav-graph">
            <div id="heading21" class="orange1">
              <a class="nav-graph-link switch-png" data-toggle="collapse" data-target="#collapse21" aria-expanded="true" aria-controls="collapse21" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Commprensive_icon.png').'" alt="icon">
                <p class="montserrat-medium">Comprehensive Coverage</p>
              </a>
            </div>
            <div id="collapseTwentyone" class="collapse show orange1" aria-labelledby="headingTwentyone" data-parent="#accordeonCinco">
              <div class="card-body lato-regular">
                IvyDB Global Indices covers 29 major indices from exchanges in the US, Europe, Asia, and Canada. Historical data and daily updates are available for most securities since 1996 for the US, 2002 for Europe, and 2006 for Asia and Canada. The data includes daily option pricing information (settlement prices), our own dividend projections, and all historical distributions and corporate actions, such as splits, mergers, and name changes.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading22" class="green2">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse22" aria-expanded="false" aria-controls="collapse22" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Accumulate_icon.png').'" alt="icon">
                <p class="montserrat-medium">Accurate Calculations</p>
              </a>
            </div>

            <div id="collapse22" class="collapse green2" aria-labelledby="heading22" data-parent="#accordeonCinco">
              <div class="card-body lato-regular">
                We match each option price with the security price for accurate implied volatility and greeks calculations, along with the option sensitivities (delta, gamma, vega, and theta). Both European and American models are used as appropriate, with dividend/split adjustments correctly incorporated. In addition, a standardized constant-maturity volatility surface is calculated for each security every day, including interpolated implied volatilities over a wide range of expirations and moneyness (by delta). You can use our volatility surface to create your own volatility trading strategies, whether simple or complex.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading23" class="ping3">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse23" aria-expanded="false" aria-controls="collapse23" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Continuos_icon.png').'" alt="icon">
                <p class="montserrat-medium">Continuous Time Series</p>
              </a>
            </div>

            <div id="collapse23" class="collapse ping3" aria-labelledby="heading23" data-parent="#accordeonCinco">
              <div class="card-body lato-regular">
                Our database handles underlying symbol changes, dividend payments, and split/spinoff adjustments for you automatically. A permanent ID is associated with each instrument (equity, index, or option) to allow it to be easily tracked over time even when the option symbol, strike price or deliverables change. We also include a record of underlying security name and ticker changes, to allow you to easily search for options on securities either no longer trade or trade under a new ticker symbol.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading24" class="blue4">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse24" aria-expanded="false" aria-controls="collapse24" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Daily_icon.png').'" alt="icon">
                <p class="montserrat-medium">Daily Updates</p>
              </a>
            </div>

            <div id="collapse24" class="collapse blue4" aria-labelledby="heading24" data-parent="#accordeonCinco">
              <div class="card-body lato-regular">
                IvyDB Global Indices is updated daily to incorporate new end-of-day prices in all the equity and option exchanges we follow. A daily patch file is also provided which contains corrections to previous prices or calculations when needed. Your IvyDB database is always current and ready to use.
              </div>
            </div>
          </div>

          <div class="card content-nav-graph">
            <div id="heading25" class="purple5">
              <a class="nav-graph-link collapsed switch-png" data-toggle="collapse" data-target="#collapse25" aria-expanded="false" aria-controls="collapse25" role="button">
                <img src="'.home_url('wp-content/uploads/2019/04/Customer_icon.png').'" alt="icon">
                <p class="montserrat-medium">Customer Support</p>
              </a>
            </div>

            <div id="collapse25" class="collapse purple5" aria-labelledby="heading25" data-parent="#accordeonCinco">
              <div class="card-body lato-regular">
                As an OptionMetrics customer, you will receive dedicated support and expert guidance from day one. We provide you with step-by-step manuals for installation, and in-depth Reference Manuals for your day-to-day use. Should you have any questions, our support team is available Monday through Friday, 8AM to 6PM (EST); for urgent issues, assistance is available 24/7. Contact us via, Email: <a href="mailto:info@optionmetrics.com">info@optionmetrics.com</a>, Phone: (212) 707-8370 or Fax: (212) 707-8495.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';

	return $html;

}
add_shortcode( 'my_vc_php_output_data_products', 'vc_shortcode_data_products');
<?php
/* ThemeREX Addons support functions
------------------------------------------------------------------------------- */

// Add theme-specific functions
require_once TRANSLANG_THEME_DIR . 'theme-specific/trx_addons.setup.php';

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('translang_trx_addons_theme_setup1')) {
	add_action( 'after_setup_theme', 'translang_trx_addons_theme_setup1', 1 );
	add_action( 'trx_addons_action_save_options', 'translang_trx_addons_theme_setup1', 8 );
	function translang_trx_addons_theme_setup1() {
		if (translang_exists_trx_addons()) {
			add_filter( 'translang_filter_list_posts_types',	'translang_trx_addons_list_post_types');
			add_filter( 'translang_filter_list_header_styles','translang_trx_addons_list_header_styles');
			add_filter( 'translang_filter_list_footer_styles','translang_trx_addons_list_footer_styles');
		}
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('translang_trx_addons_theme_setup9')) {
	add_action( 'after_setup_theme', 'translang_trx_addons_theme_setup9', 9 );
	function translang_trx_addons_theme_setup9() {
		if (translang_exists_trx_addons()) {
			add_filter( 'trx_addons_filter_featured_image',				'translang_trx_addons_featured_image', 10, 2);
			add_filter( 'trx_addons_filter_no_image',					'translang_trx_addons_no_image' );
			add_filter( 'trx_addons_filter_get_list_icons',				'translang_trx_addons_get_list_icons', 10, 2 );
			add_action( 'wp_enqueue_scripts', 							'translang_trx_addons_frontend_scripts', 1100 );
			add_filter( 'translang_filter_query_sort_order',	 			'translang_trx_addons_query_sort_order', 10, 3);
			add_filter( 'translang_filter_merge_scripts',					'translang_trx_addons_merge_scripts');
			add_filter( 'translang_filter_prepare_css',					'translang_trx_addons_prepare_css', 10, 2);
			add_filter( 'translang_filter_prepare_js',					'translang_trx_addons_prepare_js', 10, 2);
			add_filter( 'translang_filter_localize_script',				'translang_trx_addons_localize_script');
			add_filter( 'translang_filter_get_post_categories',		 	'translang_trx_addons_get_post_categories');
			add_filter( 'translang_filter_get_post_date',		 			'translang_trx_addons_get_post_date');
			add_filter( 'trx_addons_filter_get_post_date',		 		'translang_trx_addons_get_post_date_wrap');
			add_filter( 'translang_filter_post_type_taxonomy',			'translang_trx_addons_post_type_taxonomy', 10, 2 );
			if (is_admin()) {
				add_filter( 'translang_filter_allow_override', 			'translang_trx_addons_allow_override', 10, 2);
				add_filter( 'translang_filter_allow_theme_icons', 		'translang_trx_addons_allow_theme_icons', 10, 2);
			} else {
				add_filter( 'trx_addons_filter_theme_logo',				'translang_trx_addons_theme_logo');
				add_filter( 'trx_addons_filter_post_meta',				'translang_trx_addons_post_meta', 10, 2);
				add_filter( 'translang_filter_get_mobile_menu',			'translang_trx_addons_get_mobile_menu');
				add_filter( 'translang_filter_detect_blog_mode',			'translang_trx_addons_detect_blog_mode' );
				add_filter( 'translang_filter_get_blog_title', 			'translang_trx_addons_get_blog_title');
				add_action( 'translang_action_login',						'translang_trx_addons_action_login', 10, 2);
				add_action( 'translang_action_search',					'translang_trx_addons_action_search', 10, 3);
				add_action( 'translang_action_breadcrumbs',				'translang_trx_addons_action_breadcrumbs');
				add_action( 'translang_action_show_layout',				'translang_trx_addons_action_show_layout', 10, 1);
			}
		}
		
		// Add this filter any time: if plugin exists - load plugin's styles, if not exists - load layouts.css instead plugin's styles
		add_filter( 'translang_filter_merge_styles',						'translang_trx_addons_merge_styles');
		
		if (is_admin()) {
			add_filter( 'translang_filter_tgmpa_required_plugins',		'translang_trx_addons_tgmpa_required_plugins' );
			add_action( 'admin_enqueue_scripts', 						'translang_trx_addons_editor_load_scripts_admin');
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'translang_trx_addons_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('translang_filter_tgmpa_required_plugins',	'translang_trx_addons_tgmpa_required_plugins');
	function translang_trx_addons_tgmpa_required_plugins($list=array()) {
		if (in_array('trx_addons', translang_storage_get('required_plugins'))) {
			$path = translang_get_file_dir('plugins/trx_addons/trx_addons.zip');
			$list[] = array(
					'name' 		=> esc_html__('ThemeREX Addons', 'translang'),
					'slug' 		=> 'trx_addons',
					'version'	=> '1.6.23.1',
					'source'	=> !empty($path) ? $path : 'upload://trx_addons.zip',
					'required' 	=> true
				);
		}
		return $list;
	}
}


/* Add options in the Theme Options Customizer
------------------------------------------------------------------------------- */

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('translang_trx_addons_setup3')) {
	add_action( 'after_setup_theme', 'translang_trx_addons_setup3', 3 );
	function translang_trx_addons_setup3() {
		
		// Section 'Courses' - settings to show 'Courses' blog archive and single posts
		if (translang_exists_courses()) {
		
			translang_storage_merge_array('options', '', array(
				'courses' => array(
					"title" => esc_html__('Courses', 'translang'),
					"desc" => wp_kses_data( __('Select parameters to display the courses pages', 'translang') ),
					"type" => "section"
					),
				'expand_content_courses' => array(
					"title" => esc_html__('Expand content', 'translang'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'translang') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_courses' => array(
					"title" => esc_html__('Header style', 'translang'),
					"desc" => wp_kses_data( __('Select style to display the site header on the courses pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_position_courses' => array(
					"title" => esc_html__('Header position', 'translang'),
					"desc" => wp_kses_data( __('Select position to display the site header on the courses pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_widgets_courses' => array(
					"title" => esc_html__('Header widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the courses pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_widgets_courses' => array(
					"title" => esc_html__('Sidebar widgets', 'translang'),
					"desc" => wp_kses_data( __('Select sidebar to show on the courses pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_position_courses' => array(
					"title" => esc_html__('Sidebar position', 'translang'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the courses pages', 'translang') ),
					"refresh" => false,
					"std" => 'left',
					"options" => array(),
					"type" => "select"
					),
				'hide_sidebar_on_single_courses' => array(
					"title" => esc_html__('Hide sidebar on the single course', 'translang'),
					"desc" => wp_kses_data( __("Hide sidebar on the single course's page", 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					),
				// 'widgets_above_page_courses' => array(
				// 	"title" => esc_html__('Widgets above the page', 'translang'),
				// 	"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'translang') ),
				// 	"std" => 'hide',
				// 	"options" => array(),
				// 	"type" => "select"
				// 	),
				// 'widgets_above_content_courses' => array(
				// 	"title" => esc_html__('Widgets above the content', 'translang'),
				// 	"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'translang') ),
				// 	"std" => 'hide',
				// 	"options" => array(),
				// 	"type" => "select"
				// 	),
				// 'widgets_below_content_courses' => array(
				// 	"title" => esc_html__('Widgets below the content', 'translang'),
				// 	"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'translang') ),
				// 	"std" => 'hide',
				// 	"options" => array(),
				// 	"type" => "select"
				// 	),
				// 'widgets_below_page_courses' => array(
				// 	"title" => esc_html__('Widgets below the page', 'translang'),
				// 	"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'translang') ),
				// 	"std" => 'hide',
				// 	"options" => array(),
				// 	"type" => "select"
				// 	),
				'footer_scheme_courses' => array(
					"title" => esc_html__('Footer Color Scheme', 'translang'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'translang') ),
					"std" => 'dark',
					"options" => array(),
					"type" => "select"
					),
				'footer_widgets_courses' => array(
					"title" => esc_html__('Footer widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'translang') ),
					"std" => 'footer_widgets',
					"options" => array(),
					"type" => "select"
					),
				'footer_columns_courses' => array(
					"title" => esc_html__('Footer columns', 'translang'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'translang') ),
					"dependency" => array(
						'footer_widgets_courses' => array('^hide')
					),
					"std" => 0,
					"options" => translang_get_list_range(0,4),
					"type" => "select"
					),
				'footer_wide_courses' => array(
					"title" => esc_html__('Footer fullwide', 'translang'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
		
		// Section 'Properties' - settings to show 'Properties' blog archive and single posts
		if (translang_exists_properties()) {
		
			translang_storage_merge_array('options', '', array(
				'properties' => array(
					"title" => esc_html__('Properties', 'translang'),
					"desc" => wp_kses_data( __('Select parameters to display the properties pages', 'translang') ),
					"type" => "section"
					),
				'expand_content_properties' => array(
					"title" => esc_html__('Expand content', 'translang'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'translang') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_properties' => array(
					"title" => esc_html__('Header style', 'translang'),
					"desc" => wp_kses_data( __('Select style to display the site header on the properties pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_position_properties' => array(
					"title" => esc_html__('Header position', 'translang'),
					"desc" => wp_kses_data( __('Select position to display the site header on the properties pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_widgets_properties' => array(
					"title" => esc_html__('Header widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the properties pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_widgets_properties' => array(
					"title" => esc_html__('Sidebar widgets', 'translang'),
					"desc" => wp_kses_data( __('Select sidebar to show on the properties pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_position_properties' => array(
					"title" => esc_html__('Sidebar position', 'translang'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the properties pages', 'translang') ),
					"refresh" => false,
					"std" => 'left',
					"options" => array(),
					"type" => "select"
					),
				'hide_sidebar_on_single_properties' => array(
					"title" => esc_html__('Hide sidebar on the single pages', 'translang'),
					"desc" => wp_kses_data( __("Hide sidebar on the single property or agent pages", 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'widgets_above_page_properties' => array(
					"title" => esc_html__('Widgets above the page', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_above_content_properties' => array(
					"title" => esc_html__('Widgets above the content', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_content_properties' => array(
					"title" => esc_html__('Widgets below the content', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_page_properties' => array(
					"title" => esc_html__('Widgets below the page', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'footer_scheme_properties' => array(
					"title" => esc_html__('Footer Color Scheme', 'translang'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'translang') ),
					"std" => 'dark',
					"options" => array(),
					"type" => "select"
					),
				'footer_widgets_properties' => array(
					"title" => esc_html__('Footer widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'translang') ),
					"std" => 'footer_widgets',
					"options" => array(),
					"type" => "select"
					),
				'footer_columns_properties' => array(
					"title" => esc_html__('Footer columns', 'translang'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'translang') ),
					"dependency" => array(
						'footer_widgets_properties' => array('^hide')
					),
					"std" => 0,
					"options" => translang_get_list_range(0,4),
					"type" => "select"
					),
				'footer_wide_properties' => array(
					"title" => esc_html__('Footer fullwide', 'translang'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
		
		// Section 'Sport' - settings to show 'Sport' blog archive and single posts
		if (translang_exists_sport()) {
			translang_storage_merge_array('options', '', array(
				'sport' => array(
					"title" => esc_html__('Sport', 'translang'),
					"desc" => wp_kses_data( __('Select parameters to display the sport pages', 'translang') ),
					"type" => "section"
					),
				'expand_content_sport' => array(
					"title" => esc_html__('Expand content', 'translang'),
					"desc" => wp_kses_data( __('Expand the content width if the sidebar is hidden', 'translang') ),
					"refresh" => false,
					"std" => 1,
					"type" => "checkbox"
					),
				'header_style_sport' => array(
					"title" => esc_html__('Header style', 'translang'),
					"desc" => wp_kses_data( __('Select style to display the site header on the sport pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_position_sport' => array(
					"title" => esc_html__('Header position', 'translang'),
					"desc" => wp_kses_data( __('Select position to display the site header on the sport pages', 'translang') ),
					"std" => 'inherit',
					"options" => array(),
					"type" => "select"
					),
				'header_widgets_sport' => array(
					"title" => esc_html__('Header widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the header on the sport pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_widgets_sport' => array(
					"title" => esc_html__('Sidebar widgets', 'translang'),
					"desc" => wp_kses_data( __('Select sidebar to show on the sport pages', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'sidebar_position_sport' => array(
					"title" => esc_html__('Sidebar position', 'translang'),
					"desc" => wp_kses_data( __('Select position to show sidebar on the sport pages', 'translang') ),
					"refresh" => false,
					"std" => 'left',
					"options" => array(),
					"type" => "select"
					),
				'hide_sidebar_on_single_sport' => array(
					"title" => esc_html__('Hide sidebar on the single pages', 'translang'),
					"desc" => wp_kses_data( __("Hide sidebar on the single sport pages (competitions, rounds, matches or players)", 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					),
				'widgets_above_page_sport' => array(
					"title" => esc_html__('Widgets above the page', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show above page (content and sidebar)', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_above_content_sport' => array(
					"title" => esc_html__('Widgets above the content', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show at the beginning of the content area', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_content_sport' => array(
					"title" => esc_html__('Widgets below the content', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show at the ending of the content area', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'widgets_below_page_sport' => array(
					"title" => esc_html__('Widgets below the page', 'translang'),
					"desc" => wp_kses_data( __('Select widgets to show below the page (content and sidebar)', 'translang') ),
					"std" => 'hide',
					"options" => array(),
					"type" => "select"
					),
				'footer_scheme_sport' => array(
					"title" => esc_html__('Footer Color Scheme', 'translang'),
					"desc" => wp_kses_data( __('Select color scheme to decorate footer area', 'translang') ),
					"std" => 'dark',
					"options" => array(),
					"type" => "select"
					),
				'footer_widgets_sport' => array(
					"title" => esc_html__('Footer widgets', 'translang'),
					"desc" => wp_kses_data( __('Select set of widgets to show in the footer', 'translang') ),
					"std" => 'footer_widgets',
					"options" => array(),
					"type" => "select"
					),
				'footer_columns_sport' => array(
					"title" => esc_html__('Footer columns', 'translang'),
					"desc" => wp_kses_data( __('Select number columns to show widgets in the footer. If 0 - autodetect by the widgets count', 'translang') ),
					"dependency" => array(
						'footer_widgets_sport' => array('^hide')
					),
					"std" => 0,
					"options" => translang_get_list_range(0,4),
					"type" => "select"
					),
				'footer_wide_sport' => array(
					"title" => esc_html__('Footer fullwide', 'translang'),
					"desc" => wp_kses_data( __('Do you want to stretch the footer to the entire window width?', 'translang') ),
					"std" => 0,
					"type" => "checkbox"
					)
				)
			);
		}
	}
}



/* Plugin's support utilities
------------------------------------------------------------------------------- */

// Check if plugin installed and activated
if ( !function_exists( 'translang_exists_trx_addons' ) ) {
	function translang_exists_trx_addons() {
		return defined('TRX_ADDONS_VERSION');
	}
}

// Return true if courses is supported
if ( !function_exists( 'translang_exists_courses' ) ) {
	function translang_exists_courses() {
		return defined('TRX_ADDONS_CPT_COURSES_PT');
	}
}

// Return true if dishes is supported
if ( !function_exists( 'translang_exists_dishes' ) ) {
	function translang_exists_dishes() {
		return defined('TRX_ADDONS_CPT_DISHES_PT');
	}
}

// Return true if layouts is supported
if ( !function_exists( 'translang_exists_layouts' ) ) {
	function translang_exists_layouts() {
		return defined('TRX_ADDONS_CPT_LAYOUTS_PT');
	}
}

// Return true if portfolio is supported
if ( !function_exists( 'translang_exists_portfolio' ) ) {
	function translang_exists_portfolio() {
		return defined('TRX_ADDONS_CPT_PORTFOLIO_PT');
	}
}

// Return true if properties is supported
if ( !function_exists( 'translang_exists_properties' ) ) {
	function translang_exists_properties() {
		return defined('TRX_ADDONS_CPT_PROPERTIES_PT');
	}
}

// Return true if services is supported
if ( !function_exists( 'translang_exists_services' ) ) {
	function translang_exists_services() {
		return defined('TRX_ADDONS_CPT_SERVICES_PT');
	}
}

// Return true if sport is supported
if ( !function_exists( 'translang_exists_sport' ) ) {
	function translang_exists_sport() {
		return defined('TRX_ADDONS_CPT_COMPETITIONS_PT');
	}
}

// Return true if team is supported
if ( !function_exists( 'translang_exists_team' ) ) {
	function translang_exists_team() {
		return defined('TRX_ADDONS_CPT_TEAM_PT');
	}
}


// Return true if it's courses page
if ( !function_exists( 'translang_is_courses_page' ) ) {
	function translang_is_courses_page() {
		return function_exists('trx_addons_is_courses_page') && trx_addons_is_courses_page();
	}
}

// Return true if it's dishes page
if ( !function_exists( 'translang_is_dishes_page' ) ) {
	function translang_is_dishes_page() {
		return function_exists('trx_addons_is_dishes_page') && trx_addons_is_dishes_page();
	}
}

// Return true if it's properties page
if ( !function_exists( 'translang_is_properties_page' ) ) {
	function translang_is_properties_page() {
		return function_exists('trx_addons_is_properties_page') && trx_addons_is_properties_page();
	}
}

// Return true if it's portfolio page
if ( !function_exists( 'translang_is_portfolio_page' ) ) {
	function translang_is_portfolio_page() {
		return function_exists('trx_addons_is_portfolio_page') && trx_addons_is_portfolio_page();
	}
}

// Return true if it's services page
if ( !function_exists( 'translang_is_services_page' ) ) {
	function translang_is_services_page() {
		return function_exists('trx_addons_is_services_page') && trx_addons_is_services_page();
	}
}

// Return true if it's team page
if ( !function_exists( 'translang_is_team_page' ) ) {
	function translang_is_team_page() {
		return function_exists('trx_addons_is_team_page') && trx_addons_is_team_page();
	}
}

// Return true if it's sport page
if ( !function_exists( 'translang_is_sport_page' ) ) {
	function translang_is_sport_page() {
		return function_exists('trx_addons_is_sport_page') && trx_addons_is_sport_page();
	}
}

// Detect current blog mode
if ( !function_exists( 'translang_trx_addons_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'translang_filter_detect_blog_mode', 'translang_trx_addons_detect_blog_mode' );
	function translang_trx_addons_detect_blog_mode($mode='') {
		if ( translang_is_courses_page() )
			$mode = 'courses';
		else if ( translang_is_dishes_page() )
			$mode = 'dishes';
		else if ( translang_is_properties_page() )
			$mode = 'properties';
		else if ( translang_is_portfolio_page() )
			$mode = 'portfolio';
		else if ( translang_is_services_page() )
			$mode = 'services';
		else if ( translang_is_sport_page() )
			$mode = 'sport';
		else if ( translang_is_team_page() )
			$mode = 'team';
		return $mode;
	}
}

// Add team, courses, etc. to the supported posts list
if ( !function_exists( 'translang_trx_addons_list_post_types' ) ) {
	//Handler of the add_filter( 'translang_filter_list_posts_types', 'translang_trx_addons_list_post_types');
	function translang_trx_addons_list_post_types($list=array()) {
		if (function_exists('trx_addons_get_cpt_list')) {
			$cpt_list = trx_addons_get_cpt_list();
			foreach ($cpt_list as $cpt => $title) {
				if (   (defined('TRX_ADDONS_CPT_COURSES_PT') && $cpt == TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $cpt == TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $cpt == TRX_ADDONS_CPT_PORTFOLIO_PT)
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $cpt == TRX_ADDONS_CPT_PROPERTIES_PT)
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $cpt == TRX_ADDONS_CPT_SERVICES_PT)
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $cpt == TRX_ADDONS_CPT_COMPETITIONS_PT)
					)
					$list[$cpt] = $title;
			}
		}
		return $list;
	}
}

// Return taxonomy for current post type
if ( !function_exists( 'translang_trx_addons_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'translang_filter_post_type_taxonomy',	'translang_trx_addons_post_type_taxonomy', 10, 2 );
	function translang_trx_addons_post_type_taxonomy($tax='', $post_type='') {
		if ( defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type == TRX_ADDONS_CPT_COURSES_PT )
			$tax = TRX_ADDONS_CPT_COURSES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type == TRX_ADDONS_CPT_DISHES_PT )
			$tax = TRX_ADDONS_CPT_DISHES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type == TRX_ADDONS_CPT_PORTFOLIO_PT )
			$tax = TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') && $post_type == TRX_ADDONS_CPT_PROPERTIES_PT )
			$tax = TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE;
		else if ( defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type == TRX_ADDONS_CPT_SERVICES_PT )
			$tax = TRX_ADDONS_CPT_SERVICES_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && $post_type == TRX_ADDONS_CPT_COMPETITIONS_PT )
			$tax = TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY;
		else if ( defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type == TRX_ADDONS_CPT_TEAM_PT )
			$tax = TRX_ADDONS_CPT_TEAM_TAXONOMY;
		return $tax;
	}
}

// Show categories of the team, courses, etc.
if ( !function_exists( 'translang_trx_addons_get_post_categories' ) ) {
	//Handler of the add_filter( 'translang_filter_get_post_categories', 		'translang_trx_addons_get_post_categories');
	function translang_trx_addons_get_post_categories($cats='') {

		if ( defined('TRX_ADDONS_CPT_COURSES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COURSES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_DISHES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_DISHES_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_DISHES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PORTFOLIO_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PORTFOLIO_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PORTFOLIO_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_PROPERTIES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_PROPERTIES_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_PROPERTIES_TAXONOMY_TYPE);
			}
		}
		if ( defined('TRX_ADDONS_CPT_SERVICES_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_SERVICES_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_COMPETITIONS_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_COMPETITIONS_TAXONOMY);
			}
		}
		if ( defined('TRX_ADDONS_CPT_TEAM_PT') ) {
			if (get_post_type()==TRX_ADDONS_CPT_TEAM_PT) {
				$cats = translang_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_TEAM_TAXONOMY);
			}
		}
		return $cats;
	}
}

// Show post's date with the theme-specific format
if ( !function_exists( 'translang_trx_addons_get_post_date_wrap' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_post_date', 'translang_trx_addons_get_post_date_wrap');
	function translang_trx_addons_get_post_date_wrap($dt='') {
		return apply_filters('translang_filter_get_post_date', $dt);
	}
}

// Show date of the courses
if ( !function_exists( 'translang_trx_addons_get_post_date' ) ) {
	//Handler of the add_filter( 'translang_filter_get_post_date', 'translang_trx_addons_get_post_date');
	function translang_trx_addons_get_post_date($dt='') {

		if ( defined('TRX_ADDONS_CPT_COURSES_PT') && get_post_type()==TRX_ADDONS_CPT_COURSES_PT) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date'];
			$dt = sprintf($dt < date('Y-m-d') 
					? esc_html__('Started on %s', 'translang') 
					: esc_html__('Starting %s', 'translang'), 
					date(get_option('date_format'), strtotime($dt)));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array(get_post_type(), array(TRX_ADDONS_CPT_COMPETITIONS_PT, TRX_ADDONS_CPT_ROUNDS_PT, TRX_ADDONS_CPT_MATCHES_PT))) {
			$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
			$dt = $meta['date_start'];
			$dt = sprintf($dt < date('Y-m-d').(!empty($meta['time_start']) ? ' H:i' : '')
					? esc_html__('Started on %s', 'translang') 
					: esc_html__('Starting %s', 'translang'), 
					date(get_option('date_format') . (!empty($meta['time_start']) ? ' '.get_option('time_format') : ''), strtotime($dt.(!empty($meta['time_start']) ? ' '.trim($meta['time_start']) : ''))));

		} else if ( defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && get_post_type() == TRX_ADDONS_CPT_PLAYERS_PT) {
			// Uncomment (remove) next line if you want to show player's birthday in the page title block
			if (false) {
				$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
				$dt = !empty($meta['birthday']) ? sprintf(esc_html__('Birthday: %s', 'translang'), date(get_option('date_format'), strtotime($meta['birthday']))) : '';
			} else
				$dt = '';
		}
		return $dt;
	}
}

// Check if meta box is allowed
if (!function_exists('translang_trx_addons_allow_override')) {
	//Handler of the add_filter( 'translang_filter_allow_override', 'translang_trx_addons_allow_override', 10, 2);
	function translang_trx_addons_allow_override($allow, $post_type) {
		return $allow
					|| (defined('TRX_ADDONS_CPT_COURSES_PT') && $post_type==TRX_ADDONS_CPT_COURSES_PT)
					|| (defined('TRX_ADDONS_CPT_DISHES_PT') && $post_type==TRX_ADDONS_CPT_DISHES_PT)
					|| (defined('TRX_ADDONS_CPT_PORTFOLIO_PT') && $post_type==TRX_ADDONS_CPT_PORTFOLIO_PT) 
					|| (defined('TRX_ADDONS_CPT_PROPERTIES_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_PROPERTIES_PT,
																				TRX_ADDONS_CPT_AGENTS_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_RESUME_PT') && $post_type==TRX_ADDONS_CPT_RESUME_PT) 
					|| (defined('TRX_ADDONS_CPT_SERVICES_PT') && $post_type==TRX_ADDONS_CPT_SERVICES_PT) 
					|| (defined('TRX_ADDONS_CPT_COMPETITIONS_PT') && in_array($post_type, array(
																				TRX_ADDONS_CPT_COMPETITIONS_PT,
																				TRX_ADDONS_CPT_ROUNDS_PT,
																				TRX_ADDONS_CPT_MATCHES_PT
																				)))
					|| (defined('TRX_ADDONS_CPT_TEAM_PT') && $post_type==TRX_ADDONS_CPT_TEAM_PT);
	}
}

// Check if theme icons is allowed
if (!function_exists('translang_trx_addons_allow_theme_icons')) {
	//Handler of the add_filter( 'translang_filter_allow_theme_icons', 'translang_trx_addons_allow_theme_icons', 10, 2);
	function translang_trx_addons_allow_theme_icons($allow, $post_type) {
		return $allow
					|| (defined('TRX_ADDONS_CPT_LAYOUTS_PT') && $post_type==TRX_ADDONS_CPT_LAYOUTS_PT);
	}
}

// Add layouts to the headers list
if ( !function_exists( 'translang_trx_addons_list_header_styles' ) ) {
	//Handler of the add_filter( 'translang_filter_list_header_styles', 'translang_trx_addons_list_header_styles');
	function translang_trx_addons_list_header_styles($list=array()) {
		if (translang_exists_layouts()) {
			$layouts = translang_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'header',
							'not_selected' => false
							)
						);
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $list['header-custom-'.intval($id)] = $title;
			}
		}
		return $list;
	}
}

// Add layouts to the footers list
if ( !function_exists( 'translang_trx_addons_list_footer_styles' ) ) {
	//Handler of the add_filter( 'translang_filter_list_footer_styles', 'translang_trx_addons_list_footer_styles');
	function translang_trx_addons_list_footer_styles($list=array()) {
		if (translang_exists_layouts()) {
			$layouts = translang_get_list_posts(false, array(
							'post_type' => TRX_ADDONS_CPT_LAYOUTS_PT,
							'meta_key' => 'trx_addons_layout_type',
							'meta_value' => 'footer',
							'not_selected' => false
							)
						);
			foreach ($layouts as $id=>$title) {
				if ($id != 'none') $list['footer-custom-'.intval($id)] = $title;
			}
		}
		return $list;
	}
}


// Add theme-specific layouts to the list
if (!function_exists('translang_trx_addons_default_layouts')) {
	add_filter( 'trx_addons_filter_default_layouts',	'translang_trx_addons_default_layouts');
	function translang_trx_addons_default_layouts($default_layouts=array()) {
		require_once TRANSLANG_THEME_DIR . 'theme-specific/trx_addons.layouts.php';
		return isset($layouts) && is_array($layouts) && count($layouts) > 0
						? array_merge($default_layouts, $layouts)
						: $default_layouts;
	}
}


// Enqueue custom styles
if ( !function_exists( 'translang_trx_addons_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'translang_trx_addons_frontend_scripts', 1100 );
	function translang_trx_addons_frontend_scripts() {
		if (translang_exists_trx_addons()) {
			if (translang_is_on(translang_get_theme_option('debug_mode')) && translang_get_file_dir('plugins/trx_addons/trx_addons.css')!='') {
				wp_enqueue_style( 'translang-trx_addons',  translang_get_file_url('plugins/trx_addons/trx_addons.css'), array(), null );
				wp_enqueue_style( 'translang-trx_addons_editor',  translang_get_file_url('plugins/trx_addons/trx_addons.editor.css'), array(), null );
			}
			if (translang_is_on(translang_get_theme_option('debug_mode')) && translang_get_file_dir('plugins/trx_addons/trx_addons.js')!='')
				wp_enqueue_script( 'translang-trx_addons', translang_get_file_url('plugins/trx_addons/trx_addons.js'), array('jquery'), null, true );
		} else {
			// Load custom layouts from the theme if plugin not exists
			if ( translang_is_on(translang_get_theme_option('debug_mode')) ) {
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/layouts.css') );
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/logo.css') );
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/menu.css') );
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/search.css') );
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/title.css') );
				wp_enqueue_style( 'translang-layouts', translang_get_file_url('plugins/trx_addons/layouts/featured.css') );
			}
		}
	}
}
	
// Merge custom styles
if ( !function_exists( 'translang_trx_addons_merge_styles' ) ) {
	//Handler of the add_filter( 'translang_filter_merge_styles', 'translang_trx_addons_merge_styles');
	function translang_trx_addons_merge_styles($list) {
		// ALWAYS merge custom layouts from the theme
		$list[] = 'plugins/trx_addons/layouts/layouts.css';
		$list[] = 'plugins/trx_addons/layouts/logo.css';
		$list[] = 'plugins/trx_addons/layouts/menu.css';
		$list[] = 'plugins/trx_addons/layouts/search.css';
		$list[] = 'plugins/trx_addons/layouts/title.css';
		$list[] = 'plugins/trx_addons/layouts/featured.css';
		if (translang_exists_trx_addons()) {
			$list[] = 'plugins/trx_addons/trx_addons.css';
			$list[] = 'plugins/trx_addons/trx_addons.editor.css';
		}
		return $list;
	}
}
	
// Merge custom scripts
if ( !function_exists( 'translang_trx_addons_merge_scripts' ) ) {
	//Handler of the add_filter('translang_filter_merge_scripts', 'translang_trx_addons_merge_scripts');
	function translang_trx_addons_merge_scripts($list) {
		$list[] = 'plugins/trx_addons/trx_addons.js';
		return $list;
	}
}



// WP Editor addons
//------------------------------------------------------------------------

// Load required styles and scripts for admin mode
if ( !function_exists( 'translang_trx_addons_editor_load_scripts_admin' ) ) {
	//Handler of the add_action("admin_enqueue_scripts", 'translang_trx_addons_editor_load_scripts_admin');
	function translang_trx_addons_editor_load_scripts_admin() {
		// Add styles in the WP text editor
		add_editor_style( array(
							translang_get_file_url('plugins/trx_addons/trx_addons.editor.css')
							)
						 );	
	}
}



// Plugin API - theme-specific wrappers for plugin functions
//------------------------------------------------------------------------

// Debug functions wrappers
if (!function_exists('ddo')) { function ddo($obj, $level=-1) { return var_dump($obj); } }
if (!function_exists('dco')) { function dco($obj, $level=-1) { print_r($obj); } }
if (!function_exists('dcl')) { function dcl($msg, $level=-1) { echo '<br><pre>' . esc_html($msg) . '</pre><br>'; } }
if (!function_exists('dfo')) { function dfo($obj, $level=-1) {} }
if (!function_exists('dfl')) { function dfl($msg, $level=-1) {} }

// Check if URL contain specified string
if (!function_exists('translang_check_url')) {
	function translang_check_url($val='', $defa=false) {
		return function_exists('trx_addons_check_url') 
					? trx_addons_check_url($val) 
					: $defa;
	}
}

// Check if layouts components are showed or set new state
if (!function_exists('translang_sc_layouts_showed')) {
	function translang_sc_layouts_showed($name, $val=null) {
		if (function_exists('trx_addons_sc_layouts_showed')) {
			if ($val!==null)
				trx_addons_sc_layouts_showed($name, $val);
			else
				return trx_addons_sc_layouts_showed($name);
		} else {
			if ($val!==null)
				return translang_storage_set_array('sc_layouts_components', $name, $val);
			else
				return translang_storage_get_array('sc_layouts_components', $name);
		}
	}
}

// Return image size multiplier
if (!function_exists('translang_get_retina_multiplier')) {
	function translang_get_retina_multiplier($force_retina=0) {
		static $mult = 0;
		if ($mult == 0) $mult = function_exists('trx_addons_get_retina_multiplier') ? trx_addons_get_retina_multiplier($force_retina) : 1;
		return max(1, $mult);
	}
}

// Return slider layout
if (!function_exists('translang_get_slider_layout')) {
	function translang_get_slider_layout($args) {
		return function_exists('trx_addons_get_slider_layout') 
					? trx_addons_get_slider_layout($args) 
					: '';
	}
}

// Return video player layout
if (!function_exists('translang_get_video_layout')) {
	function translang_get_video_layout($args) {
		return function_exists('trx_addons_get_video_layout') 
					? trx_addons_get_video_layout($args) 
					: '';
	}
}

// Return theme specific layout of the featured image block
if ( !function_exists( 'translang_trx_addons_featured_image' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_featured_image', 'translang_trx_addons_featured_image', 10, 2);
	function translang_trx_addons_featured_image($processed=false, $args=array()) {
		$args['show_no_image'] = true;
		$args['singular'] = false;
		$args['hover'] = isset($args['hover']) && $args['hover']=='' ? '' : translang_get_theme_option('image_hover');
		translang_show_post_featured($args);
		return true;
	}
}

// Return theme specific 'no-image' picture
if ( !function_exists( 'translang_trx_addons_no_image' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_no_image', 'translang_trx_addons_no_image');
	function translang_trx_addons_no_image($no_image='') {
		return translang_get_no_image($no_image);
	}
}

// Return theme-specific icons
if ( !function_exists( 'translang_trx_addons_get_list_icons' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_get_list_icons', 'translang_trx_addons_get_list_icons', 10, 2 );
	function translang_trx_addons_get_list_icons($list, $prepend_inherit) {
		return translang_get_list_icons($prepend_inherit);
	}
}

// Return links to the social profiles
if (!function_exists('translang_get_socials_links')) {
	function translang_get_socials_links($style='icons') {
		return function_exists('trx_addons_get_socials_links') 
					? trx_addons_get_socials_links($style)
					: '';
	}
}

// Return links to share post
if (!function_exists('translang_get_share_links')) {
	function translang_get_share_links($args=array()) {
		return function_exists('trx_addons_get_share_links') 
					? trx_addons_get_share_links($args)
					: '';
	}
}

// Display links to share post
if (!function_exists('translang_show_share_links')) {
	function translang_show_share_links($args=array()) {
		if (function_exists('trx_addons_get_share_links')) {
			$args['echo'] = true;
			trx_addons_get_share_links($args);
		}
	}
}


// Return image from the category
if (!function_exists('translang_get_category_image')) {
	function translang_get_category_image($term_id=0) {
		return function_exists('trx_addons_get_category_image') 
					? trx_addons_get_category_image($term_id)
					: '';
	}
}

// Return small image (icon) from the category
if (!function_exists('translang_get_category_icon')) {
	function translang_get_category_icon($term_id=0) {
		return function_exists('trx_addons_get_category_icon') 
					? trx_addons_get_category_icon($term_id)
					: '';
	}
}

// Return string with counters items
if (!function_exists('translang_get_post_counters')) {
	function translang_get_post_counters($counters='views') {
		return function_exists('trx_addons_get_post_counters')
					? str_replace('post_counters_item', 'post_meta_item post_counters_item', trx_addons_get_post_counters($counters))
					: '';
	}
}

// Return list with animation effects
if (!function_exists('translang_get_list_animations_in')) {
	function translang_get_list_animations_in() {
		return function_exists('trx_addons_get_list_animations_in') 
					? trx_addons_get_list_animations_in()
					: array();
	}
}

// Return classes list for the specified animation
if (!function_exists('translang_get_animation_classes')) {
	function translang_get_animation_classes($animation, $speed='normal', $loop='none') {
		return function_exists('trx_addons_get_animation_classes') 
					? trx_addons_get_animation_classes($animation, $speed, $loop)
					: '';
	}
}

// Return string with the likes counter for the specified comment
if (!function_exists('translang_get_comment_counters')) {
	function translang_get_comment_counters($counters = 'likes') {
		return function_exists('trx_addons_get_comment_counters') 
					? trx_addons_get_comment_counters($counters)
					: '';
	}
}

// Display likes counter for the specified comment
if (!function_exists('translang_show_comment_counters')) {
	function translang_show_comment_counters($counters = 'likes') {
		if (function_exists('trx_addons_get_comment_counters'))
			trx_addons_get_comment_counters($counters, true);
	}
}

// Add query params to sort posts by views or likes
if (!function_exists('translang_trx_addons_query_sort_order')) {
	//Handler of the add_filter('translang_filter_query_sort_order', 'translang_trx_addons_query_sort_order', 10, 3);
	function translang_trx_addons_query_sort_order($q=array(), $orderby='date', $order='desc') {
		if ($orderby == 'views') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_views_count';
		} else if ($orderby == 'likes') {
			$q['orderby'] = 'meta_value_num';
			$q['meta_key'] = 'trx_addons_post_likes_count';
		}
		return $q;
	}
}

// Return theme-specific logo to the plugin
if ( !function_exists( 'translang_trx_addons_theme_logo' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_theme_logo', 'translang_trx_addons_theme_logo');
	function translang_trx_addons_theme_logo($logo) {
		return translang_get_logo_image();
	}
}

// Return theme-specific post meta to the plugin
if ( !function_exists( 'translang_trx_addons_post_meta' ) ) {
	//Handler of the add_filter( 'trx_addons_filter_post_meta',	'translang_trx_addons_post_meta', 10, 2);
	function translang_trx_addons_post_meta($meta, $args=array()) {
		return translang_show_post_meta($args);
	}
}
	
// Redirect action 'get_mobile_menu' to the plugin
// Return stored items as mobile menu
if ( !function_exists( 'translang_trx_addons_get_mobile_menu' ) ) {
	//Handler of the add_filter("translang_filter_get_mobile_menu", 'translang_trx_addons_get_mobile_menu');
	function translang_trx_addons_get_mobile_menu($menu) {
		return apply_filters('trx_addons_filter_get_mobile_menu', $menu);
	}
}

// Redirect action 'login' to the plugin
if (!function_exists('translang_trx_addons_action_login')) {
	//Handler of the add_action( 'translang_action_login',		'translang_trx_addons_action_login', 10, 2);
	function translang_trx_addons_action_login($link_text='', $link_title='') {
		do_action( 'trx_addons_action_login', $link_text, $link_title );
	}
}

// Redirect action 'search' to the plugin
if (!function_exists('translang_trx_addons_action_search')) {
	//Handler of the add_action( 'translang_action_search', 'translang_trx_addons_action_search', 10, 3);
	function translang_trx_addons_action_search($style, $class, $ajax) {
		do_action( 'trx_addons_action_search', $style, $class, $ajax );
	}
}

// Redirect action 'breadcrumbs' to the plugin
if (!function_exists('translang_trx_addons_action_breadcrumbs')) {
	//Handler of the add_action( 'translang_action_breadcrumbs',	'translang_trx_addons_action_breadcrumbs');
	function translang_trx_addons_action_breadcrumbs() {
		do_action( 'trx_addons_action_breadcrumbs' );
	}
}

// Redirect action 'show_layout' to the plugin
if (!function_exists('translang_trx_addons_action_show_layout')) {
	//Handler of the add_action( 'translang_action_show_layout', 'translang_trx_addons_action_show_layout', 10, 1);
	function translang_trx_addons_action_show_layout($layout_id='') {
		do_action( 'trx_addons_action_show_layout', $layout_id );
	}
}

// Redirect filter 'get_blog_title' to the plugin
if ( !function_exists( 'translang_trx_addons_get_blog_title' ) ) {
	//Handler of the add_filter( 'translang_filter_get_blog_title', 'translang_trx_addons_get_blog_title');
	function translang_trx_addons_get_blog_title($title='') {
		return apply_filters('trx_addons_filter_get_blog_title', $title);
	}
}

// Redirect filter 'prepare_css' to the plugin
if (!function_exists('translang_trx_addons_prepare_css')) {
	//Handler of the add_filter( 'translang_filter_prepare_css',	'translang_trx_addons_prepare_css', 10, 2);
	function translang_trx_addons_prepare_css($css='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_css', $css, $remove_spaces );
	}
}

// Redirect filter 'prepare_js' to the plugin
if (!function_exists('translang_trx_addons_prepare_js')) {
	//Handler of the add_filter( 'translang_filter_prepare_js',	'translang_trx_addons_prepare_js', 10, 2);
	function translang_trx_addons_prepare_js($js='', $remove_spaces=true) {
		return apply_filters( 'trx_addons_filter_prepare_js', $js, $remove_spaces );
	}
}

// Add plugin's specific variables to the scripts
if (!function_exists('translang_trx_addons_localize_script')) {
	//Handler of the add_filter( 'translang_filter_localize_script',	'translang_trx_addons_localize_script');
	function translang_trx_addons_localize_script($arr) {
		$arr['trx_addons_exists'] = translang_exists_trx_addons();
		return $arr;
	}
}

// Return text for the "I agree ..." checkbox
if ( ! function_exists( 'translang_trx_addons_privacy_text' ) ) {
    add_filter( 'trx_addons_filter_privacy_text', 'translang_trx_addons_privacy_text' );
    function translang_trx_addons_privacy_text( $text='' ) {
        return translang_get_privacy_text();
    }
}

// Add theme-specific options to the post's options
if (!function_exists('translang_trx_addons_override_options')) {
    add_filter( 'trx_addons_filter_override_options', 'translang_trx_addons_override_options');
    function translang_trx_addons_override_options($options=array()) {
        return apply_filters('translang_filter_override_options', $options);
    }
}


// Add plugin-specific colors and fonts to the custom CSS
if (translang_exists_trx_addons()) { require_once TRANSLANG_THEME_DIR . 'plugins/trx_addons/trx_addons.styles.php'; }
?>
<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('translang_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'translang_cf7_theme_setup9', 9 );
	function translang_cf7_theme_setup9() {
		
		if (translang_exists_cf7()) {
			add_action( 'wp_enqueue_scripts', 								'translang_cf7_frontend_scripts', 1100 );
			add_filter( 'translang_filter_merge_styles',						'translang_cf7_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'translang_filter_tgmpa_required_plugins',			'translang_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'translang_cf7_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('translang_filter_tgmpa_required_plugins',	'translang_cf7_tgmpa_required_plugins');
	function translang_cf7_tgmpa_required_plugins($list=array()) {
		if (in_array('contact-form-7', translang_storage_get('required_plugins'))) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> esc_html__('Contact Form 7', 'translang'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
			// CF7 extension - datepicker 
			// $params = array(
			// 		'name' 		=> esc_html__('Contact Form 7 Datepicker', 'translang'),
			// 		'slug' 		=> 'contact-form-7-datepicker',
			// 		'required' 	=> false
			// );
			// $path = translang_get_file_dir('plugins/contact-form-7/contact-form-7-datepicker.zip');
			// if ($path != '')
			// 	$params['source'] = $path;
			// $list[] = $params;
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'translang_exists_cf7' ) ) {
	function translang_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'translang_cf7_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'translang_cf7_frontend_scripts', 1100 );
	function translang_cf7_frontend_scripts() {
		if (translang_is_on(translang_get_theme_option('debug_mode')) && translang_get_file_dir('plugins/contact-form-7/contact-form-7.css')!='')
			wp_enqueue_style( 'translang-contact-form-7',  translang_get_file_url('plugins/contact-form-7/contact-form-7.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'translang_cf7_merge_styles' ) ) {
	//Handler of the add_filter('translang_filter_merge_styles', 'translang_cf7_merge_styles');
	function translang_cf7_merge_styles($list) {
		$list[] = 'plugins/contact-form-7/contact-form-7.css';
		return $list;
	}
}
?>
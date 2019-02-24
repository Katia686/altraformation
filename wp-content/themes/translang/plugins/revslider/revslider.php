<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('translang_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'translang_revslider_theme_setup9', 9 );
	function translang_revslider_theme_setup9() {
		if (is_admin()) {
			add_filter( 'translang_filter_tgmpa_required_plugins',	'translang_revslider_tgmpa_required_plugins' );
		}
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'translang_exists_revslider' ) ) {
	function translang_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'translang_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('translang_filter_tgmpa_required_plugins',	'translang_revslider_tgmpa_required_plugins');
	function translang_revslider_tgmpa_required_plugins($list=array()) {
		if (in_array('revslider', translang_storage_get('required_plugins'))) {
			$path = translang_get_file_dir('plugins/revslider/revslider.zip');
			$list[] = array(
					'name' 		=> esc_html__('Revolution Slider', 'translang'),
					'slug' 		=> 'revslider',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
			);
		}
		return $list;
	}
}
?>
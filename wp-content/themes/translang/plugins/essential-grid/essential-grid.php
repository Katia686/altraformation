<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('translang_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'translang_essential_grid_theme_setup9', 9 );
	function translang_essential_grid_theme_setup9() {
		if (translang_exists_essential_grid()) {
			add_action( 'wp_enqueue_scripts', 							'translang_essential_grid_frontend_scripts', 1100 );
			add_filter( 'translang_filter_merge_styles',					'translang_essential_grid_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'translang_filter_tgmpa_required_plugins',		'translang_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'translang_exists_essential_grid' ) ) {
	function translang_exists_essential_grid() {
		return defined('EG_PLUGIN_PATH');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'translang_essential_grid_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('translang_filter_tgmpa_required_plugins',	'translang_essential_grid_tgmpa_required_plugins');
	function translang_essential_grid_tgmpa_required_plugins($list=array()) {
		if (in_array('essential-grid', translang_storage_get('required_plugins'))) {
			$path = translang_get_file_dir('plugins/essential-grid/essential-grid.zip');
			$list[] = array(
						'name' 		=> esc_html__('Essential Grid', 'translang'),
						'slug' 		=> 'essential-grid',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
			);
		}
		return $list;
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'translang_essential_grid_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'translang_essential_grid_frontend_scripts', 1100 );
	function translang_essential_grid_frontend_scripts() {
		if (translang_is_on(translang_get_theme_option('debug_mode')) && translang_get_file_dir('plugins/essential-grid/essential-grid.css')!='')
			wp_enqueue_style( 'translang-essential-grid',  translang_get_file_url('plugins/essential-grid/essential-grid.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'translang_essential_grid_merge_styles' ) ) {
	//Handler of the add_filter('translang_filter_merge_styles', 'translang_essential_grid_merge_styles');
	function translang_essential_grid_merge_styles($list) {
		$list[] = 'plugins/essential-grid/essential-grid.css';
		return $list;
	}
}
?>
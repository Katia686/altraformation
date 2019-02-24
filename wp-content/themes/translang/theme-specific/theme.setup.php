<?php
/**
 * Setup theme-specific fonts and colors
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.22
 */

// Theme init priorities:
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
if ( !function_exists('translang_customizer_theme_setup1') ) {
	add_action( 'after_setup_theme', 'translang_customizer_theme_setup1', 1 );
	function translang_customizer_theme_setup1() {

		// -----------------------------------------------------------------
		// -- Theme fonts (Google and/or custom fonts)
		// -----------------------------------------------------------------

		// Fonts to load when theme start
		// It can be Google fonts or uploaded fonts, placed in the folder /css/font-face/font-name inside the theme folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// For example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		translang_storage_set('load_fonts', array(
			// Google font
			array(
				'name'	 => 'Roboto',
				'family' => 'sans-serif',
				'styles' => '300,300italic,400,400italic,700,700italic'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'	 => 'Work Sans',
				'family' => 'sans-serif',
				'styles' => '100,200,300,400,500,600,700,800,900'		// Parameter 'style' used only for the Google fonts
				),
			array(
				'name'   => 'metropolis',
				'family' => 'sans-serif'
			),
		));

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		translang_storage_set('load_fonts_subset', 'latin,latin-ext');

		// Settings of the main tags
		translang_storage_set('theme_fonts', array(
			'p' => array(
				'title'				=> esc_html__('Main text', 'translang'),
				'description'		=> esc_html__('Font settings of the main text of the site', 'translang'),
				'font-family'		=> 'Work Sans, sans-serif',
				'font-size' 		=> '1.0715rem',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.8em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.3px',
				'margin-top'		=> '0em',
				'margin-bottom'		=> '1.4em'
				),
			'h1' => array(
				'title'				=> esc_html__('Heading 1', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '3.4286rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '1px',
				'margin-top'		=> '0.9583em',
				'margin-bottom'		=> '1.25em'
				),
			'h2' => array(
				'title'				=> esc_html__('Heading 2', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '3.2143rem',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1111em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '1.0444em',
				'margin-bottom'		=> '1.43em'
				),
			'h3' => array(
				'title'				=> esc_html__('Heading 3', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '2.75em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.1515em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '',
				'margin-top'		=> '1.3333em',
				'margin-bottom'		=> '1.1em'
				),
			'h4' => array(
				'title'				=> esc_html__('Heading 4', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.3043em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.3px',
				'margin-top'		=> '1.9565em',
				'margin-bottom'		=> '1.7em'
				),
			'h5' => array(
				'title'				=> esc_html__('Heading 5', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '1.4286em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.35em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0.3px',
				'margin-top'		=> '1.5em',
				'margin-bottom'		=> '1.75em'
				),
			'h6' => array(
				'title'				=> esc_html__('Heading 6', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '1.2143em',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.4706em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '-0.75px',
				'margin-top'		=> '2.1176em',
				'margin-bottom'		=> '1.4em'
				),
			'logo' => array(
				'title'				=> esc_html__('Logo text', 'translang'),
				'description'		=> esc_html__('Font settings of the text case of the logo', 'translang'),
				'font-family'		=> 'Montserrat, sans-serif',
				'font-size' 		=> '1.8em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.25em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '1px'
				),
			'button' => array(
				'title'				=> esc_html__('Buttons', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '700',
				'font-style'		=> 'normal',
				'line-height'		=> '1.8em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0.75px'
				),
			'input' => array(
				'title'				=> esc_html__('Input fields', 'translang'),
				'description'		=> esc_html__('Font settings of the input fields, dropdowns and textareas', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '1em',
				'font-weight'		=> '400',
				'font-style'		=> 'normal',
				'line-height'		=> '1.2em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'none',
				'letter-spacing'	=> '0px'
				),
			'info' => array(
				'title'				=> esc_html__('Post meta', 'translang'),
				'description'		=> esc_html__('Font settings of the post meta: date, counters, share, etc.', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
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
				'title'				=> esc_html__('Main menu', 'translang'),
				'description'		=> esc_html__('Font settings of the main menu items', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '500',
				'font-style'		=> 'normal',
				'line-height'		=> '1.5em',
				'text-decoration'	=> 'none',
				'text-transform'	=> 'uppercase',
				'letter-spacing'	=> '0px'
				),
			'submenu' => array(
				'title'				=> esc_html__('Dropdown menu', 'translang'),
				'description'		=> esc_html__('Font settings of the dropdown menu items', 'translang'),
				'font-family'		=> 'metropolis, sans-serif',
				'font-size' 		=> '13px',
				'font-weight'		=> '400',
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
		translang_storage_set('schemes', array(

			// Color scheme: 'default'
			'default' => array(
				'title'	 => esc_html__('Default', 'translang'),
				'colors' => array(

					// Whole block border and background
					'bg_color'				=> '#ffffff', //use as white when need
					'bd_color'				=> '#e5e5e5',

					// Text and links colors
					'text'					=> '#85858c', // text for all
					'text_light'			=> '#75757b', // use in cources item
					'text_dark'				=> '#1b1d38', // dark text for all
					'text_link'				=> '#becf5c', //link color for all
					'text_hover'			=> '#f14f4a', //link:hover for all

					// Alternative blocks (submenu, buttons, tabs, etc.)
					'alter_bg_color'		=> '#ececec', // use from table row 2 for all
					'alter_bg_hover'		=> '#e6e8eb',
					'alter_bd_color'		=> '#f8f8f8',// use from table row 1 for all
					'alter_bd_hover'		=> '#dadada',
					'alter_text'			=> '#f3f3f3',
					'alter_light'			=> '#ababaf', // use in cources item date and prices block
					'alter_dark'			=> '#222446', // use in main menu
					'alter_link'			=> '#9ef4e8', // use in skills
					'alter_hover'			=> '#72cfd5',

					// Input fields (form's fields and textarea)
					'input_bg_color'		=> '#f3f3f3',	//'rgba(221,225,229,0.3)',
					'input_bg_hover'		=> '#f3f3f3',	//'rgba(221,225,229,0.3)',
					'input_bd_color'		=> '#f3f3f3',	//'rgba(221,225,229,0.3)',
					'input_bd_hover'		=> '#e0e0e0',
					'input_text'			=> '#b7b7b7',
					'input_light'			=> '#e5e5e5',
					'input_dark'			=> '#0a0b14', // use in MailChimp

					// Inverse blocks (text and links on accented bg)
					'inverse_text'			=> '#1c1e39',
					'inverse_light'			=> '#393a59',
					'inverse_dark'			=> '#201f2f',
					'inverse_link'			=> '#f8f8f8', //? not sure about expert bg
					'inverse_hover'			=> '#1d1d1d',

					// Additional accented colors (if used in the current theme)
					// For example:
					//'accent2'				=> '#faef81'

				)
			),

			// Color scheme: 'dark'
			'dark' => array(
				'title'  => esc_html__('Dark', 'translang'),
				'colors' => array(

					// Whole block border and background
					'bg_color'				=> '#222446', // back for all
					'bd_color'				=> '#32344f', // border for all

					// Text and links colors
					'text'					=> '#c8c9da', // text color far all
					'text_light'			=> '#ababaf', // use in progress unit
					'text_dark'				=> '#ffffff',
					'text_link'				=> '#9ef4e8', //link for all
					'text_hover'			=> '#becf5c', // link:hover far all

					// Alternative blocks (submenu, buttons, tabs, etc.)
					'alter_bg_color'		=> '#393a59', //use in progress bar
					'alter_bg_hover'		=> '#1c1e39',
					'alter_bd_color'		=> '#393a59',
					'alter_bd_hover'		=> '#3d3d3d',
					'alter_text'			=> '#33354d', // sidebar_top
					'alter_light'			=> '#5f5f5f',
					'alter_dark'			=> '#ffffff',
					'alter_link'			=> '#ffaa5f',
					'alter_hover'			=> '#fe7259',

					// Input fields (form's fields and textarea)
					'input_bg_color'		=> '#2e2d32',	//'rgba(62,61,66,0.5)',
					'input_bg_hover'		=> '#2e2d32',	//'rgba(62,61,66,0.5)',
					'input_bd_color'		=> '#2e2d32',	//'rgba(62,61,66,0.5)',
					'input_bd_hover'		=> '#353535',
					'input_text'			=> '#b7b7b7',
					'input_light'			=> '#5f5f5f',
					'input_dark'			=> '#ffffff',

					// Inverse blocks (text and links on accented bg)
					'inverse_text'			=> '#85858c',
					'inverse_light'			=> '#5f5f5f',
					'inverse_dark'			=> '#201f2f',
					'inverse_link'			=> '#f8f8f8', //expert bg,
					'inverse_hover'			=> '#1d1d1d',

					// Additional accented colors (if used in the current theme)
					// For example:
					//'accent2'				=> '#ff6469'

				)
			)

		));
	}
}


// Additional (calculated) theme-specific colors
// Attention! Don't forget setup custom colors also in the theme.customizer.color-scheme.js
if (!function_exists('translang_customizer_add_theme_colors')) {
	function translang_customizer_add_theme_colors($colors) {
		if (substr($colors['text'], 0, 1) == '#') {
			$colors['bg_color_0']  = translang_hex2rgba( $colors['bg_color'], 0 );
			$colors['bg_color_02']  = translang_hex2rgba( $colors['bg_color'], 0.2 );
			$colors['bg_color_07']  = translang_hex2rgba( $colors['bg_color'], 0.7 );
			$colors['bg_color_08']  = translang_hex2rgba( $colors['bg_color'], 0.8 );
			$colors['bg_color_09']  = translang_hex2rgba( $colors['bg_color'], 0.9 );
			$colors['alter_bg_color_07']  = translang_hex2rgba( $colors['alter_bg_color'], 0.7 );
			$colors['alter_bg_color_04']  = translang_hex2rgba( $colors['alter_bg_color'], 0.4 );
			$colors['alter_bg_color_02']  = translang_hex2rgba( $colors['alter_bg_color'], 0.2 );
			$colors['alter_bd_color_02']  = translang_hex2rgba( $colors['alter_bd_color'], 0.2 );
			$colors['text_dark_07']  = translang_hex2rgba( $colors['text_dark'], 0.7 );
			$colors['text_link_02']  = translang_hex2rgba( $colors['text_link'], 0.2 );
			$colors['text_link_07']  = translang_hex2rgba( $colors['text_link'], 0.7 );
			$colors['text_link_blend'] = translang_hsb2hex(translang_hex2hsb( $colors['text_link'], 2, -5, 5 ));
			$colors['alter_link_blend'] = translang_hsb2hex(translang_hex2hsb( $colors['alter_link'], 2, -5, 5 ));
		} else {
			$colors['bg_color_0'] = '{{ data.bg_color_0 }}';
			$colors['bg_color_02'] = '{{ data.bg_color_02 }}';
			$colors['bg_color_07'] = '{{ data.bg_color_07 }}';
			$colors['bg_color_08'] = '{{ data.bg_color_08 }}';
			$colors['bg_color_09'] = '{{ data.bg_color_09 }}';
			$colors['alter_bg_color_07'] = '{{ data.alter_bg_color_07 }}';
			$colors['alter_bg_color_04'] = '{{ data.alter_bg_color_04 }}';
			$colors['alter_bg_color_02'] = '{{ data.alter_bg_color_02 }}';
			$colors['alter_bd_color_02'] = '{{ data.alter_bd_color_02 }}';
			$colors['text_dark_07'] = '{{ data.text_dark_07 }}';
			$colors['text_link_02'] = '{{ data.text_link_02 }}';
			$colors['text_link_07'] = '{{ data.text_link_07 }}';
			$colors['text_link_blend'] = '{{ data.text_link_blend }}';
			$colors['alter_link_blend'] = '{{ data.alter_link_blend }}';
		}
		return $colors;
	}
}



// Additional theme-specific fonts rules
// Attention! Don't forget setup fonts rules also in the theme.customizer.color-scheme.js
if (!function_exists('translang_customizer_add_theme_fonts')) {
	function translang_customizer_add_theme_fonts($fonts) {
		$rez = array();
		foreach ($fonts as $tag => $font) {
			//$rez[$tag] = $font;
			if (substr($font['font-family'], 0, 2) != '{{') {
				$rez[$tag.'_font-family'] 		= !empty($font['font-family']) && !translang_is_inherit($font['font-family'])
														? 'font-family:' . trim($font['font-family']) . ';'
														: '';
				$rez[$tag.'_font-size'] 		= !empty($font['font-size']) && !translang_is_inherit($font['font-size'])
														? 'font-size:' . translang_prepare_css_value($font['font-size']) . ";"
														: '';
				$rez[$tag.'_line-height'] 		= !empty($font['line-height']) && !translang_is_inherit($font['line-height'])
														? 'line-height:' . trim($font['line-height']) . ";"
														: '';
				$rez[$tag.'_font-weight'] 		= !empty($font['font-weight']) && !translang_is_inherit($font['font-weight'])
														? 'font-weight:' . trim($font['font-weight']) . ";"
														: '';
				$rez[$tag.'_font-style'] 		= !empty($font['font-style']) && !translang_is_inherit($font['font-style'])
														? 'font-style:' . trim($font['font-style']) . ";"
														: '';
				$rez[$tag.'_text-decoration'] 	= !empty($font['text-decoration']) && !translang_is_inherit($font['text-decoration'])
														? 'text-decoration:' . trim($font['text-decoration']) . ";"
														: '';
				$rez[$tag.'_text-transform'] 	= !empty($font['text-transform']) && !translang_is_inherit($font['text-transform'])
														? 'text-transform:' . trim($font['text-transform']) . ";"
														: '';
				$rez[$tag.'_letter-spacing'] 	= !empty($font['letter-spacing']) && !translang_is_inherit($font['letter-spacing'])
														? 'letter-spacing:' . trim($font['letter-spacing']) . ";"
														: '';
				$rez[$tag.'_margin-top'] 		= !empty($font['margin-top']) && !translang_is_inherit($font['margin-top'])
														? 'margin-top:' . translang_prepare_css_value($font['margin-top']) . ";"
														: '';
				$rez[$tag.'_margin-bottom'] 	= !empty($font['margin-bottom']) && !translang_is_inherit($font['margin-bottom'])
														? 'margin-bottom:' . translang_prepare_css_value($font['margin-bottom']) . ";"
														: '';
			} else {
				$rez[$tag.'_font-family']		= '{{ data["'.$tag.'_font-family"] }}';
				$rez[$tag.'_font-size']			= '{{ data["'.$tag.'_font-size"] }}';
				$rez[$tag.'_line-height']		= '{{ data["'.$tag.'_line-height"] }}';
				$rez[$tag.'_font-weight']		= '{{ data["'.$tag.'_font-weight"] }}';
				$rez[$tag.'_font-style']		= '{{ data["'.$tag.'_font-style"] }}';
				$rez[$tag.'_text-decoration']	= '{{ data["'.$tag.'_text-decoration"] }}';
				$rez[$tag.'_text-transform']	= '{{ data["'.$tag.'_text-transform"] }}';
				$rez[$tag.'_letter-spacing']	= '{{ data["'.$tag.'_letter-spacing"] }}';
				$rez[$tag.'_margin-top']		= '{{ data["'.$tag.'_margin-top"] }}';
				$rez[$tag.'_margin-bottom']		= '{{ data["'.$tag.'_margin-bottom"] }}';
			}
		}
		return $rez;
	}
}


//-------------------------------------------------------
//-- Thumb sizes
//-------------------------------------------------------

if ( !function_exists('translang_customizer_theme_setup') ) {
	add_action( 'after_setup_theme', 'translang_customizer_theme_setup' );
	function translang_customizer_theme_setup() {

		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(370, 0, false);

		// Add thumb sizes
		// ATTENTION! If you change list below - check filter's names in the 'trx_addons_filter_get_thumb_size' hook
		$thumb_sizes = apply_filters('translang_filter_add_thumb_sizes', array(
			'translang-thumb-huge'		=> array(1170, 658, true),
			'translang-thumb-big' 		=> array( 760, 428, true),
			'translang-thumb-med' 		=> array( 370, 370, true),
			'translang-thumb-tiny' 		=> array(  90,  90, true),
			'translang-thumb-masonry-big' => array( 760,   0, false),		// Only downscale, not crop
			'translang-thumb-masonry'		=> array( 370,   0, false),		// Only downscale, not crop
			)
		);
		$mult = translang_get_theme_option('retina_ready', 1);
		if ($mult > 1) $GLOBALS['content_width'] = apply_filters( 'translang_filter_content_width', 1170*$mult);
		foreach ($thumb_sizes as $k=>$v) {
			// Add Original dimensions
			add_image_size( $k, $v[0], $v[1], $v[2]);
			// Add Retina dimensions
			if ($mult > 1) add_image_size( $k.'-@retina', $v[0]*$mult, $v[1]*$mult, $v[2]);
		}

	}
}

if ( !function_exists('translang_customizer_image_sizes') ) {
	add_filter( 'image_size_names_choose', 'translang_customizer_image_sizes' );
	function translang_customizer_image_sizes( $sizes ) {
		$thumb_sizes = apply_filters('translang_filter_add_thumb_sizes', array(
			'translang-thumb-huge'		=> esc_html__( 'Fullsize image', 'translang' ),
			'translang-thumb-big'			=> esc_html__( 'Large image', 'translang' ),
			'translang-thumb-med'			=> esc_html__( 'Medium image', 'translang' ),
			'translang-thumb-tiny'		=> esc_html__( 'Small square avatar', 'translang' ),
			'translang-thumb-masonry-big'	=> esc_html__( 'Masonry Large (scaled)', 'translang' ),
			'translang-thumb-masonry'		=> esc_html__( 'Masonry (scaled)', 'translang' ),
			)
		);
		$mult = translang_get_theme_option('retina_ready', 1);
		foreach($thumb_sizes as $k=>$v) {
			$sizes[$k] = $v;
			if ($mult > 1) $sizes[$k.'-@retina'] = $v.' '.esc_html__('@2x', 'translang' );
		}
		return $sizes;
	}
}

// Remove some thumb-sizes from the ThemeREX Addons list
if ( !function_exists( 'translang_customizer_trx_addons_add_thumb_sizes' ) ) {
	add_filter( 'trx_addons_filter_add_thumb_sizes', 'translang_customizer_trx_addons_add_thumb_sizes');
	function translang_customizer_trx_addons_add_thumb_sizes($list=array()) {
		if (is_array($list)) {
			foreach ($list as $k=>$v) {
				if (in_array($k, array(
								'trx_addons-thumb-huge',
								'trx_addons-thumb-big',
								'trx_addons-thumb-medium',
								'trx_addons-thumb-tiny',
								'trx_addons-thumb-masonry-big',
								'trx_addons-thumb-masonry',
								)
							)
						) unset($list[$k]);
			}
		}
		return $list;
	}
}

// and replace removed styles with theme-specific thumb size
if ( !function_exists( 'translang_customizer_trx_addons_get_thumb_size' ) ) {
	add_filter( 'trx_addons_filter_get_thumb_size', 'translang_customizer_trx_addons_get_thumb_size');
	function translang_customizer_trx_addons_get_thumb_size($thumb_size='') {
		return str_replace(array(
							'trx_addons-thumb-huge',
							'trx_addons-thumb-huge-@retina',
							'trx_addons-thumb-big',
							'trx_addons-thumb-big-@retina',
							'trx_addons-thumb-medium',
							'trx_addons-thumb-medium-@retina',
							'trx_addons-thumb-tiny',
							'trx_addons-thumb-tiny-@retina',
							'trx_addons-thumb-masonry-big',
							'trx_addons-thumb-masonry-big-@retina',
							'trx_addons-thumb-masonry',
							'trx_addons-thumb-masonry-@retina',
							),
							array(
							'translang-thumb-huge',
							'translang-thumb-huge-@retina',
							'translang-thumb-big',
							'translang-thumb-big-@retina',
							'translang-thumb-med',
							'translang-thumb-med-@retina',
							'translang-thumb-tiny',
							'translang-thumb-tiny-@retina',
							'translang-thumb-masonry-big',
							'translang-thumb-masonry-big-@retina',
							'translang-thumb-masonry',
							'translang-thumb-masonry-@retina',
							),
							$thumb_size);
	}
}
?>

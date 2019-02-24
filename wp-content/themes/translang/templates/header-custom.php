<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.06
 */

$translang_header_css = $translang_header_image = '';
$translang_header_video = translang_get_header_video();
if (true || empty($translang_header_video)) {
	$translang_header_image = get_header_image();
	if (translang_is_on(translang_get_theme_option('header_image_override')) && apply_filters('translang_filter_allow_override_header_image', true)) {
		if (is_category()) {
			if (($translang_cat_img = translang_get_category_image()) != '')
				$translang_header_image = $translang_cat_img;
		} else if (is_singular() || translang_storage_isset('blog_archive')) {
			if (has_post_thumbnail()) {
				$translang_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
				if (is_array($translang_header_image)) $translang_header_image = $translang_header_image[0];
			} else
				$translang_header_image = '';
		}
	}
}

$translang_header_id = str_replace('header-custom-', '', translang_get_theme_option("header_style"));
if ((int) $translang_header_id == 0) {
	$translang_header_id = translang_get_post_id(array(
			'name' => $translang_header_id,
			'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
		)
	);
} else {
	$translang_header_id = apply_filters('trx_addons_filter_get_translated_layout', $translang_header_id);
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($translang_header_id); 
						?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($translang_header_id)));
						echo !empty($translang_header_image) || !empty($translang_header_video) 
							? ' with_bg_image' 
							: ' without_bg_image';
						if ($translang_header_video!='') 
							echo ' with_bg_video';
						if ($translang_header_image!='') 
							echo ' '.esc_attr(translang_add_inline_css_class('background-image: url('.esc_url($translang_header_image).');'));
						if (is_single() && has_post_thumbnail()) 
							echo ' with_featured_image';
						if (translang_is_on(translang_get_theme_option('header_fullheight'))) 
							echo ' header_fullheight trx-stretch-height';
						?> scheme_<?php echo esc_attr(translang_is_inherit(translang_get_theme_option('header_scheme')) 
														? translang_get_theme_option('color_scheme') 
														: translang_get_theme_option('header_scheme'));
						?>"><?php

	// Background video
	if (!empty($translang_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('translang_action_show_layout', $translang_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>
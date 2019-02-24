<?php
// Add plugin-specific colors and fonts to the custom CSS
if (!function_exists('translang_mailchimp_get_css')) {
	add_filter('translang_filter_get_css', 'translang_mailchimp_get_css', 10, 4);
	function translang_mailchimp_get_css($css, $colors, $fonts, $scheme='') {

		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;


			$rad = translang_get_border_radius();
			$css['fonts'] .= <<<CSS

.mc4wp-form .mc4wp-form-fields input[type="email"],
.mc4wp-form .mc4wp-form-fields input[type="submit"] {

}

CSS;
		}


		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.mc4wp-form input[type="email"] {
	background-color: {$colors['input_dark']};
	border-color: {$colors['input_dark']};
	color: {$colors['bg_color']};
}

CSS;
		}

		return $css;
	}
}
?>

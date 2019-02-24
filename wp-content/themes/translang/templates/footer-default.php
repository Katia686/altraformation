<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */

$translang_footer_scheme =  translang_is_inherit(translang_get_theme_option('footer_scheme')) ? translang_get_theme_option('color_scheme') : translang_get_theme_option('footer_scheme');
?>
<footer class="footer_wrap footer_default scheme_<?php echo esc_attr($translang_footer_scheme); ?>">
	<?php

	// Footer widgets area
	get_template_part( 'templates/footer-widgets' );

	// Logo
	get_template_part( 'templates/footer-logo' );

	// Socials
	get_template_part( 'templates/footer-socials' );

	// Menu
	get_template_part( 'templates/footer-menu' );

	// Copyright area
	get_template_part( 'templates/footer-copyright' );
	
	?>
</footer><!-- /.footer_wrap -->

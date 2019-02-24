<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */


// Socials
if ( translang_is_on(translang_get_theme_option('socials_in_footer')) && ($translang_output = translang_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php translang_show_layout($translang_output); ?>
		</div>
	</div>
	<?php
}
?>
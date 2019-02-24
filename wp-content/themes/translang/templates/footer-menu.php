<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */

// Footer menu
$translang_menu_footer = translang_get_nav_menu('menu_footer');
if (!empty($translang_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php translang_show_layout($translang_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>
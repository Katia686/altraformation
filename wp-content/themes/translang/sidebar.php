<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_sidebar_position = translang_get_theme_option('sidebar_position');
if (translang_sidebar_present()) {
	ob_start();
	$translang_sidebar_name = translang_get_theme_option('sidebar_widgets');
	translang_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($translang_sidebar_name) ) {
		dynamic_sidebar($translang_sidebar_name);
	}
	$translang_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($translang_out)) {
		?>
		<div class="sidebar <?php echo esc_attr($translang_sidebar_position); ?> widget_area<?php if (!translang_is_inherit(translang_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(translang_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'translang_action_before_sidebar' );
				translang_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $translang_out));
				do_action( 'translang_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>
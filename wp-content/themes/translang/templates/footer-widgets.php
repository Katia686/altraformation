<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */

// Footer sidebar
$translang_footer_name = translang_get_theme_option('footer_widgets');
$translang_footer_present = !translang_is_off($translang_footer_name) && is_active_sidebar($translang_footer_name);
if ($translang_footer_present) { 
	translang_storage_set('current_sidebar', 'footer');
	$translang_footer_wide = translang_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($translang_footer_name) ) {
		dynamic_sidebar($translang_footer_name);
	}
	$translang_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($translang_out)) {
		$translang_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $translang_out);
		$translang_need_columns = true;	//or check: strpos($translang_out, 'columns_wrap')===false;
		if ($translang_need_columns) {
			$translang_columns = max(0, (int) translang_get_theme_option('footer_columns'));
			if ($translang_columns == 0) $translang_columns = min(4, max(1, substr_count($translang_out, '<aside ')));
			if ($translang_columns > 1)
				$translang_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($translang_columns).' widget ', $translang_out);
			else
				$translang_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($translang_footer_wide) ? ' footer_fullwidth' : ''; ?>">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$translang_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($translang_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'translang_action_before_sidebar' );
				translang_show_layout($translang_out);
				do_action( 'translang_action_after_sidebar' );
				if ($translang_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$translang_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>
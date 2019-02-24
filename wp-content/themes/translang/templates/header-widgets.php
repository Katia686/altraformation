<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

// Header sidebar
$translang_header_name = translang_get_theme_option('header_widgets');
$translang_header_present = !translang_is_off($translang_header_name) && is_active_sidebar($translang_header_name);
if ($translang_header_present) { 
	translang_storage_set('current_sidebar', 'header');
	$translang_header_wide = translang_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($translang_header_name) ) {
		dynamic_sidebar($translang_header_name);
	}
	$translang_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($translang_widgets_output)) {
		$translang_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $translang_widgets_output);
		$translang_need_columns = strpos($translang_widgets_output, 'columns_wrap')===false;
		if ($translang_need_columns) {
			$translang_columns = max(0, (int) translang_get_theme_option('header_columns'));
			if ($translang_columns == 0) $translang_columns = min(6, max(1, substr_count($translang_widgets_output, '<aside ')));
			if ($translang_columns > 1)
				$translang_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($translang_columns).' widget ', $translang_widgets_output);
			else
				$translang_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($translang_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$translang_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($translang_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'translang_action_before_sidebar' );
				translang_show_layout($translang_widgets_output);
				do_action( 'translang_action_after_sidebar' );
				if ($translang_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$translang_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>
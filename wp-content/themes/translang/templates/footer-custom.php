<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */

$translang_footer_scheme =  translang_is_inherit(translang_get_theme_option('footer_scheme')) ? translang_get_theme_option('color_scheme') : translang_get_theme_option('footer_scheme');
$translang_footer_id = str_replace('footer-custom-', '', translang_get_theme_option("footer_style"));
if ((int) $translang_footer_id == 0) {
	$translang_footer_id = translang_get_post_id(array(
			'name' => $translang_footer_id,
			'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
		)
	);
} else {
	$translang_footer_id = apply_filters('trx_addons_filter_get_translated_layout', $translang_footer_id);
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($translang_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($translang_footer_id))); 
						?> scheme_<?php echo esc_attr($translang_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('translang_action_show_layout', $translang_footer_id);
	?>
</footer><!-- /.footer_wrap -->

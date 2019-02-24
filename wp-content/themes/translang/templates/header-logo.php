<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_args = get_query_var('translang_logo_args');

// Site logo
$translang_logo_image  = translang_get_logo_image(isset($translang_args['type']) ? $translang_args['type'] : '');
$translang_logo_text   = translang_is_on(translang_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$translang_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($translang_logo_image) || !empty($translang_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($translang_logo_image)) {
			$translang_attr = translang_getimagesize($translang_logo_image);
			echo '<img src="'.esc_url($translang_logo_image).'" alt="'. esc_attr__('image', 'translang') .'" '.(!empty($translang_attr[3]) ? sprintf(' %s', $translang_attr[3]) : '').'>' ;
		} else {
			translang_show_layout(translang_prepare_macros($translang_logo_text), '<span class="logo_text">', '</span>');
			translang_show_layout(translang_prepare_macros($translang_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>
<?php
/**
 * The template to display the featured image in the single post
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

if ( get_query_var('translang_header_image')=='' && is_singular() && has_post_thumbnail() && in_array(get_post_type(), array('post', 'page')) )  {
	$translang_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
	if (!empty($translang_src[0])) {
		translang_sc_layouts_showed('featured', true);
		?>
		<!-- <div class="sc_layouts_featured with_image <?php echo esc_attr(translang_add_inline_css_class('background-image:url('.esc_url($translang_src[0]).');')); ?>"></div> -->
		<?php
	}
}
?>

<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_blog_style = explode('_', translang_get_theme_option('blog_style'));
$translang_columns = empty($translang_blog_style[1]) ? 2 : max(2, $translang_blog_style[1]);
$translang_post_format = get_post_format();
$translang_post_format = empty($translang_post_format) ? 'standard' : str_replace('post-format-', '', $translang_post_format);
$translang_animation = translang_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($translang_columns).' post_format_'.esc_attr($translang_post_format) ); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	>

	<?php
	$translang_image_hover = translang_get_theme_option('image_hover');
	// Featured image
	translang_show_post_featured(array(
		'thumb_size' => translang_get_thumb_size(strpos(translang_get_theme_option('body_style'), 'full')!==false || $translang_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $translang_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $translang_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>
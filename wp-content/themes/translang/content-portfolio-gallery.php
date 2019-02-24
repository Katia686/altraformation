<?php
/**
 * The Gallery template to display posts
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
$translang_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($translang_columns).' post_format_'.esc_attr($translang_post_format) ); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($translang_image[1]) && !empty($translang_image[2])) echo intval($translang_image[1]) .'x' . intval($translang_image[2]); ?>"
	data-src="<?php if (!empty($translang_image[0])) echo esc_url($translang_image[0]); ?>"
	>

	<?php
	$translang_image_hover = 'icon';	//translang_get_theme_option('image_hover');
	if (in_array($translang_image_hover, array('icons', 'zoom'))) $translang_image_hover = 'dots';
	// Featured image
	translang_show_post_featured(array(
		'hover' => $translang_image_hover,
		'thumb_size' => translang_get_thumb_size( strpos(translang_get_theme_option('body_style'), 'full')!==false || $translang_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. translang_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => false,
									'seo' => false,
									'share' => true,
									'counters' => 'comments',
									'echo' => false
									))
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'translang') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>
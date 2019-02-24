<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_post_id    = get_the_ID();
$translang_post_date  = translang_get_date();
$translang_post_title = get_the_title();
$translang_post_link  = get_permalink();
$translang_post_author_id   = get_the_author_meta('ID');
$translang_post_author_name = get_the_author_meta('display_name');
$translang_post_author_url  = get_author_posts_url($translang_post_author_id, '');

$translang_args = get_query_var('translang_args_widgets_posts');
$translang_show_date = isset($translang_args['show_date']) ? (int) $translang_args['show_date'] : 1;
$translang_show_image = isset($translang_args['show_image']) ? (int) $translang_args['show_image'] : 1;
$translang_show_author = isset($translang_args['show_author']) ? (int) $translang_args['show_author'] : 1;
$translang_show_counters = isset($translang_args['show_counters']) ? (int) $translang_args['show_counters'] : 1;
$translang_show_categories = isset($translang_args['show_categories']) ? (int) $translang_args['show_categories'] : 1;

$translang_output = translang_storage_get('translang_output_widgets_posts');

$translang_post_counters_output = '';
if ( $translang_show_counters ) {
	$translang_post_counters_output = '<span class="post_info_item post_info_counters">'
								. translang_get_post_counters('comments')
							. '</span>';
}


$translang_output .= '<article class="post_item with_thumb">';

if ($translang_show_image) {
	$translang_post_thumb = get_the_post_thumbnail($translang_post_id, translang_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($translang_post_thumb) $translang_output .= '<div class="post_thumb">' . ($translang_post_link ? '<a href="' . esc_url($translang_post_link) . '">' : '') . ($translang_post_thumb) . ($translang_post_link ? '</a>' : '') . '</div>';
}

$translang_output .= '<div class="post_content">'
			. ($translang_show_categories 
					? '<div class="post_categories">'
						. translang_get_post_categories()
						. $translang_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($translang_post_link ? '<a href="' . esc_url($translang_post_link) . '">' : '') . ($translang_post_title) . ($translang_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('translang_filter_get_post_info', 
								'<div class="post_info">'
									. ($translang_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($translang_post_link ? '<a href="' . esc_url($translang_post_link) . '" class="post_info_date">' : '') 
											. esc_html($translang_post_date) 
											. ($translang_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($translang_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'translang') . ' ' 
											. ($translang_post_link ? '<a href="' . esc_url($translang_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($translang_post_author_name) 
											. ($translang_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$translang_show_categories && $translang_post_counters_output
										? $translang_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
translang_storage_set('translang_output_widgets_posts', $translang_output);
?>
<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the Visual Composer to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$translang_content = '';
$translang_blog_archive_mask = '%%CONTENT%%';
$translang_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $translang_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($translang_content = apply_filters('the_content', get_the_content())) != '') {
		if (($translang_pos = strpos($translang_content, $translang_blog_archive_mask)) !== false) {
			$translang_content = preg_replace('/(\<p\>\s*)?'.$translang_blog_archive_mask.'(\s*\<\/p\>)/i', $translang_blog_archive_subst, $translang_content);
		} else
			$translang_content .= $translang_blog_archive_subst;
		$translang_content = explode($translang_blog_archive_mask, $translang_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) translang_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$translang_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$translang_args = translang_query_add_posts_and_cats($translang_args, '', translang_get_theme_option('post_type'), translang_get_theme_option('parent_cat'));
$translang_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($translang_page_number > 1) {
	$translang_args['paged'] = $translang_page_number;
	$translang_args['ignore_sticky_posts'] = true;
}
$translang_ppp = translang_get_theme_option('posts_per_page');
if ((int) $translang_ppp != 0)
	$translang_args['posts_per_page'] = (int) $translang_ppp;
// Make a new query
query_posts( $translang_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($translang_content) && count($translang_content) == 2) {
	set_query_var('blog_archive_start', $translang_content[0]);
	set_query_var('blog_archive_end', $translang_content[1]);
}

get_template_part('index');
?>
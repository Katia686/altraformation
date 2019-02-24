<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

translang_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'classie', translang_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'imagesloaded', translang_get_file_url('js/theme.gallery/imagesloaded.min.js'), array(), null, true );
wp_enqueue_script( 'masonry', translang_get_file_url('js/theme.gallery/masonry.min.js'), array(), null, true );
wp_enqueue_script( 'translang-gallery-script', translang_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$translang_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$translang_sticky_out = is_array($translang_stickies) && count($translang_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$translang_cat = translang_get_theme_option('parent_cat');
	$translang_post_type = translang_get_theme_option('post_type');
	$translang_taxonomy = translang_get_post_type_taxonomy($translang_post_type);
	$translang_show_filters = translang_get_theme_option('show_filters');
	$translang_tabs = array();
	if (!translang_is_off($translang_show_filters)) {
		$translang_args = array(
			'type'			=> $translang_post_type,
			'child_of'		=> $translang_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $translang_taxonomy,
			'pad_counts'	=> false
		);
		$translang_portfolio_list = get_terms($translang_args);
		if (is_array($translang_portfolio_list) && count($translang_portfolio_list) > 0) {
			$translang_tabs[$translang_cat] = esc_html__('All', 'translang');
			foreach ($translang_portfolio_list as $translang_term) {
				if (isset($translang_term->term_id)) $translang_tabs[$translang_term->term_id] = $translang_term->name;
			}
		}
	}
	if (count($translang_tabs) > 0) {
		$translang_portfolio_filters_ajax = true;
		$translang_portfolio_filters_active = $translang_cat;
		$translang_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters translang_tabs translang_tabs_ajax">
			<ul class="portfolio_titles translang_tabs_titles">
				<?php
				foreach ($translang_tabs as $translang_id=>$translang_title) {
					?><li><a href="<?php echo esc_url(translang_get_hash_link(sprintf('#%s_%s_content', $translang_portfolio_filters_id, $translang_id))); ?>" data-tab="<?php echo esc_attr($translang_id); ?>"><?php echo esc_html($translang_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$translang_ppp = translang_get_theme_option('posts_per_page');
			if (translang_is_inherit($translang_ppp)) $translang_ppp = '';
			foreach ($translang_tabs as $translang_id=>$translang_title) {
				$translang_portfolio_need_content = $translang_id==$translang_portfolio_filters_active || !$translang_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $translang_portfolio_filters_id, $translang_id)); ?>"
					class="portfolio_content translang_tabs_content"
					data-blog-template="<?php echo esc_attr(translang_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(translang_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($translang_ppp); ?>"
					data-post-type="<?php echo esc_attr($translang_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($translang_taxonomy); ?>"
					data-cat="<?php echo esc_attr($translang_id); ?>"
					data-parent-cat="<?php echo esc_attr($translang_cat); ?>"
					data-need-content="<?php echo (false===$translang_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($translang_portfolio_need_content) 
						translang_show_portfolio_posts(array(
							'cat' => $translang_id,
							'parent_cat' => $translang_cat,
							'taxonomy' => $translang_taxonomy,
							'post_type' => $translang_post_type,
							'page' => 1,
							'sticky' => $translang_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		translang_show_portfolio_posts(array(
			'cat' => $translang_cat,
			'parent_cat' => $translang_cat,
			'taxonomy' => $translang_taxonomy,
			'post_type' => $translang_post_type,
			'page' => 1,
			'sticky' => $translang_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>
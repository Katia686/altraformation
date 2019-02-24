<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

// Page (category, tag, archive, author) title

if ( translang_need_page_title() ) {
	translang_sc_layouts_showed('title', true);
	translang_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								translang_show_post_meta(array(
									'date' => true,
									'categories' => true,
									'seo' => true,
									'share' => false,
									'counters' => 'views,comments,likes'
									)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$translang_blog_title = translang_get_blog_title();
							$translang_blog_title_text = $translang_blog_title_class = $translang_blog_title_link = $translang_blog_title_link_text = '';
							if (is_array($translang_blog_title)) {
								$translang_blog_title_text = $translang_blog_title['text'];
								$translang_blog_title_class = !empty($translang_blog_title['class']) ? ' '.$translang_blog_title['class'] : '';
								$translang_blog_title_link = !empty($translang_blog_title['link']) ? $translang_blog_title['link'] : '';
								$translang_blog_title_link_text = !empty($translang_blog_title['link_text']) ? $translang_blog_title['link_text'] : '';
							} else
								$translang_blog_title_text = $translang_blog_title;
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr($translang_blog_title_class); ?>"><?php
								$translang_top_icon = translang_get_category_icon();
								if (!empty($translang_top_icon)) {
									$translang_attr = translang_getimagesize($translang_top_icon);
									?><img src="<?php echo esc_url($translang_top_icon); ?>" alt="<?php esc_html__('image', 'translang'); ?>" <?php if (!empty($translang_attr[3])) translang_show_layout($translang_attr[3]);?>><?php
								}
								echo wp_kses_data($translang_blog_title_text);
							?></h1>
							<?php
							if (!empty($translang_blog_title_link) && !empty($translang_blog_title_link_text)) {
								?><a href="<?php echo esc_url($translang_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($translang_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'translang_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>
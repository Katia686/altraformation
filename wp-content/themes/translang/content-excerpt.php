<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_post_format = get_post_format();
$translang_post_format = empty($translang_post_format) ? 'standard' : str_replace('post-format-', '', $translang_post_format);
$translang_full_content = translang_get_theme_option('blog_content') != 'excerpt' || in_array($translang_post_format, array('link', 'aside', 'status', 'quote'));
$translang_animation = translang_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($translang_post_format) ); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	>
	<div class="excerpt_content_wrapper_top"><?php
		// Featured image
		translang_show_post_featured(array( 'thumb_size' => translang_get_thumb_size( strpos(translang_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ) ));

		//do_action('translang_action_before_post_meta'); 

		// Post meta
		translang_show_post_meta(array(
			'categories' => false,
			'date' => true,
			'edit' => false,
			'seo' => false,
			'share' => false,
			'counters' => ''	//comments,likes,views - comma separated in any combination
			)
		);
	?></div>
	<div class="excerpt_content_wrapper">
	<?php
	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('translang_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			
			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if ($translang_full_content) {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'translang' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'translang' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$translang_show_learn_more = !in_array($translang_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($translang_post_format, array('link', 'aside', 'status', 'quote'))) {
					the_content();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
			?></div><?php
			// More button
			/*if ( $translang_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'translang'); ?></a></p><?php
			}*/

			do_action('translang_action_before_post_meta'); 

			// Post meta
			translang_show_post_meta(array(
				'categories' => true,
				'date' => false,
				'edit' => true,
				'seo' => false,
				'share' => false,
				'counters' => 'comments,likes'	//comments,likes,views - comma separated in any combination
				)
			);

		}
	?></div><!-- .entry-content -->
	</div>
</article>
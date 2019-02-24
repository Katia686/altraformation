<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_blog_style = explode('_', translang_get_theme_option('blog_style'));
$translang_columns = empty($translang_blog_style[1]) ? 2 : max(2, $translang_blog_style[1]);
$translang_expanded = !translang_sidebar_present() && translang_is_on(translang_get_theme_option('expand_content'));
$translang_post_format = get_post_format();
$translang_post_format = empty($translang_post_format) ? 'standard' : str_replace('post-format-', '', $translang_post_format);
$translang_animation = translang_get_theme_option('blog_animation');

?><div class="<?php echo 'classic' == $translang_blog_style[0] ? 'column' : 'masonry_item masonry_item'; ?>-1_<?php echo esc_attr($translang_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_format_'.esc_attr($translang_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($translang_columns)
					. ' post_layout_'.esc_attr($translang_blog_style[0]) 
					. ' post_layout_'.esc_attr($translang_blog_style[0]).'_'.esc_attr($translang_columns)
					); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	>

	<?php

	// Featured image
	translang_show_post_featured( array( 'thumb_size' => translang_get_thumb_size($translang_blog_style[0] == 'classic'
													? (strpos(translang_get_theme_option('body_style'), 'full')!==false 
															? ( $translang_columns > 2 ? 'big' : 'huge' )
															: (	$translang_columns > 2
																? ($translang_expanded ? 'med' : 'small')
																: ($translang_expanded ? 'big' : 'med')
																)
														)
													: (strpos(translang_get_theme_option('body_style'), 'full')!==false 
															? ( $translang_columns > 2 ? 'masonry-big' : 'full' )
															: (	$translang_columns <= 2 && $translang_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($translang_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('translang_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('translang_action_before_post_meta'); 

			// Post meta
			translang_show_post_meta(array(
				'categories' => true,
				'date' => true,
				'edit' => $translang_columns < 3,
				'seo' => false,
				'share' => false,
				'counters' => 'comments',
				)
			);
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$translang_show_learn_more = false; //!in_array($translang_post_format, array('link', 'aside', 'status', 'quote'));
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($translang_post_format, array('link', 'aside', 'status', 'quote'))) {
				the_content();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($translang_post_format, array('link', 'aside', 'status', 'quote'))) {
			translang_show_post_meta(array(
				'share' => false,
				'counters' => 'comments'
				)
			);
		}
		// More button
		if ( $translang_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'translang'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>
<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

$translang_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$translang_post_format = get_post_format();
$translang_post_format = empty($translang_post_format) ? 'standard' : str_replace('post-format-', '', $translang_post_format);
$translang_animation = translang_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($translang_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($translang_post_format) ); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}
	?>
	<div class="excerpt_content_wrapper_top"><?php
	// Featured image
	translang_show_post_featured(array(
		'thumb_size' => translang_get_thumb_size($translang_columns==1 ? 'big' : ($translang_columns==2 ? 'med' : 'avatar'))
	));

	do_action('translang_action_before_post_meta'); 
	// Post meta
	translang_show_post_meta(array(
		'categories' => false,
		'date' => true,
		'edit' => false,
		'seo' => false,
		'share' => false,
		'counters' => 'comments,likes'	//comments,likes,views - comma separated in any combination
		)
	);
	?></div>
	<div class="excerpt_content_wrapper">
	<?php

	if ( !in_array($translang_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
			// Post content area
			?><div class="post_content_inner"><?php
				the_excerpt();
			?></div><?php

			// Post meta
			translang_show_post_meta(array(
				'categories' => true,
				'date' => false,
				'edit' => true,
				'seo' => true,
				'share' => true,
				'counters' => 'comments,likes'	//comments,likes,views - comma separated in any combination
				)
			);
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
	</div>
</article></div>
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
$translang_columns = empty($translang_blog_style[1]) ? 1 : max(1, $translang_blog_style[1]);
$translang_expanded = !translang_sidebar_present() && translang_is_on(translang_get_theme_option('expand_content'));
$translang_post_format = get_post_format();
$translang_post_format = empty($translang_post_format) ? 'standard' : str_replace('post-format-', '', $translang_post_format);
$translang_animation = translang_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($translang_columns).' post_format_'.esc_attr($translang_post_format) ); ?>
	<?php echo (!translang_is_off($translang_animation) ? ' data-animation="'.esc_attr(translang_get_animation_classes($translang_animation)).'"' : ''); ?>
	>

	<?php
	// Add anchor
	if ($translang_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Featured image
	translang_show_post_featured( array(
											'class' => $translang_columns == 1 ? 'trx-stretch-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => translang_get_thumb_size(
																	strpos(translang_get_theme_option('body_style'), 'full')!==false
																		? ( $translang_columns > 1 ? 'huge' : 'original' )
																		: (	$translang_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('translang_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('translang_action_before_post_meta'); 

			// Post meta
			$translang_post_meta = translang_show_post_meta(array(
									'categories' => true,
									'date' => true,
									'edit' => $translang_columns == 1,
									'seo' => false,
									'share' => false,
									'counters' => $translang_columns < 3 ? 'comments' : '',
									'echo' => false
									)
								);
			translang_show_layout($translang_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$translang_show_learn_more = !in_array($translang_post_format, array('link', 'aside', 'status', 'quote'));
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
				translang_show_layout($translang_post_meta);
			}
			// More button
			if ( $translang_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'translang'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>
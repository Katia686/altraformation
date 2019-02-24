<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

translang_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	?><div class="posts_container"><?php
	
	$translang_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$translang_sticky_out = is_array($translang_stickies) && count($translang_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($translang_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($translang_sticky_out && !is_sticky()) {
			$translang_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $translang_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($translang_sticky_out) {
		$translang_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	translang_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>
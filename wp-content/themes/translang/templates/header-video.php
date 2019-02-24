<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.14
 */
$translang_header_video = translang_get_header_video();
$translang_embed_video = '';
if (!empty($translang_header_video) && !translang_is_from_uploads($translang_header_video)) {
	if (translang_is_youtube_url($translang_header_video) && preg_match('/[=\/]([^=\/]*)$/', $translang_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$translang_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($translang_header_video) . '[/embed]' ));
			$translang_embed_video = translang_make_video_autoplay($translang_embed_video);
		} else {
			$translang_header_video = str_replace('/watch?v=', '/embed/', $translang_header_video);
			$translang_header_video = translang_add_to_url($translang_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$translang_embed_video = '<iframe src="' . esc_url($translang_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php translang_show_layout($translang_embed_video); ?></div><?php
	}
}
?>
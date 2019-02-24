<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0.10
 */

// Copyright area
$translang_footer_scheme =  translang_is_inherit(translang_get_theme_option('footer_scheme')) ? translang_get_theme_option('color_scheme') : translang_get_theme_option('footer_scheme');
$translang_copyright_scheme = translang_is_inherit(translang_get_theme_option('copyright_scheme')) ? $translang_footer_scheme : translang_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($translang_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and [[...]] on the <i>...</i> and <b>...</b>
				$translang_copyright = translang_prepare_macros(translang_get_theme_option('copyright'));
				if (!empty($translang_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $translang_copyright, $translang_matches)) {
						$translang_copyright = str_replace($translang_matches[1], date(str_replace(array('{', '}'), '', $translang_matches[1])), $translang_copyright);
					}
//					// Display copyright
//					echo wp_kses_data(nl2br($translang_copyright));


					// Replace {{Y}} or {Y} with the current year
					$translang_copyright = str_replace(array('{{Y}}', '{Y}'), date('Y'), $translang_copyright);
					// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
					// $translang_copyright = seventrees_prepare_macros($translang_copyright);
					// Display copyright
					echo wp_kses_data(nl2br($translang_copyright));
				}
			?></div>
		</div>
	</div>
</div>

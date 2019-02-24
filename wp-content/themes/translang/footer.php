<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage TRANSLANG
 * @since TRANSLANG 1.0
 */

						// Widgets area inside page content
						translang_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					translang_create_widgets_area('widgets_below_page');

					$translang_body_style = translang_get_theme_option('body_style');
					if ($translang_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$translang_footer_style = translang_get_theme_option("footer_style");
			if (strpos($translang_footer_style, 'footer-custom-')===0) $translang_footer_style = 'footer-custom';
			get_template_part( "templates/{$translang_footer_style}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (translang_is_on(translang_get_theme_option('debug_mode')) && translang_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(translang_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>
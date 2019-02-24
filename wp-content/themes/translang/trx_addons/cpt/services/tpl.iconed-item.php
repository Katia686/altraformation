<?php
/**
 * The style "iconed" of the Services item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

$args = get_query_var('trx_addons_args_sc_services');

$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
$link = get_permalink();
$featured_position = !empty($args['featured_position']) ? $args['featured_position'] : 'top';
$svg_present = false;
$image = '';
if ( has_post_thumbnail() ) {
	$image = trx_addons_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), trx_addons_get_thumb_size('masonry') );
}

if ($args['slider']) {
	?><div class="swiper-slide"><?php
} else if ($args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?> "><?php
}
?>
<div class="sc_services_item<?php
	echo isset($args['hide_excerpt']) && $args['hide_excerpt'] ? ' without_content' : ' with_content';
	echo !empty($image) || $args['featured']=='image_icon'
		? ' with_image' : '';
	//echo $args['featured']=='icon' ? ' with_icon' : '';
	echo esc_attr($args['featured']=='icon' ? ' with_icon' : '');
	//echo $args['featured']=='number' ? ' with_number' : '';
	echo esc_attr($args['featured']=='number' ? ' with_number' : '');

	echo ' sc_services_item_featured_'.esc_attr($featured_position);
?>">
	<div class="sc_services_item_header"<?php if (!empty($image)) echo ' style="background-image: url('.esc_url($image).');"'; ?>>

		<?php
		// Featured image or icon
		if ( has_post_thumbnail() && (empty($args['featured']) || $args['featured']=='image')) {
			set_query_var('trx_addons_args_featured', apply_filters('trx_addons_filter_args_featured', array(
				'class' => 'sc_services_item_thumb',
				'hover' => 'zoomin',
				'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size($args['columns'] > 2 ? 'medium' : 'big'), 'services-default')
			), 'services-default'));
			if (($fdir = trx_addons_get_file_dir('templates/tpl.featured.php')) != '') { include $fdir; }
		} else if ( $args['featured']=='image_icon' && !empty($meta['image_icon'])) {
		?>
			<a href="<?php echo esc_url($link); ?>"
				 class="sc_services_item_image_icon"
			 ><img src="<?php echo esc_url($meta['image_icon']); ?>" alt="<?php esc_html__('image', 'translang'); ?>"/></a>
		 <?php
		} else if ($args['featured']=='icon' && !empty($meta['icon'])) {
			$svg = '';
			if (!empty($args['icons_animation']) && $args['icons_animation'] > 0 && ($svg = trx_addons_get_file_dir('css/svg-icons/'.trx_addons_esc($meta['icon']).'.svg')) != '') {
				$svg_present = true;
			}
			?><a href="<?php echo esc_url($link); ?>"
				 id="<?php echo esc_attr($args['id'].'_'.trim($meta['icon'])); ?>"
				 class="sc_services_item_icon <?php echo empty($svg) ? esc_attr($meta['icon']) : 'sc_icon_type_svg'; ?>"
				 ><?php
				if (!empty($svg)) {
					trx_addons_show_layout(trx_addons_get_svg_from_file($svg));
				}
			?></a><?php
		} else if ($args['featured']=='number') {
			?><span class="sc_services_item_number"><?php
				$number = get_query_var('trx_addons_args_item_number');
				printf("%02d", $number);
			?></span><?php
		}
		if (isset($args['hide_excerpt']) && $args['hide_excerpt']==1) {
			?>
			<h6 class="sc_services_item_title">
				<?php
					if ($args['featured']=='image_icon' && !empty($meta['image_icon'])) { ?>
				<?php } ?>
				<a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a>
			</h6>
			<div class="sc_services_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY));?></div>
			<?php
		}
		?>
	</div>
	<?php if (!isset($args['hide_excerpt']) || $args['hide_excerpt']==0) { ?>
		<div class="sc_services_item_content">
			<h6 class="sc_services_item_title"><a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a></h6>
			<div class="sc_services_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY));?></div>
			<div class="sc_services_item_text"><?php the_excerpt(); ?></div>
			<div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>" class="sc_button sc_button_simple"><?php esc_html_e('Learn more', 'translang'); ?></a></div>
		</div>
	<?php } ?>
</div>
<?php
if ($args['slider'] || $args['columns'] > 1) {
	?></div><?php
}
if (trx_addons_is_on(trx_addons_get_option('debug_mode')) && $svg_present) {
	wp_enqueue_script( 'vivus', trx_addons_get_file_url('shortcodes/icons/vivus.js'), array('jquery'), null, true );
	wp_enqueue_script( 'trx_addons-sc_icons', trx_addons_get_file_url('shortcodes/icons/icons.js'), array('jquery'), null, true );
}
?>

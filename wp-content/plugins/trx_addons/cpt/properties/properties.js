/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

// Init properties functionality
jQuery(document).on('action.ready_trx_addons', function() {

	"use strict";
	
	// Single Property's page: Change featured image on click on the gallery image
	jQuery('.properties_page_gallery:not(.inited)')
		.addClass('inited')
		.on('click', '.properties_page_gallery_item', function(e) {
			jQuery(this).siblings().removeClass('properties_page_gallery_item_active');
			jQuery(this).addClass('properties_page_gallery_item_active');
			var image = jQuery(this).data('image');
			if (!image) return;
			jQuery(this).parent().prev('.properties_page_featured').find('img').attr({
				'src': image,
				'srcset': ''
			});
			e.preventDefault();
			return false;
		});
	
	// Widget "Properties Order": Submit form on change sorting field
	jQuery('select[name="properties_order"]:not(.inited)')
		.addClass('inited')
		.on('change', function(e) {
			jQuery(this).parents('form').submit();
			e.preventDefault();
			return false;
		});
	
	// Widget "Properties Advanced Search": Show/Hide Advanced fields
	jQuery('.properties_search_show_advanced:not(.inited)')
		.addClass('inited')
		.on('click', function () {
			jQuery(this).parents('.properties_search').toggleClass('properties_search_opened');
		});
	
	// Widget "Properties Advanced Search": Field "Country" is changed - refresh states
	jQuery('select[name="properties_country"]:not(.inited)')
		.addClass('inited')
		.on('change', function () {
			var fld = jQuery(this);
			var slave_fld = fld.parents('form').find('select[name="properties_state"]');
			if (slave_fld.length > 0) {
				var slave_lbl = slave_fld.parents('label');
				trx_addons_refresh_list('states', fld.val(), slave_fld, slave_lbl);
			}
		});

	// Widget "Properties Advanced Search": Field "State" is changed - refresh cities
	jQuery('select[name="properties_state"]:not(.inited)')
		.addClass('inited')
		.on('change', function () {
			var fld = jQuery(this);
			var slave_fld = fld.parents('form').find('select[name="properties_city"]');
			if (slave_fld.length > 0) {
				var slave_lbl = slave_fld.parents('label');
				var country = 0;
				if (fld.val() == 0) country = fld.parents('form').find('select[name="properties_country"]').val();
				trx_addons_refresh_list('cities', {'state': fld.val(), 'country': country}, slave_fld, slave_lbl);
			}
		});

	// Widget "Properties Advanced Search": Field "City" is changed - refresh neighborhoods
	jQuery('select[name="properties_city"]:not(.inited)')
		.addClass('inited')
		.on('change', function () {
			var fld = jQuery(this);
			var slave_fld = fld.parents('form').find('select[name="properties_neighborhood"]');
			if (slave_fld.length > 0) {
				var slave_lbl = slave_fld.parents('label');
				trx_addons_refresh_list('neighborhoods', fld.val(), slave_fld, slave_lbl);
			}
		});

});
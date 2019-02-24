/* global jQuery:false */
/* global TRANSLANG_STORAGE:false */

jQuery(document).ready(function() {
	"use strict";

	// Init Media manager variables
	TRANSLANG_STORAGE['media_id'] = '';
	TRANSLANG_STORAGE['media_frame'] = [];
	TRANSLANG_STORAGE['media_link'] = [];
	jQuery('.translang_media_selector').on('click', function(e) {
		translang_show_media_manager(this);
		e.preventDefault();
		return false;
	});
	
	// Hide empty meta-boxes
	jQuery('.postbox > .inside').each(function() {
		if (jQuery(this).html().length < 5) jQuery(this).parent().hide();
	});

	// Hide admin notice
	jQuery('#translang_admin_notice .translang_hide_notice').on('click', function(e) {
		jQuery('#translang_admin_notice').slideUp();
		jQuery.post( TRANSLANG_STORAGE['ajax_url'], {'action': 'translang_hide_admin_notice'}, function(response){});
		e.preventDefault();
		return false;
	});
	
	// TGMPA Source selector is changed
	jQuery('.tgmpa_source_file').on('change', function(e) {
		var chk = jQuery(this).parents('tr').find('>th>input[type="checkbox"]');
		if (chk.length == 1) {
			if (jQuery(this).val() != '')
				chk.attr('checked', 'checked');
			else
				chk.removeAttr('checked');
		}
	});
		
	// Add icon selector after the menu item classes field
	jQuery('.edit-menu-item-classes').each(function() {
		var icon = translang_get_icon_class(jQuery(this).val());
		jQuery(this).after('<span class="translang_list_icons_selector'+(icon ? ' '+icon : '')+'" title="'+TRANSLANG_STORAGE['icon_selector_msg']+'"></span>');
	});
	jQuery('.translang_list_icons_selector').on('click', function(e) {
		var selector = jQuery(this);
		var input_id = selector.prev().attr('id');
		if (input_id === undefined) {
			input_id = ('translang_icon_field_'+Math.random()).replace(/\./g, '');
			selector.prev().attr('id', input_id)
		}
		var in_menu = selector.parents('.menu-item-settings').length > 0;
		var list = in_menu ? jQuery('.translang_list_icons') : selector.next('.translang_list_icons');
		if (list.length > 0) {
			list.find('span.translang_list_active').removeClass('translang_list_active');
			var icon = translang_get_icon_class(selector.attr('class'));
			if (icon != '') list.find('span[class*="'+icon+'"]').addClass('translang_list_active');
			var pos = in_menu ? selector.offset() : selector.position();
			list.data('input_id', input_id).css({'left': pos.left-(in_menu ? 0 : list.outerWidth()-selector.width()-1), 'top': pos.top+(in_menu ? 0 : selector.height()+4)}).fadeIn();
		}
		e.preventDefault();
		return false;
	});
	jQuery('.translang_list_icons span').on('click', function(e) {
		var list = jQuery(this).parent().fadeOut();
		var icon = translang_alltrim(jQuery(this).attr('class').replace(/translang_list_active/, ''));
		var input = jQuery('#'+list.data('input_id'));
		input.val(translang_chg_icon_class(input.val(), icon)).trigger('change');
		var selector = input.next();
		selector.attr('class', translang_chg_icon_class(selector.attr('class'), icon));
		e.preventDefault();
		return false;
	});

	// Standard WP Color Picker
	if (jQuery('.translang_color_selector').length > 0) {
		jQuery('.translang_color_selector').wpColorPicker({
			// you can declare a default color here,
			// or in the data-default-color attribute on the input
			//defaultColor: false,
	
			// a callback to fire whenever the color changes to a valid color
			change: function(e, ui){
				jQuery(e.target).val(ui.color).trigger('change');
			},
	
			// a callback to fire when the input is emptied or an invalid color
			clear: function(e) {
				jQuery(e.target).prev().trigger('change')
			},
	
			// hide the color picker controls on load
			//hide: true,
	
			// show a group of common colors beneath the square
			// or, supply an array of colors to customize further
			//palettes: true
		});
	}

	function translang_chg_icon_class(classes, icon) {
		var chg = false;
		classes = translang_alltrim(classes).split(' ');
		for (var i=0; i<classes.length; i++) {
			if (classes[i].indexOf('icon-') >= 0) {
				classes[i] = icon;
				chg = true;
				break;
			}
		}
		if (!chg) {
			if (classes.length == 1 && classes[0] == '')
				classes[0] = icon;
			else
				classes.push(icon);
		}
		return classes.join(' ');
	}

	function translang_get_icon_class(classes) {
		var classes = translang_alltrim(classes).split(' ');
		var icon = '';
		for (var i=0; i<classes.length; i++) {
			if (classes[i].indexOf('icon-') >= 0) {
				icon = classes[i];
				break;
			}
		}
		return icon;
	}

	function translang_show_media_manager(el) {
		TRANSLANG_STORAGE['media_id'] = jQuery(el).attr('id');
		TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']] = jQuery(el);
		// If the media frame already exists, reopen it.
		if ( TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']] ) {
			TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']].open();
			return false;
		}
		// Create the media frame.
		TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']] = wp.media({
			// Popup layout (if comment next row - hide filters and image sizes popups)
			frame: 'post',
			// Set the title of the modal.
			title: TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('choose'),
			// Tell the modal to show only images.
			library: {
				type: TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('type') ? TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('type') : 'image'
			},
			// Multiple choise
			multiple: TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('multiple')===true ? 'add' : false,
			// Customize the submit button.
			button: {
				// Set the text of the button.
				text: TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('update'),
				// Tell the button not to close the modal, since we're
				// going to refresh the page when the image is selected.
				close: true
			}
		});
		// When an image is selected, run a callback.
		TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']].on( 'insert select', function(selection) {
			// Grab the selected attachment.
			var field = jQuery("#"+TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('linked-field')).eq(0);
			var attachment = null, attachment_url = '';
			if (TRANSLANG_STORAGE['media_link'][TRANSLANG_STORAGE['media_id']].data('multiple')===true) {
				TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']].state().get('selection').map( function( att ) {
					attachment_url += (attachment_url ? "\n" : "") + att.toJSON().url;
				});
				var val = field.val();
				attachment_url = val + (val ? "\n" : '') + attachment_url;
			} else {
				attachment = TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']].state().get('selection').first().toJSON();
				attachment_url = attachment.url;
				var sizes_selector = jQuery('.media-modal-content .attachment-display-settings select.size');
				if (sizes_selector.length > 0) {
					var size = translang_get_listbox_selected_value(sizes_selector.get(0));
					if (size != '') attachment_url = attachment.sizes[size].url;
				}
			}
			field.val(attachment_url);
			if (attachment_url.indexOf('.jpg') > 0 || attachment_url.indexOf('.png') > 0 || attachment_url.indexOf('.gif') > 0) {
				var preview = field.siblings('.translang_meta_box_field_preview');
				if (preview.length != 0) {
					if (preview.find('img').length == 0)
						preview.append('<img src="'+attachment_url+'">');
					else 
						preview.find('img').attr('src', attachment_url);
				} else {
					preview = field.siblings('img');
					if (preview.length != 0)
						preview.attr('src', attachment_url);
				}
			}
			field.trigger('change');
		});
		// Finally, open the modal.
		TRANSLANG_STORAGE['media_frame'][TRANSLANG_STORAGE['media_id']].open();
		return false;
	}

});
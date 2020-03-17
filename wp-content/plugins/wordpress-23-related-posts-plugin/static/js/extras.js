(function ($) {
	var extra_settings = function () {
		var custom_size_panel = $('#wp_rp_custom_thumb_sizes_settings');
		if ($('#wp_rp_custom_size_thumbnail_enabled:checked').length) {
			custom_size_panel.show();
		} else {
			custom_size_panel.hide();
		}

		$('#wp_rp_custom_size_thumbnail_enabled').click(function() {
			custom_size_panel.toggle(this.checked);
		});
	}

	$(extra_settings);
}(jQuery));

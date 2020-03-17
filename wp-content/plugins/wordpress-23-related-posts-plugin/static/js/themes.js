(function ($) {
	var theme_selector = function () {
		var plugin_static_url = $('#wp_rp_plugin_static_base_url').val(),
			static_url = $('#wp_rp_static_base_url').val(),
			json_url = $('#wp_rp_json_url').val(),
			plugin_version = $('#wp_rp_version').val(),
			platforms = {
				mobile: {
					wrap: $('#wp_rp_mobile_theme_options_wrap'),
					theme_area: $('#wp_rp_mobile_theme_area'),
					current_theme: $('#wp_rp_mobile_theme_selected').val()
				},
				desktop: {
					wrap: $('#wp_rp_desktop_theme_options_wrap'),
					theme_area: $('#wp_rp_desktop_theme_area'),
					current_theme: $('#wp_rp_desktop_theme_selected').val()
				}
			},

			themes = {
				'mobile': [
					{
						"name": "Modern",
						"location": "m-modern.css"
					},
					{
						"name": "Infinite Stream (experimental)",
						"location": "m-stream.css"
					},
					{
						"name": "Plain (your own css)",
						"location": "m-plain.css"
					}
				],
				'desktop': [
					{
						"name": "Momma",
						"location": "momma.css"
					},
					{
						"name": "Modern",
						"location": "modern.css"
					},
					{
						"name": "Vertical (Large)",
						"location": "vertical.css"
					},
					{
						"name": "Vertical (Medium)",
						"location": "vertical-m.css"
					},
					{
						"name": "Vertical (Small)",
						"location": "vertical-s.css"
					},
					{
						"name": "Pinterest Inspired",
						"location": "pinterest.css"
					},
					{
						"name": "Two Columns",
						"location": "twocolumns.css"
					},
					{
						"name": "Plain (your own css)",
						"location": "plain.css"
					}
				]
			},

			update_themes = function () {
				$.each(platforms, function (platform, elms) {
					var td = elms.wrap.find('div.theme-list');
					var screenshot_wrap = elms.wrap.find('div.theme-screenshot');
					var update_img = function (input) {
						if (!input.val()) {
							screenshot_wrap.html('');
							return;
						}

						var screenshot_src = plugin_static_url + 'img/themes/' + input.val().replace(/\.css$/, '.jpg');
						var img = screenshot_wrap.find('img');

						if (!img.length) {
							img = $('<img />');
							screenshot_wrap.html(img);
						} else if (img.attr('src') === screenshot_src) {
							return;
						}

						img.attr('src', screenshot_src);
					};
					td.empty();

					$.each(themes[platform], function (i, theme) {
						if (theme.location == 'custom.css') {
							return;
						}

						var selected = theme.location === elms.current_theme ? 'checked="checked"' : '';

						td.append('<label class="theme-label"><input ' + selected + ' class="theme-option" type="radio" name="wp_rp_' + platform + '_theme_name" value="' + theme.location + '" /> ' + theme.name  + '</label><br />');
					});

					td.on('hover', 'label.theme-label', function () {
						update_img($('input', this));
					});

					td.on('mouseleave', function () {
						update_img(td.find('input:checked'));
					});
					update_img(td.find('input:checked'));

					elms.theme_area.show();
				});
			},
			append_get_themes_script = function () {
				var script = document.createElement('script'),
					body = document.getElementsByTagName("body").item(0);
				script.type = 'text/javascript';
				script.src = json_url + 'themes2.js?plv=' + plugin_version;

				body.appendChild(script);
			},
			themes_loaded = false;

		window.wp_rp_themes_cb = function (data) {
			if (data && data.themes) {
				themes = data.themes;

				if(themes) {
					themes_loaded = true;
					update_themes();
				}
			}
			if(themes_loaded) {
				$('#wp_rp_theme_options_wrap').show()
			}
		};

		if ($('#wp_rp_enable_themes:checked').length) {
			update_themes();
			$('#wp_rp_theme_options_wrap').show();
		}

		$('#wp_rp_enable_themes').change(function () {
			if ($('#wp_rp_enable_themes:checked').length) {
				append_get_themes_script();
			} else {
				$('#wp_rp_theme_options_wrap').hide();
			}
		});
	};

	$(theme_selector);
}(jQuery));

(function ($) {
	var template_eval = function (template, vars) {
		$.each(vars, function (k, v) {
			template = template.replace(new RegExp('{{ *' + k + ' *}}'), v);
		});
		return template;
	};

	$(function () {
		var nonce = $('#wp_rp_ajax_nonce').val(),
			logHabit = function (action, extras) {
				var img = new Image(),
					protocol = ("https:" === location.protocol ? "https://" : "http://"),
					payload = {
						'zem-habit-platform': 'wordpress-wprp',
						'zem-habit-action': action,
						'zem-habit-timestamp': (new Date()).getTime()
					};
				extras = extras || {};
				payload = $.extend(extras, payload);
				img.src =  protocol + "eyepatch-ea.sovrn.com/log/?" + object_to_query(payload);
			},
			ajaxCallSubscribe = function (email, subscriptions, successCallback) {
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'wprp_subscribe',
						subscription: subscriptions,
						_wpnonce: nonce,
						email: email || '0'
					},
					success: successCallback,
					type: 'POST'
				});
			},
			disableCustomCSS = function (evt) {
				var disabled = $('#wp_rp_desktop_custom_theme_enabled:checked').length !== 1;
				$('#wp_rp_desktop_theme_custom_css').prop("readonly", disabled);
			},
			turn_on_rp = function (button_type) {
				var static_url = $('#wp_rp_static_base_url').val();

				$('#wp_rp_ctr_dashboard_enabled, #wp_rp_enable_themes, #wp_rp_promoted_content_enabled, #wp_rp_traffic_exchange_enabled').prop('checked', true);
				$('#wp_rp_settings_form').append('<input type="hidden" value="statistics+thumbnails+promoted" name="wp_rp_turn_on_button_pressed" id="wp_rp_turn_on_button_pressed">');
				$('#wp_rp_settings_form').append('<input type="hidden" value="' + button_type + '" name="wp_rp_button_type" id="wp_rp_button_type">');

				$('#wp_rp_settings_form').submit();
			};

		disableCustomCSS();
		$('#wp_rp_desktop_custom_theme_enabled').click(disableCustomCSS);

		if ($('#wp_rp_subscribe_email').length) {
			if (! $('#wp_rp_subscribe_email').val().length) {
				$('#wp_rp_unsubscribe_button').hide();
			}
			else {
				$('#wp_rp_subscribe_button').hide();
			}
		}

		$('#wp_rp_subscribe_button').on('click', function (evt) {
			var email = $('#wp_rp_subscribe_email').val();
			evt.preventDefault();
			if (!email) { return; }
			$('#wp_rp_subscribe_button').attr('disabled', true);
			ajaxCallSubscribe(email, 'activityreport,newsletter', function (data) {
				$('#wp_rp_subscribe_button').attr('disabled', false);
				if (parseInt(data)) {
					$('#wp_rp_subscribe_button').prop('disabled', false);
					$('#wp_rp_subscribe_button').hide();
					$('#wp_rp_unsubscribe_button').show();
					alert('Subscription successful!');
				}
			});
		});

		$('#wp_rp_unsubscribe_button').on('click', function (evt) {
			evt.preventDefault();
			$('#wp_rp_unsubscribe_button').attr('disabled', true);
			ajaxCallSubscribe(false, false, function (data) {
				$('#wp_rp_unsubscribe_button').attr('disabled', false);
				if (parseInt(data)) {
					$('#wp_rp_subscribe_email').val('');
					$('#wp_rp_unsubscribe_button').hide();
					$('#wp_rp_subscribe_button').show();
				}
			});
		});

		// collapsible blocks implementation
		$('#wp_rp_wrap .collapsible .collapse-handle').on('click', function (event) {
			var wrapper = $(this).closest('.collapsible');
			var container = wrapper.find('.container');
			var is_collapsed = wrapper.hasClass('collapsed');

			var block = wrapper.attr('block');

			var callback = function() {
				wrapper.toggleClass('collapsed');
			};

			if(is_collapsed) {
				container.slideDown();
				$.post(ajaxurl, { action: 'rp_show_hide_' + block, show: true, _wpnonce: nonce});
				callback();
			} else {
				container.slideUp();
				$.post(ajaxurl, { action: 'rp_show_hide_' + block, hide: true, _wpnonce: nonce});
				callback();
			}

			if (block === 'statistics') {
				logHabit('statistics_' + (is_collapsed ? 'on' : 'off'));
			}


			event.preventDefault();
		});

	});
}(jQuery));



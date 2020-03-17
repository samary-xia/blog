(function () {
	var ZemRPResponse = [];
	if (window.jQuery) {
		jQuery(function ($) {
			window._wp_rp_request_id = window._wp_rp_request_id || ((new Date().getTime() % 60466176) / 60466176).toString(36).substr(2,5) + Math.random().toString(36).substr(2,10); // 60466176 = 36 ^ 5

			var scrollTimeout = 0,
				win = $(window),
				fetching_first_time = window._wp_rp_num_rel_posts * 1 || 5,
				fetching = fetching_first_time * 2,
				is_first_time = true,
				related = $('.wp_rp.related_post'),
				loading = false,
				stop = false,
				originalRPHeight = 2 * related.outerHeight(true),

				from = fetching_first_time,

				push_stats = function (action, extra_params) {
					var img = document.createElement('img');
					var params = {
							action: action,
							post_id: window._wp_rp_post_id,
							request_id: window._wp_rp_request_id,
							_: (+new Date())
						};
					var ajax_query = [];
					var ajax_url = window._wp_rp_static_base_url + 'stats.gif?';

					if (extra_params) {
						for (var attrname in extra_params) {
							if (extra_params.hasOwnProperty(attrname)) {
								params[attrname] = extra_params[attrname];
							}
						}
					}

					for(x in params) {
						if (params.hasOwnProperty(x)) {
							ajax_query.push(x + '=' + params[x]);
						}
					}

					ajax_url += ajax_query.join('&');

					img.src = ajax_url;
				},
				getNextSet = function () {
					if (ZemRPResponse.length <= 0) {
						$('#wp_rp_related_load_more').parent().remove();
						return [];
					}
					var i = 0, result = [], next = {};
					for (; i < (is_first_time ? fetching_first_time : fetching); i += 1) {
						next = ZemRPResponse.shift();
						if (next) {
							result.push(next);
						}
					}
					is_first_time = false;
					return result;
				},
				fillList = function (cb) {
					if (stop && ZemRPResponse.length <= 0) {
						$('#wp_rp_related_load_more').parent().remove();
					}
					if (loading || stop) {
						return;
					}

					loading = true;
					$.getJSON(window._wp_rp_wp_ajax_url + '?action=wp_rp_load_articles&post_id=' + window._wp_rp_post_id + '&from=' + from + '&count=50&size=full', function (data) {
						if (!data || !data.length || typeof(data) === 'string') {
							stop = true;
							if (ZemRPResponse.length <= 0) {
								$('#wp_rp_related_load_more').parent().remove();
							}
						} else {
							from += data.length;
							$.each(data, function (i, newOne) {
								ZemRPResponse.push(newOne);
							});
							if (cb) {
								cb();
							}
						}
						loading = false;
					});
				},
				fetchRelated = function (cb) {
					if (ZemRPResponse.length <= 0) {
						fillList(function () {
							cb(getNextSet());
						});
					} else if (ZemRPResponse.length <= (2 * fetching)) {
						cb(getNextSet());
						fillList();
					} else {
						cb(getNextSet());
					}
				},
				loadMoreRelated = function () {
					fetchRelated(function (data) {
						setTimeout(function () {
							$('#wp_rp_related_load_more')
								.find('.zloader').hide().end()
								.find('span').show();
						}, 500);

						var postContainer = $('.related_post.wp_rp'),
							nextPosition = postContainer.find('li ul li').length,
							prevImg = null,
							columns = postContainer.find('.wp_rp_related_post_column'),
							appendArticle = function (newElm, newImg) {
								var shortest = $();

								columns.each(function (i, column) {
									column = $('ul', column);

									if (shortest.height() === null || shortest.height() >= column.height()) {
										shortest = column;
									}
								});

								shortest.append(newElm);
							},
							loadArticle = function (i, newElm, prevImg, newImg) {
								setTimeout(function () {
									if (!prevImg || !prevImg.length || prevImg.data('zloaded')) {
										appendArticle(newElm, newImg);
									} else {
										prevImg
											.load(function () {appendArticle(newElm, newImg);})
											.error(function () {appendArticle(newElm, newImg);});
									}
								}, 75 * i);
							};

						$.each(data, function (i, post) {
							var newImg = $(post.img);
							newImg
								.load(function () {$(this).data('zloaded', true)})
								.error(function () {$(this).data('zloaded', true)});

							var newElm = $('<li data-position="' + nextPosition + '" data-poid="' + post.id + '"><a href="' + post.url + '" class="wp_rp_thumbnail"></a><a href="' + post.url + '" class="wp_rp_title">' + post.title + '</a></li>');
							newElm.data('position', nextPosition);
							newElm.data('poid', post.id);
							newElm.find('.wp_rp_thumbnail').append(newImg);

							nextPosition += 1;

							loadArticle(i, newElm, prevImg, newImg);

							prevImg = newImg;
						});
					});
				},
				scrollHandler = function () {
					if (scrollTimeout) {
						clearTimeout(scrollTimeout);
					}
					scrollTimeout = setTimeout(function () {
						var postContainer = $('.related_post.wp_rp'),
							fromBottom = postContainer.offset().top + postContainer.outerHeight(true) - win.scrollTop() - win.height();

						if (fromBottom + 100 < originalRPHeight) { // before the user scrolls below this threshold, load more
							loadMoreRelated();
						}
					}, 150);
				},
				initScrollHandler = function () {
					scrollHandler();
					$(window).bind('scroll.zloader', function () {
						if (is_first_time) {
							scrollHandler();
						} else {
							$(window).unbind('scroll.zloader');
						}
					});
				},
				preparseRelatedPosts = function () {
					var max_left = -1,
						columns = [],
						column_count = 0;

					related.find('li').each(function (i, column) {
						column = $(column);
						column.children().find('img').data('zloaded', true);

						var id = column.data('poid');
						var position = column.data('position');
						var post_type = column.data('post-type');
						var class_name = column.attr('class');;

						var first = $('<li class="' + class_name + '" data-post-type="' + post_type + '" data-position="' + position + '" data-poid="' + id + '"></li>');
						var left = column.offset().left;

						if (left > max_left) {
							max_left = left;
							column_count += 1;
						}

						var column_idx = i % column_count;

						first.append(column.children());

						if (columns[column_idx]) {
							columns[column_idx].find('ul').append(first);
							column.remove();
						} else {
							column.empty();
							column.attr('data-position', null);
							column.attr('data-poid', null);
							column.attr('data-post-type', null);

							column.addClass('wp_rp_related_post_column');
							column.addClass('wp_rp_special');

							column.append('<ul></ul>');
							column.find('ul').append(first);

							columns[column_idx] = column;
						}
					});

					initScrollHandler();
				};


			preparseRelatedPosts();
			fillList();

			related.append($('<li class="wp_rp_related_post_load_more wp_rp_special">' +
						'<a id="wp_rp_related_load_more" href="#">' +
							'<span>Load more posts</span>' +
							'<img src="' + window._wp_rp_static_base_url + 'img/loading.gif" class="zloader" />' +
						'</a>' +
					'</li>'));

			related.find('#wp_rp_related_load_more').click(function (ev) {
				$('span', this).hide();
				$('.zloader', this).show();

				ev.preventDefault();
				loadMoreRelated();
				push_stats('pinterest-load-more');
			});
		});
	}
}());

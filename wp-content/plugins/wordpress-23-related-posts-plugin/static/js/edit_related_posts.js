(function ($) {
	/* enable drag and drop data in jquery events */
	$.event.props.push('dataTransfer');

	var related_posts = function () {
		var conf = {
			num_articles: 30,
			num_articles_to_insert: window._wp_rp_num_rel_posts,

			post_id: window._wp_rp_post_id,

			admin_ajax_url: window._wp_rp_admin_ajax_url,
			admin_ajax_action: 'rp_update_related_posts',

			plugin_static_url: window._wp_rp_plugin_static_base_url,
			zemanta_thumbnail_url: 'http://i-ea.sovrn.com/{aid}_150_150.jpg',
			num_default_thumbnails: 30,

			search_support: !!window._wp_rp_erp_search,

			promoted: window._wp_rp_promoted_content !== false,
			tx: window._wp_rp_traffic_exchange !== false,
			num_external_slots: 0
		};

		var elms = {
			holder: null, wrapper: null,
			search_form: null, search_input: null,
			selected_articles_wrap: null,
			replace_articles_wrap: null, replace_articles_list: null, article_loader: null,
			article_list: {}, articles_to_insert: null,
			footer: null, save: null
		};

		var articles = {
			selected: {}, all: [], ids: {}, special: []
		};

		var paintWindow = function () {
			elms.replace_articles_wrap.css('width', Math.min(elms.holder.width() - 142, Math.max(680, conf.num_articles_to_insert * 110 + 130)) + 'px');
		};

		var close_editor = function (ev) {
			ev.preventDefault();
			elms.holder.remove();
			$('html').css('overflow', 'visible');
		};

		var init = function () {
			elms.holder = $('<div id="wp_rp_zem_related_posts_holder"></div>');

			elms.wrapper = $('<div id="wp_rp_zem_related_posts_wrap">' +
					'<div class="selected-header">' +
						'<h4 class="selected-title">Selected posts</h4>' +
						'<a href="#" class="save button">Save and Close</a>' +
					'</div>' +
					'<div class="selected-content"></div>' +
				'</div>');
			elms.holder.append(elms.wrapper);
			elms.wrapper.bind('click', function (ev) {
				ev.stopPropagation();
			});

			elms.save = elms.wrapper.find('.save');
			elms.save.bind('click', function () {
				save_picked_articles(function () {
					window.location.reload();
				});
				return false;
			});

			elms.selected_articles_wrap = elms.wrapper.find('.selected-content');

			var ul = $('<ul class="selected" />');
			for (var i = 0; i < conf.num_articles_to_insert; i += 1) {
				var li = $('<li><div class="droppable" /><span class="notice">Drag post here</span></li>');
				li.data('pos', i);
				elms.article_list[i] = li;
				ul.append(li);
			}
			elms.selected_articles_wrap.append(ul);

			elms.replace_articles_wrap = $('<div id="wp_rp_replace_article_wrap">' +
					'<div class="remove-article-sign">Drop article here to remove it</div>' +
					'<div class="recommendations-header">' +
						'<h4 class="recommendations-title">Recommended posts</h4>' +
						(conf.search_support ? '<form class="search" action="#">' +
							'<input placeholder="search" class="search" type="text" />' +
							'<input class="go button" type="submit" value="go" />' +
						'</form>' :
						'<div class="search notice">Please upgrade the plugin to use search.</div>') +
					'</div>' +
					'<div class="content">' +
						'<ul></ul>' +
					'</div>' +
					'<div class="footer"><a href="http://www.sovrn.com/?ref=edit-rp" target="_blank">sovrn.com</a></div>' +
				'</div>');
			elms.wrapper.append(elms.replace_articles_wrap);

			elms.replace_articles_list = elms.replace_articles_wrap.find('.content ul');

			elms.article_loader = $('<div class="zem-loader-wrap">' +
					'<div class="zem-no-articles">No results.</div>' +
					'<div class="zem-loader">' +
						'<div class="zem-loader-step zem-loader-step-1"></div>' +
						'<div class="zem-loader-step zem-loader-step-2"></div>' +
						'<div class="zem-loader-step zem-loader-step-3"></div>' +
					'</div>' +
				'</div>');
			elms.replace_articles_wrap.append(elms.article_loader);

			elms.remove_article_sign = elms.replace_articles_wrap.find('.remove-article-sign');
			elms.search_form = elms.replace_articles_wrap.find('form.search');
			elms.search_input = elms.replace_articles_wrap.find('input.search');
			elms.footer = elms.replace_articles_wrap.find('.footer');

			// Close pop-up with esc key
			elms.holder.bind('click', close_editor);
			$(document).keydown(function(e) {
				if (e.keyCode == 27) {
					close_editor(e);
				}
			});

			// stop scroll
			$('html').css('overflow', 'hidden');

			update_articles.init();
			load_saved_articles();
			update_articles.update();
			update_articles.render();

			$('body').append(elms.holder);

			paintWindow();
		};

		var load_saved_articles = function () {
			var article_lis = $('.wp_rp:first li:not(.wp_rp_special)');
			if (article_lis) {
				article_lis.each(function (pos, article) {
					article = $(article);
					if (article.data('post-type') == 'own_sourcefeed') {
						var art = {
							aid: article.data('poid').split('-')[1],

							url: article.find('a:first').attr('href'),

							title: article.find('a.wp_rp_title').text(),
							excerpt: article.find('.wp_rp_excerpt').text(),
							comments: parseInt(article.find('.wp_rp_comments_count').text().replace('(', '').replace(')', ''), 10),
							date: article.find('.wp_rp_publish_date').text(),
							text_preview: '',
							published_datetime: '',

							thumbnail: article.find('img').attr('src'),

							picked: true,
							type: article.data('post-type'),
							pos: article.data('position')
						};
						articles.all.push(art);
						articles.ids[art.aid] = art;
						articles.selected[pos] = art;
					} else {
						if ({'promoted': true, 'network': true, 'external': true}[article.data('post-type')]) {
							articles.special.push(pos);
						}
					}
				});
			}
		};

		var save_picked_articles = function (cb) {
			var wp_articles = [];
			var articles_all_pos = 0;
			var selected_articles_ids = {};

			$.each(articles.selected, function (i, a) {
				if (a) {selected_articles_ids[a.aid] = true;}
			});

			for (var pos = 0; pos < conf.num_articles_to_insert; pos += 1) {
				var article = articles.selected[pos];

				if (article) {
					if (article.type === 'own_sourcefeed') {
						wp_articles.push({
							ID: article.aid,

							post_url: article.url,
							thumbnail: article.thumbnail,

							post_title: article.title,
							post_excerpt: article.excerpt || '',
							post_content: '',
							post_date: article.date || '',
							comment_count: article.comments || 0,

							picked: !!article.picked,
							type: article.type,
							pos: pos
						});
					} else {
						wp_articles.push({
							ID: false,
							pos: pos,
							type: article.type
						});
					}
				} else {
					wp_articles.push({
						ID: false,
						pos: pos,
						type: 'empty'
					});
				}
			}

			$.post(conf.admin_ajax_url, {
				'action': conf.admin_ajax_action,
				'post_id': conf.post_id,
				'related_posts': JSON.stringify(wp_articles),
				'_wpnonce': window._wp_rp_ajax_nonce
			}, cb);
		};

		var fetch_related_posts = (function () {
			var get_internal_articles = function(search, success, error) {
				var data = {
					post_id: conf.post_id,
					search: search || '',
					action: 'wp_rp_load_articles',
					count: conf.num_articles
				};
				$.ajax({
					url: window._wp_rp_wp_ajax_url,
					dataType: "json",
					data: data,
					success: function (response) {
						var arts = [];
						$.each(response, function (i, art) {
							arts.push({
								type: 'own_sourcefeed',
								aid: 'in_' + art.id,
								thumbnail: $(art.img).attr('src'),
								title: art.title,
								excerpt: art.excerpt,
								date: art.date,
								comments: art.comments,
								url: art.url,
								target_url: art.url
							});
						});
						success({
							'status': 'ok',
							'source': 'internal',
							'data': {
								'results': arts
							}
						});
					},
					error: error
				});
			};

			var get_articles = function(search, tags, title, success, error) {
				var responses = {};
				var num_requests = 1;

				var combine_articles = function () {
					var articles = [];
					var urls = {};

					$.each(['external', 'internal'], function (i, type) {
						if (responses[type] && responses[type]['status'] === 'ok' && responses[type]['data']) {
							$.each(responses[type].data.results, function (j, article) {
								if (urls[article.url]) {
									return true;
								}
								urls[article.url] = true;
								articles.push(article);
							});
						}
					});

					if (responses['external'] && responses['external']['status'] === 'ok') {
						conf.num_external_slots = responses['external']['data']['settings']['num_external_slots'];
					}

					if (articles) {
						success(articles);
					} else {
						error();
					}
				};
				var response_cb = function () {
					num_requests -= 1;

					if (num_requests <= 0) {
						combine_articles();
					}
				};
				var response_success = function (response) {
					var response_type = response.source === 'internal' ? 'internal' : 'external';
					responses[response_type] = response;
					response_cb();
				};

				get_internal_articles(search, response_success, response_cb);
				if (conf.remote_recommendations) {
					get_sre_articles(search, tags, title, response_success, response_cb);
				}
			};

			return function (search, force_update, success, error) {
				var tags = (window._wp_rp_post_tags && window._wp_rp_post_tags.join(',')) || '';
				var title = window._wp_rp_post_title || '';

				search = search || false;

				if (!tags && !title && search === false) {
					success(false);
					return;
				}

				get_articles(search, tags, title, function (articles) {
					if (success && articles) {
						success(articles);
					}
				},
				function () {
					if (error) {
						error();
					}
				});
			}
		}());

		var update_articles = (function () {
			var init = function () {
				drag_and_drop.init();
				search();

				elms.replace_articles_list.bind('scroll', render.render_selector_shadows);
			};

			var update = function (cb, search, force_update) {
				elms.replace_articles_list.html('');
				render.render_selector_shadows();
				articles.all = [];

				elms.article_loader.find('.zem-no-articles').hide();
				elms.article_loader.find('.zem-loader').show();
				elms.article_loader.show();

				var num_ext_pre = conf.num_external_slots;
				fetch_related_posts(search, force_update, function (arts) {
					if (arts && arts.length) {
						elms.article_loader.hide();

						articles.all = $.grep(arts, function (a) {
							// Skip for this post, but make sure it's not postfixed with some params or anchors
							return window.location.href.indexOf(a.url) < 0;
						});

						$.each(articles.all, function (i, a) {
							if (!articles.ids[a.aid]) {
								articles.ids[a.aid] = a;
							} else {
								a = articles.ids[a.aid];
								articles.all[i] = a;
							}
						});
						render.article_selector();
						if (num_ext_pre !== conf.num_external_slots) {
							render.articles();
						}
					} else {
						elms.article_loader.find('.zem-no-articles').show();
						elms.article_loader.find('.zem-loader').hide();
					}
					render.render_selector_shadows();
					if (cb) {cb(true);}
				}, function () {
					elms.article_loader.find('.zem-no-articles').show();
					elms.article_loader.find('.zem-loader').hide();
					render.render_selector_shadows();

					if (cb) {cb(false);}
				});
			};

			var search = function () {
				elms.search_form.bind('submit', function (ev) {
					ev.preventDefault();
					var search = elms.search_input.val();
					update(null, search, true);
				});
			};

			var article_insert = function (article, pos, commit) {
				article.picked = true;
				article.pos = pos;
				articles.selected[pos] = article;
				articles.ids[article.aid] = article;

				render.article_li_selected(article);

				if (commit) {
					save_picked_articles();
					render.article_selector();
				}
			};

			var article_remove = function (article, commit) {
				delete articles.selected[article.pos];
				article.picked = false;
				article.pos = -1;

				article.elm && article.elm
					.html('<div class="droppable" /><span class="notice">Drag post here</span>')
					.attr('draggable', false)
					.removeClass('external')
					.data('aid', false);

				if (commit) {
					save_picked_articles();
					render.article_selector();
				}
			};

			var render = {
				article_li: function (li, article) {
					li.html('<div class="droppable" />');
					li.data('aid', article);

					li.attr('draggable', true);
					li.unbind('dragstart').bind('dragstart', function (ev) {
						drag_and_drop.drag(ev, article, li);
					});

					var img = $('<img draggable="false" />');
					img.error(function () {
						img.unbind('error');

						var aid_num = parseInt(article.aid.replace('in_')) || parseInt(Math.random() * conf.num_default_thumbnails);
						var default_url = conf.plugin_static_url + 'thumbs/' + (aid_num % conf.num_default_thumbnails) + '.jpg';
						article.thumbnail = default_url;
						img.attr('src', default_url);
					});

					article.thumbnail = article.thumbnail || article.thumbnail_url;
					img.attr('src', article.thumbnail);

					li.append(img);
					li.append('<span unselectable="on" class="title">' + article.title + '</span>');

					var out_link = $('<a class="open-article" draggable="false" target="_blank" href="' + article.target_url + '">link out</a>');
					out_link.bind('click', function (ev) {
						ev.stopPropagation();
					});
					li.append(out_link);
				},

				article_li_selector: function (li, article) {
					article.elm = li;

					render.article_li(li, article);

					var insert = $('<a draggable="false" class="insert overlay" href="#"><div class="txt">insert</div></a>');

					insert.bind('click', function (ev) {
						ev.preventDefault();

						var pos = 0;
						for (pos = 0; pos < conf.num_articles_to_insert - 1 && articles.selected[pos]; pos += 1) {}

						if (!articles.selected[pos]) {
							article_insert(article, pos, true);
						}
					});

					li.append(insert);
				},

				article_li_selected: function (article) {
					var li = elms.article_list[article.pos];
					article.elm = li;
					render.article_li(li, article);

					if (article.external) {
						return;
					}
					var remove = $('<a draggable="false" class="remove overlay" href="#"><span class="icon"></span><span class="txt">remove</span></a>');
					remove.bind('click', function (ev) {
						ev.preventDefault();

						article_remove(article, true);
					});
					li.append(remove);
				},

				article_selector: function () {
					elms.replace_articles_list.html('');

					var selected_articles_ids = {};
					$.each(articles.selected, function (pos, article) {
						selected_articles_ids[article.aid] = true;
					});

					var count = 0;
					$.each(articles.all, function (i, article_rend) {
						if (!selected_articles_ids[article_rend.aid]) {
							var li = $('<li />');
							render.article_li_selector(li, article_rend);
							elms.replace_articles_list.append(li);
							count += 1;
						}
						if (count >= conf.num_articles) {
							return false;
						}
					});
					render.render_selector_shadows();
				},

				render_selector_shadows: function (ev) {
					var pos_left = elms.replace_articles_list.scrollLeft();
					var width = elms.replace_articles_list[0].scrollWidth - elms.replace_articles_list.width();
					if (pos_left > 0) {
						elms.replace_articles_list.addClass('scroll-left');
					} else {
						elms.replace_articles_list.removeClass('scroll-left');
					}
					if (pos_left < width) {
						elms.replace_articles_list.addClass('scroll-right');
					} else {
						elms.replace_articles_list.removeClass('scroll-right');
					}
				},
				articles: function() {
					$.each(articles.selected, function (pos, article) {
						if (article && article.aid && article.picked) {
							if (pos < conf.num_articles_to_insert) {
								article_insert(article, pos, false);
							} else {
								article_remove(article, false);
							}
						}
					});
				},

				all: function () {
					render.articles();
					render.article_selector();
				}
			};

			var drag_and_drop = {
				hint_timeout: null,
				dragged_article: null,

				ie9_drag_start: function (ev) {
					if (ev.which !== 1 || ev.ctrlKey || ev.metaKey) {
						return;
					}
					if ($(this).get(0).dragDrop) {
						$(this).get(0).dragDrop();
					}
				},
				drag_hint: function (ev) {
					if (ev.which !== 1 || ev.ctrlKey || ev.metaKey) {
						return;
					}

					var $this = $(this);

					var article = drag_and_drop.dragged_article || $this.data('aid');
					if (!article) { return; }

					drag_and_drop.hint_timeout = setTimeout(function () {

						if (!article.picked || article.external) {
							elms.wrapper.find('ul.selected li:not(.external)').addClass('drop-hint');
						} else {
							elms.wrapper.find('ul.selected li').addClass('drop-hint');
						}

						if (article.picked && !article.external) {
							elms.remove_article_sign.show();
						}
					}, 100);
				},
				drag: function (ev, article, li) {
					ev.dataTransfer.setData('text', 'wprp_article_' + article.aid);
					if (ev.dataTransfer.setDragImage) {
						ev.dataTransfer.setDragImage(li.get(0), li.outerWidth() / 2, li.outerHeight() / 2);
					} else if (ev.dataTransfer.addElement) {
						ev.dataTransfer.addElement(li.get(0));
					}

					drag_and_drop.dragged_article = article;

					setTimeout(function () {
						elms.wrapper.find('li .droppable').css('z-index', 2);
					}, 1);
					drag_and_drop.drag_hint(ev);
				},
				drop_remove: function (ev) {
					ev.preventDefault();

					var article = drag_and_drop.dragged_article;

					if (!drag_and_drop.dragged_article || article.external) {
						// External articles can't be removed
						return;
					}
					article_remove(article, true);

					drag_and_drop.dragend(ev);
				},
				drop: function (ev) {
					$(this).removeClass('drop');
					ev.preventDefault();

					var article = drag_and_drop.dragged_article;
					if (!article) {return false;}

					var old_pos = article.pos;
					var new_pos = $(this).data('pos') * 1;
					if (old_pos === new_pos) { return false; }
					var replaced_article = articles.selected[new_pos];

					if (replaced_article && ((replaced_article.external && !article.picked) || (replaced_article.external && article.external))) {
						// External articles can't be removed
						return;
					}

					var picked = article.picked;
					if (picked) {
						article_remove(article, false);
					}
					if (replaced_article) {
						article_remove(replaced_article, false);
						if (picked) {
							article_insert(replaced_article, old_pos, false);
						}
					}

					article_insert(article, new_pos, true);

					drag_and_drop.dragend(ev);
				},
				dragover: function (ev) {
					ev.preventDefault();
					var article = drag_and_drop.dragged_article;
					var replaced_article = $(this).data('aid');

					if (replaced_article && ((replaced_article.external && !article.picked) || (replaced_article.external && article.external))) {
						// External articles can't be removed
						return;
					}
					$(this).addClass('drop');
				},
				dragleave: function (ev) {
					ev.preventDefault();
					$(this).removeClass('drop');
				},
				dragend: function (ev) {
					clearTimeout(drag_and_drop.hint_timeout);
					drag_and_drop.dragged_article = null;

					elms.remove_article_sign.hide();
					elms.wrapper.find('li .droppable').css('z-index', -1);
					elms.wrapper.find('ul.selected li').removeClass('drop-hint');
				},
				init: function () {
					elms.selected_articles_wrap
						.delegate('li', 'dragover', drag_and_drop.dragover)
						.delegate('li', 'dragleave', drag_and_drop.dragleave)
						.delegate('li', 'drop', drag_and_drop.drop);

					elms.replace_articles_wrap
						.bind('dragover', drag_and_drop.dragover)
						.bind('dragleave', drag_and_drop.dragleave)
						.bind('drop', drag_and_drop.drop_remove);

					elms.wrapper
						.delegate('li[draggable=true]', 'dragstart', drag_and_drop.drag_hint)
						.delegate('li[draggable=true]', 'dragend', drag_and_drop.dragend)
						.delegate('li[draggable=true]', 'mousedown', drag_and_drop.drag_hint)
						.delegate('li[draggable=true]', 'mouseup', drag_and_drop.dragend)
						.delegate('li[draggable=true]', 'mousemove', drag_and_drop.ie9_drag_start);

				}
			};

			return {
				update: update,
				render: render.all,
				init: init
			};
		}());

		init();

		return {
			update: update_articles.update
		};
	};

	var bind_edit = function () {
		$('#wp_rp_edit_related_posts').click(function () {
			var rp = related_posts();
			return false;
		});
	};
	(function load_edit(t, d) {
		if (!d) {
			d = 10; t = 0;
		}
		if ($('#wp_rp_edit_related_posts').length) {
			bind_edit();
		} else {
			if (t < 30000) {
				setTimeout(function () {
					load_edit(t + d, d * 1.5)
				}, d);
			} else {
				$(function () {
					bind_edit();
				});
			}
		}
	}());
}(jQuery));





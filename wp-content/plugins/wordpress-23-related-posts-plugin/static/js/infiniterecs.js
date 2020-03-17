var ZemRPResponse = [];

jQuery(function ($) {
	
	window._wp_rp_request_id = window._wp_rp_request_id || ((new Date().getTime() % 60466176) / 60466176).toString(36).substr(2,5) + Math.random().toString(36).substr(2,10); // 60466176 = 36 ^ 5

	var scrollTimeout = 0,
		win = $(window),
		fetching = 10,
		related = $('.related_post'),
		loading = false,
		from = related.find('li').length,
		lastFrom = -1,
		
		
		getBottomScroll = function () {
			return win.height() + document.body.scrollTop;
		},
		getNextSet = function () {
			var i = 0, result = [], next = {};
			for (; i < fetching; i += 1) {
				next = ZemRPResponse.shift();
				if (next) {
					result.push(next);
				}
			}
			return result;
		},
		fillList = function () {
			var ajax_url = window._wp_rp_wp_ajax_url + '?action=wp_rp_load_articles&post_id=' + window._wp_rp_post_id + '&from=' + from + '&count=50'; 
			if (loading) {
				return;
			}
			if (lastFrom === from){
				return;
			}
			loading = true;

			$.get(ajax_url, function (data) {
				$.each(data, function (i, newOne) {
					ZemRPResponse.push(newOne);
				});
				lastFrom = from;
				from += data.length;

				loading = false;
			}, 'json');
		},
		fetchRelated = function (cb) {
			cb(getNextSet());
			if (ZemRPResponse.length <= (2 * fetching)) {
				fillList();
			}
		},
		loadMoreRelated = function () {
			fetchRelated(function (data) {
				var postContainer = $('.related_post'),
					nextPosition = postContainer.find('li').last().data('position') + 1,
					newElm;
				$.each(data, function (i, post) {
					newElm = $('<li data-position="' + nextPosition + '" data-poid="' + post.id + '"><a href="' + post.url + '" class="wp_rp_thumbnail">' + post.img + '</a><a href="' + post.url + '" class="wp_rp_title">' + post.title + '</a></li>');
					newElm.data('position', nextPosition);
					newElm.data('poid', post.id);

					postContainer.append(newElm);

					nextPosition += 1;
				});
			});
		},
		smartScrollHandler = function () {

			var firstArticle = related.children(':first');
			
			if (getBottomScroll() > firstArticle.offset().top) {
			
				loadMoreRelated();
				return;
			}
			
		},
		
		isFocused = true,
		onBlur = function () {
			isFocused = false;
		},
		onFocus = function () {
			isFocused = true;
		}
	;
	
	
	if (/*@cc_on!@*/false) { // check for Internet Explorer
		document.onfocusin = onFocus;
		document.onfocusout = onBlur;
	} else {
		window.onfocus = onFocus;
		window.onblur = onBlur;
	}

	fillList();
	win.scroll(smartScrollHandler);
});


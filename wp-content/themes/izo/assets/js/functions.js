var izo = izo || {};

/**
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
izo.navigation = {

	init: function() {
		const siteNavigation = document.getElementById( 'site-navigation' );
		
		// Return early if the navigation don't exist.
		if ( ! siteNavigation ) {
			return;
		}
	
		const button = document.getElementsByClassName( 'menu-toggle' )[ 0 ];
	
		// Return early if the button don't exist.
		if ( 'undefined' === typeof button ) {
			return;
		}
	
		const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];
	
		// Hide menu toggle button if menu is empty and return early.
		if ( 'undefined' === typeof menu ) {
			button.style.display = 'none';
			return;
		}
	
		if ( ! menu.classList.contains( 'nav-menu' ) ) {
			menu.classList.add( 'nav-menu' );
		}	

		button.addEventListener( 'click', function() {
			siteNavigation.classList.toggle( 'toggled' );

			//Append + for submenus
			const linksWithChildren = siteNavigation.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );
		
			for ( const link of linksWithChildren ) {
				link.innerHTML += '<span class="submenu-toggle" tabindex=0><span>+</span></span>';
			}

			//Toggle submenus
			const submenuToggles 	= siteNavigation.querySelectorAll( '.submenu-toggle' );
			for ( const submenuToggle of submenuToggles ) {
				submenuToggle.addEventListener( 'click', function(e) {
					e.preventDefault();
					submenuToggle.getElementsByTagName( 'span' )[0].classList.toggle( 'submenu-exp' );
					var parent = submenuToggle.parentNode.parentNode;
					parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
				} );


				submenuToggle.addEventListener('keydown', function(e) {
					var isTabPressed = (e.key === 'Enter' || e.keyCode === 13);
	
					if (!isTabPressed) { 
						return; 
					}
					e.preventDefault();
					submenuToggle.getElementsByTagName( 'span' )[0].classList.toggle( 'submenu-exp' );
					var parent = submenuToggle.parentNode.parentNode;
					parent.getElementsByClassName( 'sub-menu' )[0].classList.toggle( 'toggled' );
				});
			}
			
			
			//Trap focus inside modal
			var focusableEls = siteNavigation.querySelectorAll('a[href]:not([disabled]), input[type="search"]:not([disabled])'),
				firstFocusableEl = focusableEls[0];  
				lastFocusableEl = focusableEls[focusableEls.length - 1];
				KEYCODE_TAB = 9;

				siteNavigation.addEventListener('keydown', function(e) {
				var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

				if (!isTabPressed) { 
					return; 
				}

				if ( e.shiftKey ) /* shift + tab */ {
					if (document.activeElement === firstFocusableEl) {
						button.focus();
						e.preventDefault();
					}
				} else /* tab */ {
					if (document.activeElement === lastFocusableEl) {
						button.click();
						e.preventDefault();
					}
				}
			});

			button.addEventListener('keydown', function(e) {
				var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

				if (!isTabPressed) { 
					return; 
				}

				if ( e.shiftKey ) /* shift + tab */ {
					if (document.activeElement === button) {
						button.click();
					}
				}
			});	
		} );

		// Get all the link elements within the menu.
		const links = menu.getElementsByTagName( 'a' );
	
		// Get all the link elements with children within the menu.
		const linksWithChildren = menu.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );
	
		// Toggle focus each time a menu link is focused or blurred.
		for ( const link of links ) {
			link.addEventListener( 'focus', toggleFocus, true );
			link.addEventListener( 'blur', toggleFocus, true );
		}
	
		// Toggle focus each time a menu link with children receive a touch event.
		for ( const link of linksWithChildren ) {
			link.addEventListener( 'touchstart', toggleFocus, false );
		}
	
		/**
		 * Sets or removes .focus class on an element.
		 */
		function toggleFocus() {
			if ( event.type === 'focus' || event.type === 'blur' ) {
				let self = this;
				// Move up through the ancestors of the current link until we hit .nav-menu.
				while ( ! self.classList.contains( 'nav-menu' ) ) {
					// On li elements toggle the class .focus.
					if ( 'li' === self.tagName.toLowerCase() ) {
						self.classList.toggle( 'focus' );
					}
					self = self.parentNode;
				}
			}
	
			if ( event.type === 'touchstart' ) {
				const menuItem = this.parentNode;
				event.preventDefault();
				for ( const link of menuItem.parentNode.children ) {
					if ( menuItem !== link ) {
						link.classList.remove( 'focus' );
					}
				}
				menuItem.classList.toggle( 'focus' );
			}
		}
	},
};

/**
 * Merge bottom header bar
 */
izo.mergeHeader = {

	init: function() {
		this.mergeBottomBar();

		window.addEventListener( 'resize', function() {
			this.mergeBottomBar();
		}.bind( this ) );		
	},

	mergeBottomBar: function() {
		const siteHeader 	= document.getElementById( 'masthead' );
		const adminBar 		= document.getElementById( 'wpadminbar' );
		const bottomBar 	= siteHeader.getElementsByClassName( 'bottom-header-bar' )[0];
		const topBar 		= siteHeader.getElementsByClassName( 'top-header-bar' )[0];

		if ( typeof( bottomBar ) == 'undefined' && bottomBar == null ) {
			return;
		}

		if ( bottomBar.classList.contains( 'is-merged' ) ) {
			
			if ( typeof( topBar ) != 'undefined' && topBar != null ) {
				var topBarHeight = topBar.offsetHeight;
			} else {
				var topBarHeight = 0;
			}

			bottomBar.style.top = topBarHeight + 'px';
		}		

	},
};

/**
 * Header search
 */
izo.headerSearch = {

	init: function() {
		this.searchForm();	
	},

	searchForm: function() {
		const siteHeader 	= document.getElementById( 'masthead' );
		const mainNav 		= siteHeader.getElementsByClassName( 'main-navigation' )[0];
		const searchToggle 	= siteHeader.getElementsByClassName( 'header-search-toggle' )[0];
		const searchForm 	= siteHeader.getElementsByClassName( 'header-search-form' )[0];

		if ( typeof( searchForm ) == 'undefined' && searchForm == null ) {
			return;
		}
		
		searchToggle.addEventListener( 'click', function() {
			searchForm.classList.toggle( 'show' );
			mainNav.classList.toggle( 'hide' );
			searchToggle.getElementsByClassName( 'icon-search' )[0].classList.toggle( 'icon-cancel' );
		} );
	},
};

/**
 * Header search
 */
izo.stickyMenu = {

	init: function() {

		if ( ! document.body.classList.contains( 'has-sticky-menu' ) ) {
			return;
		}

		if ( ! document.body.classList.contains( 'disable-sticky-mobiles' ) ) {
			window.requestAnimationFrame( this.runSticky.bind(this) );
		} else {
			if ( window.matchMedia( "(min-width: 768px)" ).matches ) {
				window.requestAnimationFrame( this.runSticky.bind(this) );
			}
		}
	},

	sticky: function() {
		const siteHeader 	= document.getElementById( 'masthead' );
		const menuBar 		= siteHeader.getElementsByClassName( 'bottom-header-bar' )[0];

		var vertDist 		= window.scrollY;
		var elDist 			= menuBar.offsetTop;		

		if ( vertDist > elDist + 200 ) {
			menuBar.classList.add( 'is-shrinked' );
		} else {
			menuBar.classList.remove( 'is-shrinked' );
		}

		if ( vertDist > elDist ) {
			if ( ! menuBar.classList.contains( 'is-merged' ) ) {
				siteHeader.style.paddingBottom = menuBar.offsetHeight + 'px'; //no need for padding if the bar is merged
			}
			menuBar.classList.add( 'is-sticky' );
		} else {
			siteHeader.style.paddingBottom = 0;
			menuBar.classList.remove( 'is-sticky' );
		}
	},

	runSticky: function() {
		this.sticky();

		window.addEventListener( 'scroll', function() {
			this.sticky();
		}.bind( this ) );		
	},
};

/**
 * Back to top
 */
izo.backToTop = {

	init: function() {
		this.showIcon();	
	},

	setup: function() {
		let icon 	= document.getElementById( 'backtotop' );

		var vertDist = window.scrollY;

		if ( vertDist > 200 ) {
			icon.classList.add( 'show' );
		} else {
			icon.classList.remove( 'show' );
		}
	
		icon.addEventListener( 'click', function() {
			window.scrollTo({
				top: 0,
				left: 0,
				behavior: 'smooth',
			});
		} );
	},

	showIcon: function() {
		this.setup();

		window.addEventListener( 'scroll', function() {
			this.setup();
		}.bind( this ) );		
	},
};


/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
function izoDomReady( fn ) {
	if ( typeof fn !== 'function' ) {
		return;
	}

	if ( document.readyState === 'interactive' || document.readyState === 'complete' ) {
		return fn();
	}

	document.addEventListener( 'DOMContentLoaded', fn, false );
}

izoDomReady( function() {
	izo.navigation.init();
	izo.mergeHeader.init();
	izo.headerSearch.init();	
	izo.stickyMenu.init();
	izo.backToTop.init();
} );
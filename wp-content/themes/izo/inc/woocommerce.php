<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Izo
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function izo_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 800,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 4,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'izo_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function izo_woocommerce_scripts() {
	wp_enqueue_style( 'izo-woocommerce-style', get_template_directory_uri() . '/woocommerce.min.css', array(), IZO_VERSION );

	$font_path   = esc_url( WC()->plugin_url() . '/assets/fonts/' );
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'izo-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'izo_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function izo_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'izo_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function izo_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'izo_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'izo_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function izo_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'izo_woocommerce_wrapper_before' );

if ( ! function_exists( 'izo_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function izo_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'izo_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'izo_woocommerce_header_cart' ) ) {
			izo_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'izo_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function izo_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		?>

		<span class="cart-count"><?php izo_get_svg_icon( 'icon-cart', true ); ?><span class="count-number"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span></span>

		<?php
		$fragments['.cart-count'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'izo_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'izo_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function izo_woocommerce_cart_link() {

		$link = '<a class="cart-contents" href="' . esc_url( wc_get_cart_url() ) . '" title="' . esc_attr__( 'View your shopping cart', 'izo' ) . '">';
		$link .= '<span class="cart-count">' . izo_get_svg_icon( 'icon-cart', false ) . '<span class="count-number">' . esc_html( WC()->cart->get_cart_contents_count() ) . '</span></span>';
		$link .= '</a>';

		return $link;
	}
}

if ( ! function_exists( 'izo_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function izo_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<?php ob_start(); ?>
		<?php echo '<a class="wc-account-link" href="' . esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ) . '" title="' . esc_html__( 'Your account', 'izo' ) . '">' . izo_get_svg_icon( 'icon-user', false ) . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

		<div id="site-header-cart" class="site-header-cart">
			<?php echo izo_woocommerce_cart_link();  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</span>
		</div>
		<?php
		return ob_get_clean();
	}
}

/**
 * Remove sidebar, remove single product elements
 */
function izo_woocommerce_actions() {
	
	if ( is_checkout() || is_cart() || is_account_page() ) {
		add_filter( 'izo_enable_sidebar', '__return_false' );
		add_filter( 'izo_has_sidebar', '__return_false' );
	}

	//Product archives sidebar
	$shop_archive_layout = get_theme_mod( 'shop_archive_layout', 'no-sidebar' );

	if ( 'no-sidebar' == $shop_archive_layout ) {
		if ( is_shop() || is_product_category() || is_product_tag()	) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'izo_has_sidebar', '__return_false' );
		}		
	}

	//Single products sidebar
	$single_product_layout = get_theme_mod( 'single_product_layout', 'no-sidebar' );
	
	if ( 'no-sidebar' == $single_product_layout ) {
		if ( is_product() ) {
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_filter( 'izo_has_sidebar', '__return_false' );
		}
	}

	//Check if we need to disable breadcrumbs, related and upsell products, sku, cats
	if ( is_product() ) {
		$disable_single_product_breadcrumbs = get_theme_mod( 'disable_single_product_breadcrumbs' );
		$disable_single_product_related 	= get_theme_mod( 'disable_single_product_related' );
		$disable_single_product_upsells 	= get_theme_mod( 'disable_single_product_upsells' );
		$disable_single_product_meta 		= get_theme_mod( 'disable_single_product_meta' );
		$disable_single_product_rating 		= get_theme_mod( 'disable_single_product_rating' );

		if ( $disable_single_product_breadcrumbs ) {
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',20 );
		}

		if ( $disable_single_product_related ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}

		if ( $disable_single_product_upsells ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
		}
		
		if ( $disable_single_product_meta ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		
		if ( $disable_single_product_rating ) {
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		}		
	}
}
add_action( 'wp', 'izo_woocommerce_actions' );

/**
 * Add product categories to product loop
 */
function izo_loop_product_categories() {
	echo '<div class="loop-product-cats">' . wc_get_product_category_list( get_the_id() ) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
add_action( 'woocommerce_before_shop_loop_item_title', 'izo_loop_product_categories', 15 );

/**
 * Wrap single product gallery and summary before
 */
function izo_single_product_wrap_before() {
	echo '<div class="single-product-top">';
}
add_action( 'woocommerce_before_single_product_summary', 'izo_single_product_wrap_before', -99 );

/**
 * Wrap single product gallery and summary after
 */
function izo_single_product_wrap_after() {
	echo '</div>';
}
add_action( 'woocommerce_after_single_product_summary', 'izo_single_product_wrap_after', 9 );

/**
 * Disable titles from Woocommerce tabs
 */
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
add_filter( 'woocommerce_product_description_heading', '__return_false' );

/**
 * Wrap products results and ordering before
 */
function izo_wrap_products_results_ordering_before() {

	echo '<div class="woocommerce-results-wrapper clear">';
}
add_action( 'woocommerce_before_shop_loop', 'izo_wrap_products_results_ordering_before', 19 );

/**
 * Wrap products results and ordering after
 */
function izo_wrap_products_results_ordering_after() {

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'izo_wrap_products_results_ordering_after', 31 );

/**
 * Loop product thumbnails wrapper before
 */
function izo_loop_thumb_wrapper_before() {
	echo '<div class="loop-thumb-wrapper">';
	woocommerce_template_loop_product_link_open(); //open product link
}
add_action( 'woocommerce_before_shop_loop_item', 'izo_loop_thumb_wrapper_before', 11 );

/**
 * Loop product thumbnails wrapper after
 */
function izo_loop_thumb_wrapper_after() {

	woocommerce_template_loop_product_link_close(); //close product link
	echo '<div class="button-wrapper">';
		woocommerce_template_loop_add_to_cart();
	echo '</div>';

	echo '</div>'; //close .loop-thumb-wrapper
}
add_action( 'woocommerce_before_shop_loop_item_title', 'izo_loop_thumb_wrapper_after', 11 );

/**
 * Remove loop product actions
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

/**
 * Wrap loop product title in link before
 */
function izo_loop_title_wrapper_before() {
	woocommerce_template_loop_product_link_open(); //open product link
}
add_action( 'woocommerce_shop_loop_item_title', 'izo_loop_title_wrapper_before', 9 );

/**
 * Wrap loop product title in link after
 */
function izo_loop_title_wrapper_after() {
	woocommerce_template_loop_product_link_close(); //open product link
}
add_action( 'woocommerce_shop_loop_item_title', 'izo_loop_title_wrapper_after', 11 );


/**
 * Wrap order review before
 */
function izo_wrap_order_review_before() {
	echo '<div class="order-review-wrapper">';
}
add_action( 'woocommerce_checkout_before_order_review_heading', 'izo_wrap_order_review_before', 5 );

/**
 * Wrap order review after
 */
function izo_wrap_order_review_after() {
	echo '</div">';
}
add_action( 'woocommerce_checkout_after_order_review', 'izo_wrap_order_review_after', 15 );

/**
 * Woocommerce related custom CSS
 */
function izo_woocommerce_custom_css( $css ) {

	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'single_product_title_size', $defaults = array( 'desktop' => 40, 'tablet' => 36, 'mobile' => 28 ), '.single-product-top .entry-title' );
	$css .= Izo_Custom_CSS::get_color_css( 'single_product_title_color', '', '.single-product-top .entry-title' );

	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'single_product_price_size', $defaults = array( 'desktop' => 22, 'tablet' => 22, 'mobile' => 22 ), '.single-product-top .price' );
	$css .= Izo_Custom_CSS::get_color_css( 'single_product_price_color', '', '.single-product-top .price' );	


	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'loop_product_title_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'ul.products li.product .woocommerce-loop-product__title' );
	$css .= Izo_Custom_CSS::get_color_css( 'loop_product_title_color', '', 'ul.products li.product .woocommerce-loop-product__title' );	

	$css .= Izo_Custom_CSS::get_resp_font_sizes_css( 'loop_product_price_size', $defaults = array( 'desktop' => 16, 'tablet' => 16, 'mobile' => 16 ), 'ul.products li.product .price' );
	$css .= Izo_Custom_CSS::get_color_css( 'loop_product_price_color', '', 'ul.products li.product .price' );	

	return $css;
}
add_filter( 'izo_custom_css_output', 'izo_woocommerce_custom_css' );
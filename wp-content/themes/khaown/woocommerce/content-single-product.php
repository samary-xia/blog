<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
defined( 'ABSPATH' ) || exit;
global $product; ?>
	
<div class="container">
    <div class="row mb-xs-24 mt48">
        <div class="col-md-8 col-md-offset-2 mt24">
            <?php 
                /**
                 * Hook: woocommerce_before_single_product.
                 *
                 * @hooked wc_print_notices - 10
                 */
                do_action( 'woocommerce_before_single_product' );
                if ( post_password_required() ) {
                    echo get_the_password_form(); // WPCS: XSS ok.
                    return;
                }
            ?>
        </div>
    </div>
    <!--end of row-->
</div>
	<!--end of container-->
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div id="khaown-product">
		<div class="container">
			<div class="row mb-xs-24">
				<div class="col-md-8 col-md-offset-2">
					<div class="row khaown-woo-single-product-header">
						<div class="col-sm-6">
							<?php
							/**
							 * Hook: woocommerce_before_single_product_summary.
							 *
							 * @hooked woocommerce_show_product_sale_flash - 10
							 * @hooked woocommerce_show_product_images - 20
							 */
							do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>
						<div class="col-sm-6">
							<div class="khaown-wc-product-summery summary entry-summary mt-sm-16">
								<?php
								/**
								 * Hook: woocommerce_single_product_summary.
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 * @hooked WC_Structured_Data::generate_product_data() - 60
								 */
								do_action( 'woocommerce_single_product_summary' );
								?>
								<div class="khaown-woo-product-cat-tag-wrapper">
									<?php
										// Display a html formatted list of the product categories for this product
										echo '<ul class="khaown-woo-list"> Categories: ' . wc_get_product_category_list( get_the_id(), '</li><li>','<li>','</li>' ) . '</ul>';

										// Display a html formatted list of the product categories for this product
										echo '<ul class="khaown-woo-list"> Tags: ' . wc_get_product_tag_list( get_the_id(), '</li><li>','<li>','</li>' ) . '</ul>';
									?>
								</div>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-xs-12 khaown-woo-desc-review">
							<?php
							/**
							 * Hook: woocommerce_after_single_product_summary.
							 *
							 * @hooked woocommerce_output_product_data_tabs - 10
							 * @hooked woocommerce_upsell_display - 15
							 * @hooked woocommerce_output_related_products - 20
							 */
							do_action( 'woocommerce_after_single_product_summary' );
							?>
						</div>
					</div>
				</div>
			</div>
			<!--end of row-->
		</div>
		<!--end of container-->
	</div>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>




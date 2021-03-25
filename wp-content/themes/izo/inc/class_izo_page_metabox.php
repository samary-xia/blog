<?php
/**
 * Single page and post metabox
 *
 * @package Izo
 */


function izo_page_metabox_init() {
    new Izo_Page_Metabox();
}

if ( is_admin() ) {
    add_action( 'load-post.php', 'izo_page_metabox_init' );
    add_action( 'load-post-new.php', 'izo_page_metabox_init' );
}

class Izo_Page_Metabox {

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );

		
	}

	public function add_meta_box( $post_type ) {
        $post_types = array( 'post', 'page' );
        if ( in_array( $post_type, $post_types )) {
			add_meta_box(
				'izo_single_page_metabox'
				,__( 'Izo page options', 'izo' )
				,array( $this, 'render_meta_box_content' )
				,array( 'post', 'page' )
				,'side'
				,'low'
			);
        }
	}

	public function save( $post_id ) {
	
		// Check if our nonce is set.
		if ( ! isset( $_POST['izo_single_page_box_nonce'] ) )
			return $post_id;

		$nonce = sanitize_key( $_POST['izo_single_page_box_nonce'] );

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'izo_single_page_box' ) )
			return $post_id;


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		}

		//Transparent menu

		$activate_merge_bottom = ( isset( $_POST['izo_merge_bottom_bar'] ) && '1' === $_POST['izo_merge_bottom_bar'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_merge_bottom_bar', $activate_merge_bottom );

		//Hide title
		$activate_title_hide = ( isset( $_POST['izo_hide_title'] ) && '1' === $_POST['izo_hide_title'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_hide_title', $activate_title_hide );	

		//Hide featured image
		$activate_featured_hide = ( isset( $_POST['izo_hide_featured_image'] ) && '1' === $_POST['izo_hide_featured_image'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_hide_featured_image', $activate_featured_hide );			

		//disable Sidebar
		$activate_sidebar_hide = ( isset( $_POST['izo_hide_sidebar'] ) && '1' === $_POST['izo_hide_sidebar'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_hide_sidebar', $activate_sidebar_hide );

		//disable Header
		$activate_header_hide = ( isset( $_POST['izo_hide_header'] ) && '1' === $_POST['izo_hide_header'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_hide_header', $activate_header_hide );

		//disable Footer
		$activate_footer_hide = ( isset( $_POST['izo_hide_footer'] ) && '1' === $_POST['izo_hide_footer'] ) ? 1 : 0;
		update_post_meta( $post_id, '_izo_hide_footer', $activate_footer_hide );		

		//Layout
		$layout_choices = array( 'customizer', 'layout-boxed', 'layout-unboxed', 'layout-wide', 'layout-stretched' );
		$post_layout = $this->sanitize_selects( sanitize_key( $_POST['izo_page_layout'] ), $layout_choices ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		update_post_meta( $post_id, '_izo_page_layout', $post_layout );

		//Sidebar layout
		$sidebar_layout_choices = array( 'customizer', 'sidebar-left', 'sidebar-right', 'no-sidebar' );
		$sidebar_layout 		= $this->sanitize_selects( sanitize_key( $_POST['izo_sidebar_layout'] ), $sidebar_layout_choices ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
		update_post_meta( $post_id, '_izo_sidebar_layout', $sidebar_layout );
	}

	public function render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'izo_single_page_box', 'izo_single_page_box_nonce' );
		$merge_bottom_bar 		= get_post_meta( $post->ID, '_izo_merge_bottom_bar', true );
		$sidebar_hide 			= get_post_meta( $post->ID, '_izo_hide_sidebar', true );
		$header_hide 			= get_post_meta( $post->ID, '_izo_hide_header', true );
		$footer_hide 			= get_post_meta( $post->ID, '_izo_hide_footer', true );
		$title_hide 			= get_post_meta( $post->ID, '_izo_hide_title', true );
		$featured_hide 			= get_post_meta( $post->ID, '_izo_hide_featured_image', true );
		$post_layout 			= get_post_meta( $post->ID, '_izo_page_layout', true );
		$sidebar_layout			= get_post_meta( $post->ID, '_izo_sidebar_layout', true );

	?>
	<p>
	<label for="izo_page_layout"><?php esc_html_e( 'Page layout', 'izo' ); ?></label>	
	<select style="max-width:200px;" name="izo_page_layout">
		<option value="customizer" <?php selected( $post_layout, 'customizer' ); ?>><?php esc_html_e( 'Set from Customizer', 'izo' ); ?></option>
		<option value="layout-boxed" <?php selected( $post_layout, 'layout-boxed' ); ?>><?php esc_html_e( 'Boxed (default)', 'izo' ); ?></option>
		<option value="layout-unboxed" <?php selected( $post_layout, 'layout-unboxed' ); ?>><?php esc_html_e( 'Unboxed', 'izo' ); ?></option>
		<option value="layout-wide" <?php selected( $post_layout, 'layout-wide' ); ?>><?php esc_html_e( 'Wide (disables sidebar)', 'izo' ); ?></option>
		<option value="layout-stretched" <?php selected( $post_layout, 'layout-stretched' ); ?>><?php esc_html_e( 'Stretched (for page builders)', 'izo' ); ?></option>
	</select>
	</p>
	<p>
	<label for="izo_sidebar_layout"><?php esc_html_e( 'Sidebar layout', 'izo' ); ?></label>	
	<select style="max-width:200px;" name="izo_sidebar_layout">
		<option value="customizer" <?php selected( $sidebar_layout, 'customizer' ); ?>><?php esc_html_e( 'Set from Customizer', 'izo' ); ?></option>
		<option value="sidebar-left" <?php selected( $sidebar_layout, 'sidebar-left' ); ?>><?php esc_html_e( 'Left', 'izo' ); ?></option>
		<option value="sidebar-right" <?php selected( $sidebar_layout, 'sidebar-right' ); ?>><?php esc_html_e( 'Right', 'izo' ); ?></option>
		<option value="no-sidebar" <?php selected( $sidebar_layout, 'no-sidebar' ); ?>><?php esc_html_e( 'Disable sidebar for this page', 'izo' ); ?></option>
	</select>
	</p>
	<p>
		<label><input type="checkbox" name="izo_merge_bottom_bar" value="1" <?php checked( $merge_bottom_bar, 1 ); ?> /><?php esc_html_e( 'Transparent menu bar', 'izo' ); ?></label>
	</p>
	<p>
		<label><input type="checkbox" name="izo_hide_title" value="1" <?php checked( $title_hide, 1 ); ?> /><?php esc_html_e( 'Disable the title', 'izo' ); ?></label>
	</p>
	<p>
		<label><input type="checkbox" name="izo_hide_featured_image" value="1" <?php checked( $featured_hide, 1 ); ?> /><?php esc_html_e( 'Disable the featured image', 'izo' ); ?></label>
	</p>	
	<p>
		<label><input type="checkbox" name="izo_hide_header" value="1" <?php checked( $header_hide, 1 ); ?> /><?php esc_html_e( 'Disable the header', 'izo' ); ?></label>
	</p>	
	<p>
		<label><input type="checkbox" name="izo_hide_footer" value="1" <?php checked( $footer_hide, 1 ); ?> /><?php esc_html_e( 'Disable the footer', 'izo' ); ?></label>
	</p>	
		
	<?php
	}

	/**
	 * Function to sanitize selects
	 */
	public function sanitize_selects( $input, $choices ) {

		$input = sanitize_key( $input );

		return ( in_array( $input, $choices ) ? $input : '' );
	}
}
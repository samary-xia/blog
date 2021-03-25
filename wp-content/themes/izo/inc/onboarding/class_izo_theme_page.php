<?php
/**
 * Theme page
 *
 */

class Izo_Theme_Page {
	/**
	 * Instance of class.
	 *
	 * @var bool $instance instance variable.
	 */
	private static $instance;

	/**
	 * Check if instance already exists.
	 *
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Main ) ) {
			self::$instance = new Izo_Theme_Page();
		}

		return self::$instance;
	}

	/**
	 * Construct
	 */
	public function __construct() {
		add_action( 'admin_menu', __CLASS__ . '::theme_page', 99 );

	}	

	/**
	 * Theme page
	 */
	public static function theme_page() {
		$theme_page = add_theme_page( esc_html__( 'Izo theme', 'izo' ), esc_html__( 'Izo theme', 'izo' ), 'edit_theme_options', 'izo-theme.php', __CLASS__ . '::markup' );
		add_action( 'load-' . $theme_page, __CLASS__ . '::theme_page_styles' );
	}	

	/**
	 * Theme page markup
	 */
	public static function markup() {
		if ( !current_user_can( 'edit_theme_options' ) )  {
			wp_die( esc_html__( 'You do not have the right to view this page', 'izo' ) );
		}

		$theme = wp_get_theme();

		?>
		<div class="izo-theme-page">
			<div class="theme-page-header">
				<div class="theme-page-container">
					<h2>Izo</h2><span class="theme-version"><?php echo esc_html( $theme->version ); ?></span>
				</div>
			</div>
			<div class="theme-page-container">
				<div class="theme-page-content">
					<div class="theme-grid">
						<div class="grid-item">
							<h3><span class="dashicons dashicons-admin-page"></span><?php echo esc_html__( 'Starter sites', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Looking for a quick start? You can import one of our premade demos.', 'izo' ); ?></p>
							<?php Izo_Install_Plugins::instance()->do_plugin_install(); ?>
						</div>
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-book-alt"></span><?php echo esc_html__( 'Documentation', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Our documentation can help you learn how to use the Izo WordPress theme.', 'izo' ); ?></p>
							<a class="button" href="https://elfwp.com/documentation/izo/" target="_blank"><?php echo esc_html__( 'See the documentation', 'izo' ); ?></a>
						</div>
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-sos"></span><?php echo esc_html__( 'Need help?', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Are you stuck? No problem! Send us a message and we\'ll be happy to help you.', 'izo' ); ?></p>
							<a class="button" href="https://elfwp.com/support/" target="_blank"><?php echo esc_html__( 'Contact support', 'izo' ); ?></a>
						</div>
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-welcome-write-blog"></span><?php echo esc_html__( 'Changelog', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Read our changelog and see what recent changes we\'ve implemented in Izo', 'izo' ); ?></p>
							<a class="button" href="https://elfwp.com/changelog/izo/" target="_blank"><?php echo esc_html__( 'See the changelog', 'izo' ); ?></a>
						</div>	
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-format-image"></span><?php echo esc_html__( 'Upload your logo', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Use this option to add a logo image to your menu bar.', 'izo' ); ?></p>
							<a class="button" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[control]=custom_logo' ) ); ?>"><?php esc_html_e( 'Upload your logo', 'izo' ); ?></a>
						</div>
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-edit"></span><?php echo esc_html__( 'Change footer credits', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Change the credits in the footer to your own text. HTML is also supported.', 'izo' ); ?></p>
							<a class="button" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_footer_bar' ) ); ?>"><?php esc_html_e( 'Change footer credits', 'izo' ); ?></a>
						</div>	
						
						<div class="grid-item">
							<h3><span class="dashicons dashicons-admin-customizer"></span><?php echo esc_html__( 'Change colors', 'izo' ); ?></h3>
							<p><?php echo esc_html__( 'Explore the color options and make your website your own.', 'izo' ); ?></p>
							<a class="button" href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=colors' ) ); ?>"><?php esc_html_e( 'Change colors', 'izo' ); ?></a>
						</div>	
						
						<div class="grid-item cols2">
							<h3><span class="dashicons dashicons-admin-appearance"></span><?php echo esc_html__( 'Other theme settings', 'izo' ); ?></h3>
							<ul class="customizer-quick-links">
								<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_header_sticky' ) ); ?>"><?php esc_html_e( 'Enable the sticky header', 'izo' ); ?></a></li>
								<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_header_top_bar' ) ); ?>"><?php esc_html_e( 'Enable the top bar', 'izo' ); ?></a></li>
								<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_main_header' ) ); ?>"><?php esc_html_e( 'Configure the menu bar', 'izo' ); ?></a></li>
							</ul>
							<ul class="customizer-quick-links">
							<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[panel]=izo_panel_blog' ) ); ?>"><?php esc_html_e( 'Visit the blog options', 'izo' ); ?></a></li>
								<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_pages_section' ) ); ?>"><?php esc_html_e( 'General page options', 'izo' ); ?></a></li>
								<li><a href="<?php echo esc_url( admin_url( 'customize.php?autofocus[section]=izo_footer_widgets' ) ); ?>"><?php esc_html_e( 'Footer widgets layout', 'izo' ); ?></a></li>
							</ul>							
						</div>	
					</div>					
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Theme page styles and scripts
	 */
	public static function theme_page_styles() {
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::styles' );
	}

	/**
	 * Styles
	 */
	public static function styles( $hook ) {

		if ( 'appearance_page_izo-theme' != $hook ) {
			return;
		}

		wp_enqueue_style( 'izo-theme-page-styles', get_template_directory_uri() . '/inc/onboarding/assets/css/theme-page.min.css', array(), IZO_VERSION );
	}	

}

$izo_theme_page = new Izo_Theme_Page();
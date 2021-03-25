<?php
namespace Elementor; // phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedNamespaceFound

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Blog block
 *
 * @since 1.0.0``
 */
class Izo_Blog_Elementor extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve blog widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'izo-elementor-blog';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve blog widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Izo Blog', 'izo' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve blog widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-image-box';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the icon list widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'izo-elements' ];
	}	

	/**
	 * Register blog widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_blog_settings',
			[
				'label' => __( 'Blog', 'izo' ),
			]
		);

		$cats_array = $this->prepare_cats_for_select();

		$this->add_control(
			'categories',
			[
				'label' => __( 'Select your categories', 'izo' ),
				'type' => Controls_Manager::SELECT2,
				'dynamic' => [
					'active' => true,
				],
				'options' => $cats_array,
				'multiple' => true
			]
		);

		$this->add_control(
			'number',
				[
				'label'   => __( 'Number of posts', 'izo' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 24,
				'step'    => 1,
				]
		);	
	
		
		$this->add_control(
			'show_thumb',
			[
				'label' => __( 'Show featured image', 'izo' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);	

		$this->add_control(
			'show_meta',
			[
				'label' => __( 'Show meta', 'izo' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);			

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Show excerpt', 'izo' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);	

		$this->add_control(
			'excerpt_words',
			[
				'label'   => __( 'Number of words in the excerpt', 'izo' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 18,
				'min'     => 0,
				'max'     => 150,
				'step'    => 1,
				'conditions' => [
					'terms' => [
						[
							'name' 		=> 'show_excerpt',
							'operator' 	=> '==',
							'value' 	=> 'yes',
						],
					],
				],				
			]
		);			
		
		$this->add_control(
			'show_cats',
			[
				'label' => __( 'Show categories', 'izo' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);			

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label' => __( 'Content', 'izo' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		//Title
		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Post Title', 'izo' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'izo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .izo-elementor-blog .entry-title a' => 'color: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .izo-elementor-blog .entry-title a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);
		//End title

		//Date
		$this->add_control(
			'heading_date',
			[
				'label' => __( 'Meta', 'izo' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Color', 'izo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .izo-elementor-blog .entry-meta a, {{WRAPPER}} .izo-elementor-blog .entry-meta' => 'color: {{VALUE}};',
					'{{WRAPPER}} .izo-elementor-blog .entry-meta .izo-icon' => 'fill: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);
		//End date

		//Date
		$this->add_control(
			'heading_cats',
			[
				'label' => __( 'Categories', 'izo' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cats_color',
			[
				'label' => __( 'Color', 'izo' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .izo-elementor-blog .entry-footer a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .izo-elementor-blog .entry-footer .izo-icon' => 'fill: {{VALUE}};',
				],
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);
		//End date		

		$this->end_controls_section();
	}

	/**
	 * Render blog widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();

		$cats = is_array( $settings['categories'] ) ? implode( ',', $settings['categories'] ) : $settings['categories'];
		
		$read_more = get_theme_mod( 'continue_reading_text', esc_html__( 'Continue reading', 'izo' ) );

		$query = new \WP_Query( array(
			'posts_per_page'      => $settings['number'],
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'cat' 			      => $cats
		) ); ?>

		<div class="izo-elementor-blog">
		<?php if ( $query->have_posts() ) : ?>
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="post-item">
					<?php if ( has_post_thumbnail() && $settings['show_thumb'] ) : ?>
						<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'izo-400x400' ); ?></a>
					<?php endif; ?>					
					<div class="post-content">	

						<?php if ( $settings['show_meta'] ) : ?>
						<div class="entry-meta">
							<?php izo_posted_on(); ?>
							<?php izo_posted_by(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>

						<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

						<?php if ( $settings['show_excerpt'] ) : ?>
						<div class="entry-content">
							<?php echo wp_trim_words( get_the_content(), intval( $settings['excerpt_words'] ), '&nbsp;&lsqb;&hellip;&rsqb;<a class="read-more" href="'. esc_url( get_permalink() ) . '">' . esc_html( $read_more ) . '</a>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<?php endif; ?>

						<?php if ( $settings['show_cats'] ) : ?>
						<div class="entry-footer">
							<?php izo_entry_categories(); ?>
						</div><!-- .entry-footer -->
						<?php endif; ?>
						
					</div>	
				</div>				
			<?php
			endwhile;
			wp_reset_postdata();
		endif; ?>
		</div>	
		<?php
	}

	/**
	 * Prepare posts to be used in the SELECT2 field
	 */
	private function prepare_cats_for_select() {

		$categories = get_categories();

		$options = ['' => ''];

		foreach ( $categories as $cat ) {
			$options[$cat->term_id] = $cat->name;
		}

		return $options;
	}	

}

Plugin::instance()->widgets_manager->register_widget_type( new Izo_Blog_Elementor() );
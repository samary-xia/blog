<?php
/**
 * Radio control for header layout
 *
 * @package Izo
 */

class Izo_Radio_Header extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 */
	public $type = 'izo-radio-header';

	/**
	 * Displays the control content.
	 */
	public function render_content() {

		/* If no choices are provided, bail. */
		if ( empty( $this->choices ) )
			return; ?>

		<?php if ( !empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<?php endif; ?>

		<?php if ( !empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<div id="<?php echo esc_attr( "input_{$this->id}" ); ?>">

			<?php foreach ( $this->choices as $value => $args ) : ?>

				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( "_customize-radio-{$this->id}" ); ?>" id="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> /> 

				<label for="<?php echo esc_attr( "{$this->id}-{$value}" ); ?>">
					<div class="radio-selection"><?php echo esc_html( $args['label'] ); ?></div>
				</label>

			<?php endforeach; ?>

		</div><!-- .image -->

		<script type="text/javascript">
			jQuery( document ).ready( function() {
				jQuery( '#<?php echo esc_attr( "input_{$this->id}" ); ?>' ).buttonset();
			} );
		</script>
	<?php }

	/**
	 * Loads the jQuery UI Button script and hooks our custom styles in.
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );

		add_action( 'customize_controls_print_styles', array( $this, 'print_styles' ) );
	}

	/**
	 * Output CSS
	 */
	public function print_styles() { ?>

		<style type="text/css">
			#input_izo_header_builder_radio {overflow:hidden;}
			.customize-control-izo-radio-header .radio-selection { transition: background 0.2s;text-align:center;box-sizing: border-box;padding: 7px 10px;background: #b4cad2;color:#fff;width:50%;float:left;border:1px solid; }
			#input_izo_header_builder_radio label:nth-of-type(3) .radio-selection,#input_izo_header_builder_radio label:nth-of-type(4) .radio-selection, #input_izo_header_builder_radio label:nth-of-type(5) .radio-selection { width:33.33%; }
			.customize-control-izo-radio-header .ui-state-active .radio-selection { background: #008ec2; }
			.customize-control-izo-radio-header .radio-selection:hover { background: #008ec2; }
		</style>
	<?php }
}
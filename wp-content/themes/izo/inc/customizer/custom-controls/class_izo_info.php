<?php
/**
 * Info control
 *
 * @package Izo
 */

class Izo_Info extends WP_Customize_Control {
	public $type = 'izo-info';
	public $label = '';
	public $description = '';
	public $attr = '';

	public function render_content() {
	?>
		<?php if ( $this->label ) : ?>
			<?php if ( '' === $this->attr ) : ?>
			<p class="izo-customizer-info"><?php echo wp_kses_post( $this->label ); ?></p>
			<?php else : ?>
				<p><?php echo $this->label; ?></p>
			<?php endif; ?>
		<?php endif; ?>
	<?php
	}
}   
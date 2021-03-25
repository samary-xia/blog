<?php
/**
 * Title control
 *
 * @package Izo
 */

class Izo_Title extends WP_Customize_Control {
	public $type = 'izo-title';
	public $label = '';
	public $description = '';

	public function render_content() {
	?>
		<h3 style="background:#fff;color:#7991d6;font-size:13px;text-transform:uppercase;letter-spacing:1px;padding:12px;border:0;margin:20px -12px 0;"><?php echo esc_html( $this->label ); ?></h3>
		<?php if ( $this->description ) : ?>
		<p><?php echo esc_html( $this->description ); ?></p>
		<?php endif; ?>
	<?php
	}
}   
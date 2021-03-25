<?php
/**
 * Responsive number control
 *
 * @package Izo
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Izo_Responsive_Number extends WP_Customize_Control {

	public $type = 'izo-responsive_number';

	public $html = array();

	public function build_field_html( $key, $setting, $devices ) {
		$value = '';
		if ( isset( $this->settings[ $key ] ) ) {
			$value = $this->settings[ $key ]->value();
		}
		if ( 'desktop' == $devices ) {
			$active = 'active';
		} else {
			$active = ''; 
		}
		$this->html[] = '<div class="' . $active . ' izo-preview-' . $devices . '"><input min="' . intval( $this->input_attrs['min'] ) . '" step="' . intval( $this->input_attrs['step'] ) . '" max="' . intval( $this->input_attrs['max'] ) . '" type="number" value="' . $value . '" '.$this->get_link( $key ).' /></div>';
	}

	public function render_content() { ?>

		<div class="izo-responsive-control-header">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<ul class="izo-devices-preview">
				<li class="desktop active">
					<button type="button" class="preview-desktop" data-device="desktop">
						<i class="dashicons dashicons-desktop"></i>
					</button>
				</li>
				<li class="tablet">
					<button type="button" class="preview-tablet" data-device="tablet">
						<i class="dashicons dashicons-tablet"></i>
					</button>
				</li>
				<li class="mobile">
					<button type="button" class="preview-mobile" data-device="mobile">
						<i class="dashicons dashicons-smartphone"></i>
					</button>
				</li>
			</ul>
		</div>
		<div class="izo-responsive-wrapper">
		<?php
		$devices = array( 'desktop', 'tablet', 'mobile' );
		foreach( $this->settings as $key => $value ) {
			$this->build_field_html( $key, $value, $devices[$key] );
		}
		echo implode( '', $this->html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}

}
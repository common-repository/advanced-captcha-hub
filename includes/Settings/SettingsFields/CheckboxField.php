<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsFields;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsFields\FieldBase;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Checkbox Field.
 */
class CheckboxField extends FieldBase {


	/**
	 * Get Checkbox Field HTML.
	 *
	 * @param boolean $return;
	 *
	 * @return mixed
	 */
	public function get_field_html( $return = false ) {
		if ( $return ) {
			ob_start();
		}
		?>
		<input type="checkbox" <?php $this->field_id(); ?> <?php $this->field_classes(); ?> <?php $this->field_name(); ?> value="<?php echo esc_attr( ! empty( $this->field['value'] ) ? $this->field['value'] : '' ); ?>" <?php $this->custom_attributes_html(); ?> <?php $this->checked( ! empty( $this->field['value'] ) && 'on' === $this->field['value'] ); ?> >
		<?php
		if ( $return ) {
			return ob_get_clean();
		}
	}

	/**
	 * Sanitize Field.
	 *
	 * @param mixed $value
	 * @return string
	 */
	public function sanitize_field( $value ) {
		return ( ! empty( $value ) ? 'on' : 'off' );
	}

	/**
	 * Get Empty Value.
	 *
	 * @return string
	 */
	public function get_empty_value() {
		return 'off';
	}
}

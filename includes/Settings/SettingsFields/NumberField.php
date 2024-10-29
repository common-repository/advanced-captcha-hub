<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsFields;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsFields\TextField;
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Text Field.
 */
class NumberField extends TextField {

	/**
	 * Sanitize Field.
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public function sanitize_field( $value ) {
		return sanitize_text_field( $value ) + 0;
	}
}

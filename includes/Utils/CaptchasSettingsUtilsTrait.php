<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Utils;

defined( 'ABSPATH' ) || exit;

/**
 * Captchas Related Utils Trait.
 */
trait CaptchasSettingsUtilsTrait {

	/**
	 * Filer usable Captchas.
	 *
	 * @param array $captchas
	 * @return array
	 */
	public function filter_captchas_availability( $captchas ) {
		$filtered_captchas = array_filter(
			$captchas,
			function( $captcha ) {
				return ( $captcha->is_ready() && $captcha->is_enabled() );
			}
		);
		return $filtered_captchas;
	}
}

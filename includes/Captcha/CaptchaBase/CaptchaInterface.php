<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\CaptchaBase;

defined( 'ABSPATH' ) || exit;

/**
 * Captcha interface.
 *
 * @property string $id
 *
 * @property array $assets_keys
 */
interface CaptchaInterface {

	/**
	 * Is Captcha Ready ? [ keys - secret are set, etc.. ].
	 *
	 * @return boolean
	 */
	public function is_ready();

	/**
	 * Is Captcha Enabled.
	 *
	 * @return boolean
	 */
	public function is_enabled();

	/**
	 * Captcha Assets.
	 *
	 * @return array
	 */
	public function get_assets();

	/**
	 * Captcha Frontend HTML.
	 *
	 * @param string $html_id
	 * @param string $form_key
	 *
	 * @return void
	 */
	public function captcha_html( $html_id, $form_key );

	/**
	 * Get Captcha ID.
	 *
	 * @return void
	 */
	public function get_id();

	/**
	 * Verify Captcha.
	 *
	 * @return boolean
	 */
	public function verify_captcha();

}

<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Utils;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasSettingsUtilsTrait;

/**
 * Captchas Related Utils Trait.
 */
trait CaptchasUtilsTrait {

	use CaptchasSettingsUtilsTrait;

	/**
	 * Forms keys.
	 *
	 * @var array
	 */
	protected $forms_keys = array(
		'woo_add_to_cart',
		'woo_checkout',
		'woo_login',
		'woo_register',
		'woo_lost_pass',
		'comments',
		'wp_login',
		'wp_register',
		'wp_lost_pass',
	);

	/**
	 * Printed Captchas Tracker.
	 *
	 * @var string
	 */
	protected $printed_captchas_tracker = '';

	/**
	 * Get Captchas.
	 *
	 * @return array
	 */
	protected function get_captchas() {
		return $this->settings->_get_captchas();
	}


	/**
	 * Track Captchas.
	 *
	 * @param array|string $captchas
	 * @return void
	 */
	protected function track_captchas( $captchas ) {
		if ( empty( $this->printed_captchas_tracker ) ) {
			$this->printed_captchas_tracker = self::$page['prefix'] . '-printed-captchas-tracker-' . wp_generate_password( 12, false, false );
		}

		if ( ! empty( $GLOBALS[ $this->printed_captchas_tracker ] ) ) {
			$printed_captchas_keys = array_map( 'sanitize_text_field', wp_unslash( $GLOBALS[ $this->printed_captchas_tracker ] ) );
		} else {
			$printed_captchas_keys = array();
		}

		if ( ! is_array( $captchas ) ) {
			$captchas = array( $captchas );
		}

		$printed_captchas_keys = array_merge( $printed_captchas_keys, $captchas );

		$GLOBALS[ $this->printed_captchas_tracker ] = $printed_captchas_keys;
	}

	/**
	 * Is Captcha already printed.
	 *
	 * @param string $captcha
	 * @return boolean
	 */
	protected function is_captcha_printed( $captcha ) {
		if ( empty( $this->printed_captchas_tracker ) ) {
			return false;
		}

		if ( empty( $GLOBALS[ $this->printed_captchas_tracker ] ) || ! in_array( $captcha, $GLOBALS[ $this->printed_captchas_tracker ] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Get Captchas Keys.
	 *
	 * @param array $captchas
	 * @return array
	 */
	public function get_captchas_keys( $captchas ) {
		$keys = array();
		foreach ( $captchas as $captcha ) {
			$keys[] = $captcha->get_key();
		}
		return $keys;
	}

	/**
	 * Get Captchas By Keys.
	 *
	 * @param array $keys
	 * @return array
	 */
	protected function get_captchas_by_keys( $keys ) {
		return array_intersect_key( $this->get_captchas(), array_flip( $keys ) );
	}

	/**
	 * Get Captchas IDs.
	 *
	 * @param array $captchas
	 * @return array
	 */
	protected function get_captchas_ids( $captchas ) {
		return array_map(
			function( $captcha ) {
				return $captcha->get_id();
			},
			$captchas
		);
	}

	/**
	 * Check if Form is enabled.
	 *
	 * @param string $form_key
	 * @return boolean
	 */
	protected function is_form_enabled( $form_key ) {
		return ( 'on' === $this->settings->get_settings( 'captchas_places_' . $form_key . '_status' ) );
	}

	/**
	 * Get Form Captcha Select Type.
	 *
	 * @param string $form_key
	 * @return int 1 => random , 2 => manual
	 */
	protected function get_form_captcha_select_type( $form_key ) {
		return ( $this->settings->get_settings( 'captchas_places_' . $form_key . '_select_type' ) );
	}

	/**
	 * Get Form Captcha Selected.
	 *
	 * @param string $form_key
	 * @return array
	 */
	protected function get_form_captchas( $form_key ) {
		$captchas = ( $this->settings->get_settings( 'captchas_places_' . $form_key . '_select' ) );
		return is_array( $captchas ) ? array( $captchas[0] ) : array( $captchas );
	}
}

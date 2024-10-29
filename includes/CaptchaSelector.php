<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\GeneralUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;

/**
 * Captcha Selector Class.
 */
final class CaptchaSelector extends Base {
	use GeneralUtilsTrait, CaptchasUtilsTrait;

	/**
	 * Instance.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Main Settings.
	 *
	 * @var MainSettings
	 */
	protected $settings;

	/**
	 * Conflicts Captchas.
	 *
	 * @var array
	 */
	private $conflicts = array(
		array( 'hcaptcha', 'googlerecaptchav2' ),
		array( 'hcaptcha', 'googlerecaptchav3' ),
	);

	/**
	 * Singular Init.
	 *
	 * @return self
	 */
	public static function init() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->setup();
		$this->hooks();
	}

	/**
	 * Setup.
	 *
	 * @return void
	 */
	private function setup() {
		$this->settings = MainSettings::init();
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	private function hooks() {
	}

	/**
	 * Get Manual Form Selected Captchas.
	 *
	 * @param string $form_key
	 * @return array
	 */
	public function select_manual_captchas( $form_key ) {
		$captchas_keys = $this->get_form_captchas( $form_key );
		$captchas_keys = is_array( $captchas_keys ) ? array( $captchas_keys[0] ) : $captchas_keys;
		return $this->get_captchas_by_keys( $captchas_keys );
	}

	/**
	 * Get Chosen Captchas.
	 *
	 * @return array
	 */
	public function get_chosen_captchas( $form_key = '' ) {
		if ( ! $this->is_form_enabled( $form_key ) ) {
			return array();
		}

		// 2) return selected captchas.
		return $this->select_manual_captchas( $form_key );
	}

}

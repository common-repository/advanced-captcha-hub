<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\GeneralUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Utils\CaptchasUtilsTrait;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaVerifier;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaSelector;

/**
 * Captcha Handler Class.
 */
final class CaptchaHandler extends Base {
	use GeneralUtilsTrait, CaptchasUtilsTrait;

	/**
	 * Instance.
	 *
	 * @var self
	 */
	private static $instance = null;

	/**
	 * Captcha Settings.
	 *
	 * @var MainSettings
	 */
	private $verifier;

	/**
	 * Captcha Selector
	 *
	 * @var CaptchaSelector
	 */
	private $selector;

    /**
     * Captchas Settings
     *
     * @var MainSettings
     */
    protected $settings;

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
		$this->verifier = CaptchaVerifier::init();
		$this->selector = CaptchaSelector::init();
        $this->settings = MainSettings::init();
	}

	/**
	 * Hooks.
	 *
	 * @return void
	 */
	private function hooks() {
		if ( is_admin() ) {
			return;
		}

		// Captchas HTML.
		add_action( self::$plugin_info['prefix'] . '-place-captchas', array( $this, 'print_captchas_handler' ), 100, 3 );

		// Captchas Verification.
		add_filter( self::$plugin_info['prefix'] . '-verify-captchas', array( $this, 'verify_captchas_handler' ), 100, 4 );
	}

	/**
	 * Print Captchas Hander.
	 *
	 * @param array $captchas_keys
	 * @return void
	 */
	public function print_captchas_handler( $captchas_keys, $is_random = false, $random_count = 0 ) {
		$captchas = $this->get_captchas_by_keys( $captchas_keys );
		$captchas = $this->verifier->filter_captchas_availability( $captchas );
		foreach ( $captchas as $captcha ) {
			$captcha->print_captcha_html( '' );
			$captcha->captcha_assets();
		}
	}

	/**
	 * Verify Captchas Handler.
	 *
	 * @param boolean $verification_status
	 * @param array   $captchas_keys
	 * @param boolean $is_random
	 * @param integer $random_count
	 * @return boolean
	 */
	public function verify_captchas_handler( $verification_status, $captchas_keys, $is_random = false, $random_count = 0 ) {
		$captchas = $this->get_captchas_by_keys( $captchas_keys );
		$captchas = $this->verifier->filter_captchas_availability( $captchas );
		if ( $is_random && $random_count ) {
			$captchas_num = count( $captchas );
			$captchas     = $this->verifier->get_submitted_captchas( $captchas );
			$check_num    = min( array( $captchas_num, $random_count ) );
			if ( count( $captchas ) < $check_num ) {
				return false;
			}
		}
		foreach ( $captchas as $captcha ) {
			$result = $captcha->verify_captcha();
			if ( ! $result ) {
				return false;
			}
		}
		return $verification_status;
	}
}

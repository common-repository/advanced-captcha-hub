<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Base;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaHandler;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaVerifier;
use GPLSCore\GPLS_PLUGIN_WADVCPA\CaptchaHTML;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GeeTestCaptchaV3;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GoogleRecaptchaV3;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GeeTestCaptchaV4;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\GoogleRecaptchaV2;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Captcha\HCaptcha;

use function GPLSCore\GPLS_PLUGIN_WADVCPA\Pages\PagesBase\setup_pages;
use function GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\SettingsBase\setup_settings;
use function GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\ShortcodesBase\setup_shortcodes;

/**
 * Plugin Class for Activation - Deactivation - Uninstall.
 */
class Plugin extends Base {

	/**
	 * Main Class Load.
	 *
	 * @return void
	 */
	public static function load() {
		setup_settings();
		setup_pages();
		setup_shortcodes();

		CaptchaHandler::init();
		CaptchaVerifier::init();
		CaptchaHTML::init();
		GeeTestCaptchaV3::init();
		GoogleRecaptchaV3::init();
		GeeTestCaptchaV4::init();
		GoogleRecaptchaV2::init();
		HCaptcha::init();

		if ( function_exists( __NAMESPACE__ . '\Backgrounds\Base\setup_backgrounds' ) ) {
			Backgrounds\Base\setup_backgrounds();
		}
	}

	/**
	 * Plugin is activated.
	 *
	 * @return void
	 */
	public static function activated() {
		if ( function_exists( __NAMESPACE__ . '\Backgrounds\Base\setup_auto_backgrounds' ) ) {
			Backgrounds\Base\setup_auto_backgrounds();
		}
		// Activation Custom Code here...
	}

	/**
	 * Plugin is Deactivated.
	 *
	 * @return void
	 */
	public static function deactivated() {
		if ( function_exists( __NAMESPACE__ . '\Backgrounds\Base\clear_backgrounds' ) ) {
			Backgrounds\Base\clear_backgrounds();
		}

		// Deactivation Custom Code here...
	}

	/**
	 * Plugin is Uninstalled.
	 *
	 * @return void
	 */
	public static function uninstalled() {
		// Uninstall Custom Code here...
	}

	/**
	 * Is Plugin Active.
	 *
	 * @param string $plugin_basename
	 * @return boolean
	 */
	public static function is_plugin_active( $plugin_basename ) {
		require_once \ABSPATH . 'wp-admin/includes/plugin.php';
		return is_plugin_active( $plugin_basename );
	}
}

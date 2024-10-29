<?php
namespace GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes;

defined( 'ABSPATH' ) || exit;

use GPLSCore\GPLS_PLUGIN_WADVCPA\Shortcodes\ShortcodesBase\Shortcode;
use GPLSCore\GPLS_PLUGIN_WADVCPA\Settings\MainSettings;

/**
 * Captchas Shortcode.
 */
class CaptchasShortcode extends Shortcode {

	/**
	 * Instance.
	 *
	 * @var self
	 */
	protected static $instance = null;

	/**
	 * Captchas Settings
	 *
	 * @var MainSettings
	 */
	protected $settings;

	/**
	 * Setup.
	 *
	 * @return void
	 */
	protected function setup() {
		$this->settings                      = MainSettings::init();
		$this->shortcode_attributes          = array(
			array(
				'name'            => 'captchas',
				'status'          => 'required',
				'description'     => esc_html__( 'Comma separated List of captchas names to use', 'gpls-waadtct-woo-advanced-add-to-cart' ),
				'possible_values' => implode( ',', array_values( $this->settings->get_captchas_keys() ) ),
				'default'         => '',
				'default_val'     => '',
			),
			array(
				'name'            => 'is_random',
				'status'          => 'optional',
				'description'     => esc_html__( 'Pick captchas randomly from captchas attribute', 'gpls-waadtct-woo-advanced-add-to-cart' ),
				'possible_values' => 'no | yes',
				'default'         => 'no',
				'default_val'     => 'no',
			),
			array(
				'name'            => 'random_num',
				'status'          => 'optional',
				'description'     => esc_html__( 'Number of captchas to select randomly from captchas attribute', 'gpls-waadtct-woo-advanced-add-to-cart' ),
				'possible_values' => 'Captchas number',
				'default'         => '0',
				'default_val'     => 0,
			),
		);
		$this->required_shortcode_attributes = array( 'captchas' );
	}

	/**
	 * Get Shortcode Name.
	 *
	 * @return string
	 */
	public static function get_shortcode_name() {
		return self::$plugin_info['prefix_under'] . '_captchas';
	}

	/**
	 * Shortcode Content.
	 *
	 * @return void
	 */
	protected function _shortcode_callback( $attrs, $content ) {
	}
}
